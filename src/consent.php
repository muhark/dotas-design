<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Consent Form</title>
  <link rel="stylesheet" href="/survey.css" type="text/css">

</head>

<body>
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

if(isset($_GET['PROLIFIC_PID'])){
  $email = "musashi.harukawa@politics.ox.ac.uk";
} else {
  $email = "musashi{dot}harukawa{=^.^= - C}ox{dot}ac{dot}uk";
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

  <!-- BODY STARTS -->
  <div class="sv-page sv-body__page">

    <!-- SUBHEADER AND BRIEF -->
    <div class="sv-page sv-page__description">
      <h4 class="sv-title sv-page__title">Participant Consent Form</h4>
      <div class="sv-description sv-page__description">
        <h6>Doctoral Research in Political Campaigning</h6>
        <p>Central University Research Ethics Committee (CUREC) Approval Reference: SSH_DPIR_C1A_20_019</p>
      </div>
    </div>

    <div class="sv-row sv-clearfix">
      <div class="sv-question" style="flex: 1 1 100%; width: 100%; min-width: 300px; max-width: initial;" id="consent0" name="consent0">
        <h5 class="sv-question__title">
          Key Points regarding Data and Consent:
        </h5>
        <!-- <h5 class="sv-question__title">
          Prior to starting the survey, please take a moment to <a href="/Participant-Information-Sheet.docx">download and read the Participant Information Sheet</a>, and record your consent to the following below.
        </h5> -->
        <div class="sv-description sv-question__description">
          <ul>
            <li><b>Purpose of Study:</b> The aim of this research is to better measure the effect of political advertisements with the aim of providing better evidence-based strategies for their regulation.</li>
            <li><b>Data Collected:</b> This survey asks 13 questions, and records an additional 4 pieces of metadata.<ul>
              <li>13 questions concerning demographic traits such as age, gender, ethnicity, and geographic region, as well as political opinions. These are central to the research being conducted. <em>Only this data will be shared with other researchers</em></li>
              <li>4 pieces of metadata include 3 data points regarding user, session and study id, provided by Prolific. The final point is the time of submission. These data points are used to link Prolific accounts with completed tasks so that payment can be made.</li>
            </ul></li>
            <li><b>Data Security:</b> None of the information collected is personally identifiable. Nevertheless, because the researcher cares greatly about data security, all stored information will be stored and transferred in a cryptographically secure manner.</li>
            <li><b>Your Consent:</b> Your participation in this research is entirely <em>voluntary</em>. You may also withdraw your consent, without giving a reason, by advising me prior to 31 December 2020. After this point, information provided may be included in publication, but will always remain anonymised and secure.</li>
            <li><b>Further Information:</b> For further information, you can contact the lead researcher at <?php echo $email; ?>. At the end of the survey there will also be a debrief and Participant Information Sheet.</li>
        </div>
        <form method="post" action="
        <?php
        echo "/consent-interstitial.php?PROLIFIC_PID=" . $userData['PROLIFIC_PID'] .
             "&STUDY_ID=" . $userData['STUDY_ID'] .
             "&SESSION_ID=" . $userData['SESSION_ID'];
        ?>" target="_self">

          <ol type="1">
            <li> <input type="checkbox" id="consent1" name="consent1" value="1" required><label for="consent1">I agree to take part in this study.</label></li>
            <li> <input type="checkbox" id="consent1" name="consent2" value="1" required><label for="consent1">I understand that my participation is voluntary and that I am free to withdraw at any time, without giving any reason, and without any adverse consequences or penalty.</label></li>
            <li> <input type="checkbox" id="consent1" name="consent3" value="1" required><label for="consent1">I understand that the answers I provide may be accessed by authorised researchers outside the research team, potentially outside the UK and EU. I give permission for these individuals to access my data.</label></li>
            <li> <input type="checkbox" id="consent1" name="consent4" value="1" required><label for="consent1">I understand that I may raise concerns and complaints to the researcher at any time.</label></li>
          </ol>
      </div>
    </div>
    <div data-bind="css: css.footer" class="sv-footer sv-body__footer sv-clearfix">
      <input type="submit" value="Submit" class="sv-btn sv-footer__complete-btn">
    </div>
    </form>
  </div>
