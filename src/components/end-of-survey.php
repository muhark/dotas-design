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
// Parse GET and POST data
$dbData = array();
$awsVars = array(
  'assignmentId',
  'hitId',
  'workerId'
);
$postVars = array(
  'favorJB_rev',
  'general_vote'
);

foreach($awsVars as $name){
  if(isset($_GET[$name])){
    $awsData[$name] = $_GET[$name];
  } else {
    $awsData[$name] = "placeholder_" . $name;
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

try {
  // Initiate new connection
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

  // Set the error mode to exception (as per w3)
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Prepare SQL and bind parameters
  $stmt = $conn->prepare("INSERT INTO test_post" .
  "(assignmentId, hitId, workerId, favorJB_rev, general_vote)" .
  "VALUES (:assignmentId, :hitId, :workerId, :favorJB_rev, :general_vote)");
  $stmt->bindParam(':assignmentId', $assignmentId);
  $stmt->bindParam(':hitId', $hitId);
  $stmt->bindParam(':workerId', $workerId);
  $stmt->bindParam(':favorJB_rev', $favorJB_rev);
  $stmt->bindParam(':general_vote', $general_vote);

  // Insert row
  $assignmentId = $awsData['assignmentId'];
  $hitId = $awsData['hitId'];
  $workerId = $awsData['workerId'];
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
        <p>Please click on the link below, which will redirect you back to the MTurk portal where this task will be marked as completed and you will receive payment.</p>
        <p>If you have further questions about the survey, payment, or change your mind regarding consent, please contact me at <?php echo $email; ?></p>
      </div>
    </div>

  </div>
</body>
</html>
