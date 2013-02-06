<?php

/**
 * This class holds the child info of the sequence tag in Sequence data File.
 * For every child ITEM tag, a VO of this type is created.
 * 
 * @author Mani
 * @version 0.0
 */


class SequenceChildVO {

	private $Item;

	function getItem(){
		return $this->Item;
	}
	function setItem($item){
		$this->Item = $item;
	}

}


?>