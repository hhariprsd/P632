<?php
require_once ('SequenceDataParser.php');
require_once ('DataParser.php');
require_once ('SequenceStyleParser.php');
require_once ('StyleParser.php');
/**
 * This functions parses the style file xml and returns a style vo object
 *
 * @param unknown $styleFileContent
 * @return StyleVO
*/

function parseStyleFile($styleFileContent){

	try{
		
		$seqStyleParser = new SequenceStyleParser();
		$styleParser = new StyleParser();
		$styleParser->setStyleParserObject($seqStyleParser);
		$styleVO = $styleParser->parseStyle($styleFileContent);
		
	}catch(Exception $e){
		throw $e;
	}

	return $styleVO;
}

/**
 * This function parses the data file xml and returns the data VO
 *
 * @param unknown $dataFileContent
 * @return SequenceVO
 */

function parseDataFile($dataFileContent){

	$xmlObject = simplexml_load_string($dataFileContent);
	$dataParser = new DataParser();


	if(!($xmlObject) || (is_null($xmlObject))){
		throw new Exception("Data File Empty / Parse Error");
	}

	try{
		if ($xmlObject->getName() == 'SEQUENCE'){

			$seqParser = new SequenceDataParser();
			$dataParser->setDataParserObject($seqParser);
			$dataVO = $dataParser->parseData($dataFileContent);
				
		}else{
			throw new Exception("Data File Format Not Supported");
		}
	}catch(Exception $e){
		throw $e;
	}
	
	return $dataVO;

}
?>