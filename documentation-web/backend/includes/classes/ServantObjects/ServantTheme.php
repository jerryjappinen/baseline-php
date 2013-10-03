<?php

class ServantTheme extends ServantObject {

	/**
	* Properties
	*/
	protected $propertyIcon			= null;
	protected $propertyPath 		= null;
	protected $propertyScripts 		= null;
	protected $propertyStylesheets 	= null;



	/**
	* Public getters for paths
	*/

	public function icon ($format = null) {
		$icon = $this->getAndSet('icon');
		if ($format and !empty($icon)) {
			$icon = $this->servant()->format()->path($icon, $format);
		}
		return $icon;
	}

	public function path ($format = false) {
		$path = $this->getAndSet('path');
		if ($format) {
			$path = $this->servant()->format()->path($path, $format);
		}
		return $path;
	}

	public function scripts ($format = false) {
		$files = $this->getAndSet('scripts');
		if ($format) {
			foreach ($files as $key => $filepath) {
				$files[$key] = $this->servant()->format()->path($filepath, $format);
			}
		}
		return $files;
	}

	public function stylesheets ($format = false) {
		$files = $this->getAndSet('stylesheets');
		if ($format) {
			foreach ($files as $key => $filepath) {
				$files[$key] = $this->servant()->format()->path($filepath, $format);
			}
		}
		return $files;
	}



	/**
	* Setters
	*/

	/**
	* Path to theme's fallback site icon
	*/
	protected function setIcon () {
		$result = '';

		// Look for an icon image file in theme package
		foreach (rglob_files($this->path('server'), $this->servant()->settings()->formats('iconImages')) as $path) {
			$result = $this->servant()->format()->path($path, 'plain', 'server');
			break;
		}

		return $this->set('icon', $result);
	}

	/**
	* Theme is a folder under the themes directory
	*/
	protected function setPath () {
		return $this->set('path', $this->servant()->paths()->theme());
	}

	/**
	* Stylesheet files
	*/
	protected function setStylesheets () {
		return $this->set('stylesheets', $this->findFiles($this->servant()->settings()->formats('stylesheets')));
	}

	/**
	* Script files
	*/
	protected function setScripts () {
		return $this->set('scripts', $this->findFiles($this->servant()->settings()->formats('scripts')));
	}



	/**
	* Private helpers
	*/

	private function findFiles ($formats) {
		$files = array();

		// All files of this type in theme's directory
		foreach (rglob_files($this->path('server'), $formats) as $file) {
			$files[] = $this->servant()->format()->path($file, false, 'server');
		}

		return $files;
	}



}

?>