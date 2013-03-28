<?php

/**
* dump() objects or values into HTML.
*
* @param (any number of parameters)
*	Any objects or values to be passed to dump()
*
* @return
*	dump()'d $value wrapped in <pre>, ready to be used in HTML
*/
function htmlDump () {
	$arguments = func_get_args();
	return '<pre>'.call_user_func_array('dump', $arguments).'</pre>';
}

?>