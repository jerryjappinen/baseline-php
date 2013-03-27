<?php

/**
* Make sure initial characters of a string are what they need to be
*
* @param $subject
*	...
*
* @param $substring
*	...
*
* @return
*	The contents of $subject, guaranteed to begin with $substring
*/
function start_with ($subject, $substring = '') {

	// No need to do anything
	if (starts_with($subject, $substring)) {
		$result = $subject;

	// Add substring to the beginning
	} else {
		$result = $substring.$subject;
	}

	return $result;
}

?>