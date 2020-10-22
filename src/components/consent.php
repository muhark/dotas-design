<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Consent Form</title>
  <link rel="stylesheet" href="/survey.css" type="text/css">

</head>

<body>
<?php
// Generate UUID
$uuid = uuid_create(UUID_TYPE_RANDOM);
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
        <p>
          Purpose of Study: <em>Purpose of Study: The aim of this research is to better measure the effect of political advertisements with the aim of providing better evidence-based strategies for their regulation.</em>
        </p>
      </div>
    </div>

    <div class="sv-row sv-clearfix">
      <div class="sv-question" style="flex: 1 1 100%; width: 100%; min-width: 300px; max-width: initial;" id="consent0" name="consent0">
        <h5 class="sv-question__title">
          Prior to starting the survey, please take a moment to <a href="/Participant-Information-Sheet.docx">download and read the Participant Information Sheet</a>, and record your consent to the following below.
        </h5>
        <div class="sv-description sv-question__description">
          <p>
            Please note, your answers on this page will be stored separately so that your name is not directly linked to the answers you give in the data.
          </p>
        </div>
        <form method="post" action="
        <?php
        echo "/components/consent-interstitial.php?userid=" . $uuid;
        ?>" target="_self">

          <ol type="1">
            <li> <input type="checkbox" id="consent1" name="consent1" value="1" required><label for="consent1">I confirm that I have read and understand the information sheet version 1 dated 15 October 2020 for the above study. I have had the opportunity to
                consider the information, ask questions and have had these answered satisfactorily.</label>
            <li> <input type="checkbox" id="consent2" name="consent2" value="1" required><label for="consent2">I understand that my participation is voluntary and that I am free to withdraw at any time, without giving any reason, and without any adverse
                consequences or penalty.</label>
            <li> <input type="checkbox" id="consent3" name="consent3" value="1" required><label for="consent3">I understand that research data collected during the study may be looked at by authorised people outside the research team. I give permission for
                these individuals to access my data.</label>
            <li> <input type="checkbox" id="consent4" name="consent4" value="1" required><label for="consent4">I understand that this project has been reviewed by, and received ethics clearance through, the University of Oxford Central University Research
                Ethics Committee.</label>
            <li> <input type="checkbox" id="consent5" name="consent5" value="1" required><label for="consent5">I understand who will have access to personal data provided, how the data will be stored and what will happen to the data at the end of the
                project.</label>
            <li> <input type="checkbox" id="consent6" name="consent6" value="1" required><label for="consent6">I understand how this research will be written up and published.</label>
            <li> <input type="checkbox" id="consent7" name="consent7" value="1" required><label for="consent7">I understand how to raise a concern or make a complaint.</label>
            <li> <input type="checkbox" id="consent8" name="consent8" value="1" required><label for="consent8">I agree to take part in the study.</label>
            <li> <input type="checkbox" id="consent9" name="consent9" value="1" required><label for="consent9">I agree for research data collected in this study to be given to researchers, including those working outside of the UK and the EU, to be used in
                other research studies. I understand that any data that leave the research group will be anonymised so that I cannot be identified.</label>
          </ol>
      </div>
    </div>
    <div data-bind="css: css.footer" class="sv-footer sv-body__footer sv-clearfix">
      <input type="submit" value="Submit" class="sv-btn sv-footer__complete-btn">
    </div>
    </form>
  </div>
