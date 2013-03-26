<?php

/**
* Convert an object or variable into boolean
*
* @param $value
*	Any object or variable whose value is used for interpretation
*
* @return
*	FALSE on empty or less-than-zero values and falsy keywords, TRUE otherwise
*/
function to_boolean ($value) {
	if (
		!$value or
		empty($value) or
		(is_numeric($value) and strval($value) <= 0) or
		(is_string($value) and in_array(trim(strtolower($value)), array('null', 'nul', 'nil', 'false')))
	) {
		return false;
	} else {
		return true;
	}
}

?>