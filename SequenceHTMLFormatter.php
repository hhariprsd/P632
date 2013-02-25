<?php

require_once("iHTMLContentFormatter.php");

class SequenceHTMLFormatter implements iHTMLContentFormatter{
	
	public function formHeaderContentHTML($dataVO,$styleVO){

		$htmlInstructionCode = "";
		$htmlInstructionCode = $htmlInstructionCode . "<link href=\"http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css\" rel=\"stylesheet\">";
 		$htmlInstructionCode = $htmlInstructionCode . "<link href=\"http://code.jquery.com/ui/1.10.0/themes/ui-lightness/jquery-ui.css\" rel=\"stylesheet\">";
		$htmlInstructionCode = $htmlInstructionCode . "<script type=\"text/javascript\" async src=\"http://www.google-analytics.com/ga.js\"></script>";
		$htmlInstructionCode = $htmlInstructionCode . "<script src=\"http://code.jquery.com/jquery-1.9.0.js\"></script>";
		$htmlInstructionCode = $htmlInstructionCode . "<script src=\"http://code.jquery.com/ui/1.10.0/jquery-ui.js\"></script>";
		$htmlInstructionCode = $htmlInstructionCode . "<script src=\"http://www.cs.indiana.edu/cgi-pub/harihanu/Resources/js/jqueryuitouchpunchmin.js\"></script>";
		
		$htmlInstructionCode = $htmlInstructionCode . "<style>";
		$htmlInstructionCode = $htmlInstructionCode . "#sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }";
		$htmlInstructionCode = $htmlInstructionCode . "#sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; width: 350px; height: 18px; background-image: url(\"http://www.cs.indiana.edu/cgi-pub/harihanu/Resources/images/gradient.jpg\");}";
		$htmlInstructionCode = $htmlInstructionCode . "#sortable li span { position: absolute; margin-left: -1.3em; }";
		
		$htmlInstructionCode = $htmlInstructionCode . "#expected { list-style-type: none; margin: 0; padding: 0; width: 50%; }";
		$htmlInstructionCode = $htmlInstructionCode . "#expected li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; width: 250px; height: 18px; background-image: url(\"http://www.cs.indiana.edu/cgi-pub/harihanu/Resources/images/gradient.jpg\");}";
		$htmlInstructionCode = $htmlInstructionCode . "#expected li span { position: absolute; margin-left: -1.3em; }";
		
		$htmlInstructionCode = $htmlInstructionCode . "#output { list-style-type: none; margin: 0; padding: 0; width: 50%; }";
		$htmlInstructionCode = $htmlInstructionCode . "#output li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; width: 250px; height: 18px; background-image: url(\"http://www.cs.indiana.edu/cgi-pub/harihanu/Resources/images/gradient.jpg\");}";
		$htmlInstructionCode = $htmlInstructionCode . "#output li span { position: absolute; margin-left: -1.3em; }";
		
		$htmlInstructionCode = $htmlInstructionCode . "</style>";
		
		$htmlInstructionCode = $htmlInstructionCode. "<script type='text/javascript'>";

		$htmlInstructionCode = $htmlInstructionCode . "var OriginalItemArray = new Array();";
		$htmlInstructionCode = $htmlInstructionCode . "var itemArray = null;";
		$htmlInstructionCode = $htmlInstructionCode . "var sampleArray = null;";   // expected array which needs to be compared with userArray at the end
		$htmlInstructionCode = $htmlInstructionCode . "var shuffleArray = null;";  //
		//$htmlInstructionCode = $htmlInstructionCode . "var userArray = null;";    // this is the user created array 
		$htmlInstructionCode = $htmlInstructionCode . "var audioFlag = 1;";
		$htmlInstructionCode = $htmlInstructionCode . "var pausedTime = null;";
		
		$itemList = $dataVO->getChildInfo();
		
		foreach($itemList as $item){
			if((strlen(trim($item->getItem())))>0){
				$htmlInstructionCode = $htmlInstructionCode . "OriginalItemArray.push(\"" . $item->getItem() ."\");";
			}
		}
		$htmlInstructionCode = $htmlInstructionCode . " function calcScore(sampleArray,itemArray){";

		$htmlInstructionCode = $htmlInstructionCode . " var currOrder = new Array();";

		$htmlInstructionCode = $htmlInstructionCode . " var i =0;";

		$htmlInstructionCode = $htmlInstructionCode . " var k=0;";

		$htmlInstructionCode = $htmlInstructionCode . " var m;";

		$htmlInstructionCode = $htmlInstructionCode . " var j=0;";

		$htmlInstructionCode = $htmlInstructionCode . " var score=0;";

		$htmlInstructionCode = $htmlInstructionCode . " var sum=0;";
		$htmlInstructionCode = $htmlInstructionCode . " var flag =0;";

		//$htmlInstructionCode = $htmlInstructionCode . " if(initScore==1){";

		$htmlInstructionCode = $htmlInstructionCode . " while(i<itemArray.length)";

		$htmlInstructionCode = $htmlInstructionCode . " {currOrder[i] = itemArray[i].childNodes[0].nodeValue.toString();";

		$htmlInstructionCode = $htmlInstructionCode . " i++;}";
		//$htmlInstructionCode = $htmlInstructionCode . " else {currOrder = itemArray;";

		$htmlInstructionCode = $htmlInstructionCode . " for (j = 0; j < currOrder.length; j++) {";

		$htmlInstructionCode = $htmlInstructionCode . " k = j + 1;";

		$htmlInstructionCode = $htmlInstructionCode . " m = sampleArray.indexOf(currOrder[j]);";

		$htmlInstructionCode = $htmlInstructionCode . " sum = sum + (k - m)*(k - m);";

		$htmlInstructionCode = $htmlInstructionCode . " }";

		$htmlInstructionCode = $htmlInstructionCode . " var n = currOrder.length;";

		$htmlInstructionCode = $htmlInstructionCode . " score = Math.round((1 - (itemArray.length * sum / (n * (n * n - 1)))) * 50 + 50);";

		$htmlInstructionCode = $htmlInstructionCode . " if(score<=0){";

		$htmlInstructionCode = $htmlInstructionCode . " document.getElementById('score').innerHTML=''+0;}";

		$htmlInstructionCode = $htmlInstructionCode . " else if(score>100){";

		$htmlInstructionCode = $htmlInstructionCode . " document.getElementById('score').innerHTML=''+100;}";

		$htmlInstructionCode = $htmlInstructionCode . " else if(score>0 && score<=100){";
		$htmlInstructionCode = $htmlInstructionCode . " for(i=0;i<itemArray.length;i++){";
		$htmlInstructionCode = $htmlInstructionCode . " if(sampleArray[i]==currOrder[i]) {";
		$htmlInstructionCode = $htmlInstructionCode . " flag += 1;}";
		$htmlInstructionCode = $htmlInstructionCode . "  else {break;}}";
		$htmlInstructionCode = $htmlInstructionCode . " if (flag == itemArray.length) {";
		$htmlInstructionCode = $htmlInstructionCode . " document.getElementById('score').innerHTML=''+100;";
		$htmlInstructionCode = $htmlInstructionCode . " score=100;";
		$htmlInstructionCode = $htmlInstructionCode . " gameOver(score);}";
		$htmlInstructionCode = $htmlInstructionCode . " else {";
		$htmlInstructionCode = $htmlInstructionCode . " document.getElementById('score').innerHTML=''+score;}";
		$htmlInstructionCode = $htmlInstructionCode . " }";

		$htmlInstructionCode = $htmlInstructionCode . " } ";
		
		$htmlInstructionCode = $htmlInstructionCode . "function setAudioFlag(){";

		

		$htmlInstructionCode = $htmlInstructionCode . "if(audioFlag==0)";

		$htmlInstructionCode = $htmlInstructionCode . "{audioFlag=1; document.getElementById('Mute').style.color='#000000';";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"Mute\").value=\"Mute\";}";

		$htmlInstructionCode = $htmlInstructionCode . "else";

		$htmlInstructionCode = $htmlInstructionCode . "{audioFlag=0; document.getElementById('Mute').style.color='#808080';";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"Mute\").value=\"UnMute\";}";

		$htmlInstructionCode = $htmlInstructionCode . "}";

		$htmlInstructionCode = $htmlInstructionCode . "function play(){";
		$htmlInstructionCode = $htmlInstructionCode . "itemArray = new Array();";
		$htmlInstructionCode = $htmlInstructionCode . "sampleArray = new Array();";
		$htmlInstructionCode = $htmlInstructionCode . "shuffleArray = new Array();";
		
		$htmlInstructionCode = $htmlInstructionCode . " document.getElementById('score').innerHTML=''+0;";
		$htmlInstructionCode = $htmlInstructionCode . "itemArray = OriginalItemArray.slice(0,OriginalItemArray.length);";
		
		$htmlInstructionCode = $htmlInstructionCode . "if(itemArray.length>".$dataVO->getSampleSize()."){";

		$htmlInstructionCode = $htmlInstructionCode . "for (var i = ".$dataVO->getSampleSize()." - 1; i >= 0; i--) {";
		$htmlInstructionCode = $htmlInstructionCode . "var randomIndex = Math.floor((Math.random() * (itemArray.length))%7);";
		$htmlInstructionCode = $htmlInstructionCode . "sampleArray.push(itemArray.splice(randomIndex,1).toString());";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		
		$htmlInstructionCode = $htmlInstructionCode . "}else{";
		$htmlInstructionCode = $htmlInstructionCode . "for (var i = itemArray.length - 1; i >= 0; i--) {";
		$htmlInstructionCode = $htmlInstructionCode . "var randomIndex = Math.floor(Math.random() * (i + 1));";
		$htmlInstructionCode = $htmlInstructionCode . "sampleArray.push(itemArray.splice(randomIndex,1).toString());";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		$htmlInstructionCode = $htmlInstructionCode . "}";
			
		$htmlInstructionCode = $htmlInstructionCode . "shuffleArray = sampleArray.slice(0,sampleArray.length);";
		
		$htmlInstructionCode = $htmlInstructionCode . "for(var i=0;i<sampleArray.length;i++){";
		$htmlInstructionCode = $htmlInstructionCode . "for(var j=0;j<sampleArray.length-i-1;j++){";
		$htmlInstructionCode = $htmlInstructionCode . "if(OriginalItemArray.indexOf(sampleArray[j]+\"\") > OriginalItemArray.indexOf(sampleArray[j+1]+\"\")){";
		$htmlInstructionCode = $htmlInstructionCode . "temp = sampleArray[j];";
		$htmlInstructionCode = $htmlInstructionCode . "sampleArray[j]= sampleArray[j+1];";
		$htmlInstructionCode = $htmlInstructionCode . "sampleArray[j+1]= temp;";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		$htmlInstructionCode = $htmlInstructionCode . "var liItems = [];";
		$htmlInstructionCode = $htmlInstructionCode . "$.each(shuffleArray,function(i,item){";
		$htmlInstructionCode = $htmlInstructionCode . "liItems.push('<li id=\"sortable'+(i+1)+'\" class=\"ui-state-default\">' + item + '</li>');";
		$htmlInstructionCode = $htmlInstructionCode . "});";
		$htmlInstructionCode = $htmlInstructionCode . "$('#sortable').empty();";
		$htmlInstructionCode = $htmlInstructionCode . "$('#sortable').append( liItems.join('') );"; 
		$htmlInstructionCode = $htmlInstructionCode . " var items = document.getElementById(\"sortable\").getElementsByTagName(\"li\");";
		$htmlInstructionCode = $htmlInstructionCode . "calcScore(sampleArray,items);";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		
		$htmlInstructionCode = $htmlInstructionCode . "function changeLevel(timerVal){";
		$htmlInstructionCode = $htmlInstructionCode . "play();";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('counter').innerHTML=timerVal;";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		
		
		$htmlInstructionCode = $htmlInstructionCode . "function changeDiv(id1,id2,id3,id4,id5,id6){";
		$htmlInstructionCode = $htmlInstructionCode . "if(id6 == 'true'){";
		$htmlInstructionCode = $htmlInstructionCode . "play();";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('instructions').style.display=id1;";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('items').style.display=id2;";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('pause').style.display=id3;";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('controls').style.display=id4;";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('end').style.display=id5;";
		$htmlInstructionCode = $htmlInstructionCode . "setaudio();";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		
		$htmlInstructionCode = $htmlInstructionCode . "function setaudio(){";
		$htmlInstructionCode = $htmlInstructionCode . "var myAudio = document.createElement('audio');";
		$htmlInstructionCode = $htmlInstructionCode . "myAudio.controls = false;";
		$htmlInstructionCode = $htmlInstructionCode . "myAudio.src = 'beep.wav';";
		$htmlInstructionCode = $htmlInstructionCode . "}";
 		$htmlInstructionCode = $htmlInstructionCode . "$(function() {";
 		$htmlInstructionCode = $htmlInstructionCode . "$( \"#sortable\" ).sortable({";
 		$htmlInstructionCode = $htmlInstructionCode . "	beforeStop: function(play, ui) {";

 		$htmlInstructionCode = $htmlInstructionCode . "if(audioFlag==1)";
 		$htmlInstructionCode = $htmlInstructionCode . " {document.getElementById('sound').play();}";
		$htmlInstructionCode = $htmlInstructionCode . " },";
		$htmlInstructionCode = $htmlInstructionCode . "	stop: function( event, ui ) {";
		$htmlInstructionCode = $htmlInstructionCode . " var itemArray = document.getElementById(\"sortable\").getElementsByTagName(\"li\");";
		$htmlInstructionCode = $htmlInstructionCode . " calcScore(sampleArray,itemArray);";
		$htmlInstructionCode = $htmlInstructionCode . " }});";
 		$htmlInstructionCode = $htmlInstructionCode . " });";
 		 		
 		$htmlInstructionCode = $htmlInstructionCode . "function countdown() { ";
 		$htmlInstructionCode = $htmlInstructionCode . "var i = document.getElementById('counter');";
 		$htmlInstructionCode = $htmlInstructionCode . "if( document.getElementById('items').style.display == 'block'){";
  		$htmlInstructionCode = $htmlInstructionCode . "i.innerHTML = parseInt(i.innerHTML)-1;";
  		$htmlInstructionCode = $htmlInstructionCode . "}";
  		$htmlInstructionCode = $htmlInstructionCode . "if (i.innerHTML <= 0) {";
  		$htmlInstructionCode = $htmlInstructionCode . "gameOver(document.getElementById('score').toString());";
  		$htmlInstructionCode = $htmlInstructionCode . "exit();";
  		$htmlInstructionCode = $htmlInstructionCode . "}";
 		$htmlInstructionCode = $htmlInstructionCode . "}";
 		$htmlInstructionCode = $htmlInstructionCode . "setInterval(function(){ countdown(); },1000);";
 		 		
 		$htmlInstructionCode = $htmlInstructionCode . "function sortids() {";
 		$htmlInstructionCode = $htmlInstructionCode . "var myArray = ['1', '2', '3','4','5','6','7','8','9']; ";
 		$htmlInstructionCode = $htmlInstructionCode . "$.each(myArray,function(index,value){";
 		$htmlInstructionCode = $htmlInstructionCode . "$('#sortable').append($('#ITEM'+value));";
 		$htmlInstructionCode = $htmlInstructionCode . "});";
 		$htmlInstructionCode = $htmlInstructionCode . "}";
 		
 		$htmlInstructionCode = $htmlInstructionCode . "function pauseResume(){";
 		$htmlInstructionCode = $htmlInstructionCode . "if(document.getElementById('pauseButton').value == 'Pause'){";
 		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('pauseButton').value='Resume';";
 		$htmlInstructionCode = $htmlInstructionCode . "pausedTime = document.getElementById('counter').innerHTML;";
 		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('none','none','block','block','none','false');";
 		$htmlInstructionCode = $htmlInstructionCode . "}";
 		$htmlInstructionCode = $htmlInstructionCode . "else if(document.getElementById('pauseButton').value == 'Resume'){";
 		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('pauseButton').value='Pause';";
 		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('none','block','none','block','none','false');";
 		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('counter').innerHTML=pausedTime;";
 		$htmlInstructionCode = $htmlInstructionCode . "}}";
 			
 		$htmlInstructionCode = $htmlInstructionCode . "function gameOver(score) { ";
  		$htmlInstructionCode = $htmlInstructionCode . " var userArray = document.getElementById(\"sortable\").getElementsByTagName(\"li\");";
  		$htmlInstructionCode = $htmlInstructionCode . "var liItems1 = [];";
 		$htmlInstructionCode = $htmlInstructionCode . "$.each(sampleArray,function(i,item){";
 		$htmlInstructionCode = $htmlInstructionCode . "liItems1.push('<li id='+(i+1)+' class=\"ui-state-default\" >' + item + '</li>');";
 		$htmlInstructionCode = $htmlInstructionCode . "});";
 		$htmlInstructionCode = $htmlInstructionCode . "$('#expected').empty();";
 		$htmlInstructionCode = $htmlInstructionCode . "$('#expected').append( liItems1.join('') );";
 			
 		$htmlInstructionCode = $htmlInstructionCode . "var liItems2 = [];";
 		$htmlInstructionCode = $htmlInstructionCode . "for(var i=0;i<userArray.length;i++){";
  		$htmlInstructionCode = $htmlInstructionCode . "liItems2.push('<li id='+(i+1)+' class=\"ui-state-default\" >' + userArray[i].childNodes[0].nodeValue + '</li>');";
 		$htmlInstructionCode = $htmlInstructionCode . "}";
  		$htmlInstructionCode = $htmlInstructionCode . "$('#output').empty();";
 		$htmlInstructionCode = $htmlInstructionCode . "$('#output').append( liItems2.join('') );";
 		
 		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('none','none','none','none','block','false');";
 		$htmlInstructionCode = $htmlInstructionCode . "if(audioFlag==1 && score >= 100){";
 		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('applause').play();";
 		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('gomsg').innerHTML='Congratulations!!';";
 		$htmlInstructionCode = $htmlInstructionCode . "}";
 		$htmlInstructionCode = $htmlInstructionCode . "else{";
 		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('gomsg').innerHTML='Game is Over';}";
 		$htmlInstructionCode = $htmlInstructionCode . "}";
 		
 		$htmlInstructionCode = $htmlInstructionCode . "function onclickPlay() { ";
  		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('none','block','none','block','none','true');";
 		$htmlInstructionCode = $htmlInstructionCode . "changeLevel(" . $dataVO->getTimer1() . ")";
 		$htmlInstructionCode = $htmlInstructionCode . "}";
 			
 		$htmlInstructionCode = $htmlInstructionCode . "function onclickBack() { ";
  		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('block','none','none','none','none','true');";
  		$htmlInstructionCode = $htmlInstructionCode . "changeLevel(" . $dataVO->getTimer1() . ")";
  		$htmlInstructionCode = $htmlInstructionCode . "}";
 			
 		
/*  	$htmlInstructionCode = $htmlInstructionCode . "function shuffle() {";
  		$htmlInstructionCode = $htmlInstructionCode . "var divids = [];";
  		$htmlInstructionCode = $htmlInstructionCode . "var posarr = [];";
 		
  		$htmlInstructionCode = $htmlInstructionCode . "$(\"#sortable\").children().each(function () {";
  		$htmlInstructionCode = $htmlInstructionCode . "if (this.id != '') {";
  		$htmlInstructionCode = $htmlInstructionCode . "divids.push(this.id);";
  		$htmlInstructionCode = $htmlInstructionCode . "posarr.push(this.style.top);";
  		$htmlInstructionCode = $htmlInstructionCode . "alert(posarr);";
  		$htmlInstructionCode = $htmlInstructionCode . "}});";
  		$htmlInstructionCode = $htmlInstructionCode . "for (var i = divids.length - 1; i >= 0; i--) {";
  		$htmlInstructionCode = $htmlInstructionCode . "var randomIndex = Math.floor(Math.random() * (i + 1));";
  		$htmlInstructionCode = $htmlInstructionCode . "var itemAtIndex = divids[randomIndex];";
  		$htmlInstructionCode = $htmlInstructionCode . "divids[randomIndex] = divids[i];";
  		$htmlInstructionCode = $htmlInstructionCode . "divids[i] = itemAtIndex;";
  		
  		$htmlInstructionCode = $htmlInstructionCode . "$('#'+divids[i]).animate({ top: posarr[i] }, 'slow');";
  		$htmlInstructionCode = $htmlInstructionCode . "	}}";*/
		
 			
 		$htmlInstructionCode = $htmlInstructionCode . "</script>";
		
		return $htmlInstructionCode;
		
	}
	public function formInstructionContentHTML($dataVO,$styleVO){
		$htmlInstructionCode = "<div id='instructions' style=\" width:600px;padding-left: 5em;padding-right: 5em; background-color:#F7DFBD\" >";
		$htmlInstructionCode = $htmlInstructionCode . "<h1 style= \" color: #".$styleVO->getTitleColor(). "; \">" . $dataVO->getDisplayTitle() . "</h1>";
		$htmlInstructionCode = $htmlInstructionCode . "<h2>Instructions:</h2>";
		
		$instructions = $styleVO->getInitialInstructions();
		
		if(strlen(trim($instructions))>0){
			$instructionList	 = explode("WHAT", $instructions);
		
			foreach($instructionList as $instruction){
				if((strlen(trim($instruction)))>0){
					$htmlInstructionCode = $htmlInstructionCode . "WHAT". $instruction .  "<br/><br/>";
				}
			}
		}else{
			$htmlInstructionCode = $htmlInstructionCode . "<p>In this game format, Sequence, a list of ordered items (e.g., stages of a process, steps in a procedure, or elements of a hierarchy) is displayed out of sequence. Your objective is to arrange the list into the correct order before time runs out.</p> ";
			$htmlInstructionCode = $htmlInstructionCode . "<ul> ";
			$htmlInstructionCode = $htmlInstructionCode . "<li>Level 1 provides you the most time to arrange the items</li>";
			$htmlInstructionCode = $htmlInstructionCode . "<li>Level 2 provides you less time than Level 1 to arrange the items</li>";
			$htmlInstructionCode = $htmlInstructionCode . "<li>Level 3 provides you the least time to arrange the items</li>";
			$htmlInstructionCode = $htmlInstructionCode . "</ul>";
		}
		
		$htmlInstructionCode = $htmlInstructionCode . "<input type='submit' name='Play' value='PLAY' style='width:80px; background-color: ORANGE;' onClick=\"onclickPlay()\" />";
		
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
		
		return $htmlInstructionCode;
		
	}
	public function formGameContentHTML($dataVO,$styleVO){
		
	$htmlInstructionCode = "<div id='items' style='display:none;padding-left: 5em;color:#999966'>";
		$htmlInstructionCode = $htmlInstructionCode . "<h2>Sequence Game:</h2>";
			
		$itemList = $dataVO->getChildInfo();
		$itemPrefix = "ITEM";
		$itemCount = 1;
		$buttonTitle="Pause";
		
		$Level1Disabled = "";
		$Level2Disabled = "";
		$Level3Disabled = "";
		$defaultTimerValue = $dataVO->getTimer1();
		$gameOverMsg = "Game is Over:";
		
		if($dataVO->getUse1() == "no"){
			$Level1Disabled = "disabled";
		}
		if($dataVO->getUse2() == "no"){
			$Level2Disabled = "disabled";
		}
		if($dataVO->getUse3() == "no"){
			$Level3Disabled = "disabled";
		}
		
		if($dataVO->getUse1() == "no"){
			if($dataVO->getUse2() == "no"){
				$defaultTimerValue = $dataVO->getTimer3();
			}else{
				$defaultTimerValue = $dataVO->getTimer2();
				
			}			
		}
			
		$htmlInstructionCode = $htmlInstructionCode . "<ul id=\"sortable\" class=\"ui-sortable\">";
		/* foreach($itemList as $item){
			if((strlen(trim($item->getItem())))>0){
					$htmlInstructionCode = $htmlInstructionCode . "<li id='" . $itemCount ."' class=\"ui-state-default\" >". $item->getItem() ."</li>";
				$itemCount++;
			}
		
		} */
		$htmlInstructionCode = $htmlInstructionCode . "</ul>";
		$htmlInstructionCode = $htmlInstructionCode . "Time left: 0:<span id=\"counter\">". $defaultTimerValue ."</span>";
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
		
		$htmlInstructionCode = $htmlInstructionCode . "<div id='pause' style=\" width:600px;height:310px; padding-left: 4.5em; margin-left:82px; background-color:#F7DFBD; display:none\">";
		$htmlInstructionCode = $htmlInstructionCode . "<p style=\"padding-top: 100px;\"><h2> Game is Paused, Click Resume to continue:</h2></p>";
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
		
		$htmlInstructionCode = $htmlInstructionCode . "<div id='end' style=\" width:600px;height:310px;  margin-left:82px; background-color:#F7DFBD; display:none\">";
		$htmlInstructionCode = $htmlInstructionCode . "<h2 id='gomsg' align=\"center\">".$gameOverMsg."</h2>";
		
		$htmlInstructionCode = $htmlInstructionCode . "<div id=\"container\" style=\"float:left; width:100%;\">";
		$htmlInstructionCode = $htmlInstructionCode . "<ul id=\"expected\" style=\"float:left; width:50%; \">";
		$htmlInstructionCode = $htmlInstructionCode . "</ul>";
		$htmlInstructionCode = $htmlInstructionCode . "<ul id=\"output\" style=\"float:left; width:50%; \">";
		$htmlInstructionCode = $htmlInstructionCode . "</ul>";
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
		
		$htmlInstructionCode = $htmlInstructionCode . "<br/><input type='submit' name='Back' value='BACK' style='width:80px; background-color: ORANGE; margin-left:10px;' onClick=\"onclickBack()\" />";
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
		
		$htmlInstructionCode = $htmlInstructionCode ."<div id='controls' style='width:100%; padding-left: 4.5em; display:none'>";
//		$htmlInstructionCode = $htmlInstructionCode . "<br/><br/><input type=\"button\" value=\"Shuffle\" onclick = \"shuffle()\" style=\"position: absolute;top: 500px;\" />";
		$htmlInstructionCode = $htmlInstructionCode . "<br/><input type='submit' name='Back' value='BACK' style='width:80px; background-color: ORANGE; margin-left:10px;' onClick=\"onclickBack()\" />";
		$htmlInstructionCode = $htmlInstructionCode . "<input type='image' name='Level1' value='Level1' style='height:20px;width:30px; margin-left:10px;' src=\"http://www.cs.indiana.edu/cgi-pub/harihanu/Resources/images/one.png\" onClick=\"changeLevel(" . $dataVO->getTimer1() . ")\" " .$Level1Disabled . "/>";
		$htmlInstructionCode = $htmlInstructionCode . "<input type='image' name='Level2' value='Level2' style='height:20px;width:30px; margin-left:10px;' src=\"http://www.cs.indiana.edu/cgi-pub/harihanu/Resources/images/two.png\" onClick=\"changeLevel(" . $dataVO->getTimer2() . ")\" " .$Level2Disabled . "/>";
		$htmlInstructionCode = $htmlInstructionCode . "<input type='image' name='Level3' value='Level3' style='height:20px;width:30px; margin-left:10px;' src=\"http://www.cs.indiana.edu/cgi-pub/harihanu/Resources/images/three.png\" onClick=\"changeLevel(" . $dataVO->getTimer3() . ")\" " .$Level3Disabled . "/>";
		$htmlInstructionCode = $htmlInstructionCode . "<input type='button' id='Mute' name='Mute' value='Mute' style='width:80px; background-color: ORANGE; margin-left:10px;' onClick=\"setAudioFlag()\" />";
		$htmlInstructionCode = $htmlInstructionCode . "<input type='button' id='pauseButton' name='Mute' value='$buttonTitle' style='width:80px; background-color: ORANGE; margin-left:10px;' onClick=\"pauseResume()\" />";
		$htmlInstructionCode = $htmlInstructionCode . "<label id=\"scoreLabel\" style='width:80px; background-color: ORANGE; margin-left:10px;'>Score: </label>";

		$htmlInstructionCode = $htmlInstructionCode . "<span id=\"score\" style='width:80px; background-color: ORANGE; margin-left:10px;'>0 </span>";
		$htmlInstructionCode = $htmlInstructionCode . "<audio id='sound' type='audio/wav' src='http://www.cs.indiana.edu/cgi-pub/harihanu/Resources/sounds/sequence_click.wav' preload/>";
		$htmlInstructionCode = $htmlInstructionCode . "<audio id='applause' type='audio/wav' src='http://www.cs.indiana.edu/cgi-pub/harihanu/Resources/sounds/Clap.wav' preload/>";
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
		
		return $htmlInstructionCode;
	}
	
	
}

?>