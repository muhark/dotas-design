Survey.StylesManager.applyTheme("modern");

 var surveyJSON = {
   "title": "Political Ads Survey",
   "pages": [{
     "name": "page1",
     "elements": [{
         "type": "text",
         "name": "Age",
         "title": "Please write your age in years.",
         "valueName": "age",
         "isRequired": true,
         "requiredErrorText": "Please give your age as a whole number (between 18 and 85).",
         "validators": [{
           "type": "numeric",
           "minValue": 18,
           "maxValue": 85
         }],
         "maxLength": 2,
         "placeHolder": "25"
       },
       {
         "type": "radiogroup",
         "name": "gender",
         "title": "What is your gender?",
         "isRequired": true,
         "choices": [{
             "value": "0",
             "text": "Male"
           },
           {
             "value": "1",
             "text": "Female"
           }
         ],
         "choicesOrder": "random"
       },
       {
         "type": "dropdown",
         "name": "race",
         "title": "Select the race that best describes you.",
         "isRequired": true,
         "choices": [{
             "value": "1",
             "text": "White"
           },
           {
             "value": "2",
             "text": "Black"
           },
           {
             "value": "3",
             "text": "Hispanic"
           },
           {
             "value": "4",
             "text": "Asian"
           },
           {
             "value": "5",
             "text": "Native American"
           },
           {
             "value": "6",
             "text": "Mixed"
           },
           {
             "value": "7",
             "text": "Other"
           },
           {
             "value": "8",
             "text": "Middle Eastern"
           }
         ],
         "choicesOrder": "random"
       },
       {
         "type": "radiogroup",
         "name": "income",
         "title": "Which of the following describes your annual income?",
         "isRequired": true,
         "choices": [{
             "value": "1",
             "text": "Under $50k"
           },
           {
             "value": "2",
             "text": "$50k to $100k"
           },
           {
             "value": "3",
             "text": "$100k or more"
           },
           {
             "value": "4",
             "text": "Prefer not to say"
           }
         ]
       },
       {
         "type": "radiogroup",
         "name": "region",
         "title": "Which region of the United States do you live in?",
         "isRequired": true,
         "choices": [{
             "value": "1",
             "text": "Northeast"
           },
           {
             "value": "2",
             "text": "Midwest"
           },
           {
             "value": "3",
             "text": "South"
           },
           {
             "value": "4",
             "text": "West"
           }
         ],
         "choicesOrder": "random"
       },
       {
         "type": "radiogroup",
         "name": "newsint",
         "title": "Some people seem to follow what's going on in government and public affairs most of the time, whether there's an election going on or not. Others aren't that interested. Would you say you follow what's going on in government and public affairs...",
         "isRequired": true,
         "choices": [{
             "value": "1",
             "text": "Most of the time"
           },
           {
             "value": "2",
             "text": "Some of the time"
           },
           {
             "value": "3",
             "text": "Only now and then"
           },
           {
             "value": "4",
             "text": "Hardly at all"
           }
         ]
       },
       {
         "type": "radiogroup",
         "name": "track_pre",
         "title": "Generally speaking, would you say things in the country are going in the right direction, or are they off on the wrong track?",
         "isRequired": true,
         "choices": [{
             "value": "right track",
             "text": "Right direction"
           },
           {
             "value": "wrong track",
             "text": "Wrong track"
           },
           {
             "value": "not sure",
             "text": "I'm not sure"
           }
         ]
       },
       {
         "type": "rating",
         "name": "pid_7_pre",
         "title": "On a scale from Democrat to Republican, with 1 being Democrat and 7 being Republican, where would you place yourself?",
         "isRequired": true,
         "rateMax": 7,
         "minRateDescription": "Democrat",
         "maxRateDescription": "Republican"
       },
       {
         "type": "rating",
         "name": "ideo5_pre",
         "title": "Political ideology is often thought of as being a spectrum from left to right. What point do you think lies closest to your views?",
         "isRequired": true,
         "minRateDescription": "Left",
         "maxRateDescription": "Right"
       }
     ],
     "title": "Political Ads Survey",
     "description": "Pre-advertisement questionnaire."
   }]
 }

 function sendDataToServer(survey) {
   //send Ajax request to your web server.
   alert("The results are:" + JSON.stringify(survey.data));
 }

 var survey = new Survey.Model(surveyJSON, "surveyContainer");
 survey.onComplete.add(sendDataToServer);
