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

	if (is_file(func_get_arg(0))) {

		// Set up variables for the script
		foreach (func_get_arg(1) as $____key => $____value) {
			if (is_string($____key)) {
				${$____key} = $____value;
			}
		}

		// Clean up variables
		if (!array_key_exists('____key', func_get_arg(1))) {
			unset($____key);
		}
		if (!array_key_exists('____value', func_get_arg(1))) {
			unset($____value);
		}

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