<?php

/**
* Add a suffix to string if needed.
*
* @param $subject
*	...
*
* @param $suffix
*	...
*
* @param $caseInsensitive
*	Check if suffix exists using case-insensitive comparison.
*
* @return
*	A string that includes $subject and $suffix.
*/
function suffix ($subject, $suffix = '', $caseInsensitive = false) {
	$result = $subject;

	// suffix if needed
	if (!empty($suffix) and !ends_with($subject, $suffix, $caseInsensitive)) {
		$result = $subject.$suffix;
	}

	return $result;
}

?>