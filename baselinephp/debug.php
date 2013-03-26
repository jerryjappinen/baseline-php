<?php

/**
* Development helpers
*/



/**
* Dump objects or variables into a (mostly) human-readable format.
*
* @param $value
*	Any object or value to be passed to var_dump()
*
* @return
*	var_dump()'d $value
*/
function dump ($value) {
	return var_export($value, true);
}



/**
* dump() objects or values into HTML.
*
* @param $value
*	Any object or value to be passed to dump()
*
* @return
*	dump()'d $value wrapped in <pre>, ready to be used in HTML
*/
function htmlDump ($value) {
	return '<pre>'.dump($value).'</pre>';
}



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