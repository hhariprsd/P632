<?php

/**
 * This functions parses the style file xml and returns a style vo object
 * 
 * @param unknown $styleFileContent
 * @return StyleVO
 */

function parseStyleFile($styleFileContent){

	$xmlObject = simplexml_load_string($styleFileContent);
	$styleObject = new StyleVO();

	if(!($xmlObject) || (is_null($xmlObject))){
		throw new Exception("Data File Empty / Parse Error");
	}
	
	$childTags = $xmlObject->children();
	foreach($childTags as $child){
		if($child->getName() == 'SoundDisplay'){
			$styleObject->setSoundDisplay($child);
		}else if($child->getName() == 'TitleColor'){
			$styleObject->setTitleColor($child);
		}else if($child->getName() == 'ColorScheme'){
			$styleObject->setColorScheme($child);
		}else if($child->getName() == 'logo'){
			$styleObject->setLogo($child);
		}else if($child->getName() == 'InitialInstructions'){
			$styleObject->setInitialInstructions($child);
		}else{
			throw new Exception("Style File Format Not Supported");
		}

	}

	return $styleObject;
}

/**
 * This function parses the data file xml and returns the data VO
 * 
 * @param unknown $dataFileContent
 * @return SequenceVO
 */

function parseDataFile($dataFileContent){

	$xmlObject = simplexml_load_string($dataFileContent);

	$sequenceObject = new SequenceVO();
	
	if(!($xmlObject) || (is_null($xmlObject))){
		throw new Exception("Data File Empty / Parse Error");
	}
	

	if ($xmlObject->getName() == 'SEQUENCE'){
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

		$sequenceObject->setChildInfo($sequenceItemList);

		return $sequenceObject;
	}else{
		throw new Exception("Data File Format Not Supported");		
	}
}
?>