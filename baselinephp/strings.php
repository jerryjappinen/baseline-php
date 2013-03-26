<?php

/**
* String functions
*/



/**
* Underscored to lower-camelcase 
*
* @param $string
*	...
*
* @return
*	...
*/
function to_camelcase ($string) {
	return preg_replace('/ (.?)/e', 'strtoupper("$1")', strtolower($string)); 
}



/**
* Camelcase to regular text 
*
* @param $string
*	...
*
* @return
*	...
*/
function from_camelcase ($string) {
	return strtolower(preg_replace('/([^A-Z])([A-Z])/', '$1 $2', $string)); 
}



/**
* Do a calculation with a formula in a string
*
* @param $string
*	...
*
* @param $forceInteger
*	...
*
* @return
*	Result of the calculation as an integer or float
*/
function calculate_string($string, $forceInteger = false) {
	$result = trim(preg_replace('/[^0-9\+\-\*\.\/\(\) ]/i', '', $string));
	$compute = create_function('', 'return ('.(empty($result) ? 0 : $result).');');
	$result = 0 + $compute();
	return $forceInteger ? intval($result) : $result;
}



/**
* Check if string starts with a specific substring
*
* @param $subject
*	...
*
* @param $substring
*	...
*
* @return
*	TRUE if $subject starts with $substring, FALSE otherwise
*/
function starts_with ($subject, $substring) {
	$result = false;
	$substringLength = strlen($substring);
	if (strlen($subject) >= $substringLength and substr($subject, 0, $substringLength) === $substring) {
		$result = true;
	}
	return $result;
}



/**
* Check if string ends with a specific substring
*
* @param $subject
*	...
*
* @param $substring
*	...
*
* @return
*	TRUE if $subject ends with $substring, FALSE otherwise
*/
function ends_with ($subject, $substring) {
	$result = false;
	$substringLength = strlen($substring);
	if (strlen($subject) >= $substringLength and substr($subject, -($substringLength)) === $substring) {
		$result = true;
	}
	return $result;
}



/**
* Make sure initial characters of a string are what they need to be
*
* @param $subject
*	...
*
* @param $substring
*	...
*
* @return
*	The contents of $subject, guaranteed to begin with $substring
*/
function start_with ($subject, $substring = '') {

	// No need to do anything
	if (starts_with($subject, $substring)) {
		$result = $string;

	// Add substring to the beginning
	} else {
		$result = $substring.$subject;
	}

	return $result;
}



/**
* Make sure initial characters of a string are NOT what they shouldn't to be
*
* @param $subject
*	...
*
* @param $substring
*	...
*
* @param $onlyCheckOnce
*	...
*
* @return
*	The contents of $subject, guaranteed to not begin with $substring
*/
function dont_start_with ($subject, $substring = '', $onlyCheckOnce = false) {

	// No need to do anything
	if (!starts_with($subject, $substring)) {
		$result = $subject;

	} else {

		// Cut the substring out
		$result = substr($subject, strlen($substring));
		if ($result === false) {
			$result = '';
		}

		// Make sure that the new string still doesn't start with the substring
		if (!$onlyCheckOnce) {
			$result = dont_start_with($result, $substring);
		}
	}

	return $result;
}



/**
* Make sure final characters of a string are what they need to be
*
* @param $subject
*	...
*
* @param $substring
*	...
*
* @return
*	The contents $subject, guaranteed to end with $substring
*/
function end_with ($subject, $substring = '') {

	// No need to do anything
	if (ends_with($subject, $substring)) {
		$result = $subject;

	// Add substring to the end
	} else {
		$result = $subject.$substring;
	}

	return $result;
}



/**
* Make sure final characters of a string are NOT what they shouldn't to be
*
* @param $subject
*	...
*
* @param $substring
*	...
*
* @param $onlyCheckOnce
*	...
*
* @return
*	The contents $subject, guaranteed to not end with $substring
*/
function dont_end_with ($subject, $substring = '', $onlyCheckOnce = false) {

	// No need to do anything
	if (!ends_with($subject, $substring)) {
		$result = $subject;

	} else {

		// Cut the substring out
		$result = substr($subject, 0, -(strlen($substring)));

		// Make sure that the new string still doesn't start with the substring
		if (!$onlyCheckOnce) {
			$result = dont_end_with($result, $substring);
		}

	}
	return $result;
}



/**
* Decodes a string into an array
*
* The format is roughly "key:value,anotherKey:value;nextSetOfValues;lastSetA,lastSetB"
*
* That's semicolon-separated key-value pairs or other values.
*
* @param $string
*	...
*
* @return
*	...
*/
function shorthand_decode ($string) {

	$result = array();

	// Iterate through all the values/key-value pairs
	foreach (explode(';', $string) as $key => $value) {

		// Individual value
		if (strpos($value, ',') === false and strpos($value, ':') === false) {
			$result[$key] = trim($value);

		// List
		} else {
			foreach (explode(',', $value) as $key2 => $value2) {

				$value2 = trim($value2, '"');

				// Key-value pair
				if (strpos($value2, ':') !== false) {
					$temp2 = explode(':', $value2);
					$result[$key][$temp2[0]] = $temp2[1];

				// Plain value
				} else {
					$result[$key][$key2] = $value2;
				}

			}
		}
	}

	// FLAG I'm looping the results twice
	foreach ($result as $key => $value) {
		if (is_string($value) and empty($value)) {
			unset($result[$key]);
		}
	}

	return $result;
}

?>