<?php

/**
* Underscored to lower-camelcase 
*
* @param $string
*	...
*
* @return
*	...
*/
// FLAG doesn't really work as expected
function to_camelcase ($string) {
	return preg_replace('/ (.?)/e', 'strtoupper("$1")', strtolower($string)); 
}

?>