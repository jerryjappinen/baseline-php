<?php
// Custom helpers for running and preparing tests

// Get files recursively
function test_helper_rglob_files ($path = '', $filetypes = array()) {
	$files = glob_files($path, $filetypes);
	foreach (glob_dir($path) as $child) {
		$files = array_merge($files, rglob_files($child, $filetypes));
	}
	return $files;
}



// Purge and destroy a directory
function test_helper_purge_dir ($path) {

	// Purge dir if it exists
	if (is_dir($path)) {
		$scan = scandir($path);

		// Remove everything
		foreach ($scan as $value) {
			if ($value != '.' && $value != '..') {
				if (filetype($path.'/'.$value) == 'dir') {
					remove_dir($path.'/'.$value);
				} else {
					unlink($path.'/'.$value);
				}
			}
		}

		reset($scan);
		rmdir($path);
	}

	return true;
}



// Create the new directory if it doesn't exist yet, purge it if it exists
function test_helper_prepare_dir ($path) {

	test_helper_purge_dir($path);

	// Create dir (again)
	if (!mkdir($path, 0777, true)) {
		return false;
	}

	return true;
}

?>