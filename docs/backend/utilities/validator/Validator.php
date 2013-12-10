<?php

/**
* Validate.php
*
* Released under MIT License
* Authored by Jerry Jäppinen
* http://eiskis.net/
* eiskis@gmail.com
*
* Compiled from source on 2013-12-05 21:30 UTC
*
* DEPENDENCIES
*
* baseline.php (included)
*   - http://eiskis.net/baseline-php/
*/



/**
* Main object for accessing validators
*/
class Validator {

	/**
	* Available items
	*/

	// Can I automate this?
	private $availableList = array(
		'string',
			'base64',
			'fulltext',
			'oneliner',
			'id',
		'hash',
			'flathash',
			'queue',
	);

	// List available routines, or check if a specific one is available
	public function available ($routine = null) {
		$list = $this->availableList;
		if ($routine) {
			return in_array($routine, $list);
		}
		return $list;
	}



	/**
	* Interface
	*
	* We expect users to call a validation routine by default
	*/
	public function __call ($routine, $arguments) {
		if ($this->available($routine)) {
			array_unshift($arguments, $routine);
			return call_user_func_array(array($this, 'validate'), $arguments);
		} else {
			throw new Exception('Unavailable');
			
		}
	}



	/**
	* Core behavior
	*/

	// See if will validate
	private function passes ($targetFormat, $input) {
		return $this->validate($targetFormat, $input) !== null;
	}

	// Run all behaviors to see if an input value passes the tests or passes back null
	private function validate ($targetFormat, $input) {
		return $this->createRoutine($targetFormat)->validate($input);
	}



	/**
	* Private helpers
	*/

	// Create a new routine object
	private function createRoutine ($targetFormat) {
		$className = $targetFormat.'ValidatorRoutine';

		// Make sure the routine is available
		if ($this->available($targetFormat) and class_exists($className)) {
			$object = new $className($this);
			if (is_subclass_of($object, 'ValidatorRoutine')) {
				$result = $object;
			}
		}

		// Throw exception if it doesn't
		if (!isset($result)) {
			fail('No validator routine available for "'.$targetFormat.'"');
		}

		return $result;
	}



}



/**
* Basics for all validator routines
*/
class ValidatorRoutine {



	/**
	* Constructor
	*/

	public function __construct () {
		return $this;
	}



	/**
	* Validation cycle
	*
	* NOTE
	*
	* null is never valid input. Upon any invalid input, null is always returned.
	*/
	public function validate ($input) {
		$result = null;

		// NULL is never valid input
		if ($input !== null) {

			// Normalize type
			$input = $this->normalizeType($input);

			// Proceed if input is acceptable after normalization
			if ($input !== null and $this->validType($input)) {

				// Sanitize input
				$input = $this->sanitizeInput($input);

				// Final smoke test
				if ($this->validInput($input)) {
					$result = $input;
				}

			}

		}

		return $result;
	}



	/**
	* Type normalization
	*
	* Input can be converted to another, acceptable type if needed. Returns type-normalized input.
	*/
	protected function normalizeType ($input) {
		return $input;
	}

	/**
	* This should fail (return false) if type is unacceptable. Optional for each routine.
	*/
	protected function validType ($input) {
		return true;
	}

	/**
	* Sanitation. Returns sanitized input.
	*/
	protected function sanitizeInput ($input) {
		return $input;
	}

	/**
	* Final validation and smoke test. This should fail (return false) if content is unacceptable. Optional for each routine.
	*/
	protected function validInput ($input) {
		return true;
	}



}



/**
* Hashes (arrays)
*
* RESULT
* 	Type: Array
*/
class HashValidatorRoutine extends ValidatorRoutine {



	/**
	* Turn input into array if it makes sense
	*/
	protected function normalizeType ($input) {

		if (is_string($input)) {

			// Parse as JSON
			// FLAG Validator should include JSON with normalizations
			$temp = json_decode(suffix(prefix($input, '{'), '}'));
			if (is_array($temp)) {
				$input = $temp;

			// Comma-separated list
			} else {
				$input = $this->parseStringIntoArray($input);
			}


		// Last resort
		} else {
			$input = to_array($input);
		}

		return $input;
	}



	/**
	* Must be array
	*/
	protected function validType ($input) {
		return is_array($input);
	}



	/**
	* Decodes a string into an array (probably from GET)
	*
	* NOTE
	*   - takes in JSON or "key:value,anotherKey:value;nextSetOfValues;lastSetA,lastSetB"
	*/
	private function parseStringIntoArray ($input) {
		$input = trim($input);
		$result = array();

		// Iterate through all the values/key-value pairs
		foreach (explode(';', $input) as $key => $value) {

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

}



/**
* Strings
*
* RESULT
* 	Type: String
*/
class StringValidatorRoutine extends ValidatorRoutine {



	/**
	* Turn input into string if it makes sense
	*/
	protected function normalizeType ($input) {
		$result = null;

		// Strings
		if (is_string($input)) {
			$result = $input;

		// Numbers
		} else if (is_numeric($input)) {
			$result = ''.$input;

		// Booleans
		} else if (is_bool($input)) {
			$result = $input ? 'True': 'False';
		}

		return $result;
	}



	/**
	* Must be string
	*/
	protected function validType ($input) {
		return is_string($input);
	}



}



/**
* Flat hashes (arrays)
*
* RESULT
* 	Type: Array
*   Stripped: Child arrays
*/
class FlathashValidatorRoutine extends HashValidatorRoutine {



	/**
	* Children are normalized
	*/
	protected function sanitizeInput ($input) {
		return array_flatten($input, false, true);
	}



}



/**
* Lists (flat, indexed arrays)
*
* RESULT
* 	Type: Array
*   Stripped: Child arrays, keys
*/
class QueueValidatorRoutine extends HashValidatorRoutine {



	/**
	* Children are normalized, keys are removed
	*/
	protected function sanitizeInput ($input) {
		return array_flatten($input);
	}



}



/**
* Base64-formatted string (extend Strings)
*
* RESULT
* 	Type: String
* 	Stripped: newlines, excess whitespace
*/
class Base64ValidatorRoutine extends StringValidatorRoutine {



	/**
	* Trim whitespace and linebreaks
	*/
	protected function sanitizeInput ($input) {
		return preg_replace('/\s+/', '', $input);
	}



	/**
	* Must be Base64-compatible
	*/
	protected function validInput ($input) {
		return base64_decode($input, true) === false ? false : true;
	}


}



/**
* Fulltext (extend Strings)
*
* RESULT
* 	Type: String
* 	Stripped: excess whitespace
*/
class FulltextValidatorRoutine extends StringValidatorRoutine {



	/**
	* Trim whitespace
	*/
	protected function sanitizeInput ($input) {
		return trim_text($input);
	}



}



/**
* ID (extend Strings)
*
* RESULT
* 	Type: String
* 	Stripped: all whitespace
*/
class IdValidatorRoutine extends StringValidatorRoutine {



	/**
	* Trim all whitespace
	*/
	protected function sanitizeInput ($input) {
		return trim_whitespace($input);
	}



}



/**
* One-liner (extend Strings)
*
* RESULT
* 	Type: String
* 	Stripped: newlines, excess whitespace
*/
class OnelinerValidatorRoutine extends StringValidatorRoutine {



	/**
	* Trim whitespace and linebreaks
	*/
	protected function sanitizeInput ($input) {
		return trim_text($input, true);
	}



}

?>