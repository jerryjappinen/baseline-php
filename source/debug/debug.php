<?php

/**
* Silently log a dump()'d object or variable to error log.
*
* @param $value
*	Any object or value to be passed to dump()
*
* @return
*	No return value.
*/
function debug ($value) {
	$displayErrors = ini_get('display_errors');
	ini_set('display_errors', '0');
	error_log("\n\n\n".dump($value), 0)."\n\n";
	ini_set('display_errors', $displayErrors);
}

?>