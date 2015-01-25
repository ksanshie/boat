<?php
// Includes of classes
include_once('autoload.php');

$logger = new CliLogger();

$init = array(
	'Adult Jeronimo left',
	'Adult Maria left',
	'Child Barbra left',
	'Child John left'	
);

$worldmap = new Creator($logger, $init);

$boat = new Boat($logger, $worldmap);

foreach($worldmap->world() as $item) {
	echo $item->getName(); echo "\n";
	
}