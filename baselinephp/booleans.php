<?php

/**
* Convert an object or variable into boolean
*
* @param $value
*	Any object or variable whose value is used for interpretation
*
* @return
*	dump()'d $value wrapped in <pre>, ready to be used in HTML
*/
function to_boolean ($value) {
	if (
		empty($value) or
		((is_int($value) or is_float($value)) and $value < 0) or
		(is_string($value) and in_array(strtolower($value), array('null', 'nil', 'false')))
	) {
		return false;
	} else {
		return true;
	}
}

?>