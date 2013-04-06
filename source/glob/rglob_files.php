<?php

/**
* Search for files recursively
*
* @param $path
*	...
*
* @param $filetypes
*	...
*
* @return
*	...
*/
function rglob_files ($path = '', $filetypes = array()) {

	// Accept file type restrictions as a single array or multiple independent values
	$arguments = func_get_args();
	array_shift($arguments);
	$filetypes = array_flatten($arguments);

	// Run glob_files for this directory and its subdirectories
	$files = glob_files($path, $filetypes);
	foreach (glob_dir($path) as $child) {
		$files = array_merge($files, rglob_files($child, $filetypes));
	}

	return $files;
}

?>