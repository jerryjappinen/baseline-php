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
function from_camelcase ($string) {
	return strtolower(preg_replace('/([^A-Z])([A-Z])/', '$1 $2', $string)); 
}

?>