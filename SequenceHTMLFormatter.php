<?php

require_once("iHTMLContentFormatter.php");

class SequenceHTMLFormatter implements iHTMLContentFormatter{
	
	public function formHeaderContentHTML($dataVO,$styleVO){

		$htmlInstructionCode = "";
		$htmlInstructionCode = $htmlInstructionCode . "<link href=\"http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css\" rel=\"stylesheet\"> ";
 		$htmlInstructionCode = $htmlInstructionCode . "<link href=\"http://code.jquery.com/ui/1.10.0/themes/ui-lightness/jquery-ui.css\" rel=\"stylesheet\">";
 		$htmlInstructionCode = $htmlInstructionCode . "<link href=\"". $styleVO->getResourcePath()  ."css/Sequence.css\" rel=\"stylesheet\">";	
 		$htmlInstructionCode = $htmlInstructionCode . "<title>" . $dataVO->getDisplayTitle() . " (SEQUENCE)</title>";
		$htmlInstructionCode = $htmlInstructionCode . "<script src=\"http://code.jquery.com/jquery-1.9.0.js\"></script>";
		$htmlInstructionCode = $htmlInstructionCode . "<script src=\"http://code.jquery.com/ui/1.10.0/jquery-ui.js\"></script>";
		$htmlInstructionCode = $htmlInstructionCode . "<script src=\"" . $styleVO->getResourcePath()  ."js/jqueryuitouchpunchmin.js\"></script>";
		
		$htmlInstructionCode = $htmlInstructionCode. "<script type='text/javascript'>";

		$htmlInstructionCode = $htmlInstructionCode . "var OriginalItemArray = new Array();";
		$htmlInstructionCode = $htmlInstructionCode . "var itemArray = null;";
		$htmlInstructionCode = $htmlInstructionCode . "var sampleArray = null;";   // expected array which needs to be compared with userArray at the end
		$htmlInstructionCode = $htmlInstructionCode . "var shuffleArray = null;";  //
		$htmlInstructionCode = $htmlInstructionCode . "var audioFlag = 1;";
		$htmlInstructionCode = $htmlInstructionCode . "var pausedTime = null;";
		$htmlInstructionCode = $htmlInstructionCode . "var initScore = 0;";
		$htmlInstructionCode = $htmlInstructionCode . " function setHeight() { $('#instructions').height((((".$dataVO->getSampleSize()." - 7) * 30 ) + 280));}";
		
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
		$htmlInstructionCode = $htmlInstructionCode . " while(i<itemArray.length)";
		$htmlInstructionCode = $htmlInstructionCode . " {currOrder[i] = itemArray[i].childNodes[0].nodeValue.toString();";
		$htmlInstructionCode = $htmlInstructionCode . " i++;}";
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
		$htmlInstructionCode = $htmlInstructionCode . " initScore=score;";
		$htmlInstructionCode = $htmlInstructionCode . " gameOver(score);}";
		$htmlInstructionCode = $htmlInstructionCode . " else {";
		$htmlInstructionCode = $htmlInstructionCode . " document.getElementById('score').innerHTML=''+score;}";
		$htmlInstructionCode = $htmlInstructionCode . " }";
		$htmlInstructionCode = $htmlInstructionCode . " } ";
		
		$htmlInstructionCode = $htmlInstructionCode . "function setAudioFlag(){";
		$htmlInstructionCode = $htmlInstructionCode . "if(audioFlag==0)";
		$htmlInstructionCode = $htmlInstructionCode . "{audioFlag=1; document.getElementById('Mute').style.color='#000000';";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"Mute\").style.backgroundImage=\"url('". $styleVO->getResourcePath()  ."images/sequence/sound_button0001.png')\";";
		$htmlInstructionCode = $htmlInstructionCode ."}";

		$htmlInstructionCode = $htmlInstructionCode . "else";

		$htmlInstructionCode = $htmlInstructionCode . "{audioFlag=0; document.getElementById('Mute').style.color='#808080';";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"Mute\").style.backgroundImage=\"url('". $styleVO->getResourcePath()  ."images/sequence/mute_button0003.png')\";}";
		$htmlInstructionCode = $htmlInstructionCode ."}";

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
		$htmlInstructionCode = $htmlInstructionCode . "liItems.push('<br/>');";
		$htmlInstructionCode = $htmlInstructionCode . "$.each(shuffleArray,function(i,item){";
		$htmlInstructionCode = $htmlInstructionCode . "liItems.push('<li id=\"sortable'+(i+1)+'\">' + item + '</li>');";
		$htmlInstructionCode = $htmlInstructionCode . "});";
		$htmlInstructionCode = $htmlInstructionCode . "$('#sortable').empty();";
		$htmlInstructionCode = $htmlInstructionCode . "$('#sortable').append( liItems.join('') );";
		$htmlInstructionCode = $htmlInstructionCode . " var items = document.getElementById(\"sortable\").getElementsByTagName(\"li\");";
		$htmlInstructionCode = $htmlInstructionCode . "calcScore(sampleArray,items);";
		$htmlInstructionCode = $htmlInstructionCode . "if(initScore==100) {";
		$htmlInstructionCode = $htmlInstructionCode . "play();";
		$htmlInstructionCode = $htmlInstructionCode . " }";
		
		$htmlInstructionCode = $htmlInstructionCode . "var liItems4 = [];";
		$htmlInstructionCode = $htmlInstructionCode . "var liItems5 = [];";
			
		$htmlInstructionCode = $htmlInstructionCode . "liItems5.push('<br/>');";
		$htmlInstructionCode = $htmlInstructionCode . "liItems4.push('<br/>');";
		$htmlInstructionCode = $htmlInstructionCode . "$.each(sampleArray,function(i,item){";
		$htmlInstructionCode = $htmlInstructionCode . "liItems5.push('<li id='+(i+1)+'></li>');";
		$htmlInstructionCode = $htmlInstructionCode . "liItems4.push('<li id='+(i+1)+'><font color=\"#FFCE9C\">' + (i+1) + '</font></li>');";
		$htmlInstructionCode = $htmlInstructionCode . "});";
		$htmlInstructionCode = $htmlInstructionCode . "$('#output2').empty();";
 		$htmlInstructionCode = $htmlInstructionCode . "$('#output2').append( liItems5.join('') );";
		$htmlInstructionCode = $htmlInstructionCode . "$('#sequence2').empty();";
		$htmlInstructionCode = $htmlInstructionCode . "$('#sequence2').append( liItems4.join('') );";
		
		$htmlInstructionCode = $htmlInstructionCode . "}";
		
		$htmlInstructionCode = $htmlInstructionCode . "function changeLevel(timerVal){";
		$htmlInstructionCode = $htmlInstructionCode . "play();";
		$htmlInstructionCode = $htmlInstructionCode . "changeMinuteAndTime(timerVal);";
		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('none','block','none','block','none','false');";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('pauseButton').style.display='inline';";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('play').style.display='none';";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		
		$htmlInstructionCode = $htmlInstructionCode . "function changeDiv(id1,id2,id3,id4,id5,id6){";
		$htmlInstructionCode = $htmlInstructionCode . "if(id6 == 'true'){";
		$htmlInstructionCode = $htmlInstructionCode . "play();";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('instructions').style.display=id1;";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('items').style.display=id2;";
        $htmlInstructionCode = $htmlInstructionCode . "document.getElementById('pause').style.display=id3;";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('end').style.display=id5;";
		$htmlInstructionCode = $htmlInstructionCode . "setaudio();";
		$htmlInstructionCode = $htmlInstructionCode . "var divHeight = (((".$dataVO->getSampleSize()." - 7) * 30 ) + 280);";
		$htmlInstructionCode = $htmlInstructionCode . "$('#instructions').height(divHeight);";
		$htmlInstructionCode = $htmlInstructionCode . "$('#items').height(divHeight);";
		$htmlInstructionCode = $htmlInstructionCode . "$('#pause').height(divHeight);";
		$htmlInstructionCode = $htmlInstructionCode . "$('#gameOverLink').css('padding-top',((divHeight/2) - 90)+'px');";
		$htmlInstructionCode = $htmlInstructionCode . "$('#end').height(divHeight);";
		
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
 		$htmlInstructionCode = $htmlInstructionCode . "var minutes = document.getElementById('minute');";
 		$htmlInstructionCode = $htmlInstructionCode . "var seconds = document.getElementById('seconds');";
 		
 		$htmlInstructionCode = $htmlInstructionCode . "time = parseInt(minutes.innerHTML * 60,10) + parseInt(seconds.innerHTML,10);";
 		$htmlInstructionCode = $htmlInstructionCode . "if( document.getElementById('items').style.display == 'block'){";
 		$htmlInstructionCode = $htmlInstructionCode . "time = time - 1;";
 		$htmlInstructionCode = $htmlInstructionCode . "changeMinuteAndTime(time);";
  		$htmlInstructionCode = $htmlInstructionCode . "}";
  		$htmlInstructionCode = $htmlInstructionCode . "if (time <= 0) {";
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
 		$htmlInstructionCode = $htmlInstructionCode . "var minutes = document.getElementById('minute');";
 		$htmlInstructionCode = $htmlInstructionCode . "var seconds = document.getElementById('seconds');";
 		$htmlInstructionCode = $htmlInstructionCode . "pausedTime = parseInt(minutes.innerHTML * 60,10) + parseInt(seconds.innerHTML,10);";
 		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('none','none','block','block','none','false');";
 		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('pauseButton').style.display='none';";
 		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('play').style.display='inline';";
 		$htmlInstructionCode = $htmlInstructionCode . "}";
 			
 		$htmlInstructionCode = $htmlInstructionCode . "function gameOver(score) { ";
  		$htmlInstructionCode = $htmlInstructionCode . " var userArray = document.getElementById(\"sortable\").getElementsByTagName(\"li\");";
 		$htmlInstructionCode = $htmlInstructionCode . "var liItems1 = [];";
 	
 		$htmlInstructionCode = $htmlInstructionCode . "for(var i=0;i<userArray.length;i++){";
 		$htmlInstructionCode = $htmlInstructionCode . "if((sampleArray.indexOf(userArray[i].childNodes[0].nodeValue)+1) != (i+1)){";
  		$htmlInstructionCode = $htmlInstructionCode . "liItems1.push('<li id='+(i+1)+'><font color=\"#FF4747\">' + (sampleArray.indexOf(userArray[i].childNodes[0].nodeValue)+1) + '</font></li>');";
  		$htmlInstructionCode = $htmlInstructionCode . "} else{";
  		$htmlInstructionCode = $htmlInstructionCode . "liItems1.push('<li id='+(i+1)+'><font color=\"#FFCE9C\">' + (sampleArray.indexOf(userArray[i].childNodes[0].nodeValue)+1) + '</font></li>');";
  		$htmlInstructionCode = $htmlInstructionCode . "}}";
 		$htmlInstructionCode = $htmlInstructionCode . "$('#output').empty();";
 		$htmlInstructionCode = $htmlInstructionCode . "$('#output').append( liItems1.join('') );";
 			
 		$htmlInstructionCode = $htmlInstructionCode . "var liItems2 = [];";
 		$htmlInstructionCode = $htmlInstructionCode . "var liItems3 = [];";
		$htmlInstructionCode = $htmlInstructionCode . "$.each(sampleArray,function(i,item){";
 		$htmlInstructionCode = $htmlInstructionCode . "liItems2.push('<li id='+(i+1)+'><font color=\"#FFCE9C\">' + item + '</font></li>');";
 		$htmlInstructionCode = $htmlInstructionCode . "liItems3.push('<li id='+(i+1)+'><font color=\"#FFCE9C\">' + (i+1) + '</font></li>');";
 		$htmlInstructionCode = $htmlInstructionCode . "});";
 		$htmlInstructionCode = $htmlInstructionCode . "$('#expected').empty();";
 		$htmlInstructionCode = $htmlInstructionCode . "$('#expected').append( liItems2.join('') );";
 		$htmlInstructionCode = $htmlInstructionCode . "$('#sequence').empty();";
 		$htmlInstructionCode = $htmlInstructionCode . "$('#sequence').append( liItems3.join('') );";
 			
 		
 		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('none','none','none','none','block','false');";
 		$htmlInstructionCode = $htmlInstructionCode . "if(audioFlag==1 && score >= 100){";
 		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('applause').play();";
 		$htmlInstructionCode = $htmlInstructionCode . "}";
 		$htmlInstructionCode = $htmlInstructionCode . "pausedTime=null;";
 		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('pauseButton').style.display='none';";
 		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('play').style.display='inline';";
 		$htmlInstructionCode = $htmlInstructionCode . "}";
 		
 		$htmlInstructionCode = $htmlInstructionCode . "function onclickPlay() { ";
 		$htmlInstructionCode = $htmlInstructionCode . "if(pausedTime != null){";
 		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('none','block','none','block','none','false');";
  		$htmlInstructionCode = $htmlInstructionCode . "changeMinuteAndTime(pausedTime);";
 		$htmlInstructionCode = $htmlInstructionCode . "}else{"; 		
  		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('none','block','none','block','none','true');";
  		
  		 if($dataVO->getUse1() == "yes"){
  			$timer = $dataVO->getTimer1();
  			$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"level1\").checked=true;";
  		}else if($dataVO->getUse2() == 'yes'){
  			$timer = $dataVO->getTimer2();
  			$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"level2\").checked=true;";
  		}else{
  			$timer = $dataVO->getTimer3();
  			$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"level3\").checked=true;";
  		}
  		  		
 		$htmlInstructionCode = $htmlInstructionCode . "changeLevel(" . $timer . ");";
 		$htmlInstructionCode = $htmlInstructionCode . "}";
 		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('play').style.display='none';";
 		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('pauseButton').style.display='inline';";
 		$htmlInstructionCode = $htmlInstructionCode . "}";
	
		$htmlInstructionCode = $htmlInstructionCode . "function onclickBack() { ";
		$htmlInstructionCode = $htmlInstructionCode . "var minutes = document.getElementById('minute');";
		$htmlInstructionCode = $htmlInstructionCode . "var seconds = document.getElementById('seconds');";
		$htmlInstructionCode = $htmlInstructionCode . "pausedTime = parseInt(minutes.innerHTML * 60,10) + parseInt(seconds.innerHTML,10);";
 		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('block','none','none','block','none','false');";
 		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('pauseButton').style.display='none';";
 		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('play').style.display='inline';";
 		$htmlInstructionCode = $htmlInstructionCode . "}";		

 		
 		$htmlInstructionCode = $htmlInstructionCode . "function changeMinuteAndTime(time) { ";
 		$htmlInstructionCode = $htmlInstructionCode . "newMinutes = Math.floor(time/60);";
 		$htmlInstructionCode = $htmlInstructionCode . "newSeconds = time%60;";
 		$htmlInstructionCode = $htmlInstructionCode . "if(newMinutes<10){";
 		$htmlInstructionCode = $htmlInstructionCode . "newMinutes = \"0\" + newMinutes;";
 		$htmlInstructionCode = $htmlInstructionCode . "}";
 		$htmlInstructionCode = $htmlInstructionCode . "if(newSeconds<10){";
 		$htmlInstructionCode = $htmlInstructionCode . "newSeconds = \"0\" + newSeconds;";
 		$htmlInstructionCode = $htmlInstructionCode . "}";
 		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('minute').innerHTML=newMinutes;";
 		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('seconds').innerHTML=newSeconds;";
 		$htmlInstructionCode = $htmlInstructionCode . "}";
 		
 		$htmlInstructionCode = $htmlInstructionCode . "</script>";
		
		return $htmlInstructionCode;
		
	}
	public function formInstructionContentHTML($dataVO,$styleVO){
		
		$htmlInstructionCode = "<div class='main' id='main'>";
		$htmlInstructionCode = $htmlInstructionCode . "<h1 style= \" color: #".$styleVO->getTitleColor(). "; \">" . $dataVO->getDisplayTitle() . "</h1>";
		$htmlInstructionCode = $htmlInstructionCode . "<div class='instructions' id='instructions' >";
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
		
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
		
		return $htmlInstructionCode;
		
	}
	public function formGameContentHTML($dataVO,$styleVO){
				
		$htmlInstructionCode = "<div id='items' class='game' >";
		
		$itemList = $dataVO->getChildInfo();
		$itemPrefix = "ITEM";
		$itemCount = 1;
		$buttonTitle="Pause";
		
		$Level1Disabled = false;
		$Level2Disabled = false;
		$Level3Disabled = false;
		$defaultTimerValue = 0;
		
		
		if($dataVO->getUse1() == "no"){
			$Level1Disabled = true;
		}
		if($dataVO->getUse2() == "no"){
			$Level2Disabled = true;
		}
		if($dataVO->getUse3() == "no"){
			$Level3Disabled = true;
		}
		
		$minutes = $defaultTimerValue/60;
		$seconds = $defaultTimerValue%60;
		if(strlen($minutes)==1){
			$minutes = "0" . $minutes;
		}
		if(strlen($seconds)==1){
			$seconds = "0" . $seconds;
		}

		$htmlInstructionCode = $htmlInstructionCode . "<font color=\"#FFCE9C\">";
		$htmlInstructionCode = $htmlInstructionCode . "<div class='sequenceIndex' >";
		$htmlInstructionCode = $htmlInstructionCode . "<table  class='tableHeight'><tr>";
		$htmlInstructionCode = $htmlInstructionCode . "<td class='yourSequenceTable'></td>";
		
		$htmlInstructionCode = $htmlInstructionCode . "<td class='correctSequenceTable'></td>";
		$htmlInstructionCode = $htmlInstructionCode . "</tr></table>";
		$htmlInstructionCode = $htmlInstructionCode . "<ul id=\"output2\" class='yourOutput'>";
		$htmlInstructionCode = $htmlInstructionCode . "</ul>";
		
		$htmlInstructionCode = $htmlInstructionCode . "<ul id=\"sequence2\" class='correctOutput'>";
		$htmlInstructionCode = $htmlInstructionCode . "</ul>";
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
		
		
				
		$htmlInstructionCode = $htmlInstructionCode . "<div class='playerOrder'>";
		$htmlInstructionCode = $htmlInstructionCode . "<table class='tableHeight'><tr>";
		$htmlInstructionCode = $htmlInstructionCode . "<td class='yourSequenceTable'></td>";
		
		$htmlInstructionCode = $htmlInstructionCode . "<td class='correctSequenceTable'></td>";
		$htmlInstructionCode = $htmlInstructionCode . "</tr></table>";
		$htmlInstructionCode = $htmlInstructionCode . "<ul id=\"sortable\">";
		$htmlInstructionCode = $htmlInstructionCode . "</ul>";
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
		$htmlInstructionCode = $htmlInstructionCode . "</font>";
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
		
		$htmlInstructionCode = $htmlInstructionCode . "<div id='pause' class='pause' >";
		$htmlInstructionCode = $htmlInstructionCode . "<p>The game is paused.</p><p> Press PLAY to resume.</p>";
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
		
		$htmlInstructionCode = $htmlInstructionCode . "<div id='end' class='gameOver' >";
		$htmlInstructionCode = $htmlInstructionCode . "<table><tr>";
		$htmlInstructionCode = $htmlInstructionCode . "<td class='yourSequenceTable'>Your Sequence</td>";
		
		$htmlInstructionCode = $htmlInstructionCode . "<td class='correctSequenceTable'>Correct Sequence</td>";
		$htmlInstructionCode = $htmlInstructionCode . "<td></td>";
		$htmlInstructionCode = $htmlInstructionCode . "</tr></table>";
		$htmlInstructionCode = $htmlInstructionCode . "<div class='sequenceIndex'>";
		$htmlInstructionCode = $htmlInstructionCode . "<ul id=\"output\" class='yourOutput'>";
		$htmlInstructionCode = $htmlInstructionCode . "</ul>";
		
		$htmlInstructionCode = $htmlInstructionCode . "<ul id=\"sequence\" class='correctOutput'>";
		$htmlInstructionCode = $htmlInstructionCode . "</ul>";
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
		
		$htmlInstructionCode = $htmlInstructionCode . "<div class='correctOutput'>";
		$htmlInstructionCode = $htmlInstructionCode . "<ul id=\"expected\">";
		$htmlInstructionCode = $htmlInstructionCode . "</ul>";
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
		
		$htmlInstructionCode = $htmlInstructionCode . "<div>";
		$htmlInstructionCode = $htmlInstructionCode . "<span id='gameOverLink' class='gameOverLink' >";
		$htmlInstructionCode = $htmlInstructionCode . "<center><p>GAME OVER!!!!</p><p> <a href=\"javascript:location.reload(true);\">CLICK HERE TO PLAY AGAIN</a></p></center>";
		$htmlInstructionCode = $htmlInstructionCode . "</span>";
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
		
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
				
		$htmlInstructionCode = $htmlInstructionCode ."<div id='controls' class='navigation'>";
		$htmlInstructionCode = $htmlInstructionCode ."<span class='controls' id='controls'>";
		$htmlInstructionCode = $htmlInstructionCode ."<input type='submit' name='instruction' class='instructionsButton' id='instruction' value='' onClick=\"onclickBack()\"/>";
		$htmlInstructionCode = $htmlInstructionCode ."<input name='sound' type='button' class='muteButton' id='Mute' value='' onClick=\"setAudioFlag()\"/>";
		$htmlInstructionCode = $htmlInstructionCode ."</span>";
		$htmlInstructionCode = $htmlInstructionCode ."<span class='playPause' id='playPause'>";
		$htmlInstructionCode = $htmlInstructionCode ."<input name='play' type='submit' class='playButton' id='play' value='' onClick=\"onclickPlay()\"/>";
		$htmlInstructionCode = $htmlInstructionCode ."<input name='pause' type='button' class='pauseButton' id='pauseButton' value='' onClick=\"pauseResume()\" />";
		$htmlInstructionCode = $htmlInstructionCode ."</span>";
		$htmlInstructionCode = $htmlInstructionCode ."<span class='levels' id='levels'>";
		$htmlInstructionCode = $htmlInstructionCode ."<label class='levelLabel'>Level </label>";
		
		if($Level1Disabled){
			$htmlInstructionCode = $htmlInstructionCode ."<input name='Level' type='radio' id='level1' value='1' onClick=\"changeLevel(" . $dataVO->getTimer1() . ")\" disabled ><span class=\"levelDisabled\">1</span></input>";
		
		}else{
			$htmlInstructionCode = $htmlInstructionCode ."<input name='Level' type='radio' id='level1' value='1' onClick=\"changeLevel(" . $dataVO->getTimer1() . ")\"><span class=\"levelEnabled\">1</span></input>";
		}
		
		if($Level2Disabled){
			$htmlInstructionCode = $htmlInstructionCode ."<input name='Level' type='radio' id='level2' value='2' onClick=\"changeLevel(" . $dataVO->getTimer2() . ")\" disabled ><span class=\"levelDisabled\">2</span></input>";
		}else{
			$htmlInstructionCode = $htmlInstructionCode ."<input name='Level' type='radio' id='level2' value='2' onClick=\"changeLevel(" . $dataVO->getTimer2() . ")\"  ><span class=\"levelEnabled\">2</span></input>";
		}
		
		if($Level3Disabled){
			$htmlInstructionCode = $htmlInstructionCode ."<input name='Level' type='radio' id='level3' value='3' onClick=\"changeLevel(" . $dataVO->getTimer3() . ")\" disabled ><span class=\"levelDisabled\">3</span></input>";
		
		}else{
			$htmlInstructionCode = $htmlInstructionCode ."<input name='Level' type='radio' id='level3' value='3' onClick=\"changeLevel(" . $dataVO->getTimer3() . ")\"><span class=\"levelEnabled\">3</span></input>";
		
		}		
		$htmlInstructionCode = $htmlInstructionCode ."</span>";
		$htmlInstructionCode = $htmlInstructionCode ."<span id='timer' class='timer'>";
		$htmlInstructionCode = $htmlInstructionCode ."<label class='timerLabel'>Time </label><label class='timerValue'><span id=\"minute\">". $minutes ."</span>:<span id=\"seconds\">".$seconds ."</span></label>";
		$htmlInstructionCode = $htmlInstructionCode ."</span>";
		$htmlInstructionCode = $htmlInstructionCode ."<span id='scoreBox' class='score'>";
		$htmlInstructionCode = $htmlInstructionCode ."<label class='scoreLabel'>Score </label><label class='scoreValue'><span id=\"score\">0</span></label>";
		$htmlInstructionCode = $htmlInstructionCode ."</span>";
		$htmlInstructionCode = $htmlInstructionCode . "<audio id='sound' type='audio/wav' src='" . $styleVO->getResourcePath()  ."sounds/sequence_click.wav' preload='metadata'>";
		$htmlInstructionCode = $htmlInstructionCode . "<audio id='applause' type='audio/wav' src='" . $styleVO->getResourcePath()  ."sounds/Clap.wav' preload>";
		$htmlInstructionCode = $htmlInstructionCode ."</div>";
		
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
		
		return $htmlInstructionCode;
	}
	
	
}

?>