<?php

/**
* Calculate a formula in a string.
*
* @param $formula
*	...
*
* @param $forceInteger
*	...
*
* @return
*	Result of the calculation as an integer or float
*/
function calculate_string ($formula, $forceInteger = false) {
	$result = trim(preg_replace('/[^0-9\+\-\*\.\/\(\) ]/i', '', $formula));
	$compute = create_function('', 'return ('.(empty($result) ? 0 : $result).');');
	$result = 0 + $compute();
	return $forceInteger ? intval($result) : $result;
}

?>