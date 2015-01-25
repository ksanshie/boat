<?php
class Boat extends MatObject {
	
	private $inBoat = array();
	
	const CAPABILITY = 2; // One child have size 1; Man is 2
	
	private $coast;
	
	public function __construct($logger) {
		parent::__construct($logger);
		
		// Here's boat individual state
		$this->addInBoat(new Boater($logger));
		$this->toCoast('left');
	}
	
	public function addInBoat(MatObject $what) {
		$alreadyIn = 0;
		$inBCount = count($this->inBoat);
		for ($i = 0; $i < $inBCount; $i++) {
			$alreadyIn += $this->inBoat[$i]->placesOccupied();
		}
		if ($alreadyIn >= self::CAPABILITY) {
			throw new Error('Cannot place anyone in boat. Boat is full');
		}
		if ($alreadyIn + $what->placesOccupied() > self::CAPABILITY) {
			throw new Error('Cannot place ' . $what->getName() . ' into boat. Didn\'t fit.');
		}
		$this->log( $what->getName() . " gets into boat.");
		$this->inBoat[] = $what;
	}

	public function toCoast($what) {
		$this->onCoast = $what;
		$this->log('Boat set onto '. $what . ' coast.');
	}

	public function status() {
		$this->log('Boat is on ' . $this->onCoast . " coast.");
		if (count($this->inBoat) == 0) {
			$this->log('Boat is empty');
		} else {
			$whoisin = array();
			$inBCount = count($this->inBoat);
			for ($i = 0; $i < $inBCount; $i++) {
				$whoisin[] =  $this->inBoat[$i]->getName();
			}
			$this->log('There are ' . implode(',', $whoisin) . " in boat.");
		}
	}
	
	
}	