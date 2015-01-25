<?php
class Boater extends Man {
	
	public function __construct($logger) {
		parent::__construct('Boater', $logger);
		
	}
	
	const PLACESOCCUPIED = 2;
}