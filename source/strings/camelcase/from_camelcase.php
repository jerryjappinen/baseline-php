<?php

/**
* Camelcase to regular text 
*
* @param $string
*	...
*
* @return
*	...
*/
// FLAG doesn't really work as expected
function from_camelcase ($string) {
	return strtolower(preg_replace('/([^A-Z])([A-Z])/', '$1 $2', $string)); 
}

?>