<?php

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

?>