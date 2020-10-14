import numpy as np
from joblib import load, dump

N_TREATS = 24
ADS_VEC = ['ad_id_fac_26', 'ad_id_fac_27', 'ad_id_fac_33', 'ad_id_fac_38',
       'ad_id_fac_39', 'ad_id_fac_4', 'ad_id_fac_44', 'ad_id_fac_47',
       'ad_id_fac_5', 'ad_id_fac_50', 'ad_id_fac_54', 'ad_id_fac_59',
       'ad_id_fac_6', 'ad_id_fac_60', 'ad_id_fac_62', 'ad_id_fac_63',
       'ad_id_fac_66', 'ad_id_fac_68', 'ad_id_fac_70', 'ad_id_fac_71',
       'ad_id_fac_75', 'ad_id_fac_77', 'ad_id_fac_8', 'ad_id_fac_99']

# Load model
model = load("../model/prefitted/rf1.joblib")

# Parse input data
req = {"birthyear": ["1960"], "gender": ["1"], "race": ["1"], "income": ["4"], "region": ["4"], "newsint": ["2"], "track_pre": ["wrong track"], "pid_7_pre": ["7"], "ideo5_pre": ["5"]}

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


def parse_input(req):
    """
    Parses JSON data transmitted by survey form.
    """
    age = np.array([2020 - np.float64(req['birthyear'][0])])
    female_pre = np.array([np.float64(req['gender'][0])])
    ideo5_pre = np.array([np.float64(req['ideo5_pre'][0])])
    income3 = np.array([np.float64(req['income'][0])])
    newsint = np.array([np.float64(req['newsint'][0])])
    pid_7_pre = np.array([np.float64(req['pid_7_pre'][0])])
    race = np.zeros(shape=(8,), dtype=np.float64)
    race[int(req['race'][0]) - 1] = 1
    region = np.zeros(shape=(4,), dtype=np.float64)
    region[int(req['region'][0]) - 1] = 1
    if req['track_pre'][0] == 'not sure':
        track_pre = np.array([1, 0, 0], dtype=np.float64)
    elif req['track_pre'][0] == 'right track':
        track_pre = np.array([0, 1, 0], dtype=np.float64)
    else:
        track_pre = np.array([0, 0, 1], dtype=np.float64)
    out = np.concatenate([
        age,
        female_pre,
        ideo5_pre,
        income3,
        newsint,
        pid_7_pre,
        race,
        region,
        track_pre])
    return out

def get_best_ad(req, model, n_treats=N_TREATS):
    covs = parse_input(req)
    pred_vec = np.concatenate(
        [np.zeros(shape=(N_TREATS,), dtype=np.float64), covs])
    pred_data = np.tile(pred_vec, (N_TREATS, 1))
    pred_data[:, 0:N_TREATS] = np.identity(N_TREATS)
    pred_y = model.predict(pred_data)
    best_ad_idx = rand_optimum(pred_y)
    return best_ad_idx
