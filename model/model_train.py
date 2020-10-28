from configparser import ConfigParser
from os.path import expanduser

import mysql.connector as mariadb
import numpy as np
import pandas as pd
import sklearn.ensemble as ske
import sklearn.neural_network as snn
import sklearn.svm as svm
import sqlalchemy as sql
from joblib import dump
from numpy.random import MT19937, RandomState, SeedSequence

from misc import *

rs = RandomState(MT19937(SeedSequence(634)))

def db_connect(config_path=expanduser("~") + "/.cfg/mariadb.cfg"):
    # First get username and password from config file
    config = ConfigParser()
    config.read(config_path)
    un = config['MARIADB']['username']
    pw = config['MARIADB']['password']
    # Create database engine
    db_conn_str = f"mysql+mysqlconnector://{un}:{pw}@localhost/survey_db"
    engine = sql.create_engine(db_conn_str)
    return engine


db_engine = db_connect()
data = pd.read_sql(con=db_engine, sql="""
SELECT * FROM prod_pre as pre
INNER JOIN prod_post as post
ON pre.prolific_pid = post.prolific_pid;
""")

data.loc[:, 'region'] = data['state'].apply(lambda x: state_region[x])
data.loc[:, 'gender'] = data['gender'].apply(lambda x: 0 if x==0 else 1)
# Need to recode some of the data
covs = [
    'ad_id',
    'age',
    'gender',
    'race',
    'income',
    'newsint',
    'region',
    'pid_7_pre',
    'ideo5_pre',
    'track_pre'
]
unord_covs = [
    'ad_id',
    'race',
    'region',
    'track_pre'
]

# Manually specify n_categories in case category appears in predict but not in train.
data.loc[:, 'ad_id'] = pd.Categorical(data['ad_id'], categories = range(1, 6), ordered=False)
data.loc[:, 'race'] = pd.Categorical(data['race'], categories = range(1, 9), ordered=False)
data.loc[:, 'region'] = pd.Categorical(data['region'], categories = range(1, 5), ordered=False)
data.loc[:, 'track_pre'] = pd.Categorical(data['track_pre'], categories = ['not sure', 'right track', 'wrong track'], ordered=False)

# Counterintuitively makes more sense to treat ad_id_fac as an int
# data.loc[:, 'ad_id'] = data['ad_id'].astype('str')


def rand_optimum(a, method='min'):
    """
    Computes optimum according to max/min. In case of ties, chooses one
    of optima at random. Returns index of optimum.
    """
    if method == "max":
        op = np.max
    elif method == "min":
        op = np.min
    else:
        raise(ValueError("Method argument must be either max or min."))
    op_ind = np.flatnonzero(a == op(a))
    return np.random.choice(op_ind)


class maximal_allocation:
    """
    Maxmimal allocation class.
    Inputs:
    - `data`: input data
    - `dv`: outcome variable to be maximised
    - `covs`: pre-treatment covariates to be included
    - `model`: sklearn model object
    """

    def __init__(self, data, dv, covs, model, treatment='ad_id'):
        # Step 1: Prepare data for use by model
        self.data = data
        self.dv = dv
        self.covs = covs
        self.df = self.prep_data(data, dv, covs)
        self.treat_cols = self.df.columns.str.contains(
            treatment + "_*", regex=True)
        self.n_treats = self.treat_cols.sum()
        # Step 2: Fit model
        self.fitted_model = self.fit_model(self.df, self.dv, model)
        # Step 3: Prepare prediction frame
        # Note: Turns out stack-then-apply is faster.
        # Each call of .predict is expensive.
        self.pred_frame = np.vstack(
            self.df.apply(lambda x: self._generate_row_pred_frame(x), axis=1))
        # Step 4: Generate predictions
        self.preds = self.fitted_model.predict(
            self.pred_frame[:, np.flatnonzero(self.df.columns != self.dv)]
        ).reshape((self.df.shape[0], self.n_treats))
        self.best_ad_idx = np.apply_along_axis(rand_optimum, 1, self.preds)
        self.best_ads = self.df.columns[self.treat_cols][self.best_ad_idx]
        self.ma_outcome = self.preds[range(
            0, self.df.shape[0]), self.best_ad_idx]

    def prep_data(self, data, dv, covs):
        df = data.loc[:, [dv] + covs].dropna()
        df = pd.get_dummies(df).sort_index(1)
        return df

    def fit_model(self, df, dv, model):
        X = df.drop(dv, axis=1).values
        y = df[dv].values
        fit = model.fit(X, y)
        return fit

    def _generate_row_pred_frame(self, row):
        pred_frame = np.tile(row.values, (self.n_treats, 1))
        pred_frame[:, self.treat_cols] = np.identity(self.n_treats)
        return pred_frame


if __name__ == '__main__':
    ma_rf1 = maximal_allocation(
        data, 'favorJB_rev', covs, ske.RandomForestRegressor())
    ma_ab1 = maximal_allocation(
        data, 'favorJB_rev', covs, ske.AdaBoostRegressor())
    ma_gb1 = maximal_allocation(
        data, 'favorJB_rev', covs, ske.GradientBoostingRegressor())
    ma_nn1 = maximal_allocation(
        data, 'favorJB_rev', covs, snn.MLPRegressor())
    ma_sv1 = maximal_allocation(
        data, 'favorJB_rev', covs, model=svm.SVR())

    models = [ma_rf1, ma_ab1, ma_gb1, ma_nn1, ma_sv1]

    ad_assignments = pd.concat([ma_rf1.df.loc[:, ma_rf1.treat_cols].sum(
    )] + [m.best_ads.value_counts() for m in models], sort=True, axis=1).fillna(0)
    ad_assignments = ad_assignments.rename(dict(zip(range(0, 6), [
                                           'Base', 'RF', 'AdaBoost', 'GradBoost', 'MLP-NN', 'SVM'])), axis=1).astype(int)
    dict(zip(['Base', 'RF', 'AdaBoost', 'GradBoost', 'MLP-NN', 'SVM'],
             [ma_rf1.df['favorJB_rev'].mean()] + [m.ma_outcome.mean() for m in models]))

    # Pickle fitted rf model.

    for model, fname in zip(models, ['RF', 'AdaBoost', 'GradBoost', 'MLP-NN', 'SVM']):
        dump(model, f'{fname}.joblib')

    for model, fname in zip(models, ['rf1', 'ab1', 'gb1', 'nn1', 'sv1']):
        dump(model.fitted_model, f'prefitted/{fname}.joblib')

    # Comparing the fitted models showed that RF performs better on balance
    # of speed and RMSE. Fitting kfold CV may be time-consuming on day may be
    # best practice, but need to be careful that it doesn't take too long.
    if cross_val:
        from sklearn.model_selection import cross_validate

        X = ma_rf1.df.drop(ma_rf1.dv, axis=1).values
        y = ma_rf1.df[ma_rf1.dv].values
        scoring = {'max_error': 'max_error',
                   'nRMSE': 'neg_root_mean_squared_error'}
        cv_compare = {}
        models = dict(zip(['RF', 'AdaBoost', 'GradBoost', 'MLP-NN', 'SVM'],
                          [ske.RandomForestRegressor(), ske.AdaBoostRegressor(),
                           ske.GradientBoostingRegressor(), snn.MLPRegressor(),
                           svm.SVR()]))

        for model in models.keys():
            cv_compare[model] = cross_validate(
                models[model], X, y, cv=30, scoring=scoring, n_jobs=-1
            )

        # Convert to DataFrame
        cvs = pd.DataFrame(cv_compare['RF'])
        cvs.columns = pd.MultiIndex.from_tuples(zip(['RF'] * 4, cvs.columns))
        for m in ['AdaBoost', 'GradBoost', 'MLP-NN', 'SVM']:
            temp = pd.DataFrame(cv_compare[m])
            temp.columns = pd.MultiIndex.from_tuples(zip([m] * 4, temp.columns))
            cvs = pd.concat([cvs, temp], axis=1)

        cvs = cvs.melt(var_name=['Model', 'Statistic'])

        import matplotlib.pyplot as plt
        import seaborn as sns
        sns.set_style('darkgrid')

        sns.catplot(x='Model', y='value', col='Statistic', data=cvs,
                    col_wrap=2, sharey=False, kind='boxen')
        temp = ad_assignments.iloc[:, 1:].subtract(
            ad_assignments['Base'], axis=0).divide(ad_assignments['Base'], axis=0)
        sns.catplot(
            x="index", y="value", col="Model", col_wrap=2, sharey=False, kind='bar',
            data=temp.reset_index().melt(id_vars='index', var_name=['Model']))
