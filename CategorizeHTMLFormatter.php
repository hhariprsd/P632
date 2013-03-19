<?php
require_once("iHTMLContentFormatter.php");

class CategorizeHTMLFormatter implements iHTMLContentFormatter{
	
	public function formHeaderContentHTML($dataVO,$styleVO){
		
		$htmlInstructionCode = "";
		$htmlInstructionCode = $htmlInstructionCode . "<link href=\"". $styleVO->getResourcePath()  ."css/Categorize.css\" rel=\"stylesheet\">";
		$htmlInstructionCode = $htmlInstructionCode . "<title>" . $dataVO->getDisplayTitle() . "</title>";
		
		$htmlInstructionCode = $htmlInstructionCode. "<script type='text/javascript'>";
		$htmlInstructionCode = $htmlInstructionCode . "function changeDiv(id1,id2){";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(id1).style.display='block';";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(id2).style.display='none';";
		$htmlInstructionCode = $htmlInstructionCode . "}";
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
		
		$htmlInstructionCode = $htmlInstructionCode ."<div id='controls' class='navigation'>";
		$htmlInstructionCode = $htmlInstructionCode ."<span class='controls' id='controls'>";
		$htmlInstructionCode = $htmlInstructionCode ."<input type='submit' name='instruction' class='instructionsButton' id='instruction' value='' onClick=\"onclickBack()\"/>";
		$htmlInstructionCode = $htmlInstructionCode ."<input name='sound' type='button' class='muteButton' id='Mute' value='' onClick=\"setAudioFlag()\"/>";
		$htmlInstructionCode = $htmlInstructionCode ."</span>";
		$htmlInstructionCode = $htmlInstructionCode ."<span class='playPause' id='playPause'>";
		$htmlInstructionCode = $htmlInstructionCode ."<input name='play' type='submit' class='playButton' id='play' value='' onClick=\"changeDiv('game','instructions')\"/>";
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
		$htmlInstructionCode = $htmlInstructionCode ."</div>";
		return $htmlInstructionCode;
	}
}