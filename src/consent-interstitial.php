<!DOCTYPE html>
<html>

<?php
// Read in prolific user data
$userVars = array(
  'PROLIFIC_PID',
  'STUDY_ID',
  'SESSION_ID'
);

$userData = array();

foreach($userVars as $name){
  if(isset($_GET[$name])){
    // echo $name . " is set to " . $_GET[$name] . "<br>";
    $userData[$name] = $_GET[$name];
  } else {
    // echo $name . " is unset<br>";
    $userData[$name] = "UNSET_" . $name;
  }
}

// Parse Consent Form
$dbData = array();
$postVars = array(
  'consent1',
  'consent2',
  'consent3',
  'consent4',
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
  $stmt = $conn->prepare("INSERT INTO prod_consent" .
  "(prolific_pid, study_id, session_id, consent1, consent2, consent3, consent4)" .
  "VALUES (:prolific_pid, :study_id, :session_id, :consent1, :consent2, :consent3, :consent4 )");
  $stmt->bindParam(':prolific_pid', $prolific_pid);
  $stmt->bindParam(':study_id', $study_id);
  $stmt->bindParam(':session_id', $session_id);
  $stmt->bindParam(':consent1', $consent1);
  $stmt->bindParam(':consent2', $consent2);
  $stmt->bindParam(':consent3', $consent3);
  $stmt->bindParam(':consent4', $consent4);

  // Insert row
  $prolific_pid = $userData['PROLIFIC_PID'];
  $study_id = $userData['STUDY_ID'];
  $session_id = $userData['SESSION_ID'];
  $consent1 = $dbData['consent1'];
  $consent2 = $dbData['consent2'];
  $consent3 = $dbData['consent3'];
  $consent4 = $dbData['consent4'];
  $stmt->execute();

} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}

$conn = null;

$nextPage = "/pretreatment.php?PROLIFIC_PID=" . $userData['PROLIFIC_PID'] .
            "&STUDY_ID=" . $userData['STUDY_ID'] .
            "&SESSION_ID=" . $userData['SESSION_ID'];
header("Location: " . $nextPage);
?>
