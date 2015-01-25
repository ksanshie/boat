<?php
class Man extends MatObject {

	private $onCoast = '';
	
	public function getName() {
		return 'Man';
	}

	public function getCoast() {
		return $this->onCoast;
	}
}