<?php

/**
* Add a prefix to string if needed.
*
* @param $subject
*	...
*
* @param $prefix
*	...
*
* @param $caseInsensitive
*	Check if prefix exists using case-insensitive comparison.
*
* @return
*	A string that includes $prefix and $subject.
*/
function prefix ($subject, $prefix = '', $caseInsensitive = false) {
	$result = $subject;

	// Prefix if needed
	if (!empty($prefix) and !prefixed($subject, $prefix, $caseInsensitive)) {
		$result = $prefix.$subject;
	}

	return $result;
}

?>