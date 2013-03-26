<?php
// Low-level array functionality

// Find a value from an array based on given keys (basically $values[ $tree[0] ][ $tree[1] ] ...)
function array_traverse ($values, $tree) {

	// Need to traverse tree
	if (isset($tree[0])) {

		// Exists
		if (array_key_exists($tree[0], $values)) {
				
			// This will be the last, no need to iterate
			if (!isset($tree[1])) {
				return $values[$tree[0]];

			// Going deeper
			} else {
				$newTree = $tree;
				array_shift($newTree);
				return array_traverse($values[$tree[0]], $newTree);
			}

		// Doesn't exist
		} else {
			return null;
		}

	// We got what we came for
	} else {
		return $values;
	}

}

// Flattens an array, either with or without the content in child arrays
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



// Make sure value is array, convert if needed
function to_array ($original) {

	// Already an array
	if (is_array($original)) {
		$result = $original;

	// Object
	} else if (is_object($original)) {

		// Convert to array
		$original = (array) $original;
		
		if (is_array($original)) {

			// Convert children
			$result = array();
			foreach($original as $key => $value) {
				if (is_object($value)) {
					$result[$key] = to_array($value);
				} else {
					$result[$key] = $value;
				}
			}

		} else {
			$result = to_array($original);
		}

  	// Default
	} else {
		$result = array($original);
	}

	return $result;
}



// Allow giving a different last glue for implode
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