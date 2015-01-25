<?php
class MatObject {
	
	private $logger;
	
	private $coast;
	
	const PLACESOCCUPIED = 0;
	
	public function __construct (Logger $logger) {
		$this->logger = $logger;

		$this->log('Init ' . get_class($this), array());
	}
	
	
	function log($text, $additional_params = '') {
		$this->logger->log($text, $additional_params);
	}

	public function placesOccupied() {
		return self::PLACESOCCUPIED;
	}
	
	public function getName() {
		return 'Nothing';
	}
	
	public function toCoast($what) {
		$this->onCoast = $what;
		$this->log(get_class($this) . ' set onto '. $what . ' coast.');
	}
	
	public function onCoast() {
		return $this->onCoast;
	}
	
}