<?php

class ServantSite extends ServantObject {

	/**
	* Properties
	*/
	protected $propertyIcon 		= null;
	protected $propertyLanguage 	= null;
	protected $propertyName 		= null;
	protected $propertyPageNames 	= null;



	/**
	* Take original settings in during initialization (all are optional)
	*/
	public function initialize () {

		// Read settings from JSON
		$manifest = $this->readJsonFile($this->servant()->paths()->manifest('server'));
		if ($manifest) {

			// This is what we can set
			$properties = array(
				'icon',
				'language',
				'name',
				'pageNames',
			);

			// Run setters if values are given
			foreach ($properties as $key) {
				$parameters = array();
				if (isset($manifest[$key]) and !empty($manifest[$key])) {
					$parameters[] = $manifest[$key];
					$this->callSetter($key, $parameters);
				}
			}

		}

		return $this;
	}



	/**
	* Public getters
	*/

	public function icon ($format = null) {
		$icon = $this->getAndSet('icon');
		if ($format and !empty($icon)) {
			$icon = $this->servant()->format()->path($icon, $format);
		}
		return $icon;
	}



	/**
	* Setters
	*/

	/**
	* Path to site icon comes from settings or remains an empty string
	*/
	protected function setIcon ($input = null) {
		$result = '';

		// A string will do
		if ($input and is_string($input)) {

			// Sanitize input
			$path = unprefix(unsuffix(trim_text($input, true), '/'), '/');

			// File format must be acceptable
			$extension = pathinfo($path, PATHINFO_EXTENSION);
			if (in_array($extension, $this->servant()->settings()->formats('iconImages'))) {

				// File must exist
				if (is_file($this->servant()->format()->path($path, 'server'))) {
					$result = $path;
				}

			}

		}

		return $this->set('icon', $result);
	}

	/**
	* Language
	*
	* FLAG
	*   - Hardcoded default
	*   - Should this be a list of supported languages in order of preference?
	*/
	protected function setLanguage ($input = null) {
		$result = 'en';

		// Language from site settings
		if ($input and is_string($input)) {
			$result = $input;

		// Global default
		} else {
			$globalDefault = $this->servant()->settings()->defaults('language');
			if ($globalDefault and is_string($globalDefault)) {
				$result = $globalDefault;
			}
		}

		return $this->set('language', trim_text($result, true));
	}

	/**
	* Name comes from settings or is created from ID
	*
	* FLAG
	*   - Hardcoded default name
	*/
	protected function setName ($input = null) {
		$result = 'Home';

		// A string will do
		if ($input and is_string($input)) {
			$result = $input;
		}

		return $this->set('name', trim_text($result, true));
	}

	/**
	* Overrides for page naming
	*/
	protected function setPageNames ($input = null) {
		$pageNames = array();

		// A flat array will do
		if ($input and is_array($input)) {
			$pageNames = array_flatten($input, false, true);
		}

		return $this->set('pageNames', $pageNames);
	}



	/**
	* Private helpers
	*/

	private function readJsonFile ($path) {
		$result = array();

		// Look for a settings file
		if (is_file($path)) {

			// Read settings file as JSON, turn into an array
			$temp = json_decode(suffix(prefix(trim(file_get_contents($path)), '{'), '}'), true);
			if (is_array($temp)) {
				$result = $temp;
			}
			unset($temp);

		}

		return $result;
	}

}

?>