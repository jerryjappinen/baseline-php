<?php

/**
* Move one file
*
* @param $path
*	...
*
* @param $newLocation
*	...
*
* @return
*	...
*/
function move_file ($path, $newLocation) {

	if (is_file($path) and is_writable($path)) {
		$newLocation = suffix($newLocation, '/');

		// Create the new directory if needed
		if (!is_dir($newLocation)) {
			if (!mkdir($newLocation, 0777, true)) {
				return false;
			}
		}

		rename($path, $newLocation.basename($path));
		return true;

	}

	return false;
}

?>