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
	$directories = glob(suffix($path, '/').'*', GLOB_MARK | GLOB_ONLYDIR);
	foreach ($directories as $key => $value) {
		$directories[$key] = str_replace('\\', '/', $value);
	}
	
	// Sort results
	usort($directories, 'strcasecmp');

	return $directories;
}

?>