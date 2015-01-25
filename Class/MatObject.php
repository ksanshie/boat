<?php
class MatObject {
	
	private $logger;
	
	public function __construct (Logger $logger) {
		$this->logger = $logger;

		$this->log('Init!', array());
	}
	
	
	function log($text, $additional_params) {
		$this->logger->log($text, $additional_params);
	}

	
	
}