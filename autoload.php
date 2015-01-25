<?php
function __autoload($class_name) {
	
	include_once "Class/" . $class_name . '.php';
}

