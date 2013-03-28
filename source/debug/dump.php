<?php

/**
* Dump objects or variables into a (mostly) human-readable format.
*
* @param (any number of parameters)
*	Any objects or values to be passed to var_dump()
*
* @return
*	var_dump()'d $value
*/
function dump () {
	$values = func_get_args();
	return var_export(count($values) < 2 ? $values[0] : $values, true);
}

?>