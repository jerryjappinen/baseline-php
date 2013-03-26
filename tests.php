<?php

// Root of all problems
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', '1');
date_default_timezone_set('UTC');

// Load Baseline PHP
foreach (glob('baselinephp/*.php') as $path) {
	require_once $path;
}
unset($path);

// Load tests
$suite = array();



// Allow selecting a selection of tests
if (isset($_GET['suite']) and is_string($_GET['suite'])) {
	foreach (explode(',', $_GET['suite']) as $value) {
		if (is_string($value)) {
			$suite[] = $value;
		} else {
			break;
		}
	}
}

// Load selected tests
$dir = 'tests/'.implode('/', $suite);
if (is_dir($dir)) {

	// Load SimpleTest
	require_once('simpletest/autorun.php');

	// Load tests
	foreach (rglob_files($dir, 'php') as $path) {
		require_once $path;
	}
	unset($path);

} else {

	// Print a page about how sorry we are
	header('HTTP/1.1 404 Not Found');
	echo '<h1>No test suite found</h1><p>Try one of these:</p><ul>';
	foreach (glob('tests/*', GLOB_ONLYDIR) as $path) {
		echo '<li>'.basename($path).'</li>';
	}
	echo '</ul>';
	unset($path);
}

unset($dir);
die();

?>