<?php

/**
* Allow giving a different last glue for implode
*
* @param $glue
*	...
*
* @param $array
*	...
*
* @param $lastGlue
*	...
*
* @return
*	...
*/
function limplode ($glue = '', $array = array(), $lastGlue = false) {

	// Allow giving glue and array in reverse order, like implode() does
	if (is_array($glue)) {
		$realGlue = $array;
		$realArray = $glue;
	} else {
		$realGlue = $glue;
		$realArray = $array;
	}

	$count = count($realArray);

	// Return implode() if last glue is missing or we have no use for last glue
	if (!$lastGlue or $count < 3 or $lastGlue === $glue) {
		return implode($glue, $array);

	// Last glue was given
	} else {

		$temp = $realArray;
		$lastItem = array_pop($temp);

		// Implode array without last item
		return implode($realGlue, $temp).$lastGlue.$lastItem;

	}

}

?>