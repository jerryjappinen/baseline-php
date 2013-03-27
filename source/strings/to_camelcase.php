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
function to_camelcase ($string) {
	return preg_replace('/ (.?)/e', 'strtoupper("$1")', strtolower($string)); 
}

?>