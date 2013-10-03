<?php

class ServantTemplate extends ServantObject {

	/**
	* Properties
	*/
	protected $propertyFiles 	= null;
	protected $propertyContent 	= null;
	protected $propertyOutput 	= null;
	protected $propertyPath 	= null;



	/**
	* Public getters
	*/

	/**
	* This gives content to a template as a convenience
	*/
	public function content () {
		$arguments = func_get_args();
		return call_user_func_array(array($this->servant()->action(), 'output'), $arguments);
	}

	/**
	* Files can be fetched with their paths in any format
	*/
	public function files ($format = false) {
		$files = $this->getAndSet('files');
		if ($format) {
			foreach ($files as $key => $filepath) {
				$files[$key] = $this->servant()->format()->path($filepath, $format);
			}
		}
		return $files;
	}

	/**
	* Paths can be fetched in any format
	*/
	public function path ($format = false) {
		$path = $this->getAndSet('path');
		if ($format) {
			$path = $this->servant()->format()->path($path, $format);
		}
		return $path;
	}



	/**
	* Setters
	*/

	/**
	* All files of the template
	*/
	protected function setFiles () {
		$files = array();

		// All template files in directory
		foreach (rglob_files($this->path('server'), $this->servant()->settings()->formats('templates')) as $file) {

			// Store each file's path to plain format
			$files[] = $this->servant()->format()->path($file, false, 'server');

		}

		return $this->set('files', $files);
	}



	/**
	* Full output
	*/
	protected function setOutput () {
		$result = '';
		foreach ($this->files('server') as $path) {
			$result .= $this->servant()->files()->read($path);
		}
		return $this->set('output', $result);
	}



	/**
	* Template is either a file or a folder within the templates directory
	*/
	protected function setPath () {
		return $this->set('path', $this->servant()->paths()->template('plain'));
	}

}

?>