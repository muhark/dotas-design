from configparser import ConfigParser
from os.path import expanduser
import numpy as np
from joblib import load, dump
from misc import state_region as SR

N_TREATS = 5

config = ConfigParser()
config.read(expanduser("~")+"/.cfg/.globals")

# Load model
model = load(f"../model/prefitted/{config['GLOBALS']['model']}.joblib")

# Parse input data
# req = {"age": ["60"], "gender": ["1"], "race": ["1"], "income": ["4"], "state": ["AL"], "newsint": ["2"], "track_pre": ["wrong track"], "pid_7_pre": ["7"], "ideo5_pre": ["5"]}

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
    age = np.array([np.float64(req['age'][0])])
    female_pre = np.array([np.float64(0 if req['gender'][0]=='0' else 1)])
    ideo5_pre = np.array([np.float64(req['ideo5_pre'][0])])
    income3 = np.array([np.float64(req['income'][0])])
    newsint = np.array([np.float64(req['newsint'][0])])
    pid_7_pre = np.array([np.float64(req['pid_7_pre'][0])])
    race = np.zeros(shape=(8,), dtype=np.float64)
    race[int(req['race'][0]) - 1] = 1
    region = np.zeros(shape=(4,), dtype=np.float64)
    region[int(SR[req['state'][0]]) - 1] = 1
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
