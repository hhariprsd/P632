<?php
require_once("iHTMLContentFormatter.php");

class CategorizeHTMLFormatter implements iHTMLContentFormatter{

	public function formHeaderContentHTML($dataVO,$styleVO){

		$htmlInstructionCode = "";
		$htmlInstructionCode = $htmlInstructionCode . "<link href=\"". $styleVO->getResourcePath()  ."css/Categorize.css\" rel=\"stylesheet\">\n";
		$htmlInstructionCode = $htmlInstructionCode . "<title>" . $dataVO->getDisplayTitle() . " (CATEGORIZE)</title>\n";

		$htmlInstructionCode = $htmlInstructionCode . "<script type='text/javascript'>\n";
		$htmlInstructionCode = $htmlInstructionCode . "var categoryList = new Array();\n";
		$htmlInstructionCode = $htmlInstructionCode . "var allItems = new Array();\n";
		$htmlInstructionCode = $htmlInstructionCode . "var categoryItemsArray = new Array();\n";
		$htmlInstructionCode = $htmlInstructionCode . "var shuffleListOfItems = null;\n";
		$htmlInstructionCode = $htmlInstructionCode . "var pausedTime = null;\n";
		$htmlInstructionCode = $htmlInstructionCode . "var gameItemIndex=0;\n";
		$htmlInstructionCode = $htmlInstructionCode . "var audioFlag=1;\n";
		$htmlInstructionCode = $htmlInstructionCode . "var timerValue=0;\n";
		$htmlInstructionCode = $htmlInstructionCode . "var scoreValue=0;\n";
		$htmlInstructionCode = $htmlInstructionCode . "var countDownTimerObject=null;\n";
		$htmlInstructionCode = $htmlInstructionCode . "var scoreOffset = 100 / " . $dataVO->getSampleSize().";\n";
		$htmlInstructionCode = $htmlInstructionCode . "function changeDiv(id1,id2){\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('instructions').style.display='none';\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('game').style.display='none';\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('pause').style.display='none';\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('gameOver').style.display='none';\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(id1).style.display='block';\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(id2).style.display='none';\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";

		$categories = $dataVO->getCategories();
		foreach($categories as $category){
			$htmlInstructionCode = $htmlInstructionCode . "categoryList.push(\"".$category->getTitle()."\");\n";
			$items = $category->getItems();
			$htmlInstructionCode = $htmlInstructionCode . "var itemArray = new Array();\n";
			foreach($items as $item){
				$htmlInstructionCode = $htmlInstructionCode . "allItems.push(\"" . $item->getItem() ."\");\n";
				$htmlInstructionCode = $htmlInstructionCode . "itemArray.push(\"" .  $item->getItem() ."\");\n";
			}
			$htmlInstructionCode = $htmlInstructionCode . "categoryItemsArray[\"".$category->getTitle() . "\"] = itemArray;\n";
		}

		$htmlInstructionCode = $htmlInstructionCode . " function setHeight() {\n";
		if($dataVO->getUse1() == "yes"){
			$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"level1\").checked=true;\n";
		}else if($dataVO->getUse2() == 'yes'){
			$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"level2\").checked=true;\n";
		}else{
			$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"level3\").checked=true;\n";
		}
		$htmlInstructionCode = $htmlInstructionCode . "}\n";

		$htmlInstructionCode = $htmlInstructionCode . "function play() { \n";
		$htmlInstructionCode = $htmlInstructionCode . "shuffleListOfItems = shuffle();\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"item\").innerHTML = shuffleListOfItems[gameItemIndex];\n";
		$htmlInstructionCode = $htmlInstructionCode . "gameItemIndex++;\n";
		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('game','instructions');\n";
		$htmlInstructionCode = $htmlInstructionCode . "enablePauseButton();\n";
		$htmlInstructionCode = $htmlInstructionCode . "window.clearInterval(countDownTimerObject);\n";
		$htmlInstructionCode = $htmlInstructionCode . "countDownTimerObject = setInterval(function(){ countdown(); },1000);\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";

		$htmlInstructionCode = $htmlInstructionCode . "function setAudioFlag(){\n";
		$htmlInstructionCode = $htmlInstructionCode . "if(audioFlag==0)\n";
		$htmlInstructionCode = $htmlInstructionCode . "{audioFlag=1; document.getElementById('Mute').style.color='#000000';\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"Mute\").style.backgroundImage=\"url('". $styleVO->getResourcePath()  ."images/sequence/sound_button0002.png')\";\n";
		$htmlInstructionCode = $htmlInstructionCode ."}\n";

		$htmlInstructionCode = $htmlInstructionCode . "else\n";

		$htmlInstructionCode = $htmlInstructionCode . "{\naudioFlag=0; document.getElementById('Mute').style.color='#808080';\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"Mute\").style.backgroundImage=\"url('". $styleVO->getResourcePath()  ."images/sequence/mute_button0003.png')\";\n}\n";
		$htmlInstructionCode = $htmlInstructionCode ."}\n";

		$htmlInstructionCode = $htmlInstructionCode . "function pauseResume(){\n";
		$htmlInstructionCode = $htmlInstructionCode . "var minutes = document.getElementById('minute');\n";
		$htmlInstructionCode = $htmlInstructionCode . "var seconds = document.getElementById('seconds');\n";
		$htmlInstructionCode = $htmlInstructionCode . "pausedTime = parseInt(minutes.innerHTML * 60,10) + parseInt(seconds.innerHTML,10);\n";
		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('pause','game');\n";
		$htmlInstructionCode = $htmlInstructionCode . "enablePlayButton();\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";

		$htmlInstructionCode = $htmlInstructionCode . "function validateMatch(buttonName) { \n";
		$htmlInstructionCode = $htmlInstructionCode . "var cat;\n";
		$htmlInstructionCode = $htmlInstructionCode . "window.clearInterval(countDownTimerObject);\n";
		$htmlInstructionCode = $htmlInstructionCode . "var itemMatch = false;\n";
		$htmlInstructionCode = $htmlInstructionCode . "var item = document.getElementById(\"item\").innerHTML;\n";
		$htmlInstructionCode = $htmlInstructionCode . "if(buttonName!=null){\n";
		$htmlInstructionCode = $htmlInstructionCode . "var selectedCategoryItems = new Array(); selectedCategoryItems = categoryItemsArray[buttonName];\n";
		$htmlInstructionCode = $htmlInstructionCode . "for(var i=0;i<selectedCategoryItems.length;i++){\n";
		$htmlInstructionCode = $htmlInstructionCode . "if(selectedCategoryItems[i] == item){\n";
		$htmlInstructionCode = $htmlInstructionCode . "itemMatch = true;\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('lightLabel'+(".$dataVO->getSampleSize() . " - gameItemIndex + 1)).className=\"lightLabelCorrect\";\n";
		$htmlInstructionCode = $htmlInstructionCode . "if(audioFlag==1){\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('correctSound').play();\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";
		$htmlInstructionCode = $htmlInstructionCode . "calcScore();\n";
		$htmlInstructionCode = $htmlInstructionCode . "break;\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";
		$htmlInstructionCode = $htmlInstructionCode . "if(itemMatch == false){\n";
		$htmlInstructionCode = $htmlInstructionCode . "if(audioFlag==1){\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('incorrectSound').play();\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";
		$htmlInstructionCode = $htmlInstructionCode . "for(var j=0;j<categoryList.length;j++){\n";
		$htmlInstructionCode = $htmlInstructionCode . "var selectedCategoryItems = new Array(); \nselectedCategoryItems = categoryItemsArray[categoryList[j]];\n";
		$htmlInstructionCode = $htmlInstructionCode . "for(var i=0;i<selectedCategoryItems.length;i++){\n";
		$htmlInstructionCode = $htmlInstructionCode . "if(selectedCategoryItems[i] == item){\n";
		$htmlInstructionCode = $htmlInstructionCode . "itemMatch = true;\n";
		$htmlInstructionCode = $htmlInstructionCode . "cat = categoryList[j];\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(cat).style.background='#4CC552';\n;";
		$htmlInstructionCode = $htmlInstructionCode . "break;\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";
		$htmlInstructionCode = $htmlInstructionCode . "if(itemMatch==true) break;\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('lightLabel'+ (".$dataVO->getSampleSize() . " - gameItemIndex + 1)).className=\"lightLabelInCorrect\";\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";
		$htmlInstructionCode = $htmlInstructionCode . "setTimeout(function(){continueGame()},1000);\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";

		$htmlInstructionCode = $htmlInstructionCode . "function calcScore() {\n";

		$htmlInstructionCode = $htmlInstructionCode . "scoreValue = scoreValue + scoreOffset;\n";
		$htmlInstructionCode = $htmlInstructionCode . "if(scoreValue>100){\n";
		$htmlInstructionCode = $htmlInstructionCode . "scoreValue = 100;\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('score').innerHTML=''+ Math.floor(scoreValue);\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";

		$htmlInstructionCode = $htmlInstructionCode . "function continueGame() {\n";
		$htmlInstructionCode = $htmlInstructionCode . "var i=0;\n";
		$htmlInstructionCode = $htmlInstructionCode . "for(i=0;i<categoryList.length;i++){\n";
		$htmlInstructionCode = $htmlInstructionCode ." document.getElementById(''+categoryList[i]).style.background = '#F7DFBD';\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";
		$htmlInstructionCode = $htmlInstructionCode . "if(gameItemIndex >= shuffleListOfItems.length){\n";
		$htmlInstructionCode = $htmlInstructionCode . "gameOver();\n";
		$htmlInstructionCode = $htmlInstructionCode . "}else{\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"item\").innerHTML = shuffleListOfItems[gameItemIndex];\n";
		$htmlInstructionCode = $htmlInstructionCode . "gameItemIndex++;\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";
		$htmlInstructionCode = $htmlInstructionCode . "if(document.getElementById(\"level1\").checked == true){\n";
		$htmlInstructionCode = $htmlInstructionCode . "changeMinuteAndTime(".$dataVO->getTimer1().");\n";
		$htmlInstructionCode = $htmlInstructionCode . "}else if(document.getElementById(\"level2\").checked == true){\n";
		$htmlInstructionCode = $htmlInstructionCode . "changeMinuteAndTime(".$dataVO->getTimer2().");\n";
		$htmlInstructionCode = $htmlInstructionCode . "}else if(document.getElementById(\"level3\").checked == true){\n";
		$htmlInstructionCode = $htmlInstructionCode . "changeMinuteAndTime(".$dataVO->getTimer3().");\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";
		$htmlInstructionCode = $htmlInstructionCode . "window.clearInterval(countDownTimerObject);\n";
		$htmlInstructionCode = $htmlInstructionCode . "countDownTimerObject = setInterval(function(){ countdown(); },1000);\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";

		$htmlInstructionCode = $htmlInstructionCode . "function gameOver() {\n";
		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('gameOver','game');\n";
		$htmlInstructionCode = $htmlInstructionCode . "enablePlayButton();\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('gameOverContent').style.display='block';\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";

		$htmlInstructionCode = $htmlInstructionCode . "function resetLights() {\n";
		for($i=1;$i<=$dataVO->getSampleSize();$i++){
			$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('lightLabel".$i."').className=\"lightLabel\";\n";
		}
		$htmlInstructionCode = $htmlInstructionCode . "}\n";

		$htmlInstructionCode = $htmlInstructionCode . "function onclickPlay() {\n";
		$htmlInstructionCode = $htmlInstructionCode . "if(pausedTime != null){\n";
		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('game','pause');\n";
		$htmlInstructionCode = $htmlInstructionCode . "changeMinuteAndTime(pausedTime);\n";
		$htmlInstructionCode = $htmlInstructionCode . "}else{\n";
		$htmlInstructionCode = $htmlInstructionCode . "resetLights();\n";
		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('game','instructions');\n";

		$htmlInstructionCode = $htmlInstructionCode . "if(document.getElementById(\"level1\").checked == true){\n";
		$htmlInstructionCode = $htmlInstructionCode . "changeLevel(" . $dataVO->getTimer1() . ");\n";
		$htmlInstructionCode = $htmlInstructionCode . "}else if(document.getElementById(\"level2\").checked == true){\n";
		$htmlInstructionCode = $htmlInstructionCode . "changeLevel(" . $dataVO->getTimer2() . ");\n";
		$htmlInstructionCode = $htmlInstructionCode . "}else if(document.getElementById(\"level3\").checked == true){\n";
		$htmlInstructionCode = $htmlInstructionCode . "changeLevel(" . $dataVO->getTimer3() . ");\n";
		$htmlInstructionCode = $htmlInstructionCode . "}else {\n";

		if($dataVO->getUse1() == "yes"){
			$timer = $dataVO->getTimer1();
			$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"level1\").checked=true;\n";
		}else if($dataVO->getUse2() == 'yes'){
			$timer = $dataVO->getTimer2();
			$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"level2\").checked=true;\n";
		}else{
			$timer = $dataVO->getTimer3();
			$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"level3\").checked=true;\n";
		}
		$htmlInstructionCode = $htmlInstructionCode . "timerValue = ". $timer . ";\n";
		$htmlInstructionCode = $htmlInstructionCode . "changeLevel(" . $timer . ");\n";
		$htmlInstructionCode = $htmlInstructionCode . "\n}\n}\n";
		$htmlInstructionCode = $htmlInstructionCode . "enablePauseButton();\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";

		$htmlInstructionCode = $htmlInstructionCode . "function enablePauseButton() { \n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('pauseButton').style.display='inline';\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('play').style.display='none';\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";

		$htmlInstructionCode = $htmlInstructionCode . "function enablePlayButton() { \n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('pauseButton').style.display='none';\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('play').style.display='inline';\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";

		$htmlInstructionCode = $htmlInstructionCode . "function changeLevel(timerVal){\n";
		$htmlInstructionCode = $htmlInstructionCode . "gameItemIndex=0;\n";
		$htmlInstructionCode = $htmlInstructionCode . "scoreValue=0;\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('score').innerHTML=''+scoreValue;\n";
		$htmlInstructionCode = $htmlInstructionCode . "resetLights();\n";
		$htmlInstructionCode = $htmlInstructionCode . "play();\n";
		$htmlInstructionCode = $htmlInstructionCode . "changeMinuteAndTime(timerVal);\n";
		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('game','instructions');\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('pauseButton').style.display='inline';\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('play').style.display='none';\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";

		$htmlInstructionCode = $htmlInstructionCode . "function changeMinuteAndTime(time) { \n";
		$htmlInstructionCode = $htmlInstructionCode . "newMinutes = Math.floor(time/60);\n";
		$htmlInstructionCode = $htmlInstructionCode . "newSeconds = time%60;\n";
		$htmlInstructionCode = $htmlInstructionCode . "if(newMinutes<10){\n";
		$htmlInstructionCode = $htmlInstructionCode . "newMinutes = \"0\" + newMinutes;\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";
		$htmlInstructionCode = $htmlInstructionCode . "if(newSeconds<10){\n";
		$htmlInstructionCode = $htmlInstructionCode . "newSeconds = \"0\" + newSeconds;\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('minute').innerHTML=newMinutes;\n";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('seconds').innerHTML=newSeconds;\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";

		$htmlInstructionCode = $htmlInstructionCode . "function countdown() { \n";
		$htmlInstructionCode = $htmlInstructionCode . "var minutes = document.getElementById('minute');\n";
		$htmlInstructionCode = $htmlInstructionCode . "var seconds = document.getElementById('seconds');\n";
		$htmlInstructionCode = $htmlInstructionCode . "if( document.getElementById('game').style.display == 'block'){\n";
		$htmlInstructionCode = $htmlInstructionCode . "time = parseInt(minutes.innerHTML * 60,10) + parseInt(seconds.innerHTML,10);\n";
		$htmlInstructionCode = $htmlInstructionCode . "time = time - 1;\n";
		$htmlInstructionCode = $htmlInstructionCode . "changeMinuteAndTime(time);\n";
		$htmlInstructionCode = $htmlInstructionCode . "if (time <= 0) {\n";
		$htmlInstructionCode = $htmlInstructionCode . "validateMatch(null);\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";

		$htmlInstructionCode = $htmlInstructionCode . "function onclickBack() { \n";
		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('none','block');\n";
		$htmlInstructionCode = $htmlInstructionCode . "}\n";

		$htmlInstructionCode = $htmlInstructionCode. "function shuffle(){\n";
		$htmlInstructionCode = $htmlInstructionCode. "var items = allItems.slice(0,allItems.length);\n";
		$htmlInstructionCode = $htmlInstructionCode. "sampleArray = new Array();\n";
		$htmlInstructionCode = $htmlInstructionCode. "if(items.length>".$dataVO->getSampleSize().")\n";
		$htmlInstructionCode = $htmlInstructionCode. "{\n";
		$htmlInstructionCode = $htmlInstructionCode. "for (var i = ".$dataVO->getSampleSize()." - 1; i >= 0; i--) {\n";
		$htmlInstructionCode = $htmlInstructionCode. "var randomIndex = Math.floor((Math.random() * (items.length)));\n";
		$htmlInstructionCode = $htmlInstructionCode. "sampleArray.push(items.splice(randomIndex,1).toString());\n";
		$htmlInstructionCode = $htmlInstructionCode. "}\n}\n";
		$htmlInstructionCode = $htmlInstructionCode. "else{\n";
		$htmlInstructionCode = $htmlInstructionCode. "for (var i = items.length - 1; i >= 0; i--) {\n";
		$htmlInstructionCode = $htmlInstructionCode. "var randomIndex = Math.floor(Math.random() * (i + 1));\n";
		$htmlInstructionCode = $htmlInstructionCode. "sampleArray.push(items.splice(randomIndex,1).toString());\n";
		$htmlInstructionCode = $htmlInstructionCode. "}\n}\n";
		$htmlInstructionCode = $htmlInstructionCode. "return sampleArray;\n";
		$htmlInstructionCode = $htmlInstructionCode. "}\n";
		$htmlInstructionCode = $htmlInstructionCode. "</script>\n";
		return $htmlInstructionCode;

	}
	public function formInstructionContentHTML($dataVO,$styleVO){

		$htmlInstructionCode = "<div class='main' id='main'>\n";
		$htmlInstructionCode = $htmlInstructionCode . "<h2 style= \" color: #".$styleVO->getTitleColor(). "; \">" . $dataVO->getDisplayTitle() . "</h2>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<table cellspacing=\"0\" cellpadding=\"0\" class=\"wrapperTable\"><tr><td>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<table class='maintable'><tr class='instructions' id='instructions'><td>\n";
		$htmlInstructionCode = $htmlInstructionCode . "<div>\n";
		$htmlInstructionCode = $htmlInstructionCode . "<h2>Instructions:</h2>\n";

		$instructions = $styleVO->getInitialInstructions();

		if(strlen(trim($instructions))>0){
			$instructionList	 = explode("WHAT", $instructions);

			foreach($instructionList as $instruction){
				if((strlen(trim($instruction)))>0){
					$htmlInstructionCode = $htmlInstructionCode . "WHAT". $instruction .  "<br/><br/>\n";
				}
			}
		}else{
			$htmlInstructionCode = $htmlInstructionCode . "<table>\n";
			$htmlInstructionCode = $htmlInstructionCode . "<tr><td class='defaultInstructions'>\n";
			$htmlInstructionCode = $htmlInstructionCode . "<p>In this game format, Categorize, you will see on the right half of the game screen two to five categories displayed vertically (e.g., Animals, Vegetables, Minerals). On the left half of the screen you will see words or phrases that correspond with or relate to one of the categories (e.g., Tiger). Your objective is to choose the category under which you think the item on the left falls (e.g., 'Tiger' falls under category 'Animals'). </p> \n";
			$htmlInstructionCode = $htmlInstructionCode . "</td></tr>\n";
			$htmlInstructionCode = $htmlInstructionCode . "<tr><td class='defaultInstructions'></td></tr>\n";
			$htmlInstructionCode = $htmlInstructionCode . "<tr><td class='defaultInstructions'>\n";
			$htmlInstructionCode = $htmlInstructionCode . "<p> With each increase in level, you will find that the time allowed in which to choose a category decreases. Click <?> for more details instructions </p> \n";
			$htmlInstructionCode = $htmlInstructionCode . "</td></tr>\n";
			$htmlInstructionCode = $htmlInstructionCode . "</table>\n";
		}

		$htmlInstructionCode = $htmlInstructionCode . "</div>\n";
		$htmlInstructionCode = $htmlInstructionCode ."</tr></td>\n";

		return $htmlInstructionCode;
	}
	public function formGameContentHTML($dataVO,$styleVO){

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

		$htmlInstructionCode = "";

		$htmlInstructionCode = $htmlInstructionCode ."<tr  id='game' class='game'><td>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<div>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<table>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<tr>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<td class='item'>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<div id='item'>\n</div>\n";
		$htmlInstructionCode = $htmlInstructionCode ."</td>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<td class='categories'>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<div id='categories'>\n";
		$categories = $dataVO->getCategories();
		$htmlInstructionCode = $htmlInstructionCode ."<table>\n";
		foreach($categories as $category){
			$htmlInstructionCode = $htmlInstructionCode ."<tr><td>\n<input type=\"button\" class=\"categoryButton\" id=\"" . $category->getTitle() . "\" value=\"" . $category->getTitle() . "\" onClick='validateMatch(this.id)'/></td>\n";
		}
		$htmlInstructionCode = $htmlInstructionCode ."</table>\n";
		$htmlInstructionCode = $htmlInstructionCode ."</div>\n";
		$htmlInstructionCode = $htmlInstructionCode ."</td>\n";
		$htmlInstructionCode = $htmlInstructionCode ."</tr>\n";
		$htmlInstructionCode = $htmlInstructionCode ."</table>\n";
		$htmlInstructionCode = $htmlInstructionCode ."</div>\n";
		$htmlInstructionCode = $htmlInstructionCode ."</td></tr>\n";
		$htmlInstructionCode = $htmlInstructionCode . "<tr><td  id='pause' class='pause'>\n";
		$htmlInstructionCode = $htmlInstructionCode . "<div>\n";
		$htmlInstructionCode = $htmlInstructionCode . "<p >The game is paused.</p><p > Press PLAY to resume.</p>\n";
		$htmlInstructionCode = $htmlInstructionCode . "</div></td></tr><tr><td id='gameOver' class='gameOver'>\n";
		$htmlInstructionCode = $htmlInstructionCode . "<div class=\"gameOverLink\">\n";
		$htmlInstructionCode = $htmlInstructionCode . "<span id=\"gameOverContent\" class=\"gameOverContent\">\n";
		$htmlInstructionCode = $htmlInstructionCode . "<p>GAME OVER </p>\n";
		$htmlInstructionCode = $htmlInstructionCode . "<p><a href=\"javascript:onclickPlay();\">CLICK HERE TO PLAY AGAIN</a></p>\n";
		$htmlInstructionCode = $htmlInstructionCode . "</span>\n";
		$htmlInstructionCode = $htmlInstructionCode . "</div>\n";
		$htmlInstructionCode = $htmlInstructionCode ."</td>\n";

		$htmlInstructionCode = $htmlInstructionCode ."</tr>\n";

		$htmlInstructionCode = $htmlInstructionCode ."<tr id='controls' class='navigation'><td>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<div>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<span class='controls' id='controls'>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<input type='submit' name='instruction' class='instructionsButton' id='instruction' value='' onClick=\"changeDiv('instructions','game')\"/>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<input name='sound' type='button' class='muteButton' id='Mute' value='' onClick=\"setAudioFlag()\"/>\n";
		$htmlInstructionCode = $htmlInstructionCode ."</span>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<span class='playPause' id='playPause'>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<input name='play' type='submit' class='playButton' id='play' value='' onClick=\"onclickPlay()\"/>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<input name='pause' type='button' class='pauseButton' id='pauseButton' value='' onClick=\"pauseResume()\" />\n";

		$htmlInstructionCode = $htmlInstructionCode ."</span>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<span class='levels' id='levels'>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<label class='levelLabel'>Level </label>\n";

		if($Level1Disabled){
			$htmlInstructionCode = $htmlInstructionCode ."<input name='Level' type='radio' id='level1' value='1' onClick=\"changeLevel(" . $dataVO->getTimer1() . ")\" disabled >\n<span class=\"levelDisabled\">1\n</span>\n</input>\n";

		}else{
			$htmlInstructionCode = $htmlInstructionCode ."<input name='Level' type='radio' id='level1' value='1' onClick=\"changeLevel(" . $dataVO->getTimer1() . ")\">\n<span class=\"levelEnabled\">1</span>\n</input>\n";
		}

		if($Level2Disabled){
			$htmlInstructionCode = $htmlInstructionCode ."<input name='Level' type='radio' id='level2' value='2' onClick=\"changeLevel(" . $dataVO->getTimer2() . ")\" disabled >\n<span class=\"levelDisabled\">2</span>\n</input>\n";
		}else{
			$htmlInstructionCode = $htmlInstructionCode ."<input name='Level' type='radio' id='level2' value='2' onClick=\"changeLevel(" . $dataVO->getTimer2() . ")\"  >\n<span class=\"levelEnabled\">2</span>\n</input>\n";
		}

		if($Level3Disabled){
			$htmlInstructionCode = $htmlInstructionCode ."<input name='Level' type='radio' id='level3' value='3' onClick=\"changeLevel(" . $dataVO->getTimer3() . ")\" disabled >\n<span class=\"levelDisabled\">3</span>\n</input>\n";

		}else{
			$htmlInstructionCode = $htmlInstructionCode ."<input name='Level' type='radio' id='level3' value='3' onClick=\"changeLevel(" . $dataVO->getTimer3() . ")\">\n<span class=\"levelEnabled\">3</span>\n</input>\n";

		}
		$htmlInstructionCode = $htmlInstructionCode ."</span>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<span id='timer' class='timer'>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<label class='timerLabel'>Time </label><label class='timerValue'>\n<span id=\"minute\">". $minutes ."</span>:<span id=\"seconds\">".$seconds ."</span>\n</label>\n";
		$htmlInstructionCode = $htmlInstructionCode ."</span>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<span id='scoreBox' class='score'>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<label class='scoreLabel'>Score </label>\n<label class='scoreValue'>\n<span id=\"score\">0</span></label>\n";
		$htmlInstructionCode = $htmlInstructionCode ."</span>\n";
		$htmlInstructionCode = $htmlInstructionCode . "<audio id='correctSound' type='audio/wav' src='" . $styleVO->getResourcePath()  ."sounds/Categorize/correct.wav' preload='metadata'>\n";
		$htmlInstructionCode = $htmlInstructionCode . "<audio id='incorrectSound' type='audio/wav' src='" . $styleVO->getResourcePath()  ."sounds/Categorize/incorrect.wav' preload='metadata'>\n";
		$htmlInstructionCode = $htmlInstructionCode . "<audio id='applause' type='audio/wav' src='" . $styleVO->getResourcePath()  ."sounds/Clap.wav' preload>\n";
		$htmlInstructionCode = $htmlInstructionCode ."</div>\n";

		$htmlInstructionCode = $htmlInstructionCode ."</td>\n";

		$htmlInstructionCode = $htmlInstructionCode ."</tr>\n";
		$htmlInstructionCode = $htmlInstructionCode ."</table>\n";
		$htmlInstructionCode = $htmlInstructionCode ."</td>\n";
		$htmlInstructionCode = $htmlInstructionCode ."<td rowspan=\"2\" id='lights' class='lights'>\n";
		$htmlInstructionCode = $htmlInstructionCode . "<table>\n";

		for($i=1;$i<=$dataVO->getSampleSize();$i++){
			$htmlInstructionCode = $htmlInstructionCode . "<tr>\n<td  id='lightLabel".$i. "' class='lightLabel'></td>\n</tr>\n";
		}


		$htmlInstructionCode = $htmlInstructionCode . "</table >\n";
		$htmlInstructionCode = $htmlInstructionCode ."</td>\n";


		return $htmlInstructionCode;
	}
}