<?php

/**
* Trims excess whitespaces, empty lines etc. from a string.
*
* @param $subject
*	...
*
* @return
*	...
*/
function trim_text ($subject) {
	if (is_string($subject)) {
		return preg_replace('/[ \t]+/', ' ', preg_replace('/\s*$^\s*/m', "\n\n", trim($subject)));
	} else {
		return $subject;
	}
}

?>