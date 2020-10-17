<!DOCTYPE html>
<html>
<body>

<?php
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
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

// echo json_decode($response);
echo var_dump(json_decode($response));

$ad_choice = json_decode($response);
echo $ad_choice->best_ad;
?>


<p>The response body has been set to: <?php echo $ad_choice->best_ad; ?>, and that is all.</p>

<video width="480" height="400" controls="true" poster="" id="video">
    <source type="video/mp4" src="/<?php echo $ad_choice->best_ad; ?>"></source>
</video>

<!-- <div id="status" class="incomplete">
<span>Play status: </span>
<span class="status complete">COMPLETE</span>
<span class="status incomplete">INCOMPLETE</span>
<br/>
</div>
<div>
<span id="played">0</span> seconds out of
<span id="duration"></span> seconds. (only updates when the video pauses)
</div>

<script>
var video = document.getElementById("video");

var timeStarted = -1;
var timePlayed = 0;
var duration = 0;
// If video metadata is laoded get duration
if(video.readyState > 0)
  getDuration.call(video);
//If metadata not loaded, use event to get it
else
{
  video.addEventListener('loadedmetadata', getDuration);
}
// remember time user started the video
function videoStartedPlaying() {
  timeStarted = new Date().getTime()/1000;
}
function videoStoppedPlaying(event) {
  // Start time less then zero means stop event was fired vidout start event
  if(timeStarted>0) {
    var playedFor = new Date().getTime()/1000 - timeStarted;
    timeStarted = -1;
    // add the new ammount of seconds played
    timePlayed+=playedFor;
  }
  document.getElementById("played").innerHTML = Math.round(timePlayed)+"";
  // Count as complete only if end of video was reached
  if(timePlayed>=duration && event.type=="ended") {
    document.getElementById("status").className="complete";
  }
}

function getDuration() {
  duration = video.duration;
  document.getElementById("duration").appendChild(new Text(Math.round(duration)+""));
  console.log("Duration: ", duration);
}

video.addEventListener("play", videoStartedPlaying);
video.addEventListener("playing", videoStartedPlaying);

video.addEventListener("ended", videoStoppedPlaying);
video.addEventListener("pause", videoStoppedPlaying);
</script> -->

</body>
</html>
