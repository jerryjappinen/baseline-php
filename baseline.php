<?php

/**
* Baseline PHP 2013-03-28 20:35
*
* Released under LGPL. Authored by Jerry Jäppinen.
* http://eiskis.net/
* eiskis@gmail.com
*/

/**
* Flattens an array, either with or without the content in child arrays
*/
function array_flatten ($array, $removeChildren = false, $preserveKeys = false) {
	$result = array();
	foreach ($array as $key => $value) {
		if (!is_array($value)) {

			// Preseve keys
			if ($preserveKeys) {

				// ...but treat overlapping keys right
				if ($removeChildren or !isset($result[$key])) {
					$result[$key] = $value;
				}

			// Ditch keys
			} else {
				$result[] = $value;
			}

		// FLatten child arrays if they're kept
		} else if (!$removeChildren) {
			$result = array_merge($result, array_flatten($value));
		}
	}
	return $result;
}



/**
* Find a value from an array based on given keys (basically $values[ $tree[0] ][ $tree[1] ] ...)
*/
function array_traverse ($values, $tree) {

	// Need to traverse tree
	if (isset($tree[0])) {

		// Exists
		if (array_key_exists($tree[0], $values)) {
				
			// This will be the last, no need to iterate
			if (!isset($tree[1])) {
				return $values[$tree[0]];

			// Going deeper
			} else {
				$newTree = $tree;
				array_shift($newTree);
				return array_traverse($values[$tree[0]], $newTree);
			}

		// Doesn't exist
		} else {
			return null;
		}

	// We got what we came for
	} else {
		return $values;
	}

}



/**
* Allow giving a different last glue for implode
*/
function limplode ($glue, $array, $last = false) {

	$result = '';
	$count = count($array);

	// Only one item
	if ($count === 1) {
		$temp = array_keys($array);
		$result = $array[$temp[0]];

		// Make sure array is flattened
		if (is_array($result)) {
			$result = limplode($glue, array_flatten($result), $last);
		}

	// Multiple items
	} else if ($count > 1) {

		// Make sure array is flattened
		$array = array_flatten($array);

		// Iterate through each item
		foreach ($array as $value) {
			$count--;

			// Switch glue for last two items
			if ($count == 1 && is_string($last)) {
				$glue = $last;
			} else if ($count == 0) {
				$glue = '';
			}

			// Add to return string
			$result .= $value.$glue;
		}
	}

	return $result;
}



/**
* Make sure value is array, convert if needed
*/
function to_array ($original) {

	// Already an array
	if (is_array($original)) {
		$result = $original;

	// Object
	} else if (is_object($original)) {

		// Convert to array
		$original = (array) $original;
		
		if (is_array($original)) {

			// Convert children
			$result = array();
			foreach($original as $key => $value) {
				if (is_object($value)) {
					$result[$key] = to_array($value);
				} else {
					$result[$key] = $value;
				}
			}

		} else {
			$result = to_array($original);
		}

  	// Default
	} else {
		$result = array($original);
	}

	return $result;
}



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



/**
* Silently log a dump()'d object or variable to error log.
*
* @param $value
*	Any object or value to be passed to dump()
*
* @return
*	No return value.
*/
function debug ($value) {
	$displayErrors = ini_get('display_errors');
	ini_set('display_errors', '0');
	error_log("\n\n\n".dump($value), 0)."\n\n";
	ini_set('display_errors', $displayErrors);
}



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



// Shorthand error throwing
function fail ($message, $code = null) {
	throw new Exception($message, isset($code) ? $code : 500);
}



// Move directory
function move_dir ($path, $newLocation) {
	$path = end_with($path, '/');

	// Make sure we can work with the directory
	if (is_dir($path) and is_writable($path)) {
		$newLocation = end_with($newLocation, '/');

		// Create the new directory if it doesn't exist yet
		if (!is_dir($newLocation)) {
			if (!mkdir($newLocation, 0777, true)) {
				return false;
			}
		}

		// Move files individually
		foreach (rglob_files($path) as $filepath) {
			move_file($filepath, pathinfo($newLocation.dont_start_with($filepath, $path), PATHINFO_DIRNAME));
		}

		// Remove previous, now empty directories
		remove_dir($path);

		return true;
	}
	return false;
}



// Move one file
function move_file ($path, $newLocation) {

	if (is_file($path) and is_writable($path)) {
		$newLocation = end_with($newLocation, '/');

		// Create the new directory if needed
		if (!is_dir($newLocation)) {
			if (!mkdir($newLocation, 0777, true)) {
				return false;
			}
		}

		rename($path, $newLocation.basename($path));
		return true;

	}

	return false;
}



// Remove a complete directory, including its contents
function remove_dir ($path) {

	if (is_dir($path)) {

		$scan = scandir($path);

		foreach ($scan as $value) {
			if ($value != '.' && $value != '..') {
				if (filetype($path.'/'.$value) == 'dir') {
					remove_dir($path.'/'.$value);
				} else {
					unlink($path.'/'.$value);
				}
			}
		}

		reset($scan);
		rmdir($path);
		return true;
	}

	return false;
}



// Remove one file
function remove_file ($path) {
	if (is_file($path)) {
		unlink($path);
		return true;
	}
	return false;
}



/**
* Search for directories in a path
*/
function glob_dir ($path = '') {
	$directories = glob(end_with($path, '/').'*', GLOB_MARK | GLOB_ONLYDIR);
	foreach ($directories as $key => $value) {
		$directories[$key] = str_replace('\\', '/', $value);
	}
	natcasesort($directories);
	return $directories;
}



// Search for files
function glob_files ($path = '', $filetypes = array()) {
	$result = array();

	// Handle filetype input
	$filetypes = array_flatten(to_array($filetypes));
	if (empty($filetypes)) {
		$brace = '';
	} else {
		$brace = '.{'.implode(',', $filetypes).'}';
	}

	// Handle path input
	if (!empty($path)) {
		$path = end_with($path, '/');
	}

	foreach (glob($path.'*'.$brace, GLOB_BRACE) as $value) {
		if (is_file($value)) {
			$result[] = $value;
		}
	}
	natcasesort($result);
	return $result;
}



// Search for stuff recursively
function rglob ($path = '', $pattern = '*', $flags = 0) {
	$directories = glob_dir($path);
	$files = glob(end_with($path, '/').$pattern, $flags);
	
	foreach ($directories as $path) {
		$files = array_merge($files, rglob($path, $pattern, $flags));
	}

	return $files;
}



// Search for stuff recursively
function rglob_dir ($path = '') {
	$directories = glob_dir($path);
	foreach ($directories as $path) {
		$directories = array_merge($directories, rglob_dir($path));
	}
	return $directories;
}



// Search for files recursively
function rglob_files ($path = '', $filetypes = array()) {
	$files = glob_files($path, $filetypes);
	foreach (glob_dir($path) as $child) {
		$files = array_merge($files, rglob_files($child, $filetypes));
	}
	return $files;
}



/**
* Create a new object
*/
function create ($object) {
	return $object;
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
function calculate_string ($string, $forceInteger = false) {
	$result = trim(preg_replace('/[^0-9\+\-\*\.\/\(\) ]/i', '', $string));
	$compute = create_function('', 'return ('.(empty($result) ? 0 : $result).');');
	$result = 0 + $compute();
	return $forceInteger ? intval($result) : $result;
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
* @param $onlyCheckOnce
*	Only check if the exact substring is found in the beginning of the subject, do not check substrings.
*
*	For example, starts_with('www.domain.com', 'http://') will return 'http://www.domain.com', but with $onlyCheckOnce set to true the result will be 'http:///www.domain.com/'. Checking only once is faster, so use it if you can.
*
* @return
*	The contents $subject, guaranteed to end with $substring
*/

function end_with ($subject, $substring = '', $onlyCheckOnce = false) {

	// No need to do anything
	if (ends_with($subject, $substring)) {
		$result = $subject;

	// Fast check, just add substring and be done with it
	} else if ($onlyCheckOnce) {
		$result = $subject.$substring;

	// Look for the part of substring that's NOT already at the end of subject string
	} else {

		// Maximum available length to cut from substring
		$substringLength = strlen($substring);
		$subjectLength = strlen($subject);
		$max = min($substringLength, $subjectLength);

		// Check for characters
		for ($i = 1; $i <= $max; $i++) {

			// Find out which part is NOT already at the end of the subject string
			if (substr($subject, -$i) !== substr($substring, 0, $i)) {
				break;
			}

		}

		// Cut a little bit out of the substring
		$result = $subject.substr($substring, $i-1);

	}

	return $result;
}



/**
* Check if string ends with a specific suffix
*
* @param $subject
*	...
*
* @param $suffix
*	...
*
* @param $caseInsensitive
*	Use case-insensitive comparison.
*
* @return
*	TRUE if $subject ends with $suffix, FALSE otherwise. Empty suffix always returns true.
*/
function ends_with ($subject, $suffix, $caseInsensitive = false) {
	$result = false;

	// Need these for parsing
	$suffixLength = mb_strlen($suffix);
	$subjectLength = mb_strlen($subject);

	// Empty substring is always true
	if (!$suffixLength) {
		$result = true;

	// suffix can't be bigger than subject
	} else if ($subjectLength >= $suffixLength) {

		// Part of subject to compare suffix to
		$cutout = mb_substr($subject, -$suffixLength);
		$comparison = $suffix;

		// Case-insensitive comparison
		if ($caseInsensitive) {
			$cutout = mb_strtolower($cutout);
			$comparison = mb_strtolower($comparison);
		}

		// Compare
		if ($cutout === $comparison) {
			$result = true;
		}

	}

	return $result;
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
// FLAG doesn't really work as expected
function from_camelcase ($string) {
	return strtolower(preg_replace('/([^A-Z])([A-Z])/', '$1 $2', $string)); 
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



/**
* Make sure initial characters of a string are what they need to be
*
* @param $subject
*	...
*
* @param $substring
*	...
*
* @param $onlyCheckOnce
*	Set to true to force prefix $subject with the whole $substring, even when $subject already has part of what's needed. This is faster than checking for substrings.
*
*	For example, starts_with('www.domain.com', 'http://') will return 'http://www.domain.com', but with $onlyCheckOnce set to true the result will be 'http:///www.domain.com/'. Checking only once is faster, so use it if you can.
*
* @return
*	The contents of $subject, guaranteed to begin with $substring
*/

function start_with ($subject, $substring = '', $onlyCheckOnce = false) {

	// No need to do anything
	if (starts_with($subject, $substring)) {
		$result = $subject;

	// Fast check, just add substring and be done with it
	} else if ($onlyCheckOnce) {
		$result = $substring.$subject;

	// Look for the part of substring that's NOT already in the beginning of subject string
	} else {

		// Maximum available length to cut from substring
		$substringLength = strlen($substring);
		$max = min($substringLength, strlen($subject));

		// Check for characters
		for ($i = 1; $i <= $max; $i++) {

			// Find out which part is NOT already in the beginning of the subject string
			if (substr($subject, 0, $i) !== substr($substring, -$i)) {
				break;
			}

		}

		// Cut a little bit out of the substring
		$result = substr($substring, 0, $substringLength-($i-1)).$subject;

	}

	return $result;
}



/**
* Check if string starts with a specific substring
*
* @param $subject
*	...
*
* @param $prefix
*	...
*
* @param $caseInsensitive
*	Use case-insensitive comparison.
*
* @return
*	TRUE if $subject starts with $prefix, FALSE otherwise. Empty prefix always returns true.
*/
function starts_with ($subject, $prefix, $caseInsensitive = false) {
	$result = false;

	// Need these for parsing
	$prefixLength = mb_strlen($prefix);
	$subjectLength = mb_strlen($subject);

	// Empty substring is always true
	if (!$prefixLength) {
		$result = true;

	// Prefix can't be bigger than subject
	} else if ($subjectLength >= $prefixLength) {

		// Part of subject to compare prefix to
		$cutout = mb_substr($subject, 0, $prefixLength);
		$comparison = $prefix;

		// Case-insensitive comparison
		if ($caseInsensitive) {
			$cutout = mb_strtolower($cutout);
			$comparison = mb_strtolower($comparison);
		}

		// Compare
		if ($cutout === $comparison) {
			$result = true;
		}

	}

	return $result;
}



/**
* Convert a string to camelCase 
*
* @param $subject
*	String to convert into camelcase.
*
* @param $preserveUpperCase
*	When se to true, all existing uppercase characters are left untouched, including the first character of the string. Normally consecutive uppercase letters are downcased and the result string always begins with a lowercase letter.
*
* @return
*	A string with no spaces, dashes or underscores. Each word in the subject string now begins with a capitalized letter.
*/
function to_camelcase ($subject, $preserveUppercase = false) {

	// Treat dashes and underscores as spaces, disregard whitespace at ends
	$result = trim(str_replace(array('-', '_'), ' ', $subject));

	if (!empty($result)) {

		// Disregard existing consecutive caps
		if (!$preserveUppercase) {
			$result = preg_replace_callback('/[A-Z][A-Z]+/u', create_function('$matches', 'return mb_strtolower($matches[0]);'), $result);

			// Start with a lowercase letter
			$result = mb_strtolower(mb_substr($result, 0, 1)).mb_substr($result, 1);
		}

		// Uppercase all words, remove spaces
		$result = str_replace(' ', '', preg_replace_callback('/ (.?)/u', create_function('$matches', 'return mb_strtoupper($matches[0]);'), $result));
	}

	return $result;
}

?>