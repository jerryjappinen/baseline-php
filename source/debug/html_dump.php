<?php

/**
* dump() objects or values into HTML.
*
* @param (any number of parameters)
*	Any objects or values to be passed to dump()
*
* @return
*	dump()'d $value wrapped in <pre> and <code> tags, ready to be used in HTML
*/
function html_dump () {
	$arguments = func_get_args();
	return '<pre><code>'.call_user_func_array('dump', $arguments).'</code></pre>';
}

?>