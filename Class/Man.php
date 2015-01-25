<?php
class Man extends MatObject {

	private $onCoast = '';
	
	private $name;
	
	public function __construct($logger, $name) {
		parent::__construct($logger);
		$this->log('It is ' . $name);
		$this->name = $name;
	}
	
	public function getName() {
		return $this->name;
	}


	

	
}