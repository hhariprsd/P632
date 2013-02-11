<?php

class HTMLContentFormatter{
	
	private $iHTMLContentFormatterObject;
	
	public function setHTMLFormatterObject($htmlFormatterObject){
		$this->iHTMLContentFormatterObject = $htmlFormatterObject;
	}
	
	public function formHeaderSection($dataVO,$styleVO){
		try{
			return $this->iHTMLContentFormatterObject->formHeaderContentHTML($dataVO,$styleVO);
		}catch(Exception $e){
			throw $e;
		}
	}
	
	public function formInstructionSection($dataVO,$styleVO){
		try{
			return $this->iHTMLContentFormatterObject->formInstructionContentHTML($dataVO,$styleVO);
		}catch(Exception $e){
			throw $e;
		}	
	}
	
	public function formGameSection($dataVO,$styleVO){
		try{
			return $this->iHTMLContentFormatterObject->formGameContentHTML($dataVO,$styleVO);
		}catch(Exception $e){
			throw $e;
		}
	}
	
}

?>