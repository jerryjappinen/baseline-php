<?php

/**
* Run a script file cleanly (no visible variables left around).
*
* @param 1
*   Path to a file.
*
* @param 2
*   Array of variables and values to be created for the script.
*
* @return 
*   String content of output buffer after the script has run, false on failure.
*/
function run_script () {
	$output = false;

	$path = func_get_arg(0);
	if (is_file($path)) {
		unset($path);

		// Set up variables for the script
		foreach (func_get_arg(1) as $____key => $____value) {
			if (is_string($____key) and !in_array($____key, array('____key', '____value'))) {
				${$____key} = $____value;
			}
		}
		unset($____key, $____value);

		// Run each script
		ob_start();

		// Include script
		include func_get_arg(0);

		// Catch output reliably
		$output = ob_get_contents();
		if ($output === false) {
			$output = '';
		}

		// Clear buffer
		ob_end_clean();

	}

	// Return any output
	return $output;
}

?>