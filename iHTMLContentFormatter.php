<?php

interface iHTMLContentFormatter{
	public function formHeaderContentHTML($dataVO,$styleVO);
	public function formInstructionContentHTML($dataVO,$styleVO);
	public function formGameContentHTML($dataVO,$styleVO);
}

?>