<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Political Ads Survey</title>
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=font1|font2|etc" type="text/css">
  <link rel="stylesheet" href="/survey.css" type="text/css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.0/knockout-min.js"></script>
</head>

<body>
<?php
// Generate completion code
$ccode = "https://app.prolific.co/submissions/complete?cc=PLACEHOLDER";

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
    echo $name . " is unset<br>";
    $userData[$name] = "UNSET_" . $name;
  }
}

// Parse POST data
$dbData = array();
$postVars = array(
  'favorJB_rev',
  'general_vote'
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
  $stmt = $conn->prepare("INSERT INTO test_post" .
  "(prolific_pid, study_id, session_id, favorJB_rev, general_vote)" .
  "VALUES (:prolific_pid, :study_id, :session_id, :favorJB_rev, :general_vote)");
  $stmt->bindParam(':prolific_pid', $prolific_pid);
  $stmt->bindParam(':study_id', $study_id);
  $stmt->bindParam(':session_id', $session_id);
  $stmt->bindParam(':favorJB_rev', $favorJB_rev);
  $stmt->bindParam(':general_vote', $general_vote);

  // Insert row
  $prolific_pid = $userData['PROLIFIC_PID'];
  $study_id = $userData['STUDY_ID'];
  $session_id = $userData['SESSION_ID'];
  $favorJB_rev = $dbData['favorJB_rev'];
  $general_vote = $dbData['general_vote'];
  $stmt->execute();

} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}

$conn = null;
$email = "musashi.harukawa@politics.ox.ac.uk";
?>

  <div class="sv-title sv-container-modern__title">
    <div class="sv-header__text">
      <h3>
        <span style="position: static;">Political Ads Survey</span>
      </h3>
      <h5>
        <span style="position: static;"></span>
      </h5>
    </div>
  </div>


  <div class="sv-page sv-body__page">

    <!-- SUBHEADER AND BRIEF -->
    <div class="sv-page sv-page__description">
      <h4 class="sv-title sv-page__title">Thank you!</h4>
      <div class="sv-description sv-page__description">
        <p>You have now completed the survey.</p>
        <h5 class="payment-code">Click <a href=<?php echo $ccode; ?>>here</a> to be redirected back to prolific and receive payment.</h5>
        <p>Please bear with me while I verify your responses, but I will strive to ensure that you receive payment within 72 of completing this task.</p>
        <p>If you have further questions about the survey, payment, or change your mind regarding consent, please contact me in the email address provided in the Participant Information Sheet.</p>
      </div>
    </div>

  </div>
</body>
</html>
