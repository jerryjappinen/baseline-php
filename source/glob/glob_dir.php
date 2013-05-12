<?php

/**
* List all directories within a path.
*
* @param $path
*	...
*
* @return
*	...
*/
function glob_dir ($path = '') {

	// Normalize path
	if (!empty($path)) {
		$path = suffix($path, '/');
	}

	// Find directories in the path
	$directories = glob($path.'*', GLOB_MARK | GLOB_ONLYDIR);
	foreach ($directories as $key => $value) {
		$directories[$key] = str_replace('\\', '/', $value);
	}
	
	// Sort results
	usort($directories, 'strcasecmp');

	return $directories;
}

?>