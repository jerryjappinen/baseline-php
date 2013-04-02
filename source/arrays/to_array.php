<?php

/**
* Make sure value is array, convert if needed
*
* @param $value
*	...
*
* @return
*	An array, with the value of $value if possible.
*/
function to_array ($value) {

	// Already an array
	if (is_array($value)) {
		$result = $value;

	// Object
	} else if (is_object($value)) {

		// Convert to array
		$value = (array) $value;
		
		if (is_array($value)) {

			// Convert children
			$result = array();
			foreach($value as $key => $value) {
				if (is_object($value)) {
					$result[$key] = to_array($value);
				} else {
					$result[$key] = $value;
				}
			}

		} else {
			$result = to_array($value);
		}

  	// Default
	} else {
		$result = array($value);
	}

	return $result;
}

?>