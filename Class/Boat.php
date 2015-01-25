<?php
class Boat extends MatObject {
	
	private $inBoat = array();
	
	const CAPABILITY = 2; // One child have size 1; Man is 2
	

	
	public function __construct($logger, Creator $creator) {
		parent::__construct($logger);
		
		// Here's boat individual state'
		$boater = new Boater($logger);
		$creator->addToWorld($boater);
		
		$this->addInBoat($boater);
		$this->toCoast('left');
		$creator->addToWorld($this);
	}
	
	public function addInBoat(MatObject $what) {
		$alreadyIn = 0;
		$inBCount = count($this->inBoat);
		if ($inBCount) {
			for ($i = 0; $i < $inBCount; $i++) {
				$alreadyIn += $this->inBoat[$i]->placesOccupied();
				
			}
		}
		if ($alreadyIn >= self::CAPABILITY) {
			throw new Exception('Cannot place anyone in boat. Boat is full');
		}
		if ($alreadyIn + $what->placesOccupied() > self::CAPABILITY) {
			throw new Exception('Cannot place ' . $what->getName() . ' into boat. Didn\'t fit.');
		}
		$this->log( $what->getName() . " gets into boat.");
		$this->inBoat[] = $what;
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
	
	public function getFromBoat(MatObject $what) {
		$inBCount = count($this->inBoat);
		for ($i = $inBCount - 1; $i >= 0; $i--) {
			if ($this->inBoat[$i] == $what) {
				$this->log( $what->getName() . " gets out of boat.");
				unset($this->inBoat[$i]);
			}
		}
		$this->inBoat = array_values($this->inBoat);	
	}
	
	public function toCoast($what) {
		parent::toCoast($what);
		$inBCount = count($this->inBoat);
		for ($i = 0; $i < $inBCount; $i++) {
			$this->inBoat[$i]->toCoast($what);
			
		}
		
	}

	public function whosIn() {
		return $this->inBoat;
	}
	
	public function getName() {
		return 'Boat';
	}
	
	public function isInBoat(MatObject $what) {
		$inBCount = count($this->inBoat);
		for ($i = $inBCount - 1; $i >= 0; $i--) {
			if ($this->inBoat[$i] == $what) {
				return true;
			}
		}
		return false;
	} 
}	