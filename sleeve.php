<?php
// Sleeve object

class sleeve {
	var $id = NULL;
	var $sleeve_name = NULL;
	var $brand = NULL;

	function __construct($sleeve_name, $brand, $id = NULL) {
		$this->sleeve_name = $sleeve_name;
		$this->brand = $brand;
		$this->id = $id;
	}

	// Setters
	function set_id($id) {
		$this->id = $id;
	}
	function set_name($name) {
		$this->sleeve_name = $name;
	}
	function set_brand($brand) {
		$this->brand = $brand;
	}

	// Getters
	function get_id() {
		return $this->id;
	}
	function get_name() {
		return $this->sleeve_name;
	}
	function get_brand() {
		return $this->brand;
	}
}