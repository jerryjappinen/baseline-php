<?php

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