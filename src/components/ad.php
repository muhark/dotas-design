
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Political Ads Survey Page 4</title>
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=font1|font2|etc" type="text/css">
  <link rel="stylesheet" href="/survey.css" type="text/css">
</head>
<body>
<?php
// Parse GET uuid
if(isset($_GET['userid'])){
  $uuid = $_GET['userid'];
} else {
  echo "<h1>User ID is not set! Please return to the <a href="/components/consent.php">first page</a> of the survey otherwise your answers may not be recorded and you may not be paid.</h1>"
}
?>

  <!-- TITLE -->
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

  <!-- SUBTITLE AND BRIEF -->
  <div id="video-container">
    <div class="sv-page sv-body__page">
      <h4 class="sv-title sv-page__title">
        <span style="position: static;">Short Political Advertisement</span>
      </h4>
      <div class="sv-description sv-page__description">
        <span style="position: static;">Please watch this video from beginning to end, without skipping ahead. Once the video has been watched, the option to proceed to the next page will become available.</span>
      </div>

      <video width="480" height="400" controls="false" poster="" id="video">
        <source type="video/mp4" src="<?php echo $_POST['video']; ?>">
        </source>
      </video>

      <div>
        <span id="played">0</span> seconds out of
        <span id="duration"></span> seconds. (This updates when the video is paused).
      </div>
    </div>
  <div id="nextButton">
    <form method="post" action="
      <?php
      echo "/components/posttreatment.php?userid=" . $uuid;
      ?>" target="_self">
      <div data-bind="css: css.footer" class="sv-footer sv-body__footer sv-clearfix">
          <input type="submit" value="Continue" class="sv-btn sv-footer__complete-btn">
      </div>
    </form>
  </div>

  </div>
<script>
// Script adapted from SO
var video = document.getElementById("video");
var nxtbtn = document.getElementById("nextButton");
nextButton.style.display = "none"

var timeStarted = -1;
var timePlayed = 0;
var duration = 0;
// If video metadata is loaded get duration
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
    nextButton.style.display = "block";
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
</script>

</body>
</html>
