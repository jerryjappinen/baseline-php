<?php

/**
* Run a script file cleanly (no visible variables left around).
*
* @param 1 ($file)
*   Path to a file.
*
* @param 2 ($scriptVariables)
*   Array of variables and values to be created for the script.
*
* @param 3 ($queue)
*   Array of other scripts to include, with variables carried over from previous scripts. When a missing file is encountered, execution on the queue stops.
*
* @return 
*   String content of output buffer after the script has run, false on failure.
*/
function run_script () {

	$file = func_get_arg(0);
	if (is_file($file)) {
		unset($file);

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

		// Store script variables
		$definedVars = get_defined_vars();

		// Catch output reliably
		$output = ob_get_contents();
		if (!is_string($output)) {
			$output = '';
		}

		// Clear buffer
		ob_end_clean();

		// More scripts to include
		if (func_num_args() > 2) {

			// Normalize queue
			$queue = func_get_arg(2);
			$queue = array_flatten(to_array($queue));
			$next = array_shift($queue);

			// Run other scripts
			$others = run_script($next, $definedVars, $queue);
			if ($others !== false) {
				return $output.$others;
			}

		}

	}

	// Return any output
	return $output;
}

?>