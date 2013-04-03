<?php

/**
* Check if a string has a prefix.
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
*	TRUE if $subject starts with $prefix, FALSE otherwise. Empty prefix always returns true.
*/
function prefixed ($subject, $prefix, $caseInsensitive = false) {
	$result = false;

	// Need these for parsing
	$prefixLength = mb_strlen($prefix);
	$subjectLength = mb_strlen($subject);

	// Empty substring is always true
	if (!$prefixLength) {
		$result = true;

	// Prefix can't be bigger than subject
	} else if ($subjectLength >= $prefixLength) {

		// Part of subject to compare prefix to
		$cutout = mb_substr($subject, 0, $prefixLength);
		$comparison = $prefix;

		// Case-insensitive comparison
		if ($caseInsensitive) {
			$cutout = mb_strtolower($cutout);
			$comparison = mb_strtolower($comparison);
		}

		// Compare
		if ($cutout === $comparison) {
			$result = true;
		}

	}

	return $result;
}

?>