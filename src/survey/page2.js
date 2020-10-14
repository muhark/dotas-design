Survey.StylesManager.applyTheme("modern");

 var surveyJSON = {
   "title": "Political Ads Survey",
   "pages": [

     {
       "name": "page2",
       "elements": [{
           "type": "rating",
           "name": "favorJB_rev",
           "title": "On a scale of 1-5, how do you rate presidential candidate Joseph Biden?",
           "isRequired": true,
           "minRateDescription": "Dislike",
           "maxRateDescription": "Like"
         },
         {
           "type": "radiogroup",
           "name": "general_vote_JB",
           "title": "Will you vote for Joseph Biden in the upcoming election?",
           "isRequired": true,
           "choices": [{
               "value": "yes",
               "text": "Yes"
             },
             {
               "value": "no",
               "text": "No"
             },
             {
               "value": "alreadyvoted",
               "text": "I have already voted"
             }
           ]
         }
       ],
       "title": "Post-Advertisement Questionnaire"
     }
   ]
 }

 function sendDataToServer(survey) {
   //send Ajax request to your web server.
   alert("The results are:" + JSON.stringify(survey.data));
 }

 var survey = new Survey.Model(surveyJSON, "surveyContainer");
 survey.onComplete.add(sendDataToServer);
