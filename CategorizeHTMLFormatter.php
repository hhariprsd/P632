<?php
require_once("iHTMLContentFormatter.php");

class CategorizeHTMLFormatter implements iHTMLContentFormatter{
	
	public function formHeaderContentHTML($dataVO,$styleVO){
		
		$htmlInstructionCode = "";
		$htmlInstructionCode = $htmlInstructionCode . "<link href=\"". $styleVO->getResourcePath()  ."css/Categorize.css\" rel=\"stylesheet\">";
		$htmlInstructionCode = $htmlInstructionCode . "<title>" . $dataVO->getDisplayTitle() . "</title>";
		
		$htmlInstructionCode = $htmlInstructionCode . "<script type='text/javascript'>";
		$htmlInstructionCode = $htmlInstructionCode . "var OriginalItemArray = new Array();";
		$htmlInstructionCode = $htmlInstructionCode . "var i=0;";
		$htmlInstructionCode = $htmlInstructionCode . "function changeDiv(id1,id2){";
		
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(id1).style.display='block';";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(id2).style.display='none';";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		
		$categories = $dataVO->getCategories();
		foreach($categories as $category){
			$items = $category->getItems();
			foreach($items as $item){
				$htmlInstructionCode = $htmlInstructionCode . "OriginalItemArray.push(\"" . $item->getItem() ."\");";
			}
		}
		
		//$htmlInstructionCode = $htmlInstructionCode . "alert('items '+OriginalItemArray);";
		$htmlInstructionCode = $htmlInstructionCode . "function onclickBack() { ";
	
 		//$htmlInstructionCode = $htmlInstructionCode . "pausedTime = document.getElementById('counter').innerHTML;";
 		$htmlInstructionCode = $htmlInstructionCode . "changeDiv('none','block');";
 		$htmlInstructionCode = $htmlInstructionCode . "}";
		
		$htmlInstructionCode = $htmlInstructionCode. "function shuffle(){";
		$htmlInstructionCode = $htmlInstructionCode. "itemArray = new Array();";
		$htmlInstructionCode = $htmlInstructionCode. "sampleArray = new Array();";
		$htmlInstructionCode = $htmlInstructionCode. "shuffleArray = new Array();";
		$htmlInstructionCode = $htmlInstructionCode. "itemArray = OriginalItemArray.slice(0,OriginalItemArray.length);";
		$htmlInstructionCode = $htmlInstructionCode. "if(itemArray.length>".$dataVO->getSampleSize().")";
		$htmlInstructionCode = $htmlInstructionCode. "{";
		$htmlInstructionCode = $htmlInstructionCode. "for (var i = ".$dataVO->getSampleSize()." - 1; i >= 0; i--) {";
		$htmlInstructionCode = $htmlInstructionCode. "var randomIndex = Math.floor((Math.random() * (itemArray.length))%7);";
		$htmlInstructionCode = $htmlInstructionCode. "sampleArray.push(itemArray.splice(randomIndex,1).toString());";
		$htmlInstructionCode = $htmlInstructionCode. "}}";
		$htmlInstructionCode = $htmlInstructionCode. "else{";
		$htmlInstructionCode = $htmlInstructionCode. "for (var i = itemArray.length - 1; i >= 0; i--) {";
		$htmlInstructionCode = $htmlInstructionCode. "var randomIndex = Math.floor(Math.random() * (i + 1));";
		$htmlInstructionCode = $htmlInstructionCode. "sampleArray.push(itemArray.splice(randomIndex,1).toString());";
		$htmlInstructionCode = $htmlInstructionCode. "}}";
		$htmlInstructionCode = $htmlInstructionCode. "shuffleArray = sampleArray.slice(0,sampleArray.length);";
		$htmlInstructionCode = $htmlInstructionCode. "for(var i=0;i<sampleArray.length;i++) {";
		$htmlInstructionCode = $htmlInstructionCode. "for(var j=0;j<sampleArray.length-i-1;j++) {";
		$htmlInstructionCode = $htmlInstructionCode. "if(OriginalItemArray.indexOf(sampleArray[j]+\"\") > OriginalItemArray.indexOf(sampleArray[j+1]+\"\")) {";
		$htmlInstructionCode = $htmlInstructionCode. "temp = sampleArray[j];";
		$htmlInstructionCode = $htmlInstructionCode. "sampleArray[j]= sampleArray[j+1];";
		$htmlInstructionCode = $htmlInstructionCode. "sampleArray[j+1]= temp;";
		$htmlInstructionCode = $htmlInstructionCode. "}";
		$htmlInstructionCode = $htmlInstructionCode. "}}";
		$htmlInstructionCode = $htmlInstructionCode. "alert('Shuffled Items as per the Sample Size retrieved : '+shuffleArray);";
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
		$categories = $dataVO->getCategories();
		foreach($categories as $category){
			$htmlInstructionCode = $htmlInstructionCode ."<table>";
			$htmlInstructionCode = $htmlInstructionCode ."<tr><th>" . $category->getTitle() . "</th></tr>";
			$items = $category->getItems();
			foreach($items as $item){
				$htmlInstructionCode = $htmlInstructionCode ."<tr><td>" . $item->getItem() . "</td></tr>";
				
			}
			
			$htmlInstructionCode = $htmlInstructionCode ."</table>";
		}
		
		$htmlInstructionCode = $htmlInstructionCode ."</div>";
		$htmlInstructionCode = $htmlInstructionCode ."</td><td class='categories'>";
		$htmlInstructionCode = $htmlInstructionCode ."<div id='categories'>";
		$categories = $dataVO->getCategories();
		$htmlInstructionCode = $htmlInstructionCode ."<table>";
		foreach($categories as $category){
			$htmlInstructionCode = $htmlInstructionCode ."<tr><td><input type=\"button\" class=\"categoryButton\" name=\"" . $category->getTitle() . "\" value=\"" . $category->getTitle() . "\"/></td></tr>";
		}
		$htmlInstructionCode = $htmlInstructionCode ."</table>";
		$htmlInstructionCode = $htmlInstructionCode ."</div>";
		$htmlInstructionCode = $htmlInstructionCode ."</td></tr></table>";
		$htmlInstructionCode = $htmlInstructionCode ."</div>";
		
		$htmlInstructionCode = $htmlInstructionCode ."<div id='controls' class='navigation'>";
		$htmlInstructionCode = $htmlInstructionCode ."<span class='controls' id='controls'>";
		$htmlInstructionCode = $htmlInstructionCode ."<input type='submit' name='instruction' class='instructionsButton' id='instruction' value='' onClick=\"changeDiv('instructions','game')\"/>";
		$htmlInstructionCode = $htmlInstructionCode ."<input name='sound' type='button' class='muteButton' id='Mute' value='' onClick=\"setAudioFlag()\"/>";
		$htmlInstructionCode = $htmlInstructionCode ."</span>";
		$htmlInstructionCode = $htmlInstructionCode ."<span class='playPause' id='playPause'>";
		$htmlInstructionCode = $htmlInstructionCode ."<input name='play' type='submit' class='playButton' id='play' value='' onClick=\"changeDiv('game','instructions')\"/>";
		$htmlInstructionCode = $htmlInstructionCode ."<input name='pause' type='button' class='pauseButton' id='pauseButton' value='' onClick=\"pauseResume()\" />";
		$htmlInstructionCode = $htmlInstructionCode ."<input name='Shuffle' type='button' value='Shuffle Items' id='shuffle' value='' onClick=\"shuffle()\" />";
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
		$htmlInstructionCode = $htmlInstructionCode ."</div>";
		return $htmlInstructionCode;
	}
}