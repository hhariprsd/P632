<?php

require_once("iHtmlContentFormatter.php");

class SequenceHTMLFormatter implements iHTMLContentFormatter{
	
	public function formHeaderContentHTML($dataVO,$styleVO){

		$htmlInstructionCode = $htmlInstructionCode . "<link href=\"http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css\" rel=\"stylesheet\">";
 		$htmlInstructionCode = $htmlInstructionCode . "<link href=\"http://code.jquery.com/ui/1.10.0/themes/ui-lightness/jquery-ui.css\" rel=\"stylesheet\">";
		$htmlInstructionCode = $htmlInstructionCode . "<script type=\"text/javascript\" async src=\"http://www.google-analytics.com/ga.js\"></script>";
		$htmlInstructionCode = $htmlInstructionCode . "<script src=\"http://code.jquery.com/jquery-1.9.0.js\"></script>";
		$htmlInstructionCode = $htmlInstructionCode . "<script src=\"http://code.jquery.com/ui/1.10.0/jquery-ui.js\"></script>";
		$htmlInstructionCode = $htmlInstructionCode . "<script src=\"https://raw.github.com/furf/jquery-ui-touch-punch/master/jquery.ui.touch-punch.min.js\"></script>";
		
		$htmlInstructionCode = $htmlInstructionCode . "<style>";
		$htmlInstructionCode = $htmlInstructionCode . "#sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }";
		$htmlInstructionCode = $htmlInstructionCode . "#sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }";
		$htmlInstructionCode = $htmlInstructionCode . "#sortable li span { position: absolute; margin-left: -1.3em; }";
		$htmlInstructionCode = $htmlInstructionCode . "</style>";
		
		$htmlInstructionCode = $htmlInstructionCode. "<script type='text/javascript'>";

		$htmlInstructionCode = $htmlInstructionCode . "function changeDiv(id1,id2){";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(id1).style.display='none';";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(id2).style.display='';";
		$htmlInstructionCode = $htmlInstructionCode . "setaudio();";
		$htmlInstructionCode = $htmlInstructionCode . "document.getElementById('counter').innerHTML=".$dataVO->getTimer1().";";
		$htmlInstructionCode = $htmlInstructionCode . "}";
		
		$htmlInstructionCode = $htmlInstructionCode . "function setaudio(){";
		$htmlInstructionCode = $htmlInstructionCode . "var myAudio = document.createElement('audio');";
		$htmlInstructionCode = $htmlInstructionCode . "myAudio.controls = true;";
		$htmlInstructionCode = $htmlInstructionCode . "myAudio.src = 'beep.mp3';";
		$htmlInstructionCode = $htmlInstructionCode . "}";
 		$htmlInstructionCode = $htmlInstructionCode . "$(function() {";
 		$htmlInstructionCode = $htmlInstructionCode . "$( \"#sortable\" ).sortable({";
 		$htmlInstructionCode = $htmlInstructionCode . "	beforeStop: function(play, ui) {";
 		$htmlInstructionCode = $htmlInstructionCode . " document.getElementById('sound').play();";
		$htmlInstructionCode = $htmlInstructionCode . " }});";
 		$htmlInstructionCode = $htmlInstructionCode . " });";
 		 		
 		$htmlInstructionCode = $htmlInstructionCode . "function countdown() {";
 		$htmlInstructionCode = $htmlInstructionCode . "var i = document.getElementById('counter');";
 		$htmlInstructionCode = $htmlInstructionCode . "if (parseInt(i.innerHTML)<=0) {";
 		$htmlInstructionCode = $htmlInstructionCode . "exit();";
 		$htmlInstructionCode = $htmlInstructionCode . "}";
 		$htmlInstructionCode = $htmlInstructionCode . "i.innerHTML = parseInt(i.innerHTML)-1;";
 		$htmlInstructionCode = $htmlInstructionCode . "}";
 		$htmlInstructionCode = $htmlInstructionCode . "setInterval(function(){ countdown(); },1000);";
 		
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
		$htmlInstructionCode = "<div id='instructions' style=\" width:600px; background-image:url(http://www.cs.indiana.edu/cgi-pub/harihanu/Resources/images/covered.png)\" >";
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
		
		$htmlInstructionCode = $htmlInstructionCode . "<input type='submit' name='Play' value='PLAY' style='width:80px; background-color: ORANGE;' onClick=\"changeDiv('instructions','items')\" />";
		
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
		
		return $htmlInstructionCode;
		
	}
	public function formGameContentHTML($dataVO,$styleVO){
		
		$htmlInstructionCode = "<div id='items' style='display:none'>";
		$htmlInstructionCode = $htmlInstructionCode . "<h2>Sequence:</h2><br/>";
			
		$itemList = $dataVO->getChildInfo();
		$itemPrefix = "ITEM";
		$itemCount = 1;
		
		$htmlInstructionCode = $htmlInstructionCode . "<ul id=\"sortable\" class=\"ui-sortable\">";
		foreach($itemList as $item){
			if((strlen(trim($item->getItem())))>0){
					$htmlInstructionCode = $htmlInstructionCode . "<li id='" . $itemPrefix . $itemCount ."' class=\"ui-state-default\" >". $item->getItem() ."</li>";
				$itemCount++;
			}
		
		}
		$htmlInstructionCode = $htmlInstructionCode . "</ul>";
		$htmlInstructionCode = $htmlInstructionCode . "<span id=\"counter\">". $dataVO->getTimer1() ."</span> second(s).";
//		$htmlInstructionCode = $htmlInstructionCode . "<br/><br/><input type=\"button\" value=\"Shuffle\" onclick = \"shuffle()\" style=\"position: absolute;top: 500px;\" />";
		$htmlInstructionCode = $htmlInstructionCode . "<br/><br/><input type='submit' name='Back' value='BACK' style='width:80px; background-color: ORANGE;' onClick=\"changeDiv('items','instructions')\" />";
 		$htmlInstructionCode = $htmlInstructionCode . "<audio id='sound' type='audio/mpeg' src='http://www.cs.indiana.edu/cgi-pub/harihanu/Resources/sounds/beep.mp3' preload/>";
 		
		$htmlInstructionCode = $htmlInstructionCode . "</div>";
		
		return $htmlInstructionCode;
	}
	
	
}

?>