<?php

/**
* Convert a string to camelCase.
*
* @param $subject
*	String to convert.
*
* @param $preserveUpperCase
*	When set to true, all existing uppercase characters are left untouched, including the first character of the string. Normally consecutive uppercase letters are downcased and the result string always begins with a lowercase letter.
*
* @return
*	A string with no spaces, dashes or underscores. Each word in the subject string now begins with a capitalized letter.
*/
function to_camelcase ($subject, $preserveUppercase = false) {

	// Treat dashes and underscores as spaces, disregard whitespace at ends
	$result = trim(str_replace(array('-', '_'), ' ', $subject));

	if (!empty($result)) {

		// Disregard existing consecutive caps
		if (!$preserveUppercase) {
			$result = preg_replace_callback('/[A-Z][A-Z]+/u', create_function('$matches', 'return mb_strtolower($matches[0]);'), $result);

			// Start with a lowercase letter
			$result = mb_strtolower(mb_substr($result, 0, 1)).mb_substr($result, 1);
		}

		// Uppercase all words, remove spaces
		$result = str_replace(' ', '', preg_replace_callback('/ (.?)/u', create_function('$matches', 'return mb_strtoupper($matches[0]);'), $result));
	}

	return $result;
}

?>