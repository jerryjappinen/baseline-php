<?php

/**
* Make sure initial characters of a string are NOT what they shouldn't to be.
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
*	The contents of $subject, guaranteed to not begin with $substring
*/
function dont_start_with ($subject, $substring = '', $onlyCheckOnce = false) {

	// No need to do anything
	if (!starts_with($subject, $substring)) {
		$result = $subject;

	} else {

		// Cut the substring out
		$result = substr($subject, strlen($substring));
		if ($result === false) {
			$result = '';
		}

		// Make sure that the new string still doesn't start with the substring
		if (!$onlyCheckOnce) {
			$result = dont_start_with($result, $substring);
		}
	}

	return $result;
}

?>