<?php

/**
* Shorthand for throwing an error.
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