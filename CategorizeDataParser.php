<?php
require_once('iDataXMLParser.php');
require_once('CategorizeVO.php');
require_once('CategoryVO.php');
require_once('CategoryItemVO.php');

/**
 * This class parses the data file for Sequence game and creates a SequenceVO object.
 *
*/

class CategorizeDataParser implements iDataXMLParser{


	public function parseDataXML($dataFileContent){

		$xmlObject = simplexml_load_string($dataFileContent);

		$categorizeObject = new CategorizeVO();

		if(!($xmlObject) || (is_null($xmlObject))){
			throw new Exception("Data File Empty / Parse Error");
		}

		$categorizeObject->setGameType($xmlObject->getName());
		$categorizeObject->setId($xmlObject['ID']);
		$categorizeObject->setFileVersion($xmlObject['FileVersion']);
		$categorizeObject->setFinalTime($xmlObject['FinalTime']);
		$categorizeObject->setInfoPath($xmlObject['Info_Path']);
		$categorizeObject->setIsFinal($xmlObject['IsFinal']);
		$categorizeObject->setSampleOrder($xmlObject['Sample_Order']);
		$categorizeObject->setSampleSize($xmlObject['Sample_Size']);
		$categorizeObject->setShowFeedbackLights($xmlObject['ShowFeedbackLights']);
		$categorizeObject->setShowScore($xmlObject['ShowScore']);
		$categorizeObject->setStyleFile($xmlObject['StyleFile']);
		$categorizeObject->setTimer1($xmlObject['Timer1']);
		$categorizeObject->setTimer2($xmlObject['Timer2']);
		$categorizeObject->setTimer3($xmlObject['Timer3']);
		$categorizeObject->setTitleFontSize($xmlObject['TitleFontSize']);
		$categorizeObject->setUseHallOfFame($xmlObject['UseHallOfFame']);
		$categorizeObject->setUse1($xmlObject['Use1']);
		$categorizeObject->setUse2($xmlObject['Use2']);
		$categorizeObject->setUse3($xmlObject['Use3']);

		$categories = array();

		foreach ($xmlObject->children() as $child) {

			if($child->getName() == 'CATEGORY'){
				$categoryVO = new CategoryVO();
				$items = array();
				
				foreach($child->children() as $descendant){
					if($descendant->getName() == 'TITLE'){
						$categoryVO->setTitle($descendant);
					}else if($descendant->getName() == 'ITEM'){
						$categoryItemVO = new CategoryItemVO();
						$categoryItemVO->setItems($descendant);
						$items[] = $categoryItemVO;						
					}
				}	
				
				$categoryVO->setItems($items);
				$categories[] = $categoryVO;
				
			}else if($child->getName() == 'DISPLAY_TITLE'){
				$categorizeObject->setDisplayTitle($child);
			}else{
				throw new Exception("Data File Format Not Supported");
			}
		}
		
		if(is_null($categories) || count($categories) == 0){
			throw new Exception("Categories Empty in XML");
		}

		$categorizeObject->setCategories($categories);

		return $categorizeObject;

	}

}
?>