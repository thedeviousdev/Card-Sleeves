<?php
class card {
	$nb_of_cards = 0;
	$height = 0;
	$width = 0;

	function __construct($cards, $height, $width) {
		$this->nb_of_cards = $cards;
		$this->height = $height;
		$this->width = $width;
	}

	// Setters
	function set_nb_cards($cards) {
		$this->nb_of_cards = $cards;
	}
	function set_height($height) {
		$this->height = $height;		
	}
	function set_width($width) {
		$this->width = $width;		
	}

	// Getters
	function set_nb_cards() {
		return $this->$nb_of_cards;
	}
	function set_height() {
		return $this->$height;	
	}
	function set_width() {
		return $this->$width;
	}


}

?>