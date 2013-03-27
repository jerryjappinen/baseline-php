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

function start_with ($subject, $substring = '', $onlyCheckOnce = false) {

	// No need to do anything
	if (starts_with($subject, $substring)) {
		$result = $subject;

	// Fast check, just add prefix and be done with it
	} else if ($onlyCheckOnce) {
		$result = $substring.$subject;

	// Look for the part of prefix that's NOT already in the beginning of subject string
	} else {
		$prefix = $substring;

		// Maximum available length to cut from prefix
		$prefixLength = strlen($prefix);
		$max = min($prefixLength, strlen($subject));

		// Check for characters
		for ($i = 1; $i <= $max; $i++) {

			// Find out which part is NOT already in the beginning of the subject string
			if (substr($subject, 0, $i) !== substr($prefix, -$i)) {
				break;
			}

		}

		// Cut a little bit out of the prefix
		$result = substr($prefix, 0, $prefixLength-($i-1)).$subject;

	}

	return $result;
}

?>