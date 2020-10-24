<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Political Ads Survey</title>
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=font1|font2|etc" type="text/css">
  <link rel="stylesheet" href="/survey.css" type="text/css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.0/knockout-min.js"></script>
  <script src="https://assets.crowd.aws/crowd-html-elements.js"></script>
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
    echo $name . " is set to " . $_GET[$name] . "<br>";
    $userData[$name] = $_GET[$name];
  } else {
    echo $name . " is unset<br>";
    $userData[$name] = "UNSET_" . $name;
  }
}
?>
  <crowd-instructions link-text="View instructions" link-type="button">
    <short-summary>
    </short-summary>
    <detailed-instructions>
      <h3>Survey Overview</h3>
      <p>This survey consists of three parts, taking 3-5 minutes in total.</p>
      <li>In the first part, you will be asked a number of questions about yourself. Please answer truthfully to the best of your ability, and note that all answers will be handled in line with GDPR and academic ethics and anonymity requirements.
      </li>
      <li>In the second part, you will be shown a short campaign advertisement video. You do not need to do anything, but please pay attention to the video.</li>
      <li>In the final part, you will be asked a few questions about the video.</li>
    </detailed-instructions>
  </crowd-instructions>

<div id="surveyContainer" class="sv-root-modern">
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

  <!-- SUBHEADER AND BRIEF -->

  <div id="sp_100">
    <div class="sv-page sv-body__page">
      <h4 class="sv-title sv-page__title">
        <span style="position: static;">Welcome to the 2020 Political Ad Survey</span>
      </h4>
      <div class="sv-description sv-page__description">
        <span style="position: static;">This survey asks you a few questions about yourself, asks you to watch a short ad, and asks your opinion on matters relating to the ad. It forms part of academic research into the effects of political
          campaigning. In total this should take you
          between 3-5 minutes.</span>
      </div>

      <!-- FORM BEGINS -->
      <form method="post" action="
        <?php
        echo "/treatment.php?PROLIFIC_PID=" . $userData['PROLIFIC_PID'] .
             "&STUDY_ID=" . $userData['STUDY_ID'] .
             "&SESSION_ID=" . $userData['SESSION_ID'];
        ?>" target="_self">

        <!-- AGE -->
      <div class="sv-row sv-clearfix">
        <div class="sv-question sv-row__question sv-row__question--small" id="sq_100" name="Age" aria-labelledby="sq_100_ariaTitle" style="flex: 1 1 100%; width: 100%; min-width: 300px; max-width: initial;">
          <div class="sv-question__header sv-question__header--location--top">
            <h5 class="sv-title sv-question__title sv-question__title--required" aria-label="Please write your age in years." id="sq_100_ariaTitle">
              <span style="position: static;" class="sv-question__num">1.</span>
              <span style="position: static;">Please write your age in years.</span>
              <span class="sv-question__required-text">*</span>
            </h5>
            <div class="sv-description sv-question__description">
              <span style="position: static;"></span>
            </div>
          </div>
          <!-- AGE Q CONTENT -->
          <div class="sv-question__content">
            <div role="alert" class="sv-question__erbox sv-question__erbox--location--top" id="sq_100_errors" style="display: none;"></div>
            <div>
              <select id="age" name="age" aria-label="Please select your age in years." class="sv-dropdown" required>
                <option value="">Choose...</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
                <option value="32">32</option>
                <option value="33">33</option>
                <option value="34">34</option>
                <option value="35">35</option>
                <option value="36">36</option>
                <option value="37">37</option>
                <option value="38">38</option>
                <option value="39">39</option>
                <option value="40">40</option>
                <option value="41">41</option>
                <option value="42">42</option>
                <option value="43">43</option>
                <option value="44">44</option>
                <option value="45">45</option>
                <option value="46">46</option>
                <option value="47">47</option>
                <option value="48">48</option>
                <option value="49">49</option>
                <option value="50">50</option>
                <option value="51">51</option>
                <option value="52">52</option>
                <option value="53">53</option>
                <option value="54">54</option>
                <option value="55">55</option>
                <option value="56">56</option>
                <option value="57">57</option>
                <option value="58">58</option>
                <option value="59">59</option>
                <option value="60">60</option>
                <option value="61">61</option>
                <option value="62">62</option>
                <option value="63">63</option>
                <option value="64">64</option>
                <option value="65">65</option>
                <option value="66">66</option>
                <option value="67">67</option>
                <option value="68">68</option>
                <option value="69">69</option>
                <option value="70">70</option>
                <option value="71">71</option>
                <option value="72">72</option>
                <option value="73">73</option>
                <option value="74">74</option>
                <option value="75">75</option>
                <option value="76">76</option>
                <option value="77">77</option>
                <option value="78">78</option>
                <option value="79">79</option>
                <option value="80">80</option>
                <option value="81">81</option>
                <option value="82">82</option>
                <option value="83">83</option>
                <option value="84">84</option>
                <option value="85">85</option>
              </select>
            </div>
            <div class="sv-description sv-question__description" style="display: none;">
              <span style="position: static;"></span>
            </div>
          </div>
        </div><!-- /ko -->
      </div>

      <!-- GENDER -->
      <div class="sv-row sv-clearfix">
        <div class="sv-question sv-row__question" id="sq_101" name="gender" aria-labelledby="sq_101_ariaTitle" style="flex: 1 1 100%; width: 100%; min-width: 300px; max-width: initial;">
          <div class="sv-question__header sv-question__header--location--top">
            <h5 class="sv-title sv-question__title sv-question__title--required" aria-label="What is your gender?" id="sq_101_ariaTitle">
              <span style="position: static;" class="sv-question__num">2.</span>
              <span style="position: static;">What is your gender?</span>
              <span class="sv-question__required-text">*</span>
            </h5>
            <div class="sv-description sv-question__description">
              <span style="position: static;"></span>
            </div>
          </div>
          <!-- GENDER Q CONTENT -->
          <div class="sv-question__content">
            <div role="alert" class="sv-question__erbox sv-question__erbox--location--top" id="sq_101_errors" style="display: none;"></div>
            <fieldset role="radiogroup" class="sv-selectbase">
              <legend aria-label="What is your gender?"></legend>
              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="gender" id="gender" aria-required="true" aria-label="Male" role="radio" value="0" required>
                  <span class="sv-item__control-label" title="Male">
                    <span style="position: static;">Male</span>
                  </span>
                </label>
              </div>
              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="gender" id="gender" aria-required="true" aria-label="Female" role="radio" value="1" required>
                  <span class="sv-item__control-label" title="Female">
                    <span style="position: static;">Female</span>
                  </span>
                </label>
              </div>
            </fieldset><!-- /ko -->
            <div class="sv-description sv-question__description" style="display: none;">
              <span style="position: static;"></span>
            </div>
          </div>
        </div><!-- /ko -->
      </div>

      <div class="sv-row sv-clearfix">
        <div class="sv-question sv-row__question sv-row__question--small" id="sq_102" name="race" aria-labelledby="sq_102_ariaTitle" style="flex: 1 1 100%; width: 100%; min-width: 300px; max-width: initial;">
          <div class="sv-question__header sv-question__header--location--top">
            <h5 class="sv-title sv-question__title sv-question__title--required" aria-label="Select the race that best describes you." id="sq_102_ariaTitle">
              <span style="position: static;" class="sv-question__num">3.</span>
              <span style="position: static;">Select the race that best describes you.</span>
              <span class="sv-question__required-text">*</span>
            </h5>
            <div class="sv-description sv-question__description">
              <span style="position: static;"></span>
            </div>
          </div>
          <div class="sv-question__content">
            <div role="alert" class="sv-question__erbox sv-question__erbox--location--top" id="sq_102_errors" style="display: none;"></div>
            <div>
              <select id="race" aria-label="Select the race that best describes you." class="sv-dropdown" name="race" required>
                <option value="">Choose...</option>
                <option value="2">Black</option>
                <option value="8">Middle Eastern</option>
                <option value="5">Native American</option>
                <option value="6">Mixed</option>
                <option value="4">Asian</option>
                <option value="7">Other</option>
                <option value="3">Hispanic</option>
                <option value="1">White</option>
              </select>
            </div>
            <div class="sv-description sv-question__description" style="display: none;">
              <span style="position: static;"></span>
            </div>
          </div>
        </div><!-- /ko -->
      </div>

      <div class="sv-row sv-clearfix">
        <div class="sv-question sv-row__question" id="sq_103" name="income" aria-labelledby="sq_103_ariaTitle" style="flex: 1 1 100%; width: 100%; min-width: 300px; max-width: initial;">
          <div class="sv-question__header sv-question__header--location--top">
            <h5 class="sv-title sv-question__title sv-question__title--required" aria-label="Which of the following describes your annual income?" id="sq_103_ariaTitle">
              <span style="position: static;" class="sv-question__num">4.</span>
              <span style="position: static;">Which of the following describes your annual income?</span>
              <span class="sv-question__required-text">*</span>
            </h5>
            <div class="sv-description sv-question__description">
              <span style="position: static;"></span>
            </div>
          </div>
          <div class="sv-question__content">
            <div role="alert" class="sv-question__erbox sv-question__erbox--location--top" id="sq_103_errors" style="display: none;"></div>
            <fieldset role="radiogroup" class="sv-selectbase">
              <legend aria-label="Which of the following describes your annual income?"></legend>
              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="income" id="income" aria-required="true" aria-label="Under $50k" role="radio" value="1" required>
                  <span class="sv-item__control-label" title="Under $50k">
                    <span style="position: static;">Under $50k</span>
                  </span>
                </label>
              </div>
              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="income" id="income" aria-required="true" aria-label="$50k to $100k" role="radio" value="2" required>
                  <span class="sv-item__control-label" title="$50k to $100k">
                    <span style="position: static;">$50k to $100k</span>
                  </span>
                </label>
              </div>
              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="income" id="income" aria-required="true" aria-label="$100k or more" role="radio" value="3" required>
                  <span class="sv-item__control-label" title="$100k or more">
                    <span style="position: static;">$100k or more</span>
                  </span>
                </label>
              </div>
              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="income" id="income" aria-required="true" aria-label="Prefer not to say" role="radio" value="4" required>
                  <span class="sv-item__control-label" title="Prefer not to say">
                    <span style="position: static;">Prefer not to say</span>
                  </span>
                </label>
              </div>
            </fieldset><!-- /ko -->
            <div class="sv-description sv-question__description" style="display: none;">
              <span style="position: static;"></span>
            </div>
          </div>
        </div><!-- /ko -->
      </div>

      <!-- REGION -->
      <div class="sv-row sv-clearfix">
        <div class="sv-question sv-row__question" id="sq_104" name="region" aria-labelledby="sq_104_ariaTitle" style="flex: 1 1 100%; width: 100%; min-width: 300px; max-width: initial;">
          <div class="sv-question__header sv-question__header--location--top">
            <h5 class="sv-title sv-question__title sv-question__title--required" id="sq_104_ariaTitle">
              <span style="position: static;" class="sv-question__num">5.</span>
              <span style="position: static;">Which region of the United States do you live in?</span>
              <span class="sv-question__required-text">*</span>
            </h5>
            <div class="sv-description sv-question__description">
              <span style="position: static;"></span>
            </div>
          </div>
          <div class="sv-question__content">
            <div role="alert" class="sv-question__erbox sv-question__erbox--location--top" id="sq_104_errors" style="display: none;"></div>
            <fieldset role="radiogroup" class="sv-selectbase">
              <legend aria-label="Which region of the United States do you live in?"></legend>
              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="region" id="region" aria-required="true" aria-label="West" role="radio" value="4" required>
                  <span class="sv-item__control-label" title="West">
                    <span style="position: static;">West</span>
                  </span>
                </label>
              </div>
              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="region" id="region" aria-required="true" aria-label="South" role="radio" value="3" required>
                  <span class="sv-item__control-label" title="South">
                    <span style="position: static;">South</span>
                  </span>
                </label>
              </div>
              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="region" id="region" aria-required="true" aria-label="Midwest" role="radio" value="2" required>
                  <span class="sv-item__control-label" title="Midwest">
                    <span style="position: static;">Midwest</span>
                  </span>
                </label>
              </div>
              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="region" id="region" aria-required="true" aria-label="Northeast" role="radio" value="1" required>
                  <span class="sv-item__control-label" title="Northeast">
                    <span style="position: static;">Northeast</span>
                  </span>
                </label>
              </div>
            </fieldset><!-- /ko -->
            <div class="sv-description sv-question__description" style="display: none;">
              <span style="position: static;"></span>
            </div>
          </div>
        </div><!-- /ko -->
      </div>

      <!-- NEWSINT -->
      <div class="sv-row sv-clearfix">
        <div class="sv-question sv-row__question" id="sq_105" name="newsint" aria-labelledby="sq_105_ariaTitle" style="flex: 1 1 100%; width: 100%; min-width: 300px; max-width: initial;">
          <div class="sv-question__header sv-question__header--location--top">
            <h5 class="sv-title sv-question__title sv-question__title--required" id="sq_105_ariaTitle">
              <span style="position: static;" class="sv-question__num">6.</span>
              <span style="position: static;">Some people seem to follow what's going on in government and public affairs most of the time, whether there's an election going on or not. Others aren't that interested. Would you say you follow what's going on in government and public affairs...</span>
              <span class="sv-question__required-text">*</span>
            </h5>
            <div class="sv-description sv-question__description">
              <span style="position: static;"></span>
            </div>
          </div>
          <div class="sv-question__content">
            <div role="alert" class="sv-question__erbox sv-question__erbox--location--top" id="sq_105_errors" style="display: none;"></div>
            <fieldset role="radiogroup" class="sv-selectbase">
              <legend
                aria-label="Some people seem to follow what's going on in government and public affairs most of the time, whether there's an election going on or not. Others aren't that interested. Would you say you follow what's going on in government and public affairs...">
              </legend>
              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="newsint" id="newsint" aria-required="true" aria-label="Most of the time" role="radio" value="1" required>
                  <span class="sv-item__control-label" title="Most of the time">
                    <span style="position: static;">Most of the time</span>
                  </span>
                </label>
              </div>
              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="newsint" id="newsint" aria-required="true" aria-label="Some of the time" role="radio" value="2" required>
                  <span class="sv-item__control-label" title="Some of the time">
                    <span style="position: static;">Some of the time</span>
                  </span>
                </label>
              </div>
              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="newsint" id="newsint" aria-required="true" aria-label="Only now and then" role="radio" value="3" required>
                  <span class="sv-item__control-label" title="Only now and then">
                    <span style="position: static;">Only now and then</span>
                  </span>
                </label>
              </div>
              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="newsint" id="newsint" aria-required="true" aria-label="Hardly at all" role="radio" value="4" required>
                  <span class="sv-item__control-label" title="Hardly at all">
                    <span style="position: static;">Hardly at all</span>
                  </span>
                </label>
              </div>
            </fieldset><!-- /ko -->
            <div class="sv-description sv-question__description" style="display: none;">
              <span style="position: static;"></span>
            </div>
          </div>
        </div><!-- /ko -->
      </div>

      <div class="sv-row sv-clearfix">
        <div class="sv-question sv-row__question" id="sq_106" name="track_pre" aria-labelledby="sq_106_ariaTitle" style="flex: 1 1 100%; width: 100%; min-width: 300px; max-width: initial;">
          <!--ko template: { name: 'survey-question-title', data: question  } -->
          <div class="sv-question__header sv-question__header--location--top">
            <h5 class="sv-title sv-question__title sv-question__title--required" aria-label="Generally speaking, would you say things in the country are going in the right direction, or are they off on the wrong track?" id="sq_106_ariaTitle">
              <span style="position: static;" class="sv-question__num">7.</span>
              <span style="position: static;">Generally speaking, would you say things in the country are going in the right direction, or are they off on the wrong track?</span>
              <span class="sv-question__required-text">*</span>
            </h5>
            <div class="sv-description sv-question__description">
              <span style="position: static;"></span>
            </div>
          </div>
          <div class="sv-question__content">
            <div role="alert" class="sv-question__erbox sv-question__erbox--location--top" id="sq_106_errors" style="display: none;"></div>
            <fieldset role="radiogroup" class="sv-selectbase">
              <legend aria-label="Generally speaking, would you say things in the country are going in the right direction, or are they off on the wrong track?"></legend>
              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="track_pre" id="track_pre" aria-required="true" aria-label="Right direction" role="radio" value="right track" required>
                  <span class="sv-item__control-label" title="Right direction">
                    <span style="position: static;">Right direction</span>
                  </span>
                </label>
              </div>
              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="track_pre" id="track_pre" aria-required="true" aria-label="Wrong track" role="radio" value="wrong track" required>
                  <span class="sv-item__control-label" title="Wrong track">
                    <span style="position: static;">Wrong track</span>
                  </span>
                </label>
              </div>
              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="track_pre" id="track_pre" aria-required="true" aria-label="I'm not sure" role="radio" value="not sure" required>
                  <span class="sv-item__control-label" title="I'm not sure">
                    <span style="position: static;">I'm not sure</span>
                  </span>
                </label>
              </div>
            </fieldset><!-- /ko -->
            <div class="sv-description sv-question__description" style="display: none;">
              <span style="position: static;"></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Modified PID_7_PRE -->
      <div class="sv-row sv-clearfix">
        <div class="sv-question sv-row__question" id="pid_7_pre" name="pid_7_pre" aria-labelledby="sq_107_ariaTitle" style="flex: 1 1 100%; width: 100%; min-width: 300px; max-width: initial;">
          <div class="sv-question__header sv-question__header--location--top">
            <h5 class="sv-title sv-question__title sv-question__title--required"
              aria-label="Generally speaking, do you usually think of yourself as a Republican, a Democrat or an independent?" id="sq_107_ariaTitle"
              id="sq_105_ariaTitle">
              <span style="position: static;" class="sv-question__num">8.</span>
              <span style="position: static;">
                Generally speaking, do you usually think of yourself as a Republican, a Democrat or an independent?
              </span>
              <span class="sv-question__required-text">*</span>
            </h5>
            <div class="sv-description sv-question__description">
              <span style="position: static;">Choose the option below that best describes you. For example, if you identify as neither, but feel closer to the Republican Party, then choose option 5.</span>
            </div>
          </div>
          <div class="sv-question__content">
            <div role="alert" class="sv-question__erbox sv-question__erbox--location--top" id="sq_107_errors" style="display: none;"></div>
            <fieldset role="radiogroup" class="sv-selectbase">
              <!-- <legend
                aria-label="Some people seem to follow what's going on in government and public affairs most of the time, whether there's an election going on or not. Others aren't that interested. Would you say you follow what's going on in government and public affairs...">
              </legend> -->

              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="pid_7_pre" id="pid_7_pre" aria-required="true" aria-label="Most of the time" role="radio" value="1" required>
                  <span class="sv-item__control-label" title="Strong Democrat">
                    <span style="position: static;">1. Strong Democrat</span>
                  </span>
                </label>
              </div>

              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="pid_7_pre" id="pid_7_pre" aria-required="true" aria-label="Most of the time" role="radio" value="2" required>
                  <span class="sv-item__control-label" title="Not very strong Democrat">
                    <span style="position: static;">2. Not very strong Democrat</span>
                  </span>
                </label>
              </div>

              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="pid_7_pre" id="pid_7_pre" aria-required="true" aria-label="Most of the time" role="radio" value="3" required>
                  <span class="sv-item__control-label" title="Neither, but closer to Democratic Party">
                    <span style="position: static;">3. Neither, but closer to Democratic Party</span>
                  </span>
                </label>
              </div>

              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="pid_7_pre" id="pid_7_pre" aria-required="true" aria-label="Most of the time" role="radio" value="4" required>
                  <span class="sv-item__control-label" title="Neither/independent/something else">
                    <span style="position: static;">4. Neither/independent/something else</span>
                  </span>
                </label>
              </div>

              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="pid_7_pre" id="pid_7_pre" aria-required="true" aria-label="Most of the time" role="radio" value="5" required>
                  <span class="sv-item__control-label" title="Neither, but closer to the Republican Party">
                    <span style="position: static;">5. Neither, but closer to the Republican Party</span>
                  </span>
                </label>
              </div>

              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="pid_7_pre" id="pid_7_pre" aria-required="true" aria-label="Most of the time" role="radio" value="6" required>
                  <span class="sv-item__control-label" title="Not very strong Republican">
                    <span style="position: static;">6. Not very strong Republican</span>
                  </span>
                </label>
              </div>

              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="pid_7_pre" id="pid_7_pre" aria-required="true" aria-label="Most of the time" role="radio" value="7" required>
                  <span class="sv-item__control-label" title="Strong Republican">
                    <span style="position: static;">7. Strong Republican</span>
                  </span>
                </label>
              </div>

            </fieldset><!-- /ko -->
            <div class="sv-description sv-question__description" style="display: none;">
              <span style="position: static;"></span>
            </div>
          </div>
        </div><!-- /ko -->
      </div>

      <div class="sv-row sv-clearfix">
        <div class="sv-question sv-row__question" id="sq_108" name="ideo5_pre" aria-labelledby="sq_108_ariaTitle" style="flex: 1 1 100%; width: 100%; min-width: 300px; max-width: initial;">
          <!--ko template: { name: 'survey-question-title', data: question  } -->
          <div class="sv-question__header sv-question__header--location--top">
            <h5 class="sv-title sv-question__title sv-question__title--required" aria-label="When it comes to politics, would you describe yourself as liberal, conservative, or neither liberal nor conservative?" id="sq_108_ariaTitle">
              <span style="position: static;" class="sv-question__num">9.</span>
              <span style="position: static;">When it comes to politics, would you describe yourself as liberal, conservative, or neither liberal nor conservative?</span>
              <span class="sv-question__required-text">*</span>
            </h5>
            <div class="sv-description sv-question__description">
              <span style="position: static;"></span>
            </div>
          </div>
          <div class="sv-question__content">
            <div role="alert" class="sv-question__erbox sv-question__erbox--location--top" id="sq_108_errors" style="display: none;"></div>
            <fieldset role="radiogroup" class="sv-selectbase">

              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="ideo5_pre" id="ideo5_pre" aria-required="true" aria-label="Most of the time" role="radio" value="1" required>
                  <span class="sv-item__control-label" title="Very liberal">
                    <span style="position: static;">1. Very liberal</span>
                  </span>
                </label>
              </div>

              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="ideo5_pre" id="ideo5_pre" aria-required="true" aria-label="Most of the time" role="radio" value="2" required>
                  <span class="sv-item__control-label" title="Somewhat liberal">
                    <span style="position: static;">2. Somewhat liberal</span>
                  </span>
                </label>
              </div>

              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="ideo5_pre" id="ideo5_pre" aria-required="true" aria-label="Most of the time" role="radio" value="3" required>
                  <span class="sv-item__control-label" title="Neither liberal nor conservative">
                    <span style="position: static;">3. Neither liberal nor conservative</span>
                  </span>
                </label>
              </div>

              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="ideo5_pre" id="ideo5_pre" aria-required="true" aria-label="Most of the time" role="radio" value="4" required>
                  <span class="sv-item__control-label" title="Somewhat conservative">
                    <span style="position: static;">4. Somewhat conservative</span>
                  </span>
                </label>
              </div>

              <div class="sv-item sv-radio sv-selectbase__item sv-q-col-1 sv-radio--allowhover">
                <label class="sv-selectbase__label">
                  <input type="radio" name="ideo5_pre" id="ideo5_pre" aria-required="true" aria-label="Most of the time" role="radio" value="5" required>
                  <span class="sv-item__control-label" title="Very conservative">
                    <span style="position: static;">5. Very conservative</span>
                  </span>
                </label>
              </div>

          </div>
        </div><!-- /ko -->
      </div>
    </div>
  </div>
  <div data-bind="css: css.footer" class="sv-footer sv-body__footer sv-clearfix">
      <input type="submit" value="Submit" class="sv-btn sv-footer__complete-btn">
  </div>
</form>
</div>
</body>

</html>
