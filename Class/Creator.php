<?php
class Creator {
	
	public $world;
	
	public function __construct($logger, $init) {
		// Rules:
		// Adult Maria left;
		// Adult Patric left
		// Child Jeronimo left
		foreach ($init as $rule) {
			$pars = explode(' ', $rule);
			$class = $pars[0];
			$name = $pars[1];
			$side = $pars[2];
			
			if (!class_exists($class)) {
				throw new Error('Cannot create object with class ' . $class);
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
 	
	public function solve($director) {
		
	}
	
}