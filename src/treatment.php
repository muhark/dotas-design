<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Political Ads Survey Page 2</title>
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=font1|font2|etc" type="text/css">
  <link rel="stylesheet" href="/survey.css" type="text/css">
</head>

<body>

<div class="sv-page sv-body__page">
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
    echo $name . " is unset<br>";
    $userData[$name] = "UNSET_" . $name;
  }
}

// Jupyter interaction
// First construct array of form data
$postVars = array(
  'age',
  'gender',
  'race',
  'income',
  'state',
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
// SET TO /train FOR STAGE 1
// SET TO /predict FOR STAGE 2
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8889/train");
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
$video = "ad-" . $ad_choice->video;
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
  "(prolific_pid, study_id, session_id, age, gender, race, income, state, newsint, track_pre, pid_7_pre, ideo5_pre, ad_id, brief_id)" .
  "VALUES (:prolific_pid, :study_id, :session_id, :age, :gender, :race, :income, :state, :newsint, :track_pre, :pid_7_pre, :ideo5_pre, :ad_id, :brief_id)");
  $stmt->bindParam(':prolific_pid', $prolific_pid);
  $stmt->bindParam(':study_id', $study_id);
  $stmt->bindParam(':session_id', $session_id);
  $stmt->bindParam(':age', $age);
  $stmt->bindParam(':gender', $gender);
  $stmt->bindParam(':race', $race);
  $stmt->bindParam(':income', $income);
  $stmt->bindParam(':state', $state);
  $stmt->bindParam(':newsint', $newsint);
  $stmt->bindParam(':track_pre', $track_pre);
  $stmt->bindParam(':pid_7_pre', $pid_7_pre);
  $stmt->bindParam(':ideo5_pre', $ideo5_pre);
  $stmt->bindParam(':ad_id', $ad_id);
  $stmt->bindParam(':brief_id', $brief_id);

  // Insert row
  $prolific_pid = $userData['PROLIFIC_PID'];
  $study_id = $userData['STUDY_ID'];
  $session_id = $userData['SESSION_ID'];
  $age = $dbData['age'];
  $gender = $dbData['gender'];
  $race = $dbData['race'];
  $income = $dbData['income'];
  $state = $dbData['state'];
  $newsint = $dbData['newsint'];
  $track_pre = $dbData['track_pre'];
  $pid_7_pre = $dbData['pid_7_pre'];
  $ideo5_pre = $dbData['ideo5_pre'];
  $ad_id = $ad_choice->video;
  $brief_id = $brief;
  $stmt->execute();

} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}

$conn = null;

// Generate briefing page
$briefURL = "/home/" . get_current_user() . "/Dev/dotas-design/briefs/" . $brief . ".html";
$briefFile = fopen($briefURL, "r");
echo fread($briefFile, filesize($briefURL));
fclose($briefFile);

?>

<form method="post" action="
  <?php
  echo "/ad.php?PROLIFIC_PID=" . $userData['PROLIFIC_PID'] .
       "&STUDY_ID=" . $userData['STUDY_ID'] .
       "&SESSION_ID=" . $userData['SESSION_ID'];
  ?>" target="_self">
  <input type="hidden" name="video" value="<?php echo $video; ?>" />
  <div data-bind="css: css.footer" class="sv-footer sv-body__footer sv-clearfix">
      <input type="submit" value="Continue" class="sv-btn sv-footer__complete-btn">
  </div>
</form>
</div>

</body>
</html>
