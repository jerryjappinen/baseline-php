<?php

/**
* Baseline PHP 0.1
*
* Released under LGPL
* Authored by Jerry Jäppinen
* http://eiskis.net/
* eiskis@gmail.com
*
* Compiled from source on 2013-04-06 22:15
*/

/**
* Flatten an array, either keeping or discarding content of child arrays.
*
* @param $array
*	...
*
* @param $removeChildren
*	...
*
* @param $preserveKeys
*	...
*
* @return
*	...
*/
function array_flatten (array $array, $removeChildren = false, $preserveKeys = false) {
	$result = array();
	foreach ($array as $key => $value) {

		// Value isn't child array
		if (!is_array($value)) {

			// Preseve keys if possible
			if ($preserveKeys) {
				if (!isset($result[$key])) {
					$result[$key] = $value;
				}

			// Ditch keys
			} else {
				$result[] = $value;
			}

		// Flatten child arrays if they're kept
		} else if (!$removeChildren) {
			$result = array_merge($result, array_flatten($value, $removeChildren, $preserveKeys));
		}
	}
	return $result;
}



/**
* Traverse a a multidimensional array based on given keys.
*
* I.e. $subject[ $keys[0] ][ $keys[1] ] ...
*
* @param $subject
*	...
*
* @param $keys
*	...
*
* @return
*	...
*/
function array_traverse (array $subject, $keys = array()) {

	// Accept keys as a single array or multiple independent values
	$arguments = func_get_args();
	array_shift($arguments);
	$keys = array_flatten($arguments);

	// Need to traverse tree
	if (isset($keys[0])) {

		// Exists
		if (array_key_exists($keys[0], $subject)) {

			// This will be the last, no need to iterate
			if (!isset($keys[1])) {
				return $subject[$keys[0]];

			// Going deeper
			} else {
				$newTree = $keys;
				array_shift($newTree);
				return array_traverse($subject[$keys[0]], $newTree);
			}

		// Doesn't exist
		} else {
			return null;
		}

	// We got what we came for
	} else {
		return $subject;
	}

}



/**
* Allow giving a different last glue for implode
*
* @param $glue
*	...
*
* @param $pieces
*	...
*
* @param $lastGlue
*	...
*
* @return
*	...
*/
function limplode ($glue = '', $pieces = array(), $lastGlue = false) {

	// Allow giving glue and array in reverse order, like implode() does
	if (is_array($glue)) {
		$realGlue = $pieces;
		$realArray = $glue;
	} else {
		$realGlue = $glue;
		$realArray = $pieces;
	}

	$count = count($realArray);

	// Return implode() if last glue is missing or we have no use for last glue
	if (!$lastGlue or $count < 3 or $lastGlue === $glue) {
		return implode($glue, $pieces);

	// Last glue was given
	} else {

		$temp = $realArray;
		$lastItem = array_pop($temp);

		// Implode array without last item
		return implode($realGlue, $temp).$lastGlue.$lastItem;

	}

}



/**
* Make sure value is array, convert if needed
*
* @param $value
*	...
*
* @return
*	An array, with the value of $value if possible.
*/
function to_array ($value) {

	// Already an array
	if (is_array($value)) {
		$result = $value;

	// Object
	} else if (is_object($value)) {

		// Convert to array
		$value = (array) $value;
		
		if (is_array($value)) {

			// Convert children
			$result = array();
			foreach($value as $key => $value) {
				if (is_object($value)) {
					$result[$key] = to_array($value);
				} else {
					$result[$key] = $value;
				}
			}

		} else {
			$result = to_array($value);
		}

  	// Default
	} else {
		$result = array($value);
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

		// Falsy
		!$value or

		// Empty
		empty($value) or

		// Zero or less
		(is_numeric($value) and strval($value) <= 0) or

		// Keyword
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
* @param (any number of parameters)
*	Any objects or values to be passed to dump()
*
* @return
*	No return value.
*/
function debug () {
	$arguments = func_get_args();
	$displayErrors = ini_get('display_errors');
	ini_set('display_errors', '0');
	error_log("\n\n\n".call_user_func_array('dump', $arguments), 0)."\n\n";
	ini_set('display_errors', $displayErrors);
}



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



/**
* dump() objects or values into HTML.
*
* @param (any number of parameters)
*	Any objects or values to be passed to dump()
*
* @return
*	dump()'d $value wrapped in <pre>, ready to be used in HTML
*/
function html_dump () {
	$arguments = func_get_args();
	return '<pre>'.call_user_func_array('dump', $arguments).'</pre>';
}



/**
* Shorthand error throwing
*
* @param $message
*	...
*
* @param $code
*	...
*
* @return
*	...
*/
function fail ($message, $code = null) {
	throw new Exception($message, isset($code) ? $code : 500);
}



/**
* Move directory
*
* @param $path
*	...
*
* @param $newLocation
*	...
*
* @return
*	...
*/
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




/**
* Move one file
*
* @param $path
*	...
*
* @param $newLocation
*	...
*
* @return
*	...
*/
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




/**
* Remove a complete directory, including its contents
*
* @param $path
*	...
*
* @return
*	...
*/
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




/**
* Remove one file
*
* @param $path
*	...
*
* @return
*	...
*/
function remove_file ($path) {
	if (is_file($path)) {
		unlink($path);
		return true;
	}
	return false;
}



/**
* List all directories within a path.
*
* @param $path
*	...
*
* @return
*	...
*/
function glob_dir ($path = '') {
	$directories = glob(end_with($path, '/').'*', GLOB_MARK | GLOB_ONLYDIR);
	foreach ($directories as $key => $value) {
		$directories[$key] = str_replace('\\', '/', $value);
	}
	natcasesort($directories);
	return $directories;
}



/**
* List files on the first level of a directory.
*
* @param $path
*	...
*
* @param $filetypes
*	...
*
* @return
*	...
*/
function glob_files ($path = '', $filetypes = array()) {
	$result = array();

	// Accept file type restrictions as a single array or multiple independent values
	$arguments = func_get_args();
	array_shift($arguments);
	$filetypes = array_flatten($arguments);

	// Handle filetype input
	if (empty($filetypes)) {
		$brace = '';
	} else {
		$brace = '.{'.implode(',', $filetypes).'}';
	}

	// Handle path input
	if (!empty($path)) {
		$path = end_with($path, '/');
	}

	// Do the glob()
	foreach (glob($path.'*'.$brace, GLOB_BRACE) as $value) {
		if (is_file($value)) {
			$result[] = $value;
		}
	}

	// Sort results properly
	natcasesort($result);

	return $result;
}



/**
* Search for stuff recursively
*
* @param $path
*	...
*
* @param $pattern
*	...
*
* @param $flags
*	...
*
* @return
*	...
*/
function rglob ($path = '', $pattern = '*', $flags = 0) {
	$directories = glob_dir($path);
	$files = glob(end_with($path, '/').$pattern, $flags);
	
	foreach ($directories as $path) {
		$files = array_merge($files, rglob($path, $pattern, $flags));
	}

	return $files;
}



/**
* List all directories within a path, recursively.
*
* @param $path
*	...
*
* @return
*	...
*/
function rglob_dir ($path = '') {
	$directories = glob_dir($path);
	foreach ($directories as $path) {
		$directories = array_merge($directories, rglob_dir($path));
	}
	return $directories;
}



/**
* List all files in a directory, recursively.
*
* @param $path
*	...
*
* @param $filetypes
*	...
*
* @return
*	...
*/
function rglob_files ($path = '', $filetypes = array()) {

	// Accept file type restrictions as a single array or multiple independent values
	$arguments = func_get_args();
	array_shift($arguments);
	$filetypes = array_flatten($arguments);

	// Run glob_files for this directory and its subdirectories
	$files = glob_files($path, $filetypes);
	foreach (glob_dir($path) as $child) {
		$files = array_merge($files, rglob_files($child, $filetypes));
	}

	return $files;
}



/**
* Create a new object
*
* @param $object
*	...
*
* @return
*	...
*/
function create ($object) {
	return $object;
}



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
function calculate ($formula, $forceInteger = false) {
	$result = trim(preg_replace('/[^0-9\+\-\*\.\/\(\) ]/i', '', $formula));
	$compute = create_function('', 'return ('.(empty($result) ? 0 : $result).');');
	$result = 0 + $compute();
	return $forceInteger ? intval($result) : $result;
}



/**
* Trim excess whitespaces, empty lines etc. from a string.
*
* @param $subject
*	...
*
* @return
*	...
*/
function trim_text ($subject) {
	if (is_string($subject)) {
		return preg_replace('/[ \t]+/', ' ', preg_replace('/\s*$^\s*/m', "\n\n", trim($subject)));
	} else {
		return $subject;
	}
}



/**
* Turn camelCase into regular text.
*
* @param $string
*	...
*
* @return
*	...
*/
function from_camelcase ($string) {
	return trim(mb_strtolower(preg_replace('/(?!\ )([^A-Z])([A-Z])/', '$1 $2', $string))); 
}



/**
* Convert a string to camelCase.
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



/**
* Make sure final characters of a string are NOT what they shouldn't to be.
*
* @param $subject
*	...
*
* @param $suffix
*	...
*
* @param $caseInsensitive
*	...
*
* @return
*	The contents $subject, guaranteed to not end with $suffix
*/
function dont_end_with ($subject, $suffix = '', $caseInsensitive = false) {

	// No need to do anything
	if (empty($suffix) or !suffixed($subject, $suffix, $caseInsensitive) or !ends_with($subject, $suffix, $caseInsensitive)) {
		$result = $subject;

	} else {

		// Need these for comparison
		$suffixLength = mb_strlen($suffix);
		$subjectLength = mb_strlen($subject);

		// Separate items for comparison we can play with
		$comparisonSubject = $subject;
		$comparisonSuffix = $suffix;

		// Prepare subject and suffix for comparison
		if ($caseInsensitive) {
			$comparisonSubject = mb_strtolower($comparisonSubject);
			$comparisonSuffix = mb_strtolower($comparisonSuffix);
		}

		// Iterate through substrings of suffix to see which part might be included
		for ($i = $suffixLength; $i > 0 and $suffixLength-$i <= $subjectLength; $i--) {

			// Compare latter part of subject to beginning of suffix
			if (mb_substr($comparisonSubject, -$i) === mb_substr($comparisonSuffix, 0, $i)) {
				break;
			}

		}

		// Cut a little bit out of the subject
		$result = mb_substr($subject, 0, $subjectLength-$i);

	}

	return $result;
}


















/**
* Make sure final characters of a string are what they need to be. Compares the last characters of $subject to $suffix's first characters and avoids duplicate substrings, unlike suffix().
*
* For example, end_with('www.domain.co', '.com') returns 'www.domain.com'. prefix() would return 'www.domain.co.com'.
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
*	The contents of $subject, guaranteed to end with $suffix.
*/
function end_with ($subject, $suffix = '', $caseInsensitive = false) {

	// No need to do anything
	if (empty($suffix) or suffixed($subject, $suffix, $caseInsensitive)) {
		$result = $subject;

	// Look for the part of suffix that's NOT already in the beginning of subject string
	} else {

		// Need these for comparison
		$suffixLength = mb_strlen($suffix);
		$subjectLength = mb_strlen($subject);

		// Separate items for comparison we can play with
		$comparisonSubject = $subject;
		$comparisonSuffix = $suffix;

		// Prepare subject and suffix for comparison
		if ($caseInsensitive) {
			$comparisonSubject = mb_strtolower($comparisonSubject);
			$comparisonSuffix = mb_strtolower($comparisonSuffix);
		}

		// Iterate through substrings of suffix to see which part might already be included
		for ($i = $suffixLength-1; $i > 0 and $suffixLength-$i <= $subjectLength; $i--) {

			// Compare latter part of subject to beginning of suffix
			if (mb_substr($comparisonSubject, -$i) === mb_substr($comparisonSuffix, 0, $i)) {
				break;
			}

		}

		// Cut a little bit out of the suffix
		$cut = $suffixLength-$i;
		$result = $subject.mb_substr($suffix, -$cut);

	}

	return $result;
}



/**
* Check if string ends with a specific suffix.
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
* Add a prefix to string if needed.
*
* @param $subject
*	...
*
* @param $prefix
*	...
*
* @param $caseInsensitive
*	Check if prefix exists using case-insensitive comparison.
*
* @return
*	A string that includes $prefix and $subject.
*/
function prefix ($subject, $prefix = '', $caseInsensitive = false) {
	$result = $subject;

	// Prefix if needed
	if (!empty($prefix) and !prefixed($subject, $prefix, $caseInsensitive)) {
		$result = $prefix.$subject;
	}

	return $result;
}



/**
* Check if a string has a prefix.
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
function prefixed ($subject, $prefix, $caseInsensitive = false) {
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
* Remove a part of a string from the beginning if it exists.
*
* @param $subject
*	...
*
* @param $prefix
*	...
*
* @param $caseInsensitive
*	...
*
* @return
*	The contents $subject, with $prefix removed if needed.
*/
function unprefix ($subject, $prefix = '', $caseInsensitive = false) {

	// No need to do anything
	if (empty($prefix) or !prefixed($subject, $prefix, $caseInsensitive)) {
		$result = $subject;

	// Cut the prefix out
	} else {
		$result = mb_substr($subject, mb_strlen($prefix));
	}

	return $result;
}



/**
* Make sure initial characters of a string are NOT what they shouldn't to be.
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
* Make sure initial characters of a string are what they need to be.
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
*	The contents of $subject, guaranteed to begin with $prefix.
*/
function start_with ($subject, $prefix = '', $caseInsensitive = false) {

	// No need to do anything
	if (empty($prefix) or prefixed($subject, $prefix, $caseInsensitive)) {
		$result = $subject;

	// Look for the part of prefix that's NOT already in the beginning of subject string
	} else {

		// Need these for comparison
		$prefixLength = mb_strlen($prefix);
		$subjectLength = mb_strlen($subject);

		// Separate items for comparison we can play with
		$comparisonSubject = $subject;
		$comparisonPrefix = $prefix;

		// Prepare subject and prefix for comparison
		if ($caseInsensitive) {
			$comparisonSubject = mb_strtolower($comparisonSubject);
			$comparisonPrefix = mb_strtolower($comparisonPrefix);
		}

		// Iterate through substrings of prefix to see which part might already be included
		for ($i = $prefixLength-1; $i > 0 and $prefixLength-$i <= $subjectLength; $i--) {

			// Compare latter part of prefix to beginning of subject
			if (mb_substr($comparisonPrefix, -$i) === mb_substr($comparisonSubject, 0, $i)) {
				break;
			}

		}

		// Cut a little bit out of the prefix
		$cut = $prefixLength-$i;
		$result = mb_substr($prefix, 0, $cut).$subject;

	}

	return $result;
}



/**
* Check if string starts with a specific substring.
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
* Add a suffix to string if needed.
*
* @param $subject
*	...
*
* @param $suffix
*	...
*
* @param $caseInsensitive
*	Check if suffix exists using case-insensitive comparison.
*
* @return
*	A string that includes $subject and $suffix.
*/
function suffix ($subject, $suffix = '', $caseInsensitive = false) {
	$result = $subject;

	// suffix if needed
	if (!empty($suffix) and !ends_with($subject, $suffix, $caseInsensitive)) {
		$result = $subject.$suffix;
	}

	return $result;
}



/**
* Check if a string has a suffix.
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
function suffixed ($subject, $suffix, $caseInsensitive = false) {
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
* Remove a part from the end of a string if it exists.
*
* @param $subject
*	...
*
* @param $suffix
*	...
*
* @param $caseInsensitive
*	...
*
* @return
*	The contents $subject, with $suffix removed if needed.
*/
function unsuffix ($subject, $suffix = '', $caseInsensitive = false) {

	// No need to do anything
	if (empty($suffix) or !ends_with($subject, $suffix, $caseInsensitive)) {
		$result = $subject;

	// Cut the suffix out
	} else {
		$result = mb_substr($subject, 0, -(mb_strlen($suffix)));
	}

	return $result;
}

?>