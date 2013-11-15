<?php

/**
* Traverse a a multidimensional array based on given keys.
*
* I.e. $subject[ $keys[0] ][ $keys[1] ] ...
*
* @param $subject
*	...
*
* @param $keys (optional)
*	...
*
* @return
*	...
*/
function array_traverse (array $subject, $keys = array()) {

	// Accept keys as a single array or multiple independent values
	$arguments = func_get_args();
	array_shift($arguments);
	$keys = array_flatten($arguments);

	// Need to traverse tree
	if (isset($keys[0])) {

		// Exists
		if (array_key_exists($keys[0], $subject)) {

			// This will be the last, no need to iterate
			if (!isset($keys[1])) {
				return $subject[$keys[0]];

			// Going deeper
			} else {
				$newTree = $keys;
				array_shift($newTree);
				return array_traverse($subject[$keys[0]], $newTree);
			}

		// Doesn't exist
		} else {
			return null;
		}

	// We got what we came for
	} else {
		return $subject;
	}

}

?>