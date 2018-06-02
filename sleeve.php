<?php
// Sleeve object

class sleeve {
	var $sleeve_name = 0;
	var $height = 0;
	var $width = 0;

	function __construct($name, $width, $height) {
		$this->sleeve_name = $name;
		$this->height = $height;
		$this->width = $width;
	}

	// Setters
	function set_name($name) {
		$this->sleeve_name = $name;
	}
	function set_height($height) {
		$this->height = $height;		
	}
	function set_width($width) {
		$this->width = $width;		
	}

	// Getters
	function get_name() {
		return $this->sleeve_name;
	}
	function get_height() {
		return $this->height;	
	}
	function get_width() {
		return $this->width;
	}
}
?>