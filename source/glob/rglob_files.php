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
	$files = glob_files($path, $filetypes);
	foreach (glob_dir($path) as $child) {
		$files = array_merge($files, rglob_files($child, $filetypes));
	}
	return $files;
}

?>