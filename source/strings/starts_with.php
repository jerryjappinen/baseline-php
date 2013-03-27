<?php

/**
* Check if string starts with a specific substring
*
* @param $subject
*	...
*
* @param $substring
*	...
*
* @return
*	TRUE if $subject starts with $substring, FALSE otherwise
*/
function starts_with ($subject, $substring) {
	$result = false;
	$substringLength = strlen($substring);
	if (strlen($subject) >= $substringLength and substr($subject, 0, $substringLength) === $substring) {
		$result = true;
	}
	return $result;
}

?>