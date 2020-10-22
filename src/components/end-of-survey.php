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
$ccode = uuid_create(UUID_TYPE_RANDOM);

// Parse GET uuid
if(isset($_GET['userid'])){
  $uuid = $_GET['userid'];
} else {
  echo "<h1>User ID is not set! Please return to the <a href='/components/consent.php'>first page</a> of the survey otherwise your answers may not be recorded and you may not be paid.</h1>";
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
  "(userid, favorJB_rev, general_vote, completion_code)" .
  "VALUES (:userid, :favorJB_rev, :general_vote, :completion_code)");
  $stmt->bindParam(':userid', $userid);
  $stmt->bindParam(':favorJB_rev', $favorJB_rev);
  $stmt->bindParam(':general_vote', $general_vote);
  $stmt->bindParam(':completion_code', $complete_code);

  // Insert row
  $userid = $uuid;
  $favorJB_rev = $dbData['favorJB_rev'];
  $general_vote = $dbData['general_vote'];
  $complete_code = $ccode;
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
        <p>Your unique completion code is: <em><?php echo $ccode; ?></em>. It may take me a bit of time to verify your responses, but you should receive payment within 3 days of completing this task.</p>
        <p>If you have further questions about the survey, payment, or change your mind regarding consent, please contact me at <?php echo $email; ?></p>
      </div>
    </div>

  </div>
</body>
</html>
