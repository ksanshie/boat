<?php
class Boater extends Man {
	
	public function __construct($logger) {
		parent::__construct($logger, 'Boater');
		
	}
	
	protected $PLACESOCCUPIED = 2;
}