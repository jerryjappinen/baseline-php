<?php

/**
* Make sure final characters of a string are NOT what they shouldn't to be
*
* @param $subject
*	...
*
* @param $substring
*	...
*
* @param $onlyCheckOnce
*	...
*
* @return
*	The contents $subject, guaranteed to not end with $substring
*/
function dont_end_with ($subject, $substring = '', $onlyCheckOnce = false) {

	// No need to do anything
	if (!ends_with($subject, $substring)) {
		$result = $subject;

	} else {

		// Cut the substring out
		$result = substr($subject, 0, -(strlen($substring)));

		// Make sure that the new string still doesn't start with the substring
		if (!$onlyCheckOnce) {
			$result = dont_end_with($result, $substring);
		}

	}
	return $result;
}

?>