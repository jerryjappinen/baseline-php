<?php

/**
* Search for stuff recursively
*
* @param $path
*	...
*
* @return
*	...
*/
function rglob_dir ($path = '') {
	$directories = glob_dir($path);
	foreach ($directories as $path) {
		$directories = array_merge($directories, rglob_dir($path));
	}
	return $directories;
}

?>