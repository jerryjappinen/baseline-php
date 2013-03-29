<?php

/**
* Remove a part from the end of a string if it exists.
*
* @param $subject
*	...
*
* @param $suffix
*	...
*
* @param $caseInsensitive
*	...
*
* @return
*	The contents $subject, with $suffix removed if needed.
*/
function unsuffix ($subject, $suffix = '', $caseInsensitive = false) {

	// No need to do anything
	if (!ends_with($subject, $suffix, $caseInsensitive)) {
		$result = $subject;

	// Cut the suffix out
	} else {
		$result = mb_substr($subject, 0, -(mb_strlen($suffix)));
	}

	return $result;
}

?>