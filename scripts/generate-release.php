<?php

// Root of all problems
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', '1');
date_default_timezone_set('UTC');



/**
* Merge all source files into a single file for distribution
*/

// Basic variables
$sourcePath = '../baselinephp/';
$exportPath = '../baseline.php';



// Find files recursively (= rglob_files())
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



// Go through all source files
$prefix = '<?php';
$postfix = '?>';
$prefixLength = strlen($prefix);
$postfixLength = strlen($postfix);

$output = '<?php';
foreach (findSourceFilesRecursively($sourcePath) as $file) {
	$temp = file_get_contents($file);

	// Remove PHP start tag
	if (substr($temp, 0, $prefixLength) === $prefix) {
		$temp = substr($temp, $prefixLength);
	}

	// Remove PHP end tag
	if (substr($temp, -$postfixLength) === $postfix) {
		$temp = substr($temp, 0, strlen($temp)-$postfixLength);
	}

	$output .= $temp;
}
$output .= '?>';



// Optional saving
if (!isset($_GET['dontsave'])) {

	// Create export path
	$dir = pathinfo($exportPath, PATHINFO_DIRNAME).'/';
	if ((is_dir($dir) or mkdir($dir, 0777, true)) and is_writable($dir)) {

		// Save output
		file_put_contents($exportPath, $output);
	
	} else {
		throw new Exception('Cannot write to exposrt directory', 500);
	}


}

// Output
header('Content-Type: text/plain');
echo $output;

?>