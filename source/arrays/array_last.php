<?php

/**
* Get the last item in an array.
*
* @param $array
*	...
*
* @param $traverseChildArrays
*	If the last item is a child array, treat the stack recursively and find the last non-array value.
*
* @return
*	...
*/
function array_last (array $array = array(), $traverseChildArrays = false) {
	$result = end($array);
	if ($traverseChildArrays and is_array($result)) {
		$result = array_last($result, true);
	}
	return $result;
}

?>