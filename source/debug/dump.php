<?php

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

?>