<?php

/**
* Allow giving a different last glue for implode
*/
function limplode ($glue, $array, $last = false) {

	$result = '';
	$count = count($array);

	// Only one item
	if ($count === 1) {
		$temp = array_keys($array);
		$result = $array[$temp[0]];

		// Make sure array is flattened
		if (is_array($result)) {
			$result = limplode($glue, array_flatten($result), $last);
		}

	// Multiple items
	} else if ($count > 1) {

		// Make sure array is flattened
		$array = array_flatten($array);

		// Iterate through each item
		foreach ($array as $value) {
			$count--;

			// Switch glue for last two items
			if ($count == 1 && is_string($last)) {
				$glue = $last;
			} else if ($count == 0) {
				$glue = '';
			}

			// Add to return string
			$result .= $value.$glue;
		}
	}

	return $result;
}

?>