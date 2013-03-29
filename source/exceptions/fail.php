<?php

/**
* Shorthand error throwing
*
* @param $message
*	...
*
* @param $code
*	...
*
* @return
*	...
*/
function fail ($message, $code = null) {
	throw new Exception($message, isset($code) ? $code : 500);
}

?>