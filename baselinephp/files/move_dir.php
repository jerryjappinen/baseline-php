<?php

// Move directory
function move_dir ($path, $newLocation) {
	$path = end_with($path, '/');

	// Make sure we can work with the directory
	if (is_dir($path) and is_writable($path)) {
		$newLocation = end_with($newLocation, '/');

		// Create the new directory if it doesn't exist yet
		if (!is_dir($newLocation)) {
			if (!mkdir($newLocation, 0777, true)) {
				return false;
			}
		}

		// Move files individually
		foreach (rglob_files($path) as $filepath) {
			move_file($filepath, pathinfo($newLocation.dont_start_with($filepath, $path), PATHINFO_DIRNAME));
		}

		// Remove previous, now empty directories
		remove_dir($path);

		return true;
	}
	return false;
}

?>