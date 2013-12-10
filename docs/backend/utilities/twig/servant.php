<?php

// We'll use Twig's autoloader here before Servant loads anything

// Included autoloader before Servant's loader includes anything
include_once 'Twig-1.14.2/lib/Twig/Autoloader.php';

// Load classes
Twig_Autoloader::register();

?>