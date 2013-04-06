<?php

/**
* Silently log a dump()'d object or variable to error log.
*
* @param (any number of parameters)
*	Any objects or values to be passed to dump()
*
* @return
*	No return value.
*/
function debug () {
	$arguments = func_get_args();
	$displayErrors = ini_get('display_errors');
	ini_set('display_errors', '0');
	error_log("\n\n\n".call_user_func_array('dump', $arguments), 0)."\n\n";
	ini_set('display_errors', $displayErrors);
}

?>