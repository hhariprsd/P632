<?php

class StyleParser{

	private $iStyleParserObject;

	public function setStyleParserObject($styleParserObject){
		$this->iStyleParserObject = $styleParserObject;
	}

	public function parseStyle($styleFileContent){
		try{
			return $this->iStyleParserObject->parseStyleXML($styleFileContent);
		}catch(Exception $e){
			throw $e;
		}
	}
}

?>