<?php
require_once("iHTMLContentFormatter.php");

class CategorizeHTMLFormatter implements iHTMLContentFormatter{
	
	public function formHeaderContentHTML($dataVO,$styleVO){
		
		$htmlInstructionCode = "";
		$htmlInstructionCode = $htmlInstructionCode . "<link href=\"". $styleVO->getResourcePath()  ."css/Categorize.css\" rel=\"stylesheet\">";
		$htmlInstructionCode = $htmlInstructionCode . "<title>" . $dataVO->getDisplayTitle() . " (CATEGORIZE)</title>";
		
		$htmlInstructionCode = $htmlInstructionCode . "<script type='text/javascript'>";
		$htmlInstructionCode = $htmlInstructionCode . "var allItems = new Array();";
		$htmlInstructionCode = $htmlInstructionCode . "var categoryItemsArray = new Array();";
		$htmlInstructionCode = $htmlInstructionCode . "var shuffleListOfItems = null;";
		$htmlInstructionCode = $htmlInstructionCode . "var pausedTime = null;";
		$htmlInstructionCode = $htmlInstructionCode . "var gameItemIndex=0;";
		$htmlInstructionCode = $htmlInstructionCode . "var audioFlag=1;";
		$htmlInstructionCode = $htmlInstructionCode . "var timerValue=0;";
		$htmlInstructionCode = $htmlInstructionCode . "function changeDiv(id1,id2){";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(id1).style.display='block';";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(id2).style.display='none';";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		
		$categories = $dataVO->getCategories();
		foreach($categories as $category){
			$items = $category->getItems();
			$htmlInstructionCode = $htmlInstructionCode . "var itemArray = new Array();";
			foreach($items as $item){
				$htmlInstructionCode = $htmlInstructionCode . "allItems.push(\"" . $item->getItem() ."\");";
				$htmlInstructionCode = $htmlInstructionCode . "itemArray.push(\"" .  $item->getItem() ."\");";
			}
			$htmlInstructionCode = $htmlInstructionCode . "categoryItemsArray[\"".$category->getTitle() . "\"] = itemArray;";
		}
		
		
		$htmlInstructionCode = $htmlInstructionCode . "function play() { ";
		$htmlInstructionCode = $htmlInstructionCode . "shuffleListOfItems = shuffle();";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"item\").innerHTML = shuffleListOfItems[gameItemIndex];";
		$htmlInstructionCode = $htmlInstructionCode . "gameItemIndex++;";
		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('game','instructions');";
		$htmlInstructionCode = $htmlInstructionCode . "enablePauseButton();";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		
		$htmlInstructionCode = $htmlInstructionCode . "function setAudioFlag(){";
		$htmlInstructionCode = $htmlInstructionCode . "if(audioFlag==0)";
		$htmlInstructionCode = $htmlInstructionCode . "{audioFlag=1; document.getElementById('Mute').style.color='#000000';";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"Mute\").style.backgroundImage=\"url('". $styleVO->getResourcePath()  ."images/sequence/sound_button0002.png')\";";
		$htmlInstructionCode = $htmlInstructionCode ."}";
		
		$htmlInstructionCode = $htmlInstructionCode . "else";
		
		$htmlInstructionCode = $htmlInstructionCode . "{audioFlag=0; document.getElementById('Mute').style.color='#808080';";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"Mute\").style.backgroundImage=\"url('". $styleVO->getResourcePath()  ."images/sequence/mute_button0003.png')\";}";
		$htmlInstructionCode = $htmlInstructionCode ."}";
		
		$htmlInstructionCode = $htmlInstructionCode . "function pauseResume(){";
		$htmlInstructionCode = $htmlInstructionCode . "var minutes = document.getElementById('minute');";
		$htmlInstructionCode = $htmlInstructionCode . "var seconds = document.getElementById('seconds');";
		$htmlInstructionCode = $htmlInstructionCode . "pausedTime = parseInt(minutes.innerHTML * 60,10) + parseInt(seconds.innerHTML,10);";
		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('pause','game');";
		$htmlInstructionCode = $htmlInstructionCode . "enablePlayButton();";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		
		$htmlInstructionCode = $htmlInstructionCode . "function validateMatch(buttonName) { ";
		$htmlInstructionCode = $htmlInstructionCode . "var itemMatch = false;";
		$htmlInstructionCode = $htmlInstructionCode . "var item = document.getElementById(\"item\").innerHTML;";
		$htmlInstructionCode = $htmlInstructionCode . "if(buttonName!=null){";
		$htmlInstructionCode = $htmlInstructionCode . "var selectedCategoryItems = new Array(); selectedCategoryItems = categoryItemsArray[buttonName];";
		$htmlInstructionCode = $htmlInstructionCode . "for(var i=0;i<selectedCategoryItems.length;i++){";
		$htmlInstructionCode = $htmlInstructionCode . "if(selectedCategoryItems[i] == item){";
		$htmlInstructionCode = $htmlInstructionCode . "itemMatch = true;";
		$htmlInstructionCode = $htmlInstructionCode . "if(audioFlag==1)";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('correctSound').play();";
		$htmlInstructionCode = $htmlInstructionCode . "alert('Matched');";
		$htmlInstructionCode = $htmlInstructionCode . "break;";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		$htmlInstructionCode = $htmlInstructionCode . "if(audioFlag==1 && itemMatch == false){";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('incorrectSound').play();}";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		$htmlInstructionCode = $htmlInstructionCode . "continueGame();";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		
		$htmlInstructionCode = $htmlInstructionCode . "function continueGame() { ";
		$htmlInstructionCode = $htmlInstructionCode . "if(gameItemIndex>=shuffleListOfItems.length){";
		$htmlInstructionCode = $htmlInstructionCode . "gameOver();";
		$htmlInstructionCode = $htmlInstructionCode . "}else{";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(\"item\").innerHTML = shuffleListOfItems[gameItemIndex];";
		$htmlInstructionCode = $htmlInstructionCode . "gameItemIndex++;";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		$htmlInstructionCode = $htmlInstructionCode . "changeMinuteAndTime(timerValue);";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		
		$htmlInstructionCode = $htmlInstructionCode . "function gameOver() { ";
		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('gameOver','game');";
		$htmlInstructionCode = $htmlInstructionCode . "enablePlayButton();";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('gameOverContent').style.display='block';";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		
		
		$htmlInstructionCode = $htmlInstructionCode . "function onclickPlay() { ";
		$htmlInstructionCode = $htmlInstructionCode . "if(pausedTime != null){";
		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('game','pause');";
		$htmlInstructionCode = $htmlInstructionCode . "changeMinuteAndTime(pausedTime);";
		$htmlInstructionCode = $htmlInstructionCode . "}else{";
		$htmlInstructionCode = $htmlInstructionCode . "setInterval(function(){ countdown(); },1000);";
		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('game','instructions');";
		
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
		$htmlInstructionCode = $htmlInstructionCode . "timerValue = ". $timer . ";"; 
		$htmlInstructionCode = $htmlInstructionCode . "changeLevel(" . $timer . ");";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		$htmlInstructionCode = $htmlInstructionCode . "enablePauseButton();";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		
		$htmlInstructionCode = $htmlInstructionCode . "function enablePauseButton() { ";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('pauseButton').style.display='inline';";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('play').style.display='none';";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		
		$htmlInstructionCode = $htmlInstructionCode . "function enablePlayButton() { ";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('pauseButton').style.display='none';";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('play').style.display='inline';";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		
		$htmlInstructionCode = $htmlInstructionCode . "function changeLevel(timerVal){";
		$htmlInstructionCode = $htmlInstructionCode . "play();";
		$htmlInstructionCode = $htmlInstructionCode . "changeMinuteAndTime(timerVal);";
		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('game','instructions');";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('pauseButton').style.display='inline';";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('play').style.display='none';";
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
		
		$htmlInstructionCode = $htmlInstructionCode . "function countdown() { ";
		$htmlInstructionCode = $htmlInstructionCode . "var minutes = document.getElementById('minute');";
		$htmlInstructionCode = $htmlInstructionCode . "var seconds = document.getElementById('seconds');";
		$htmlInstructionCode = $htmlInstructionCode . "if( document.getElementById('game').style.display == 'block'){";
		$htmlInstructionCode = $htmlInstructionCode . "time = parseInt(minutes.innerHTML * 60,10) + parseInt(seconds.innerHTML,10);";
		$htmlInstructionCode = $htmlInstructionCode . "time = time - 1;";
		$htmlInstructionCode = $htmlInstructionCode . "changeMinuteAndTime(time);";
		$htmlInstructionCode = $htmlInstructionCode . "if (time <= 0) {";
		$htmlInstructionCode = $htmlInstructionCode . "validateMatch(null);";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		$htmlInstructionCode = $htmlInstructionCode . "}";		
		$htmlInstructionCode = $htmlInstructionCode . "}";
		
		
	
		$htmlInstructionCode = $htmlInstructionCode . "function onclickBack() { ";
		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('none','block');";
 		$htmlInstructionCode = $htmlInstructionCode . "}";
		
		$htmlInstructionCode = $htmlInstructionCode. "function shuffle(){";
		$htmlInstructionCode = $htmlInstructionCode. "sampleArray = new Array();";
		$htmlInstructionCode = $htmlInstructionCode. "if(allItems.length>".$dataVO->getSampleSize().")";
		$htmlInstructionCode = $htmlInstructionCode. "{";
		$htmlInstructionCode = $htmlInstructionCode. "for (var i = ".$dataVO->getSampleSize()." - 1; i >= 0; i--) {";
		$htmlInstructionCode = $htmlInstructionCode. "var randomIndex = Math.floor((Math.random() * (allItems.length)));";
		$htmlInstructionCode = $htmlInstructionCode. "sampleArray.push(allItems.splice(randomIndex,1).toString());";
		$htmlInstructionCode = $htmlInstructionCode. "}}";
		$htmlInstructionCode = $htmlInstructionCode. "else{";
		$htmlInstructionCode = $htmlInstructionCode. "for (var i = itemArray.length - 1; i >= 0; i--) {";
		$htmlInstructionCode = $htmlInstructionCode. "var randomIndex = Math.floor(Math.random() * (i + 1));";
		$htmlInstructionCode = $htmlInstructionCode. "sampleArray.push(allItems.splice(randomIndex,1).toString());";
		$htmlInstructionCode = $htmlInstructionCode. "}}";
		$htmlInstructionCode = $htmlInstructionCode. "return sampleArray;";
		$htmlInstructionCode = $htmlInstructionCode. "}";
		$htmlInstructionCode = $htmlInstructionCode. "</script>";
		return $htmlInstructionCode;
		
	}
	public function formInstructionContentHTML($dataVO,$styleVO){
		$height = ((($dataVO->getSampleSize() - 7) * 30 ) + 280);
		$htmlInstructionCode = "<div class='main' id='main'>";
		$htmlInstructionCode = $htmlInstructionCode . "<h2 style= \" color: #".$styleVO->getTitleColor(). "; \">" . $dataVO->getDisplayTitle() . "</h2>";
		$htmlInstructionCode = $htmlInstructionCode . "<div class='instructions' id='instructions' style=\"height:". $height ."px;\">";
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
			$htmlInstructionCode = $htmlInstructionCode . "<table>";
			$htmlInstructionCode = $htmlInstructionCode . "<tr><td class='defaultInstructions'>";
			$htmlInstructionCode = $htmlInstructionCode . "<p>In this game format, Categorize, you will see on the right half of the game screen two to five categories displayed vertically (e.g., Animals, Vegetables, Minerals). On the left half of the screen you will see words or phrases that correspond with or relate to one of the categories (e.g., Tiger). Your objective is to choose the category under which you think the item on the left falls (e.g., 'Tiger' falls under category 'Animals'). </p> ";
			$htmlInstructionCode = $htmlInstructionCode . "</td></tr>";
			$htmlInstructionCode = $htmlInstructionCode . "<tr><td class='defaultInstructions'></td></tr>";
			$htmlInstructionCode = $htmlInstructionCode . "<tr><td class='defaultInstructions'>";
			$htmlInstructionCode = $htmlInstructionCode . "<p> With each increase in level, you will find that the time allowed in which to choose a category decreases. Click <?> for more details instructions </p> ";
			$htmlInstructionCode = $htmlInstructionCode . "</td></tr>";
			$htmlInstructionCode = $htmlInstructionCode . "</table>";
		}
		
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
		
		return $htmlInstructionCode;
	}
	public function formGameContentHTML($dataVO,$styleVO){
		$height = ((($dataVO->getSampleSize() - 7) * 30 ) + 280);
		$midHeight = (($height / 2) - 90) ;
		
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
		
		$htmlInstructionCode = $htmlInstructionCode ."<div id='game' class='game'>";
		$htmlInstructionCode = $htmlInstructionCode ."<table>";
		$htmlInstructionCode = $htmlInstructionCode ."<tr><td class='item'>";
		$htmlInstructionCode = $htmlInstructionCode ."<div id='item'>";
		$htmlInstructionCode = $htmlInstructionCode ."</div>";
		$htmlInstructionCode = $htmlInstructionCode ."</td><td class='categories'>";
		$htmlInstructionCode = $htmlInstructionCode ."<div id='categories'>";
		$categories = $dataVO->getCategories();
		$htmlInstructionCode = $htmlInstructionCode ."<table>";
		foreach($categories as $category){
			$htmlInstructionCode = $htmlInstructionCode ."<tr><td><input type=\"button\" class=\"categoryButton\" id=\"" . $category->getTitle() . "\" value=\"" . $category->getTitle() . "\" onClick='validateMatch(this.id)'/></td></tr>";
		}
		$htmlInstructionCode = $htmlInstructionCode ."</table>";
		$htmlInstructionCode = $htmlInstructionCode ."</div>";
		$htmlInstructionCode = $htmlInstructionCode ."</td></tr></table>";
		$htmlInstructionCode = $htmlInstructionCode ."</div>";
		$htmlInstructionCode = $htmlInstructionCode . "<div id='pause' class='pause' >";
		$htmlInstructionCode = $htmlInstructionCode . "<p>The game is paused.</p><p> Press PLAY to resume.</p>";
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
		$htmlInstructionCode = $htmlInstructionCode . "<div id='gameOver' class='gameOver' >";
		$htmlInstructionCode = $htmlInstructionCode . "<p>Game Over</p>";
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
		$htmlInstructionCode = $htmlInstructionCode ."<div id='controls' class='navigation'>";
		$htmlInstructionCode = $htmlInstructionCode ."<span class='controls' id='controls'>";
		$htmlInstructionCode = $htmlInstructionCode ."<input type='submit' name='instruction' class='instructionsButton' id='instruction' value='' onClick=\"changeDiv('instructions','game')\"/>";
		$htmlInstructionCode = $htmlInstructionCode ."<input name='sound' type='button' class='muteButton' id='Mute' value='' onClick=\"setAudioFlag()\"/>";
		$htmlInstructionCode = $htmlInstructionCode ."</span>";
		$htmlInstructionCode = $htmlInstructionCode ."<span class='playPause' id='playPause'>";
		$htmlInstructionCode = $htmlInstructionCode ."<input name='play' type='submit' class='playButton' id='play' value='' onClick=\"onclickPlay()\"/>";
		$htmlInstructionCode = $htmlInstructionCode ."<input name='pause' type='button' class='pauseButton' id='pauseButton' value='' onClick=\"pauseResume()\" />";
		/* $htmlInstructionCode = $htmlInstructionCode ."<input name='Shuffle' type='button' value='Shuffle Items' id='shuffle' value='' onClick=\"shuffle()\" />"; */
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
		$htmlInstructionCode = $htmlInstructionCode . "<audio id='correctSound' type='audio/wav' src='" . $styleVO->getResourcePath()  ."sounds/Categorize/correct.wav' preload='metadata'>";
		$htmlInstructionCode = $htmlInstructionCode . "<audio id='incorrectSound' type='audio/wav' src='" . $styleVO->getResourcePath()  ."sounds/Categorize/incorrect.wav' preload='metadata'>";
		$htmlInstructionCode = $htmlInstructionCode . "<audio id='applause' type='audio/wav' src='" . $styleVO->getResourcePath()  ."sounds/Clap.wav' preload>";
		$htmlInstructionCode = $htmlInstructionCode ."</div>";
		$htmlInstructionCode = $htmlInstructionCode ."</div>";
		return $htmlInstructionCode;
	}
}