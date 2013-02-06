<?php

function formInstructionsHTML($styleXMLObject,$sequenceObject){

	$htmlInstructionCode = "<div id='instructions' style=\" width:600px; background-image:url(http://www.cs.indiana.edu/cgi-pub/harihanu/covered.png)\" >";
	$titlecolor = $styleXMLObject->getTitleColor();
	$title = $sequenceObject->getDisplayTitle();
	$htmlInstructionCode = $htmlInstructionCode . "<h1 style= \" color: #$titlecolor; \">$title</h1>";
	$htmlInstructionCode = $htmlInstructionCode . "<h2>Instructions:</h2>";

	$instructions = $styleXMLObject->getInitialInstructions();
	$instructionList	 = explode("WHAT", $instructions);

	foreach($instructionList as $instruction){
		if((strlen(trim($instruction)))>0){
			$htmlInstructionCode = $htmlInstructionCode . "WHAT". $instruction .  "<br/><br/>";
		}

	}
	
	$htmlInstructionCode = $htmlInstructionCode . "<input type='submit' name='Play' value='Play' onClick=\"changeDiv('instructions','items')\" />";

	$htmlInstructionCode = $htmlInstructionCode . "</div>";

	return $htmlInstructionCode;

}
?>