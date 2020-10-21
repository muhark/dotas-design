
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
// Read in assigned ad variable from previous page.
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

      <div id="status" class="incomplete">
        <span>Play status: </span>
        <span class="status complete">COMPLETE</span>
        <span class="status incomplete">INCOMPLETE</span>
        <br />
      </div>
      <div>
        <span id="played">0</span> seconds out of
        <span id="duration"></span> seconds. (only updates when the video pauses)
      </div>
    </div>
  </div>
<script>
// First make the treatment prompt appear
// TODO: Receive treatment indicator from



// Script adapted from SO
var video = document.getElementById("video");

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
    TODO: Make "next" button appear.
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
