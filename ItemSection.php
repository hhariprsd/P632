<?php

function formSequenceHTML($dataXMLObject){

	$htmlInstructionCode = "<div id='items' style='display:none'>";
	$htmlInstructionCode = $htmlInstructionCode . "<h2>Sequence:</h2><br/>";

	$itemList = $dataXMLObject->getChildInfo();
	$itemPrefix = "ITEM";
	$itemCount = 1;
	foreach($itemList as $item){
		if((strlen(trim($item->getItem())))>0){
			$htmlInstructionCode = $htmlInstructionCode . "<div id='" . $itemPrefix . $itemCount."' style=\"position: absolute; top: ". $itemCount*50 ."px\">" . $item->getItem() .  "</div><br/><br/>";
			$itemCount++;
		}

	}
	$htmlInstructionCode = $htmlInstructionCode . "<br/><br/><input type='submit' name='Back' value='Back' onClick=\"changeDiv('items','instructions')\" />";
	$htmlInstructionCode = $htmlInstructionCode . "<input type='submit' name='Scramble' value='Shuffle' onClick=\"shuffle()\" />";
	$htmlInstructionCode = $htmlInstructionCode . "</div>";

	return $htmlInstructionCode;

}
?>