<?php

/**
* Settings service
*/
class ServantSettings extends ServantObject {

	/**
	* Properties
	*/
	protected $propertyActions 			= null;
	protected $propertyContentTypes 	= null;
	protected $propertyDefaults 		= null;
	protected $propertyFormats 			= null;
	protected $propertyNamingConvention = null;
	protected $propertyPatterns 		= null;
	protected $propertyStatuses 		= null;



	/**
	* Take original settings in during initialization (all are optional)
	*/
	public function initialize ($json = null) {
		$input = array();

		// Read input JSON, turn into an array
		if (is_string($json)) {
			$decode = json_decode(suffix(prefix(trim($json), '{'), '}'), true);
			if (is_array($decode)) {
				$input = $decode;
			}
			unset($decode);
		}

		// This is what we can set
		$properties = array(
			'actions',
			'contentTypes',
			'defaults',
			'formats',
			'namingConvention',
			'patterns',
			'statuses',
		);

		// Run setters if values are given
		if ($input and is_array($input)) {
			foreach ($properties as $key) {
				$setterParameters = array();
				if (isset($input[$key]) and !empty($input[$key])) {
					$setterParameters[] = to_array($input[$key]);
					$this->callSetter($key, $setterParameters);
				}
			}
		}

		return $this;
	}



	/**
	* Setters
	*/



	/**
	* Action names
	*/
	protected function setActions ($input = null) {

		// Base format
		$results = array(
			'read' => null,
			'error' => null,
		);

		// Pick values from input
		if ($input) {
			foreach ($results as $key => $null) {
				if (isset($input[$key]) and !(is_string($input[$key]) and empty($input[$key]))) {
					$results[$key] = is_numeric($input[$key]) ? $input[$key] : ''.$input[$key];
				}
			}
		}

		return $this->set('actions', $this->takeInFlattenedArray($input, false));
	}



	/**
	* Content types
	*/
	protected function setContentTypes ($input = null) {
		return $this->set('contentTypes', $this->takeInFlattenedArray($input, false));
	}



	/**
	* Default preferences for guiding how to choose between available items
	*
	* NOTE
	*   - Default items are not necessarily available in the system, they're just dumb preferences
	*/
	protected function setDefaults ($input = null) {

		// Base format
		$results = array(
			'action' => null,
			'browserCache' => null,
			'contentType' => null,
			'language' => null,
			'serverCache' => null,
			'status' => null,
			'template' => null,
		);

		// Pick values from input
		if ($input) {
			foreach ($results as $key => $null) {
				if (isset($input[$key])) {
					$results[$key] = is_numeric($input[$key]) ? $input[$key] : strval($input[$key]);
				}
			}
		}

		return $this->set('defaults', $results);
	}

	protected function setFormats ($input = null) {

		// Base format
		$results = array(
			'iconImages' => array(),
			'templates' => array(),
			'stylesheets' => array(),
			'scripts' => array(),
		);

		// Pick format arrays
		if ($input) {
			foreach ($results as $key => $value) {
				if (isset($input[$key])) {

					// iconImages is flattened
					// FLAG it should be with the rest of them
					if ($key === 'iconImages') {
						$results[$key] = array_flatten(to_array($input[$key]));

					// Others are multidimensional flattened
					} else if (is_array($input[$key])) {
						foreach ($input[$key] as $key2 => $value2) {
							$results[$key][$key2] = array_flatten(to_array($value2));
						}
					}

				}
			}
		}

		return $this->set('formats', $results);
	}

	protected function setNamingConvention ($input = null) {
		return $this->set('namingConvention', $this->takeInAssociativeArray($input));
	}

	protected function setPatterns ($input = null) {
		return $this->set('patterns', $this->takeInFlattenedArray($input, false));
	}

	protected function setStatuses ($input = null) {
		return $this->set('statuses', $this->takeInFlattenedArray($input, true));
	}



	/**
	* Private helpers
	*/

	private function takeInAssociativeArray ($input = null) {
		$results = array();
		if ($input) {
			$results = array_flatten(to_array($input), true, true);
		}
		return $results;
	}

	private function takeInFlattenedArray ($input = null, $numericalKeys = false) {
		$results = array();

		// Pick stuff from input
		if ($input and is_array($input)) {
			$input = array_flatten($input, true, true);
			foreach ($input as $key => $value) {

				// Accept string values with either numerical or integer keys
				if (is_string($value) and (($numericalKeys and is_numeric($key)) or (!$numericalKeys and is_string($key)))) {
					if ($numericalKeys) {
						$key = intval($key);
					}
					$results[$key] = $value;
				}

			}
		}

		return $results;
	}

}

?>