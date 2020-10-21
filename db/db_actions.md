# Notes to self on db

```{sql}
DROP DATABASE IF EXISTS survey_db;
CREATE DATABASE survey_db;
CREATE USER 'surveyor'@'localhost' IDENTIFIED BY '*password';
GRANT INSERT ON survey_db.* TO 'surveyor'@'localhost';
GRANT ALL PRIVILEGES ON survey_db.* TO 'masha'@'localhost';
FLUSH PRIVILEGES;

CREATE TABLE survey_db.test(
    test1 INT NOT NULL
    test2 BOOL NOT NULL
    test3 VARCHAR(100) NOT NULL
    );

CREATE TABLE test_consent(
    assignmentId VARCHAR(100) NOT NULL,
    hitId VARCHAR(100) NOT NULL,
    workerId VARCHAR(100) NOT NULL,
    consent1 BOOL NOT NULL,
    consent2 BOOL NOT NULL,
    consent3 BOOL NOT NULL,
    consent4 BOOL NOT NULL,
    consent5 BOOL NOT NULL,
    consent6 BOOL NOT NULL,
    consent7 BOOL NOT NULL,
    consent8 BOOL NOT NULL,
    consent9 BOOL NOT NULL
    );

CREATE TABLE test_pre(
    assignmentId VARCHAR(100) NOT NULL,
    hitId VARCHAR(100) NOT NULL,
    workerId VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    gender INT NOT NULL,
    race INT NOT NULL,
    income INT NOT NULL,
    region INT NOT NULL,
    newsint INT NOT NULL,
    track_pre INT NOT NULL,
    pid_7_pre INT NOT NULL,
    ideo5_pre INT NOT NULL
    );

CREATE TABLE test_post(
    assignmentId VARCHAR(100) NOT NULL,
    hitId VARCHAR(100) NOT NULL,
    workerId VARCHAR(100) NOT NULL,
    favorJB_rev INT NOT NULL,
    general_vote INT NOT NULL
    )
```


# Consent Page

surveyor.ini
```{ini}
dbname = survey_db
username = surveyor
password =
```


```{php}
<?php

$ini_array = parse_ini_file("/home/lunayneko/.cfg/surveyor.ini")

$servername = "localhost";
$username = $ini_array['username'];
$password = $ini_array['password'];
$dbname = $ini_array['dbname']

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO test (test1, test2, test3)
  VALUES (1, true, 'name_lastname')";
  // use exec() because no results are returned
  $conn->exec($sql);
  echo "New record created successfully";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>
```


```{php}
https://tictactoe.amazon.com/gamesurvey.cgi?gameid=01523
&assignmentId=123RVWYBAZW00EXAMPLE456RVWYBAZW00EXAMPLE
&hitId=123RVWYBAZW00EXAMPLE
&turkSubmitTo=https://www.mturk.com/
&workerId=AZ3456EXAMPLE
```
