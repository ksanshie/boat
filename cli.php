<?php
// Includes of classes
include_once('autoload.php');

$logger = new CliLogger();

$boat = new Boat($logger);

$boat->status();