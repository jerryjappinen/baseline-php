<?php

/**
* Trim excess whitespaces, empty lines etc. from a string.
*
* @param $subject
*	...
*
* @param $singleLine
*	All line breaks are stripped, return value contains only one line.
*
* @return
*	...
*/
function trim_text ($subject, $singleLine = false) {
	if (is_string($subject)) {

		// Trim all groups of whitespace
		if ($singleLine) {
			return preg_replace('!\s+!', ' ', trim($subject));

		// Collapse excess empty lines, then clean up
		} else {
			return preg_replace('/[ \t]+/', ' ', preg_replace('/\s*$^\s*/m', "\n\n", trim($subject)));
		}

	} else {
		return $subject;
	}
}

?>