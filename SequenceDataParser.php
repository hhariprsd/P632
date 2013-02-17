<?php
require_once('iDataXMLParser.php');

/**
 * This class parses the data file for Sequence game and creates a SequenceVO object.
 *
*/

class SequenceDataParser implements iDataXMLParser{


	public function parseDataXML($dataFileContent){

		$xmlObject = simplexml_load_string($dataFileContent);

		$sequenceObject = new SequenceVO();

		if(!($xmlObject) || (is_null($xmlObject))){
			throw new Exception("Data File Empty / Parse Error");
		}

		$sequenceObject->setGameType($xmlObject->getName());
		$sequenceObject->setId($xmlObject['ID']);
		$sequenceObject->setFileVersion($xmlObject['FileVersion']);
		$sequenceObject->setFinalTime($xmlObject['FinalTime']);
		$sequenceObject->setInfoPath($xmlObject['Info_Path']);
		$sequenceObject->setIsFinal($xmlObject['IsFinal']);
		$sequenceObject->setSampleOrder($xmlObject['Sample_Order']);
		$sequenceObject->setSampleSize($xmlObject['Sample_Size']);
		$sequenceObject->setShowFeedbackLights($xmlObject['ShowFeedbackLights']);
		$sequenceObject->setShowScore($xmlObject['ShowScore']);
		$sequenceObject->setStyleFile($xmlObject['StyleFile']);
		$sequenceObject->setTimer1($xmlObject['Timer1']);
		$sequenceObject->setTimer2($xmlObject['Timer2']);
		$sequenceObject->setTimer3($xmlObject['Timer3']);
		$sequenceObject->setTitleFontSize($xmlObject['TitleFontSize']);
		$sequenceObject->setUseHallOfFame($xmlObject['UseHallOfFame']);
		$sequenceObject->setUse1($xmlObject['Use1']);
		$sequenceObject->setUse2($xmlObject['Use2']);
		$sequenceObject->setUse3($xmlObject['Use3']);

		$sequenceItemList = array();

		foreach ($xmlObject->children() as $child) {

			if($child->getName() == 'ITEM'){
				$sequenceChildVO = new SequenceChildVO();
				$sequenceChildVO->setItem($child);
				$sequenceItemList[] = $sequenceChildVO;
			}else if($child->getName() == 'DISPLAY_TITLE'){
				$sequenceObject->setDisplayTitle($child);
			}else{
				throw new Exception("Data File Format Not Supported");
			}
		}
		
		if(is_null($sequenceItemList) || count($sequenceItemList) == 0){
			throw new Exception("Data Items Empty in XML");
		}

		$sequenceObject->setChildInfo($sequenceItemList);

		return $sequenceObject;

	}

}
?>