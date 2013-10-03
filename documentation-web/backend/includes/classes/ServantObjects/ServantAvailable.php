<?php

/**
* FLAG Only utilities and actions are used - remove this class
*/
class ServantAvailable extends ServantObject {

	/**
	* Properties
	*/
	protected $propertyActions 		= null;
	protected $propertyPages 		= null;
	protected $propertyUtilities 	= null;



	/**
	* Public getters
	*/

	/**
	* Pages are dependent on current site
	*/
	public function page () {
		$arguments = func_get_args();
		return $this->assert('pages', $arguments);
	}
	public function pages () {
		$arguments = func_get_args();
		return call_user_func_array(array($this->servant()->site(), 'pages'), $arguments);
	}

	/**
	* Others have extra assertion methods
	*/
	public function action ($id) {
		return in_array($id, $this->actions());
	}
	public function utility ($id) {
		return in_array($id, $this->utilities());
	}



	/**
	* Setters
	*/

	protected function setActions () {
		return $this->set('actions', array_merge($this->findFiles('actions', 'php'), $this->findDirectories('actions')));
	}

	/**
	* Utilities
	*
	* Script files or directories
	*/
	protected function setUtilities () {
		return $this->set('utilities', array_merge($this->findFiles('utilities', 'php'), $this->findDirectories('utilities')));
	}



	/**
	* Private helpers
	*/

	private function findFiles ($dir, $types) {
		$items = array();
		$files = glob_files($this->servant()->paths()->$dir('server'), $types);
		foreach ($files as $path) {
			$items[] = pathinfo($path, PATHINFO_FILENAME);
		}
		return $items;
	}

	/**
	* Find directories with at least one supported file
	*
	* FLAG
	*   - This is pretty slow. We basically go through all files in all template and theme directories.
	*/
	private function findDirectories ($dir, $formats = array()) {
		$items = array();
		$dirs = glob_dir($this->servant()->paths()->$dir('server'));
		foreach ($dirs as $path) {
			$files = rglob_files($path, $formats);
			if (!empty($files)) {
				$items[] = basename($path);
			}
			unset($files);
		}
		return $items;
	}

}

?>