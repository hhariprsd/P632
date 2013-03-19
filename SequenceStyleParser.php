<?php

require_once('iStyleXMLParser.php');

class SequenceStyleParser implements iStyleXMLParser{

	public function parseStyleXML($styleFileContent){
		$xmlObject = simplexml_load_string($styleFileContent);
		$styleObject = new StyleVO();
		
		if(!($xmlObject) || (is_null($xmlObject))){
			throw new Exception("Data File Empty / Parse Error");
		}
		
		if(!(is_null($xmlObject['resource_path']))){
			$styleObject->setResourcePath($xmlObject['resource_path']);
		}else{
			$styleObject->setResourcePath("./");
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
	
}

?>