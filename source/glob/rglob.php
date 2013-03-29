<?php

/**
* Search for stuff recursively
*
* @param $path
*	...
*
* @param $pattern
*	...
*
* @param $flags
*	...
*
* @return
*	...
*/
function rglob ($path = '', $pattern = '*', $flags = 0) {
	$directories = glob_dir($path);
	$files = glob(end_with($path, '/').$pattern, $flags);
	
	foreach ($directories as $path) {
		$files = array_merge($files, rglob($path, $pattern, $flags));
	}

	return $files;
}

?>