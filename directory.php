<?php 

function dir_path() {
	$filePath = realpath(dirname(__FILE__));
	$rootPath = realpath($_SERVER['DOCUMENT_ROOT']);
	$htmlPath = str_replace($rootPath, '', $filePath);

	if(!$htmlPath)
		return '.';

	return $htmlPath;
}