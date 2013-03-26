<?php

/**
* Find a value from an array based on given keys (basically $values[ $tree[0] ][ $tree[1] ] ...)
*/
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

?>