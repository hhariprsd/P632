<?php

class CategoryVO {

	private $title;
	private $Items;

	function getTitle(){
		return $this->title;
	}
	
	function setTitle($title){
		$this->title = $title;
	}
	
	function getItems(){
		return $this->Items;
	}
	
	function setItems($items){
		$this->Items = $items;
	}

}


?>