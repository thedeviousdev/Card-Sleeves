<?php
// Card object

include_once('sleeve.php');

class card {
	var $id = NULL;
	var $nb_of_cards = 0;
	var $height = 0;
	var $width = 0;
	var $sleeves = array();
	var $card_nb = NULL;

	function __construct($nb_of_cards, $sleeve_arr = NULL, $id = NULL, $card_nb = NULL, $width = NULL, $height = NULL) {
		$this->id = $id;
		$this->nb_of_cards = $nb_of_cards;
		$this->sleeves = $sleeve_arr;
		$this->height = $height;
		$this->width = $width;
		$this->card_nb = $card_nb;
	}

	// Setters
	function set_id($id) {
		$this->id = $id;
	}
	function set_nb_cards($nb_of_cards) {
		$this->nb_of_cards = $nb_of_cards;
	}
	function set_height($height) {
		$this->height = $height;		
	}
	function set_width($width) {
		$this->width = $width;		
	}
	function add_sleeve($sleeve){
		$this->$sleeves[] = $sleeve;
	}
	function add_card_nb($card_nb){
		$this->card_nb = $card_nb;
	}

	// Getters
	function get_id() {
		return $this->id;
	}
	function get_nb_cards() {
		return $this->nb_of_cards;
	}
	function get_height() {
		return $this->height;	
	}
	function get_width() {
		return $this->width;
	}
	function get_sleeves(){
		return $this->sleeves;
	}
	function get_card_nb(){
		return $this->card_nb;
	}


}

?>