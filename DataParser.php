<?php

class DataParser{

	private $iDataParserObject;

	public function setDataParserObject($dataParserObject){
		$this->iDataParserObject = $dataParserObject;
	}

	public function parseData($dataFileContent){
		try{
			return $this->iDataParserObject->parseDataXML($dataFileContent);
		}catch(Exception $e){
			throw $e;
		}		
	}
}
?>