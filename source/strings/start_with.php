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
* @param $onlyCheckOnce
*	Only check if the exact substring is found in the beginning of the subject, do not check substrings.
*
*	For example, starts_with('www.domain.com', 'http://') will return 'http://www.domain.com', but with $onlyCheckOnce set to true the result will be 'http:///www.domain.com/'. Checking only once is faster, so use it if you can.
*
* @return
*	The contents of $subject, guaranteed to begin with $substring
*/

function start_with ($subject, $substring = '', $onlyCheckOnce = false) {

	// No need to do anything
	if (starts_with($subject, $substring)) {
		$result = $subject;

	// Fast check, just add substring and be done with it
	} else if ($onlyCheckOnce) {
		$result = $substring.$subject;

	// Look for the part of substring that's NOT already in the beginning of subject string
	} else {

		// Maximum available length to cut from substring
		$substringLength = strlen($substring);
		$max = min($substringLength, strlen($subject));

		// Check for characters
		for ($i = 1; $i <= $max; $i++) {

			// Find out which part is NOT already in the beginning of the subject string
			if (substr($subject, 0, $i) !== substr($substring, -$i)) {
				break;
			}

		}

		// Cut a little bit out of the substring
		$result = substr($substring, 0, $substringLength-($i-1)).$subject;

	}

	return $result;
}

?>