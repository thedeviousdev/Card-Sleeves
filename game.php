<?php
include_once('card.php');

class game {
	var $id = NULL;
	var $name = NULL;
	var $language = 'English';
	var $year = NULL;
	var $edition = NULL;
	var $image = 'placeholder.png';
	var $URL = 'https://boardgamegeek.com/';
	var $cards = array();

	function __construct($id, $name, $lang, $year, $ed, $img, $URL, $card_arr) {
		$this->id = $id;
		$this->name = $name;
		$this->language = $lang;
		$this->year = $year;
		$this->edition = $ed;
		$this->image = $img;
		$this->URL = $URL;
		$this->cards = $card_arr;
	}

	// Setters
	function set_id($id){
		$this->id = $id;
	}
	function set_name($name){
		$this->name = $name;
	}
	function set_lang($lang){
		$this->language = $lang;
	}
	function set_year($year){
		$this->year = $year;
	}
	function set_edition($ed){
		$this->edition = $ed;
	}
	function set_image($img){
		$this->image = $img;
	}
	function set_URL($URL){
		$this->URL = $URL;
	}
	function add_card($card){
		$this->$cards[] = $card;
	}

	// Getters
	function get_id(){
		 	 return $this->id;
	}
	function get_name(){
		 	 return $this->name;
	}
	function get_lang(){
		 	 return $this->language;
	}
	function get_year(){
		 	 return $this->year;
	}
	function get_edition(){
		 	 return $this->edition;
	}
	function get_image(){
		 	 return $this->image;
	}
	function get_URL(){
		 	 return $this->URL;
	}
	function get_cards(){
		return $this->cards;
	}

}

?>