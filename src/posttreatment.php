<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Political Ads Survey</title>
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=font1|font2|etc" type="text/css">
  <link rel="stylesheet" href="/survey.css" type="text/css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.0/knockout-min.js"></script>
  <!-- <script src="https://assets.crowd.aws/crowd-html-elements.js"></script> -->
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
?>

<div id="surveyContainer" class-"sv-root-modern">

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

    <div id="surveyContent" class="sv-body__page">
      <form method="post" action="
      <?php
      echo "/end-of-survey.php?PROLIFIC_PID=" . $userData['PROLIFIC_PID'] .
           "&STUDY_ID=" . $userData['STUDY_ID'] .
           "&SESSION_ID=" . $userData['SESSION_ID'];
      ?>" target="_self">

        <!-- Favorability favorDT_rev -->
        <div class="sv-row sv-clearfix">
          <div class="sv-question sv-row__question" id="favorDT_rev" name="favorDT_rev" style="flex: 1 1 100%; width: 100%; min-width: 300px; max-width: initial;">
            <div class="sv-question__header sv-question__header--location--top">
              <h5 class="sv-title sv-question__title sv-question__title--required">
                <span style="position: static;" class="sv-question__num">1.</span>
                <span style="position: static;">
                  On a scale of 1-5, how would you rate Republican Presidential Candidate Donald Trump?
                </span>
                <span class="sv-question__required-text">*</span>
              </h5>
              <div class="sv-description sv-question__description">
                <span style="position: static;">
                  A rating of 4 or 5 means that you feel favorable and warm towards the candidate. A rating of 1 or 2 means that you don't feel favorable and warm towards the candidate. You would rate them at 3 if you don't feel particularly warm or cold toward them.
                </span>
              </div>
            </div>
            <div class="sv-question__content">
              <div role="alert" class="sv-question__erbox sv-question__erbox--location--top" id="sq_107_errors" style="display: none;"></div>
              <div class="sv-selectbase">

                <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                  <label class="sv-selectbase__label">
                    <input type="radio" name="favorDT_rev" id="favorDT_rev" aria-required="true" role="radio" value="1" required>
                    <span class="sv-item__control-label" title="Very cold">
                      <span style="position: static;">1. Very cold or unfavorable feeling</span>
                    </span>
                  </label>
                </div>

                <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                  <label class="sv-selectbase__label">
                    <input type="radio" name="favorDT_rev" id="favorDT_rev" aria-required="true" role="radio" value="2" required>
                    <span class="sv-item__control-label" title="Fairly cold">
                      <span style="position: static;">2. Fairly cold or unfavorable feeling</span>
                    </span>
                  </label>
                </div>

                <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                  <label class="sv-selectbase__label">
                    <input type="radio" name="favorDT_rev" id="favorDT_rev" aria-required="true" role="radio" value="3" required>
                    <span class="sv-item__control-label" title="No feeling">
                      <span style="position: static;">3. No feeling at all</span>
                    </span>
                  </label>
                </div>

                <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                  <label class="sv-selectbase__label">
                    <input type="radio" name="favorDT_rev" id="favorDT_rev" aria-required="true" role="radio" value="4" required>
                    <span class="sv-item__control-label" title="Fairly warm">
                      <span style="position: static;">4. Fairly warm or favorable feeling</span>
                    </span>
                  </label>
                </div>

                <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                  <label class="sv-selectbase__label">
                    <input type="radio" name="favorDT_rev" id="favorDT_rev" aria-required="true" role="radio" value="5" required>
                    <span class="sv-item__control-label" title="Very warm">
                      <span style="position: static;">5. Very warm or favorable feeling</span>
                    </span>
                  </label>
                </div>

              </div>
              <div class="sv-description sv-question__description" style="display: none;">
                <span style="position: static;"></span>
              </div>
          </div>
        </div>
        </div>

        <!-- Favorability favorJB_rev -->
        <div class="sv-row sv-clearfix">
          <div class="sv-question sv-row__question" id="favorJB_rev" name="favorJB_rev" style="flex: 1 1 100%; width: 100%; min-width: 300px; max-width: initial;">
            <div class="sv-question__header sv-question__header--location--top">
              <h5 class="sv-title sv-question__title sv-question__title--required">
                <span style="position: static;" class="sv-question__num">1.</span>
                <span style="position: static;">
                  On a scale of 1-5, how would you rate Democratic Presidential Candidate Joe Biden?
                </span>
                <span class="sv-question__required-text">*</span>
              </h5>
              <div class="sv-description sv-question__description">
                <span style="position: static;">
                  A rating of 4 or 5 means that you feel favorable and warm towards the candidate. A rating of 1 or 2 means that you don't feel favorable and warm towards the candidate. You would rate them at 3 if you don't feel particularly warm or cold toward them.
                </span>
              </div>
            </div>
            <div class="sv-question__content">
              <div role="alert" class="sv-question__erbox sv-question__erbox--location--top" id="sq_107_errors" style="display: none;"></div>
              <div class="sv-selectbase">

                <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                  <label class="sv-selectbase__label">
                    <input type="radio" name="favorJB_rev" id="favorJB_rev" aria-required="true" role="radio" value="1" required>
                    <span class="sv-item__control-label" title="Very cold">
                      <span style="position: static;">1. Very cold or unfavorable feeling</span>
                    </span>
                  </label>
                </div>

                <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                  <label class="sv-selectbase__label">
                    <input type="radio" name="favorJB_rev" id="favorJB_rev" aria-required="true" role="radio" value="2" required>
                    <span class="sv-item__control-label" title="Fairly cold">
                      <span style="position: static;">2. Fairly cold or unfavorable feeling</span>
                    </span>
                  </label>
                </div>

                <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                  <label class="sv-selectbase__label">
                    <input type="radio" name="favorJB_rev" id="favorJB_rev" aria-required="true" role="radio" value="3" required>
                    <span class="sv-item__control-label" title="No feeling">
                      <span style="position: static;">3. No feeling at all</span>
                    </span>
                  </label>
                </div>

                <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                  <label class="sv-selectbase__label">
                    <input type="radio" name="favorJB_rev" id="favorJB_rev" aria-required="true" role="radio" value="4" required>
                    <span class="sv-item__control-label" title="Fairly warm">
                      <span style="position: static;">4. Fairly warm or favorable feeling</span>
                    </span>
                  </label>
                </div>

                <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                  <label class="sv-selectbase__label">
                    <input type="radio" name="favorJB_rev" id="favorJB_rev" aria-required="true" role="radio" value="5" required>
                    <span class="sv-item__control-label" title="Very warm">
                      <span style="position: static;">5. Very warm or favorable feeling</span>
                    </span>
                  </label>
                </div>

              </div>
              <div class="sv-description sv-question__description" style="display: none;">
                <span style="position: static;"></span>
              </div>
          </div>
        </div>
        </div>

        <!-- Vote Propensity general_vote -->
        <div class="sv-row sv-clearfix">
          <div class="sv-question sv-row__question" id="general_vote" name="general_vote" style="flex: 1 1 100%; width: 100%; min-width: 300px; max-width: initial;">
            <div class="sv-question__header sv-question__header--location--top">
              <h5 class="sv-title sv-question__title sv-question__title--required">
                <span style="position: static;" class="sv-question__num">2.</span>
                <span style="position: static;">
                  Thinking about the 2020 Presidential Election between Donald Trump for the Republicans and Joe Biden for the Democrats, which of the following applies to you?
                </span>
                <span class="sv-question__required-text">*</span>
              </h5>
              <div class="sv-description sv-question__description">
                <span style="position: static;">
                  Place a check in the box for the option that best applies to you. For instance:<ul>
                    <li>If you haven't voted yet, but intend to vote for Donald Trump, then check the box "I intend to vote for Donald Trump".</li>
                    <li>If you have already voted, and you voted for Joe Biden, then check the box labelled "I have already voted for Joe Biden".</li>
                  </ul>
                </span>
              </div>
            </div>
            <div class="sv-question__content">
              <div role="alert" class="sv-question__erbox sv-question__erbox--location--top" id="sq_107_errors" style="display: none;"></div>
              <div class="sv-selectbase">

                <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                  <label class="sv-selectbase__label">
                    <input type="radio" name="general_vote" id="general_vote" aria-required="true" role="radio" value="1" required>
                    <span class="sv-item__control-label" title="Intend DT">
                      <span style="position: static;">I intend to vote for Donald Trump</span>
                    </span>
                  </label>
                </div>

                <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                  <label class="sv-selectbase__label">
                    <input type="radio" name="general_vote" id="general_vote" aria-required="true" role="radio" value="2" required>
                    <span class="sv-item__control-label" title="Intend JB">
                      <span style="position: static;">I intend to vote for Joe Biden</span>
                    </span>
                  </label>
                </div>

                <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                  <label class="sv-selectbase__label">
                    <input type="radio" name="general_vote" id="general_vote" aria-required="true" role="radio" value="3" required>
                    <span class="sv-item__control-label" title="Intend Other">
                      <span style="position: static;">I intend to vote for a different candidate</span>
                    </span>
                  </label>
                </div>

                <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                  <label class="sv-selectbase__label">
                    <input type="radio" name="general_vote" id="general_vote" aria-required="true" role="radio" value="4" required>
                    <span class="sv-item__control-label" title="Already DT">
                      <span style="position: static;">I already voted for Donald Trump</span>
                    </span>
                  </label>
                </div>

                <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                  <label class="sv-selectbase__label">
                    <input type="radio" name="general_vote" id="general_vote" aria-required="true" role="radio" value="5" required>
                    <span class="sv-item__control-label" title="Already JB">
                      <span style="position: static;">I already voted for Joe Biden</span>
                    </span>
                  </label>
                </div>

                <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                  <label class="sv-selectbase__label">
                    <input type="radio" name="general_vote" id="general_vote" aria-required="true" role="radio" value="6" required>
                    <span class="sv-item__control-label" title="Already Other">
                      <span style="position: static;">I already voted for a different candidate</span>
                    </span>
                  </label>
                </div>

                <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                  <label class="sv-selectbase__label">
                    <input type="radio" name="general_vote" id="general_vote" aria-required="true" role="radio" value="7" required>
                    <span class="sv-item__control-label" title="No Vote">
                      <span style="position: static;">I do not intend to vote</span>
                    </span>
                  </label>
                </div>

                <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                  <label class="sv-selectbase__label">
                    <input type="radio" name="general_vote" id="general_vote" aria-required="true" role="radio" value="8" required>
                    <span class="sv-item__control-label" title="No say">
                      <span style="position: static;">Prefer not to answer</span>
                    </span>
                  </label>
                </div>

              </div>
              <div class="sv-description sv-question__description" style="display: none;">
                <span style="position: static;"></span>
              </div>
          </div>
        </div>
        </div>
      <div data-bind="css: css.footer" class="sv-footer sv-body__footer sv-clearfix">
          <input type="submit" value="Complete" class="sv-btn sv-footer__complete-btn">
      </div>
      </form>
    </div>
  </div>
</div>
