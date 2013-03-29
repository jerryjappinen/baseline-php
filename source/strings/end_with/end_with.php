<?php

/**
* Make sure final characters of a string are what they need to be. Compares the last characters of $subject to $suffix's first characters and avoids duplicate substrings, unlike suffix().
*
* For example, end_with('www.domain.co', '.com') returns 'www.domain.com'. prefix() would return 'www.domain.co.com'.
*
* @param $subject
*	...
*
* @param $suffix
*	...
*
* @param $caseInsensitive
*	Use case-insensitive comparison.
*
* @return
*	The contents of $subject, guaranteed to end with $suffix.
*/
function end_with ($subject, $suffix = '', $caseInsensitive = false) {

	// No need to do anything
	if (empty($suffix) or ends_with($subject, $suffix, $caseInsensitive)) {
		$result = $subject;

	// Look for the part of suffix that's NOT already in the beginning of subject string
	} else {

		// Need these for comparison
		$suffixLength = mb_strlen($suffix);
		$subjectLength = mb_strlen($subject);

		// Separate items for comparison we can play with
		$comparisonSubject = $subject;
		$comparisonsuffix = $suffix;

		// Prepare subject and suffix for comparison
		if ($caseInsensitive) {
			$comparisonSubject = mb_strtolower($subject);
			$comparisonsuffix = mb_strtolower($suffix);
		}

		// Iterate through substrings of suffix to see which part might already be included
		for ($i = $suffixLength-1; $i > 0 and $suffixLength-$i <= $subjectLength; $i--) {

			// Compare latter part of subject to beginning of suffix
			if (mb_substr($comparisonSubject, -$i) === mb_substr($comparisonsuffix, 0, $i)) {
				break;
			}

		}

		// Cut a little bit out of the suffix
		$cut = $suffixLength-$i;
		$result = $subject.mb_substr($suffix, -$cut);

	}

	return $result;
}

?>