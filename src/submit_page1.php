<!DOCTYPE html>
<html>
<body>

<?php
$postVars = array(
  'birthyear',
  'gender',
  'race',
  'income',
  'region',
  'newsint',
  'track_pre',
  'pid_7_pre',
  'ideo5_pre'
);

$postData = array();

foreach($postVars as $name){
  if(isset($_POST[$name])){
    // echo $_POST[$name];
    $postData[$name] = $_POST[$name];
  }
}


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8889/testpredict");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
// curl_setopt($ch, CURLLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

echo $response['best_ad_id'];


?>
<!-- List of Variables -->
<!--
- birthyear
- gender
- race
- income
- newsint
- track_pre
- pid_7_pre
- ideo_5_pre
 -->


</body>
</html>
