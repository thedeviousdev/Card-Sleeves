<?php
class game {
	$name = NULL;
	$language = 'English';
	$year = NULL;
	$edition = NULL;
	$image = 'placeholder.png';
	$URL = 'https://boardgamegeek.com/';
	$cards = array();

	function __construct($name, $lang, $year, $ed, $img, $URL) {
		$this->name = $name;
		$this->language = $lang;
		$this->year = $year;
		$this->edition = $ed;
		$this->image = $img;
		$this->URL = $URL;
	}

	// Setters
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
	function add_card($URL){
		$cards[] = new card($cards, $height, $width);
	}

	// Getters
	function get_name(){
		 	 return $this->$name;
	}
	function get_lang(){
		 	 return $this->$language;
	}
	function get_year(){
		 	 return $this->$year;
	}
	function get_edition(){
		 	 return $this->$edition;
	}
	function get_image(){
		 	 return $this->$image;
	}
	function get_URL(){
		 	 return $this->$URL;
	}
	function get_cards($URL){
		return $this->$cards;
	}
	
}

?>