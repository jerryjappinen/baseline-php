<?php

/**
* Run scripts files cleanly (no visible variables left)
*
* @param 1
*   Path to a file
*
* @param 2
*   Array of variables and values to be created for the script
*
* @return 
*   String content of output buffer after the script has run.
*/
function run_script () {

	$script = func_get_arg(0);
	if (is_file($script)) {
		unset($script);

		// Set up variables for the script
		foreach (func_get_arg(1) as $____key => $____value) {
			if (is_string($____key)) {
				${$____key} = $____value;
			}
		}

		// Clean up variables
		// FLAG It's possibly for these to confuse the parameters provided as input in extremely rare circumstances
		$____params = func_get_arg(1);
		if (!array_key_exists('____key', $____params)) {
			unset($____key);
		}
		if (!array_key_exists('____value', $____params)) {
			unset($____value);
		}
		unset($____params);

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