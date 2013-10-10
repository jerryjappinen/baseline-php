<?php

/**
* Trim all whitespace, line breaks etc. from a string.
*
* @param $subject
*	...
*
* @return
*	...
*/
function trim_whitespace ($subject) {
	if (is_string($subject)) {

		// Trim all whitespace
		return preg_replace('/\s+/', '', $subject);

	} else {
		return $subject;
	}
}

?>