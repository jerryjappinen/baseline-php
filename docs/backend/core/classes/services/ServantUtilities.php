<?php

/**
* Utility service
*
* External software packages, called anywhere in the program.
*
* DEPENDENCIES
*   ServantFormat	-> path
*   ServantPaths	-> utilities
*/
class ServantUtilities extends ServantObject {

	/**
	* Properties
	*/
	protected $propertyLoaded = array();



	/**
	* Load a (new) utility
	*/
	public function load () {
		$arguments = func_get_args();
		$arguments = array_flatten($arguments);

		// Load utilities
		foreach ($arguments as $id) {
			$this->loadUtility($id);
		}

		return $this;
	}



	/**
	* Public getters
	*/

	/**
	* Loaded
	*/
	public function loaded ($name = null) {

		// Check for a specific utility
		if (!empty($name)) {

			// Use myself to get all loaded utilities
			if (array_search($name, $this->loaded()) === false) {
				return false;
			} else {
				return true;
			}

		// Normal getting
		} else {
			return $this->getAndSet('loaded');
		}

	}



	/**
	* Private helpers
	*/

	/**
	* List of utilities that have been loaded
	*/
	private function loadUtility ($id) {
		$path = suffix($this->servant()->paths()->utilities('server').$id, '/');

		// Utility could already be loaded
		if (!$this->loaded($id)) {

			// Include files if utility is available
			if ($this->servant()->available($id)) {
				$files = rglob_files($path, 'php');
				foreach ($files as $file) {
					require_once $file;
				}
				$this->markLoaded($id);

			// Not found
			} else {
				$this->fail($id.' utility is not available.');
			}

		}

		return $this;
	}

	/**
	* List of utilities that have been loaded
	*/
	private function markLoaded () {
		$arguments = func_get_args();
		$arguments = array_flatten($arguments);

		// Starting point
		$current = $this->get('loaded');
		if ($current === null) {
			$current = array();
		}

		return $this->set('loaded', array_merge($current, $arguments));
	}

}

?>