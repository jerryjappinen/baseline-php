<?php
// String functions

// Underscored to lower-camelcase 
function to_camelcase ($string) {
	return preg_replace('/ (.?)/e', 'strtoupper("$1")', strtolower($string)); 
}

// Camelcase to regular text 
function from_camelcase ($string) {
	return strtolower(preg_replace('/([^A-Z])([A-Z])/', '$1 $2', $string)); 
}



// Do a calculation with a formula in a string
function calculate_string($string, $intval = false) {
    $string = trim(preg_replace('/[^0-9\+\-\*\.\/\(\) ]/i', '', $string));
    $compute = create_function('', 'return ('.(empty($string) ? 0 : $string).');');
    $result = 0 + $compute();
    return $intval ? intval($result) : $result;
}



// Check if string starts with a specific substring
function starts_with ($subject, $substring) {
	$result = false;
	$substringLength = strlen($substring);
	if (strlen($subject) >= $substringLength and substr($subject, 0, $substringLength) === $substring) {
		$result = true;
	}
	return $result;
}

// Check if string ends with a specific substring
function ends_with ($subject, $substring) {
	$result = false;
	$substringLength = strlen($substring);
	if (strlen($subject) >= $substringLength and substr($subject, -($substringLength)) === $substring) {
		$result = true;
	}
	return $result;
}



// Make sure initial characters of a string are what they need to be
function start_with ($subject, $substring = '') {
	if (!starts_with($subject, $substring)) {
		$subject = $substring.$subject;
	}
	return $subject;
}

// Make sure initial characters of a string are NOT what they shouldn't to be
function dont_start_with ($subject, $substring = '', $onlyCheckOnce = false) {
	if (starts_with($subject, $substring)) {

		// Cut the substring out
		$subject = substr($subject, strlen($substring));
		if ($subject === false) {
			$subject = '';
		}

		// Make sure that the new string still doesn't start with the substring
		if (!$onlyCheckOnce) {
			$subject = dont_start_with($subject, $substring);
		}

	}
	return $subject;
}

// Make sure final characters of a string are what they need to be
function end_with ($subject, $substring = '') {
	if (!ends_with($subject, $substring)) {
		$subject .= $substring;
	}
	return $subject;
}

// Make sure final characters of a string are NOT what they shouldn't to be
function dont_end_with ($subject, $substring = '', $onlyCheckOnce = false) {
	if (ends_with($subject, $substring)) {

		// Cut the substring out
		$subject = substr($subject, 0, -(strlen($substring)));

		// Make sure that the new string still doesn't start with the substring
		if (!$onlyCheckOnce) {
			$subject = dont_end_with($subject, $substring);
		}

	}
	return $subject;
}



// Decodes a string into an array
// NOTE format: "key:value,anotherKey:value;nextSetOfValues;lastSetA,lastSetB"
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



// Serialize an array into non-human-readable strings
function array_serialize ($array) {
	$string = '';
	foreach ($array as $key => $value) {
		$string .= '.'.base64_encode(serialize($value));
	}
	return substr($string, 1);
}

// Unserialize an array back into a sane format
function array_unserialize ($string) {
	$result = array();

	// Exploding serialized data
	if (!empty($string)) {
		foreach (explode('.', $string) as $value) {
			$result[] = unserialize(base64_decode($value));
		}
	}

	return $result;
}

?>