import pandas as pd
import numpy as np
import sklearn.ensemble as ske
import sklearn.preprocessing as skp

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


def prep_data(data, treatment_filter, dv, covs):
    df = data.loc[data['assignment']==treatment_filter]
    df = df.loc[:, [dv]+covs].dropna()
    df = pd.get_dummies(df)
    return df

def fit_model(df, dv, model=ske.RandomForestRegressor):
    rf = model(random_state=634)
    fit = rf.fit(
        X = df.drop(dv, axis=1).values,
        y = df[dv].values)
    return fit

def simulate_maximal_allocation(df, dv, treatment, fitted_model):
    # Step 1 build prediction frame, alternating treatments
    treat_cols = df.columns.str.contains(treatment+"_*", regex=True)
    n_treats = treat_cols.sum()
    pred_data = pd.concat([df]*n_treats, ignore_index=True)
    pred_data.loc[:, treat_cols] = 0
    i = 0
    for treat in df.columns[treat_cols]:
        pred_data.loc[i:i+df.shape[0]-1, treat] = 1
        i += df.shape[0]
    # Step 2 generate predictions
    preds = fitted_model.predict(pred_data.drop(dv, axis=1))
    # Step 3 fold predictions into square dataframe
    preds = np.reshape(preds, (n_treats, df.shape[0]))
    preds = pd.DataFrame(preds.T, columns=df.columns[treat_cols], index=df.index)
    # Step 4 get optimum in each row
    if treatment_filter[0:4]=='Anti':
        best_ad = preds.idxmin(axis=1)
    else:
        best_ad = preds.idxmax(axis=1)
    # Step 5 simulate maximal allocation
    ma_df = df.copy()
    ma_df.loc[:, treat_cols] = 0
    for idx in zip(best_ad.index, best_ad):
        ma_df.loc[idx[0], idx[1]] = 1
    ma_df.loc[:, dv] = fitted_model.predict(ma_df.drop(dv, axis=1))
