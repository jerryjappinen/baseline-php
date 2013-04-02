<?php

/**
* Make sure final characters of a string are NOT what they shouldn't to be
*
* @param $subject
*	...
*
* @param $suffix
*	...
*
* @param $caseInsensitive
*	...
*
* @return
*	The contents $subject, guaranteed to not end with $suffix
*/
function dont_end_with ($subject, $suffix = '', $caseInsensitive = false) {

	// No need to do anything
	if (empty($suffix) or !suffixed($subject, $suffix, $caseInsensitive) or !ends_with($subject, $suffix, $caseInsensitive)) {
		$result = $subject;

	} else {

		// Need these for comparison
		$suffixLength = mb_strlen($suffix);
		$subjectLength = mb_strlen($subject);

		// Separate items for comparison we can play with
		$comparisonSubject = $subject;
		$comparisonSuffix = $suffix;

		// Prepare subject and suffix for comparison
		if ($caseInsensitive) {
			$comparisonSubject = mb_strtolower($comparisonSubject);
			$comparisonSuffix = mb_strtolower($comparisonSuffix);
		}

		// Iterate through substrings of suffix to see which part might be included
		for ($i = $suffixLength; $i > 0 and $suffixLength-$i <= $subjectLength; $i--) {

			// Compare latter part of subject to beginning of suffix
			if (mb_substr($comparisonSubject, -$i) === mb_substr($comparisonSuffix, 0, $i)) {
				break;
			}

		}

		// Cut a little bit out of the subject
		$result = mb_substr($subject, 0, $subjectLength-$i);

	}

	return $result;
}
















?>