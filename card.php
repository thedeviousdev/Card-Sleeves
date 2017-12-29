<?php
class card {
	var $nb_of_cards = 0;
	var $height = 0;
	var $width = 0;

	function __construct($cards, $width, $height) {
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
	function get_nb_cards() {
		return $this->nb_of_cards;
	}
	function get_height() {
		return $this->height;	
	}
	function get_width() {
		return $this->width;
	}


}

?>