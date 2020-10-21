<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Political Ads Survey Page 2</title>
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=font1|font2|etc" type="text/css">
  <link rel="stylesheet" href="/survey.css" type="text/css">
</head>

<body>

<?php
// Read _GET variable
$awsVars = array(
  'assignmentId',
  'hitId',
  'workerId'
);

$awsData = array();

foreach($awsVars as $name){
  if(isset($_GET[$name])){
    // echo $name . " is set to " . $_GET[$name] . "<br>";
    $awsData[$name] = $_GET[$name];
  } else {
    // echo $name . " is unset<br>";
    $awsData[$name] = "placeholder_" . $name;
  }
}
// Jupyter interaction
// First construct array of form data
$postVars = array(
  'age',
  'gender',
  'race',
  'income',
  'region',
  'newsint',
  'track_pre',
  'pid_7_pre',
  'ideo5_pre'
);
$dbData = array();
foreach($postVars as $name){
  if(isset($_POST[$name])){
    // echo $_POST[$name] . "<br>";
    $dbData[$name] = $_POST[$name];
  }
}

// cURL POST jupyter kernel
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8889/predict");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dbData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

// echo var_dump(json_decode($response));

$ad_choice = json_decode($response);
// echo $ad_choice->video;
// echo $ad_choice->brief;

// Two responses: ad_choice gives video in ad.php, brief gives statement
// on this page.
$video = $ad_choice->video;
$brief = $ad_choice->brief;

// Write the form responses to the database before continuing
// Read database access from config
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
  $stmt = $conn->prepare("INSERT INTO test_pre" .
  "(assignmentId, hitId, workerId, age, gender, race, income, region, newsint, track_pre, pid_7_pre, ideo5_pre)" .
  "VALUES (:assignmentId, :hitId, :workerId, :age, :gender, :race, :income, :region, :newsint, :track_pre, :pid_7_pre, :ideo5_pre)");
  $stmt->bindParam(':assignmentId', $assignmentId);
  $stmt->bindParam(':hitId', $hitId);
  $stmt->bindParam(':workerId', $workerId);
  $stmt->bindParam(':age', $age);
  $stmt->bindParam(':gender', $gender);
  $stmt->bindParam(':race', $race);
  $stmt->bindParam(':income', $income);
  $stmt->bindParam(':region', $region);
  $stmt->bindParam(':newsint', $newsint);
  $stmt->bindParam(':track_pre', $track_pre);
  $stmt->bindParam(':pid_7_pre', $pid_7_pre);
  $stmt->bindParam(':ideo5_pre', $ideo5_pre);

  // Insert row
  $assignmentId = $awsData['assignmentId'];
  $hitId = $awsData['hitId'];
  $workerId = $awsData['workerId'];
  $age = $dbData['age'];
  $gender = $dbData['gender'];
  $race = $dbData['race'];
  $income = $dbData['income'];
  $region = $dbData['region'];
  $newsint = $dbData['newsint'];
  $track_pre = $dbData['track_pre'];
  $pid_7_pre = $dbData['pid_7_pre'];
  $ideo5_pre = $dbData['ideo5_pre'];
  $stmt->execute();

} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}

$conn = null;

// Generate briefing page
$briefURL = "/home/" . get_current_user() . "/Dev/dotas-design/briefs/" . $brief . ".html";
$briefContent = readfile($briefURL);
echo $briefContent;

?>

<form method="post" action="
  <?php
  echo "/components/ad.php?assignmentId=" . $awsData['assignmentId'] . "&hitId=" . $awsData['hitId'] . "&=" . $awsData['workerId'];
  ?>" target="_self">
  <input type="hidden" name="video" value="<?php echo $video; ?>" />
  <div data-bind="css: css.footer" class="sv-footer sv-body__footer sv-clearfix">
      <input type="submit" value="Continue" class="sv-btn sv-footer__complete-btn">
  </div>
</form>


</body>
</html>
