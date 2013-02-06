<?php

/**
 * This class holds the data extracted from the Style File.
 * For every Style File , an instance of this VO is created.
 * 
 * @author Mani
 * @version 0.0
 */

class StyleVO {

	private $SoundDisplay;
	private $TitleColor;
	private $ColorScheme;
	private $Logo;
	private $InitialInstructions;

	function getSoundDisplay() {
		return $this->SoundDisplay;
	}
	function setSoundDisplay($soundDisplay) {
		$this->SoundDisplay = $soundDisplay;
	}
	function getTitleColor() {
		return $this->TitleColor;
	}
	function setTitleColor($titleColor) {
		$this->TitleColor = $titleColor;
	}
	function getColorScheme() {
		return $this->ColorScheme;
	}
	function setColorScheme($colorScheme) {
		$this->ColorScheme = $colorScheme;
	}
	function getLogo() {
		return $this->Logo;
	}
	function setLogo($logo) {
		$this->Logo = $logo;
	}
	function getInitialInstructions() {
		return $this->InitialInstructions;
	}
	function setInitialInstructions($initialInstructions) {
		$this->InitialInstructions = $initialInstructions;
	}
}
?>