import pandas as pd
import numpy as np
import sklearn.ensemble as ske
import sklearn.neural_network as snn
import sklearn.svm as svm

np.random.seed(634)

# Part of the goal here is to decide which script performs best.
data = pd.read_feather("exps.feather")
# Need to recode some of the data
covs = [
    'ad_id_fac',
    'age',
    'female_pre',
    'race',
    'income3',
    'newsint',
    'region',
    'pid_7_pre',
    'ideo5_pre',
    'track_pre'
]
cat_cols = [
    'race',
    'region',
    'track_pre'
]
for col in cat_cols:
    data.loc[:, col] = data[col].astype('category')

# Counterintuitively makes more sense to treat ad_id_fac as an int
data.loc[:, 'ad_id_fac'] = data['ad_id_fac'].astype('str')

def rand_optimum(a, method='min'):
    """
    Computes optimum according to max/min. In case of ties, chooses one
    of optima at random. Returns index of optimum.
    """
    if method=="max":
        op = np.max
    elif method=="min":
        op = np.min
    else:
        raise(ValueError("Method argument must be either max or min."))
    op_ind = np.flatnonzero(a==op(a))
    return np.random.choice(op_ind)


class maximal_allocation:
    """
    Maxmimal allocation class.
    Inputs:
    - `data`: CHV20 data
    - `treatment_filter`: CHV20 treatment group
    - `dv`: outcome variable to be maximised
    - `covs`: pre-treatment covariates to be included
    - `model`: sklearn model object
    """

    def __init__(self, data, treatment_filter, dv, covs, model, treatment='ad_id_fac'):
        # Step 1: Prepare data for use by model
        self.data = data
        self.treatment_filter = treatment_filter
        self.dv = dv
        self.covs = covs
        self.df =  self.prep_data(data, treatment_filter, dv, covs)
        self.treat_cols = self.df.columns.str.contains(treatment+"_*", regex=True)
        self.n_treats = self.treat_cols.sum()
        # Step 2: Fit model
        self.fitted_model = self.fit_model(self.df, self.dv, model)
        # Step 3: Prepare prediction frame
        ## Note: Turns out stack-then-apply is faster.
        ## Each call of .predict is expensive.
        self.pred_frame = np.vstack(
            self.df.apply(lambda x: self._generate_row_pred_frame(x), axis=1))
        # Step 4: Generate predictions
        self.preds = self.fitted_model.predict(
            self.pred_frame[:, np.flatnonzero(self.df.columns!=self.dv)]
            ).reshape((self.df.shape[0], self.n_treats))
        self.best_ad_idx = np.apply_along_axis(rand_optimum, 1, self.preds)
        self.best_ads = self.df.columns[self.treat_cols][self.best_ad_idx]
        self.ma_outcome = self.preds[range(0, self.df.shape[0]), self.best_ad_idx]

    def prep_data(self, data, treatment_filter, dv, covs):
        df = data.loc[data['assignment']==treatment_filter]
        df = df.loc[:, [dv]+covs].dropna()
        df = pd.get_dummies(df)
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


ma_rf1 = maximal_allocation(data, 'Anti Trump', 'favorDT_rev', covs, ske.RandomForestRegressor())
ma_ab1 = maximal_allocation(data, 'Anti Trump', 'favorDT_rev', covs, ske.AdaBoostRegressor())
ma_gb1 = maximal_allocation(data, 'Anti Trump', 'favorDT_rev', covs, ske.GradientBoostingRegressor())
ma_nn1 = maximal_allocation(data, 'Anti Trump', 'favorDT_rev', covs, snn.MLPRegressor())
ma_sv1 = maximal_allocation(data, 'Anti Trump', 'favorDT_rev', covs, model=svm.SVR())

models = [ma_rf1, ma_ab1, ma_gb1, ma_nn1, ma_sv1]

ad_assignments = pd.concat([ma_rf1.df.loc[:, ma_rf1.treat_cols].sum()]+[m.best_ads.value_counts() for m in models], sort=True, axis=1).fillna(0)
ad_assignments = ad_assignments.rename(dict(zip(range(0, 6), ['Base', 'RF', 'AdaBoost', 'GradBoost', 'MLP-NN', 'SVM'])), axis=1).astype(int)
dict(zip(['Base', 'RF', 'AdaBoost', 'GradBoost', 'MLP-NN', 'SVM'], [ma_rf1.df['favorDT_rev'].mean()] + [m.ma_outcome.mean() for m in models]))
## Speed testing
# Faster to stack then apply, or apply then stack
# temp = df.iloc[0:10, :].apply(lambda x: generate_pred_frame(x), axis=1)
# %timeit np.vstack(temp.apply(lambda x: fitted_model.predict(x[:, np.flatnonzero(df.columns!=dv)])))
# %timeit fitted_model.predict(np.vstack(temp.values)[:, np.flatnonzero(df.columns!=dv)]).reshape((temp.shape[0], n_treats))
#
#     def generate_pred_frame(row):
#         pred_frame = np.tile(row.values, (n_treats, 1))
#         pred_frame[:, treat_cols] = np.identity(n_treats)
#         return pred_frame
#
#     def simulate_maximal_allocation(df, dv, treatment, fitted_model):
#         # Step 1 build prediction frame, alternating treatments
#         treat_cols = df.columns.str.contains(treatment+"_*", regex=True)
#         n_treats = treat_cols.sum()
#         pred_data = pd.concat([df]*n_treats, ignore_index=True)
#         pred_data.loc[:, treat_cols] = 0
#         i = 0
#         for treat in df.columns[treat_cols]:
#             pred_data.loc[i:i+df.shape[0]-1, treat] = 1
#             i += df.shape[0]
#         # Step 2 generate predictions
#         preds = fitted_model.predict(pred_data.drop(dv, axis=1))
#         # Step 3 fold predictions into square dataframe
#         preds = np.reshape(preds, (n_treats, df.shape[0]))
#         preds = pd.DataFrame(preds.T, columns=df.columns[treat_cols], index=df.index)
#         # Step 4 get optimum in each row
#         if treatment_filter[0:4]=='Anti':
#             best_ad = preds.idxmin(axis=1)
#         else:
#             best_ad = preds.idxmax(axis=1)
#         # Step 5 simulate maximal allocation
#         ma_df = df.copy()
#         ma_df.loc[:, treat_cols] = 0
#         for idx in zip(best_ad.index, best_ad):
#             ma_df.loc[idx[0], idx[1]] = 1
#         ma_df.loc[:, dv] = fitted_model.predict(ma_df.drop(dv, axis=1))
