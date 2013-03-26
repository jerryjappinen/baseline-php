<?php

/**
* Flattens an array, either with or without the content in child arrays
*/
function array_flatten ($array, $removeChildren = false, $preserveKeys = false) {
	$result = array();
	foreach ($array as $key => $value) {
		if (!is_array($value)) {

			// Preseve keys
			if ($preserveKeys) {

				// ...but treat overlapping keys right
				if ($removeChildren or !isset($result[$key])) {
					$result[$key] = $value;
				}

			// Ditch keys
			} else {
				$result[] = $value;
			}

		// FLatten child arrays if they're kept
		} else if (!$removeChildren) {
			$result = array_merge($result, array_flatten($value));
		}
	}
	return $result;
}

?>