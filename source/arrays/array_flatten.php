<?php

/**
* Flatten an array, either keeping or discarding content of child arrays.
*
* @param $array
*	...
*
* @param $removeChildren (optional)
*	...
*
* @param $preserveKeys (optional)
*	...
*
* @return
*	...
*/
function array_flatten (array $array, $removeChildren = false, $preserveKeys = false) {
	$result = array();
	foreach ($array as $key => $value) {

		// Value isn't child array
		if (!is_array($value)) {

			// Preseve keys if possible
			if ($preserveKeys) {
				if (!isset($result[$key])) {
					$result[$key] = $value;
				}

			// Ditch keys
			} else {
				$result[] = $value;
			}

		// Flatten child arrays if they're kept
		} else if (!$removeChildren) {
			$result = array_merge($result, array_flatten($value, $removeChildren, $preserveKeys));
		}
	}
	return $result;
}

?>