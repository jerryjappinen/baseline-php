<?php

/**
* A page
*
* FLAG
*   - Could be made looser (no template needed, no parent needed)
*	- node, page and category could probably be fused into one node class
*
* DEPENDENCIES
*   ???
*/
class ServantPage extends ServantNode {

	/**
	* Properties
	*/
	protected $propertyEndpoint 	= null;
	protected $propertyOutput 		= null;
	protected $propertyPath 		= null;
	protected $propertyScripts 		= null;
	protected $propertyStylesheets 	= null;
	protected $propertyType 		= null;



	/**
	* Convenience
	*/

	public function category () {
		return false;
	}

	public function children () {
		return array();
	}

	public function home () {
		$home = false;

		// If this page is first of its siblings
		if ($this->index() === 0) {

			$home = true;
			foreach ($this->parents() as $parent) {
				if ($parent->index() > 0) {
					$home = false;
					break;
				}
			}

		}

		return $home;
	}

	public function page () {
		return true;
	}

	public function pick () {
		return $this;
	}



	/**
	* Template path is needed upon initialization
	*/
	public function initialize ($path, $parent, $id = null) {
		$this->setParent($parent)->setPath($path);

		// Custom ID
		if ($id) {
			$this->setId($id);
		}

		return $this;
	}



	/**
	* Getter-setters
	*/

	public function output () {
		$arguments = func_get_args();
		return $this->getOrSet('output', $arguments);
	}



	/**
	* Path-style getters
	*/

	public function endpoint ($format = false) {
		$path = $this->getAndSet('endpoint');
		if ($format) {
			$path = $this->servant()->paths()->format($path, $format);
		}
		return $path;
	}

	public function path ($format = false) {
		$path = $this->getAndSet('path');
		if ($format) {
			$path = $this->servant()->paths()->format($path, $format);
		}
		return $path;
	}

	public function scripts ($format = false) {
		$files = $this->getAndSet('scripts');
		if ($format) {
			foreach ($files as $key => $filepath) {
				$files[$key] = $this->servant()->paths()->format($filepath, $format);
			}
		}
		return $files;
	}

	public function stylesheets ($format = false) {
		$files = $this->getAndSet('stylesheets');
		if ($format) {
			foreach ($files as $key => $filepath) {
				$files[$key] = $this->servant()->paths()->format($filepath, $format);
			}
		}
		return $files;
	}



	/**
	* Setters
	*/

	// Path to this page in read action
	protected function setEndpoint () {
		$action = $this->servant()->settings()->actions('read');
		return $this->set('endpoint', $this->servant()->paths()->endpoint($action, 'plain', $this->tree()));
	}

	protected function setId ($input = null) {

		// Allow overriding auto set
		if (is_string($input)) {
			$input = trim_whitespace($input);
			if (!empty($input)) {
				$id = $input;
			}
		}

		// Default
		if (!isset($id)) {
			$id = pathinfo($this->path(), PATHINFO_FILENAME);
		}

		return $this->set('id', $id);
	}

	// Template content as a string
	protected function setOutput () {

		// Read content from source file
		$fileContent = $this->servant()->files()->read($this->path('server'), array(
			'servant' => $this->servant(),
			'page' => $this,
		));

		// Save file content
		return $this->set('output', $fileContent);
	}

	// Path to the template file
	protected function setPath ($path) {

		// Template file must exist
		if (!is_file($this->servant()->paths()->format($path, 'server'))) {
			$this->fail('Non-existing template file given to page ("'.$path.'").');
		}

		return $this->set('path', $path);
	}

	// Paths to script files under pages, relevant to this page
	protected function setScripts () {
		return $this->set('scripts', $this->filterPageFiles('scripts'));
	}

	// Paths to stylesheet files under pages, relevant to this page
	protected function setStylesheets () {
		return $this->set('stylesheets', $this->filterPageFiles('stylesheets'));
	}

	// Template file type
	protected function setType () {
		return $this->set('type', pathinfo($this->path(), PATHINFO_EXTENSION));
	}



	/**
	* Private helpers
	*/

	/**
	* Select the files under pages that are relevant for this page (i.e. stylesheets or scripts in parent folders)
	*/
	private function filterPageFiles ($formatType) {

		// Origin directories
		$pagesDir = $this->servant()->paths()->pages('server');
		$dirs = array_filter(explode('/', unprefix(dirname($this->path('server')).'/', $pagesDir)));
		array_unshift($dirs, '');

		// Compose paths for valid parent directories
		for ($i = 1; $i < count($dirs); $i++) { 
			$dirs[$i] = $dirs[$i-1].$dirs[$i].'/';
		}
		unset($i);

		// List files in the directories
		$files = array();
		foreach ($dirs as $dir) {
			$dir = $pagesDir.$dir;
			foreach (glob_files($dir, $this->servant()->settings()->formats($formatType)) as $file) {
				$files[] = $this->servant()->paths()->format($file, false, 'server');
			}
		}

		return $files;
	}

}

?>