<!DOCTYPE html>
<html>

<?php
// Parse GET uuid
if(isset($_GET['userid'])){
  $uuid = $_GET['userid'];
} else {
  echo "<h1>User ID is not set! Please return to the <a href='/components/consent.php'>first page</a> of the survey otherwise your answers may not be recorded and you may not be paid.</h1>";
}

// Parse Consent Form
$dbData = array();
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

try {
  // Initiate new connection
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

  // Set the error mode to exception (as per w3)
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Prepare SQL and bind parameters
  $stmt = $conn->prepare("INSERT INTO test_consent" .
  "(userid, consent1, consent2, consent3, consent4, consent5, consent6, consent7, consent8, consent9)" .
  "VALUES (:userid, :consent1, :consent2, :consent3, :consent4, :consent5, :consent6, :consent7, :consent8, :consent9)");
  $stmt->bindParam(':userid', $userid);
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
  $userid = $uuid;
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

$nextPage = "/components/pretreatment.php?userid=" . $uuid;
header("Location: " . $nextPage);
?>
