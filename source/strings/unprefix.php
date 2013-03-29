<?php

/**
* Remove a part from the start of a string if it exists.
*
* @param $subject
*	...
*
* @param $prefix
*	...
*
* @param $caseInsensitive
*	...
*
* @return
*	The contents $subject, with $prefix removed if needed.
*/
function unprefix ($subject, $prefix = '', $caseInsensitive = false) {

	// No need to do anything
	if (!starts_with($subject, $prefix, $caseInsensitive)) {
		$result = $subject;

	// Cut the prefix out
	} else {
		$result = mb_substr($subject, mb_strlen($prefix));
	}

	return $result;
}

?>