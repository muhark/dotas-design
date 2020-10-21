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
// $sql = "INSERT INTO test_consent" .
// "(assignmentId, hitId, workerId, consent1, consent2, consent3, consent4, consent5, consent6, consent7, consent8, consent9)" .
// "VALUES ('" .
//   $dbData['assignmentId'] . "', '" .
//   $dbData['hitId'] . "', '" .
//   $dbData['workerId'] . "', " .
//   $dbData['consent1'] . ", " .
//   $dbData['consent2'] . ", " .
//   $dbData['consent3'] . ", " .
//   $dbData['consent4'] . ", " .
//   $dbData['consent5'] . ", " .
//   $dbData['consent6'] . ", " .
//   $dbData['consent7'] . ", " .
//   $dbData['consent8'] . ", " .
//   $dbData['consent9'] . ");";
//
// echo $sql;

try {
  // Initiate new connection
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

  // Set the error mode to exception (as per w3)
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Prepare SQL and bind parameters
  $stmt = $conn->prepare("INSERT INTO test_consent" .
  "(assignmentId, hitId, workerId, consent1, consent2, consent3, consent4, consent5, consent6, consent7, consent8, consent9)" .
  "VALUES (:assignmentId, :hitId, :workerId, :consent1, :consent2, :consent3, :consent4, :consent5, :consent6, :consent7, :consent8, :consent9)");
  $stmt->bindParam(':assignmentId', $assignmentId);
  $stmt->bindParam(':hitId', $hitId);
  $stmt->bindParam(':workerId', $workerId);
  $stmt->bindParam(':consent1', $consent1);
  $stmt->bindParam(':consent2', $consent2);
  $stmt->bindParam(':consent3', $consent3);
  $stmt->bindParam(':consent4', $consent4);
  $stmt->bindParam(':consent5', $consent5);
  $stmt->bindParam(':consent6', $consent6);
  $stmt->bindParam(':consent7', $consent7);
  $stmt->bindParam(':consent8', $consent8);
  $stmt->bindParam(':consent9', $consent9);

  // Insert row
  $assignmentId = $dbData['assignmentId'];
  $hitId = $dbData['hitId'];
  $workerId = $dbData['workerId'];
  $consent1 = $dbData['consent1'];
  $consent2 = $dbData['consent2'];
  $consent3 = $dbData['consent3'];
  $consent4 = $dbData['consent4'];
  $consent5 = $dbData['consent5'];
  $consent6 = $dbData['consent6'];
  $consent7 = $dbData['consent7'];
  $consent8 = $dbData['consent8'];
  $consent9 = $dbData['consent9'];
  $stmt->execute();

} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}

$conn = null;

$nextPage = "/components/pretreatment.php?assignmentId=" . $dbData['assignmentId'] . "&hitId=" . $dbData['hitId'] . "&=" . $dbData['workerId'];
header("Location: " . $nextPage);
?>
