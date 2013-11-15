<?php

/**
* Get the first item in an array.
*
* @param $array
*	...
*
* @param $traverseChildArrays
*	If the first item is a child array, treat the stack recursively and find the first non-array value.
*
* @return
*	...
*/
function array_first (array $array = array(), $traverseChildArrays = false) {
	$result = reset($array);
	if ($traverseChildArrays and is_array($result)) {
		$result = array_first($result, true);
	}
	return $result;
}

?>