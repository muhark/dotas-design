<!DOCTYPE html>
<html>

<?php
// Parse GET and POST data
$dbData = array();
$awsVars = array(
  'assignmentId',
  'hitId',
  'workerId'
);
$postVars = array(
  'consent1',
  'consent2',
  'consent3',
  'consent4',
  'consent5',
  'consent6',
  'consent7',
  'consent8',
  'consent9',
);

foreach($awsVars as $name){
  if(isset($_GET[$name])){
    // echo $name . " is set to " . $_GET[$name] . "<br>";
    $dbData[$name] = $_GET[$name];
  } else {
    // echo $name . " is unset"<br>;
    $dbData[$name] = "placeholder_" . $name;
  }
}

foreach($postVars as $name){
  if(isset($_POST[$name])){
    $dbData[$name] = $_POST[$name];
  }
}

$ini_array = parse_ini_file("/home/". get_current_user() . "/.cfg/surveyor.ini");

$servername = "localhost";
$username = $ini_array['username'];
$password = $ini_array['password'];
$dbname = $ini_array['dbname'];
$sql = "INSERT INTO test_consent" .
"(assignmentId, hitId, workerId, consent1, consent2, consent3, consent4, consent5, consent6, consent7, consent8, consent9)" .
"VALUES ('" .
  $dbData['assignmentId'] . "', '" .
  $dbData['hitId'] . "', '" .
  $dbData['workerId'] . "', " .
  $dbData['consent1'] . ", " .
  $dbData['consent2'] . ", " .
  $dbData['consent3'] . ", " .
  $dbData['consent4'] . ", " .
  $dbData['consent5'] . ", " .
  $dbData['consent6'] . ", " .
  $dbData['consent7'] . ", " .
  $dbData['consent8'] . ", " .
  $dbData['consent9'] . ");";

echo $sql;

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // use exec() because no results are returned
  $conn->exec($sql);
  // echo "New record created successfully";
} catch(PDOException $e) {
  // echo "Error!";
  // echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
header('Location: /page1.html');
?>
