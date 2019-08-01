<?php
// Game object 

include_once('card.php');

class game {
	var $id = NULL;
	var $name = NULL;
	var $year = NULL;
	var $edition = NULL;
	var $image = 'placeholder.png';
	var $URL = 'https://boardgamegeek.com/';
	var $verified = 0;
	var $base = 0;
	var $cards = array();
	var $sleeves = array();
	var $expansions = array();

	function __construct($id, $name, $year, $img, $URL, $card_arr, $verified, $base = NULL, $edition = NULL, $expansions = NULL) {
		$this->id = $id;
		$this->name = $name;
		$this->year = $year;
		$this->edition = $edition;
		$this->image = $img;
		$this->URL = $URL;
		$this->cards = $card_arr;
		$this->verified = $verified;
		$this->base = $base;
		$this->expansions = $expansions;
	}

	// Setters
	function set_id($id){
		$this->id = $id;
	}
	function set_name($name){
		$this->name = $name;
	}
	function set_year($year){
		$this->year = $year;
	}
	function set_edition($edition){
		$this->edition = $edition;
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
	function set_verified($verified){
		$this->verified = $verified;
	}
	function set_base($base){
		$this->base = $base;
	}
	function set_cart_sleeve($sleeves){
		$this->sleeves = $sleeves;
	}
	function add_expansion($expansion){
		$this->$expansions[] = $expansion;
	}

	// Getters
	function get_id(){
		return $this->id;
	}
	function get_name(){
		return $this->name;
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
	function get_verified(){
		return $this->verified;
	}
	function get_base(){
		return $this->base;
	}
	function get_cart_sleeve(){
		return $this->sleeves;
	}
	function get_expansions(){
		return $this->expansions;
	}

	function reset_sleeves() {
		$this->$sleeves = array();
	}

}
?>