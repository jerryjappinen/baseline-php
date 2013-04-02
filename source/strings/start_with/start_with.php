<?php

/**
* Make sure initial characters of a string are what they need to be
*
* @param $subject
*	...
*
* @param $prefix
*	...
*
* @param $caseInsensitive
*	Use case-insensitive comparison.
*
* @return
*	The contents of $subject, guaranteed to begin with $prefix.
*/
function start_with ($subject, $prefix = '', $caseInsensitive = false) {

	// No need to do anything
	if (empty($prefix) or prefixed($subject, $prefix, $caseInsensitive)) {
		$result = $subject;

	// Look for the part of prefix that's NOT already in the beginning of subject string
	} else {

		// Need these for comparison
		$prefixLength = mb_strlen($prefix);
		$subjectLength = mb_strlen($subject);

		// Separate items for comparison we can play with
		$comparisonSubject = $subject;
		$comparisonPrefix = $prefix;

		// Prepare subject and prefix for comparison
		if ($caseInsensitive) {
			$comparisonSubject = mb_strtolower($comparisonSubject);
			$comparisonPrefix = mb_strtolower($comparisonPrefix);
		}

		// Iterate through substrings of prefix to see which part might already be included
		for ($i = $prefixLength-1; $i > 0 and $prefixLength-$i <= $subjectLength; $i--) {

			// Compare latter part of prefix to beginning of subject
			if (mb_substr($comparisonPrefix, -$i) === mb_substr($comparisonSubject, 0, $i)) {
				break;
			}

		}

		// Cut a little bit out of the prefix
		$cut = $prefixLength-$i;
		$result = mb_substr($prefix, 0, $cut).$subject;

	}

	return $result;
}

?>