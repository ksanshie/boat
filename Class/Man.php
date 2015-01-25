<?php
class Man extends MatObject {

	private $onCoast = '';
	
	private $name;
	
	public function __construct($name, $logger) {
		parent::__construct($logger);
		$this->name = $name;
	}
	
	public function getName() {
		return $this->name;
	}


	

	
}