<?php
class Creator {
	
	public $world;
	
	private $logger;
	
	public function __construct($logger, $init) {
		// Rules:
		// Adult Maria left;
		// Adult Patric left
		// Child Jeronimo left
		$this->logger = $logger;
		
		foreach ($init as $rule) {
			$pars = explode(' ', $rule);
			$class = $pars[0];
			$name = $pars[1];
			$side = $pars[2];
			
			if (!class_exists($class)) {
				throw new Exception('Cannot create object with class ' . $class);
			}
			$nextone = new $class($logger, $name);
			$nextone->toCoast($side);
			$this->world[] = $nextone;
		}
		
		
	}
	
	public function addToWorld(MatObject $what) {
		$this->world[] = $what;
		
	}
	
	public function world() {
		return $this->world;
	}
 	
	public function logWorld() {
		// 1. get boat index
		$totalCount = count($this->world);
		
		$onLeft = array();
		$onRight = array();
		
		
		// Get boat item
		
		for ($i=0; $i< $totalCount; $i++) {
			$item = $this->world[$i];
			if (get_class($item) == 'Boat') {
				$boat = $item;
				break;
			}
		}
		
		$onBoat = $boat->whosIn();

		// Iterate over all and place it into things
		for ($i=0; $i< $totalCount; $i++) {
			$item = $this->world[$i];
			if (in_array(get_class($item), array('Adult', 'Child', 'Boater')) && !$boat->isInBoat($item)) {
				if ($item->onCoast() == 'left') {
					$onLeft[] = $item;
				}
				if ($item->onCoast() == 'right') {
					$onRight[] = $item;
				}
				
			}
		}
		
		$out = '';
		// Now - format outer
		for ($i = 0; $i < 16; $i++) {
			if (isset($onLeft[$i])) {
				$who = $onLeft[$i]->getName();
				if (get_class( $onLeft[$i]) == 'Child') {
					$who = strtolower($who);
				}
				$who = $who[0];
				$out .= $who;
			} else {
				$out .= '.';
			}
		}
		
		$out = strrev($out);
		// Coast
		$out .= "/\\";
		
		// Where's boat?
		if ($boat->onCoast() == 'left') {
			$out .= '|_';
			for ($i = 0; $i < 2; $i++) {
				if (isset($onBoat[$i])) {
					$who = $onBoat[$i]->getName();
					if (get_class( $onBoat[$i]) == 'Child') {
						$who = strtolower($who);
					}
					$who = $who[0];
					$out .= $who;
				} else {
					$out .= '.';
				}
			}
			$out .= "_|~~~~~~~~~";
		} else {
			$out .= '~~~~~~~~~|_';
			for ($i = 0; $i < 2; $i++) {
				if (isset($onBoat[$i])) {
					$who = $onBoat[$i]->getName();
					if (get_class( $onBoat[$i]) == 'Child') {
						$who = strtolower($who);
					}
					$who = $who[0];
					$out .= $who;
				} else {
					$out .= '.';
				}
			}
			$out .= "_|";
		}
		$out .= "/\\";
		
		for ($i = 0; $i < 16; $i++) {
			if (isset($onRight[$i])) {
				$who = $onRight[$i]->getName();
				if (get_class( $onRight[$i]) == 'Child') {
					$who = strtolower($who);
				}
				$who = $who[0];
				$out .= $who;
			} else {
				$out .= '.';
			}
		}
				
		$this->logger->log($out);
	}
	
	
	
	
}