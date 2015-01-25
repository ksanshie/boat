<?php
class CliLogger extends Logger {
	
	public function log($text, $additional = '') {
		echo $text . "\n";
	}
}