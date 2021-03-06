<?php

/**
* Remove a part of a string from the beginning if it exists.
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
	if (empty($prefix) or !prefixed($subject, $prefix, $caseInsensitive)) {
		$result = $subject;

	// Cut the prefix out
	} else {
		$result = mb_substr($subject, mb_strlen($prefix));
	}

	return $result;
}

?>