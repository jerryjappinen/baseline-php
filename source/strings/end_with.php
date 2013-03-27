<?php

/**
* Make sure final characters of a string are what they need to be
*
* @param $subject
*	...
*
* @param $substring
*	...
*
* @return
*	The contents $subject, guaranteed to end with $substring
*/

// FLAG
// add (optional) "strict" checking that only adds the characters from $substring that are
// needed, so that end_with('www.foo.com/somewhere/', '/search/') becomes 'www.foo.com/somewhere/search/' and not 'www.foo.com/somewhere//search/'
function end_with ($subject, $substring = '') {

	// No need to do anything
	if (ends_with($subject, $substring)) {
		$result = $subject;

	// Add substring to the end
	} else {
		$result = $subject.$substring;
	}

	return $result;
}

?>