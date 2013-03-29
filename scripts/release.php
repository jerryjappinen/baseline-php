<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', '1');
ini_set('log_errors', '1');
mb_internal_encoding('UTF-8');



/**
* Merge all source files into a single file for distribution
*/

// Basic variables
$root = '../';
$readmePath = $root.'readme.txt';
$sourcePath = $root.'source/';
$exportPath = $root.'baseline.php';



// Find source files recursively
function findSourceFilesRecursively ($root) {
	$files = array();

	// Files first
	foreach (glob($root.'*') as $path) {
		if (is_file($path)) {
			$files[] = $path;
		}
	}

	// Then subdirectories
	foreach (glob($root.'*', GLOB_ONLYDIR) as $path) {
		$path = $path.'/';
		if (is_dir($path)) {
			$files = array_merge($files, findSourceFilesRecursively($path));
		}
	}

	return $files;
}



// Something little for parsing
$prefix = '<?php';
$suffix = '?>';
$prefixLength = strlen($prefix);
$suffixLength = strlen($suffix);

// Go through all source files
$output = '';
foreach (findSourceFilesRecursively($sourcePath) as $file) {
	$fileContents = file_get_contents($file);

	// Remove PHP start tag
	if (substr($fileContents, 0, $prefixLength) === $prefix) {
		$fileContents = substr($fileContents, $prefixLength);
	}

	// Remove PHP end tag
	if (substr($fileContents, -$suffixLength) === $suffix) {
		$fileContents = substr($fileContents, 0, strlen($fileContents)-$suffixLength);
	}

	$output .= $fileContents;
	unset($fileContents);
}

// Wrap output in PHP tags, add comments
$readme = trim(file_get_contents($readmePath));
$title = substr($readme, 0, strpos($readme, "\n"));
$output = '<?php

/**
* '.(stripos($title, 'baseline') === false ? 'Baseline PHP' : $title).'
*
* Released under LGPL
* Authored by Jerry Jäppinen
* http://eiskis.net/
* eiskis@gmail.com
*
* Compiled from source on '.date('Y-m-d H:i') .'
*/

'.trim($output).'

?>';



// Optional saving, on localhost
if (!isset($_GET['dontsave']) and in_array($_SERVER['SERVER_ADDR'], array('127.0.0.1', '::1'))) {

	// Create export path
	$dir = pathinfo($exportPath, PATHINFO_DIRNAME).'/';
	if ((is_dir($dir) or mkdir($dir, 0777, true)) and is_writable($dir)) {

		// Save output
		file_put_contents($exportPath, $output);

		// Re-read output back to make sure things went smoothly
		$output = '';
		$output = file_get_contents($exportPath);

	} else {
		throw new Exception('Cannot write to exposrt directory', 500);
	}


}

// Output
header('Content-Type: text/plain;charset=utf-8');
echo $output;

die();

?>