<?php

/**
* Shortcut to running a script consisting of multiple files with run_script
*
* @param 1 ($files)
*   Path to the script files.
*
* @param 2 ($scriptVariables)
*   Array of variables and values to be created for the script (initially).
*
* @return 
*   String content of output buffer after the script has run, false on failure.
*/
function run_scripts ($files = array(), $scriptVariables = array()) {
	$queue = array();
	$first = '';

	// Normalize
	$files = array_flatten(to_array($files));
	if (count($files) >= 1) {
		$first = array_shift($files);
		$queue = $files;
	}

	return run_script($first, $scriptVariables, $queue);
}

?>