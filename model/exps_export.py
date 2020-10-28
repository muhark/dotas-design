import pandas as pd
import sqlalchemy as sql
import numpy as np
import mysql.connector as mariadb
from configparser import ConfigParser
from os.path import expanduser
from uuid import uuid4

"""
The purpose of this script is to export the CHV20 dataset into MariaDB, in order
to ensure compatibility during production run.
"""

# Read in CHV20 data
data = pd.read_feather("exps.feather")

# Some columns were renamed for own usage
column_dict = {
    'age': 'age',
    'female_pre': 'gender',
    'race': 'race',
    'income3': 'income',
    'region': 'state',
    'newsint': 'newsint',
    'track_pre': 'track_pre',
    'pid_7_pre': 'pid_7_pre',
    'ideo5_pre': 'ideo5_pre',
    'ad_id': 'ad_id',
    'favorDT_rev': 'favorJB_rev',  # confusing, but I am doing anti-biden
    'favorHC_rev': 'favorDT_rev',
    'general_vote_DT': 'general_vote'}

# Changing region to state in this, so I want to temporarily switch it.
region_state = {
    1 : 'NY',
    2 : 'IL',
    3 : 'TX',
    4 : 'CA'
}
data.loc[:, 'region'] = data['region'].apply(lambda x: region_state[x])
data.loc[:, 'ad_id'] = data['ad_id'].apply(lambda x: 1 + x % 5)

# Take Anti Trump subset
df = data.loc[
    data['assignment'] == 'Anti Trump',
    data.columns.isin(column_dict.keys())].copy()
df.rename(column_dict, axis=1, inplace=True)

# Create test_pre dataframe
pre_cols = ['prolific_pid', 'study_id', 'session_id', 'age', 'gender', 'race',
            'income', 'state', 'newsint', 'track_pre', 'pid_7_pre',
            'ideo5_pre', 'ad_id', 'brief_id']
df_pre = df.loc[:, df.columns.isin(pre_cols)].copy()
df_pre[['study_id', 'session_id']] = "CHV20"
# Create fake pids
df_pre['prolific_pid'] = [str(uuid4()) for i in range(len(df_pre))]
df_pre['brief_id'] = 'group_a'
df_pre.loc[df_pre['track_pre'].isna(), 'track_pre'] = 'not sure'

# Create test_post dataframe
post_cols = ['prolific_pid', 'study_id', 'session_id', 'favorDT_rev', 'favorJB_rev', 'general_vote']
df_post = df.loc[:, df.columns.isin(post_cols)].copy()
df_post[['study_id', 'session_id']] = "CHV20"
df_post['prolific_pid'] = df_pre['prolific_pid'].copy()
df_post.loc[:, ['favorDT_rev', 'favorJB_rev', 'general_vote']].fillna(7, inplace=True)


# Send data to database
def db_connect(config_path=expanduser("~")+"/.cfg/mariadb.cfg"):
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
df_pre.to_sql('test_pre', db_engine, if_exists="replace", index=False)
df_post.to_sql('test_post', db_engine, if_exists="replace", index=False)
