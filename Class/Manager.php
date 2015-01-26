<?php
class Manager {
	
	public function __construct($worldProvider) {
		$this->worldProvider = $worldProvider;
	}
	
	function solve() {
		
		// Initial - all on Left

		if (!$this->canTransferAnyOneRight()) {
			throw new Exception('Cannot transfer anyone to another side.');
		}
		
		$boat = $this->find('Boat', 1, 'left');
		if (!$boat) {
			throw new Exception('Cannot transfer anyone to another side. No boat here.');
		}
		$boat = $boat[0];
		
		if ($inBoat = $boat->whosIn()) {
			// Get anyone from boat!
			for ($i=0; $i < count($inBoat); $i++) {
				$boat->getFromBoat($inBoat[$i]);
			}
		}
		
		while ($this->canTransferAnyOneRight()) {
			
			$this->worldProvider->logWorld();
			
			if ($this->cannotSendBoatBack()) {
				
				$childs = $this->findChild(2, 'left');
				if (count($childs) < 2) {
					throw new Exception('Not enough kids to make transfer.');
				}
				$boat->addInBoat($childs[0]);
				$boat->addInBoat($childs[1]);
				$this->worldProvider->logWorld();
					
				$boat->toCoast('right');
				$this->worldProvider->logWorld();
					
				$boat->getFromBoat($childs[0]);
				$boat->getFromBoat($childs[1]);
				
				// Transfer kids
				continue;
			}

			if ($this->boatReadyToSendBack()) {
				
				$kidReturner = $this->findChild(1, 'right');
				$boat->addInBoat($kidReturner[0]);
				$this->worldProvider->logWorld();
					
				$boat->toCoast('left');
				$this->worldProvider->logWorld();
					
				$boat->getFromBoat($kidReturner[0]);
				continue;
			}
			
			$anyOne = $this->findAdult(1, 'left');
			if (!$anyOne) {
				$anyOne = $this->findChild(2, 'left');
			}

			if ($anyOne) {
				$boat->addInBoat($anyOne[0]);
				if (get_class($anyOne[0]) == 'Child' && isset($anyOne[1])) {
					$boat->addInBoat($anyOne[1]);
				}
				$this->worldProvider->logWorld();
					
				$boat->toCoast('right');
				$this->worldProvider->logWorld();

				
				$boat->getFromBoat($anyOne[0]);
				if ($boat->whosIn()) {
					$boat->getFromBoat($anyOne[1]);
				}
				
				continue;
			} else {
				break;
			}

			$this->worldProvider->logWorld();
				
			
		}


        echo ('There was a '.$boat->getIterations().' iterations');
		// Final - all on Right, except Boater and Boat
		
	}
	
	private function find($who, $count, $side) {
		$find = Array();
		$currentWorld = $this->worldProvider->world();
		$inWorld = count($currentWorld);
		for ($i = 0; $i < $inWorld; $i++ ) {
			$item = $currentWorld[$i];
			if (get_class($item) == $who && $item->onCoast() == $side) {
				$find[] = $item;
			}
		}
		shuffle($find);
		return $find;
	}
	
	// Service function - to find
	private function findChild($count, $side) {
		return $this->find('Child', $count, $side);
	}
	
	private function findAdult($count, $side) {
		$result = $this->find('Adult', $count, $side);
		// Boater fine too
		$result = array_merge($result,$this->find('Boater', 1, $side));
		return $result;
	}
	
	private function wheresBoat() {
		$boat_l = $this->find('Boat', 1, 'left');
		if ($boat_l) 
			return 'left';
		$boat_r = $this->find('Boat', 1, 'right');
		if ($boat_r) 
			return 'right';
		
	}
	// Higher level find
	private function cannotSendBoatBack() {
		// to send boat back, at least one child should be on right side
		$childsOnRight = $this->findChild(1, 'right');
		
		return (count($childsOnRight) == 0);
		
	}
	
	
	private function boatReadyToSendBack() {
		$childsOnRight = $this->findChild(1, 'right');
		$boatOnRight = $this->wheresBoat() == 'right';
		
		return (count($childsOnRight) > 0) && $boatOnRight;
	} 
	
	private function canTransferAnyOneRight() {
		$adultsOnLeft = $this->findAdult(1, 'left');
		$childsOnLeft = $this->findChild(1, 'left');
		
		
		return (count($adultsOnLeft) + count($childsOnLeft)) > 0;
		
	}	
	
	
	
	
}