<?php

function formHeaderSection($dataObject,$styleObject){

	$htmlInstructionCode = "<script src=\"http://code.jquery.com/jquery-1.9.0.min.js\"></script>";
	$htmlInstructionCode = $htmlInstructionCode . "<script src=\"http://code.jquery.com/jquery-latest.js\"></script>";
	$htmlInstructionCode = $htmlInstructionCode. "<script type='text/javascript'>";

	$htmlInstructionCode = $htmlInstructionCode . "function changeDiv(id1,id2){";

	$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(id1).style.display='none';";

	$htmlInstructionCode = $htmlInstructionCode . "document.getElementById(id2).style.display='';";

	$htmlInstructionCode = $htmlInstructionCode . "}";



	$htmlInstructionCode = $htmlInstructionCode . "function shuffle() {";
	
	$htmlInstructionCode = $htmlInstructionCode . "var divids = [];";
	$htmlInstructionCode = $htmlInstructionCode . "var posarr = [];";

	$htmlInstructionCode = $htmlInstructionCode . "$(\"#items\").children().each(function () {";
	$htmlInstructionCode = $htmlInstructionCode . "if (this.id != '') {";
	$htmlInstructionCode = $htmlInstructionCode . "divids.push(this.id);";
	$htmlInstructionCode = $htmlInstructionCode . "posarr.push(this.style.top);";
	$htmlInstructionCode = $htmlInstructionCode . "}});";
	$htmlInstructionCode = $htmlInstructionCode . "";
	$htmlInstructionCode = $htmlInstructionCode . "for (var i = divids.length - 1; i >= 0; i--) {";
	$htmlInstructionCode = $htmlInstructionCode . "var randomIndex = Math.floor(Math.random() * (i + 1));";
	$htmlInstructionCode = $htmlInstructionCode . "var itemAtIndex = divids[randomIndex];";
	$htmlInstructionCode = $htmlInstructionCode . "divids[randomIndex] = divids[i];";
	$htmlInstructionCode = $htmlInstructionCode . "divids[i] = itemAtIndex;";
	$htmlInstructionCode = $htmlInstructionCode . "$('#'+divids[i]).animate({ top: posarr[i] }, 'slow');";
	$htmlInstructionCode = $htmlInstructionCode . "	}}";

	$htmlInstructionCode = $htmlInstructionCode . "</script>";

	return $htmlInstructionCode;
}

?>