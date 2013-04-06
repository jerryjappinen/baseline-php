<?php

/**
* Turn camelCase into regular text.
*
* @param $string
*	...
*
* @return
*	...
*/
function from_camelcase ($string) {
	return trim(mb_strtolower(preg_replace('/(?!\ )([^A-Z])([A-Z])/', '$1 $2', $string))); 
}

?>