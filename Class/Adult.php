<?php
class Adult extends Man {

	private $name;
	
	public function __construct($name, $logger) {
		parent::__construct($logger);
		$this->name = $name;
	}
	

	const PLACESOCCUPIED = 2;
}