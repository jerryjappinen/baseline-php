<?php

// We'll use MtHaml's autoloader here before Servant loads anything

// Included autoloader before Servant's loader includes anything
include_once 'MtHaml/Autoloader.php';

// Load classes
MtHaml\Autoloader::register();

?>