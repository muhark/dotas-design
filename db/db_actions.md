# Notes to self on db

```{sql}
CREATE TABLE survey_db.test(
    test1 INT NOT NULL
    test2 BOOL NOT NULL
    test3 VARCHAR(100) NOT NULL
    );

CREATE TABLE test_consent(
    prolific_pid VARCHAR(100) NOT NULL,
    study_id VARCHAR(100) NOT NULL,
    session_id VARCHAR(100) NOT NULL,
    consent1 BOOL NOT NULL,
    consent2 BOOL NOT NULL,
    consent3 BOOL NOT NULL,
    consent4 BOOL NOT NULL,
    ts TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    );

CREATE TABLE test_pre(
    prolific_pid VARCHAR(100) NOT NULL,
    study_id VARCHAR(100) NOT NULL,
    session_id VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    gender INT NOT NULL,
    race INT NOT NULL,
    income INT NOT NULL,
    region INT NOT NULL,
    newsint INT NOT NULL,
    track_pre VARCHAR(12) NOT NULL,
    pid_7_pre INT NOT NULL,
    ideo5_pre INT NOT NULL,
    ts TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    );

CREATE TABLE test_post(
    prolific_pid VARCHAR(100) NOT NULL,
    study_id VARCHAR(100) NOT NULL,
    session_id VARCHAR(100) NOT NULL,
    favorJB_rev INT NOT NULL,
    general_vote INT NOT NULL,
    ts TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    );
```
