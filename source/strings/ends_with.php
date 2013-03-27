<?php

/**
* Check if string ends with a specific substring
*
* @param $subject
*	...
*
* @param $substring
*	...
*
* @return
*	TRUE if $subject ends with $substring, FALSE otherwise
*/
function ends_with ($subject, $substring) {
	$result = false;
	$substringLength = strlen($substring);
	if (strlen($subject) >= $substringLength and substr($subject, -($substringLength)) === $substring) {
		$result = true;
	}
	return $result;
}

?>