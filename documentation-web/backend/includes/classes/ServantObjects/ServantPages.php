<?php

/**
* Pages component
*
* FLAG
*   - add list() that returns flat lists of each level, with categories normalized into pages
*/
class ServantPages extends ServantObject {

	/**
	* Properties
	*/
	protected $propertyCurrent 		= null;
	protected $propertyTemplates 	= null;
	protected $propertyMap 			= null;
	protected $propertyPath 		= null;



	/**
	* Convenience
	*/

	public function level () {
		$pages = array();

		// Allow tree traversal
		$arguments = func_get_args();

		// Pick pages on this level
		foreach ($this->map(array_flatten($arguments)) as $id => $value) {

			// Normalize pages with children
			if (is_array($value)) {
				$subPages = $this->level($arguments, $id);
				$subPagesKeys = array_keys($subPages);
				$pages[] = $subPages[$subPagesKeys[0]];
			} else {
				$pages[] = $value;
			}

		}

		return $pages;
	}



	/**
	* Public getters
	*/

	// Getter returns page object (while tree is stored in the prameter)
	public function current () {
		return $this->map($this->getAndSet('current'));
	}

	public function path ($format = null) {
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
	* Tree of selected page
	*/
	protected function setCurrent () {

		// Select the page most closely matching user input
		$tree = $this->selectPage($this->map(), $this->servant()->input()->page());

		return $this->set('current', $tree);
	}

	/**
	* All available template templates that can be converted to pages, recursively and with paths
	*
	* FLAG legacy
	*/
	protected function setTemplates () {
		return $this->set('templates', $this->findPageFiles($this->path('server'), $this->servant()->settings()->formats('templates')));
	}

	/**
	* All available pages as page objects
	*
	* FLAG
	*   - I should create and init page only when they're actually called
	*/
	public function setMap () {
		return $this->set('map', $this->generatePageObjects($this->templates()));
	}

	/**
	* Path
	*/
	protected function setPath () {
		return $this->set('path', $this->servant()->paths()->pages('plain'));
	}



	/**
	* Private helpers
	**/



	/**
	* List available pages recursively
	*/
	private function findPageFiles ($path, $filetypes = array()) {
		$results = array();

		// Files on this level
		foreach (glob_files($path, $filetypes) as $file) {
			$results[pathinfo($file, PATHINFO_FILENAME)] = $this->servant()->format()->path($file, 'plain', 'server');
		}

		// Non-empty child directories
		foreach (glob_dir($path) as $subdir) {
			$value = $this->findPageFiles($subdir, $filetypes);
			if (!empty($value)) {

				// Represent arrays with only one item as pages
				// NOTE the directory name is used as the key, not the filename
				if (count($value) < 2) {
					$keys = array_keys($value);
					$value = $value[$keys[0]];
				}

				$results[pathinfo($subdir, PATHINFO_FILENAME)] = $value;
			}
		}

		// Mix sort directories and files
		uksort($results, 'strcasecmp');

		return $results;
	}



	/**
	* Create page tree with actual objects
	*/
	private function generatePageObjects ($fileMap = array(), $parents = array()) {
		$result = $fileMap;

		foreach ($result as $id => $value) {
			$tree = $parents;
			$tree[] = $id;

			// Convert to page object
			if (is_string($value)) {
				$result[$id] = create_object(new ServantPage($this->servant()))->init($this, $tree);

			// Children are treated recursively
			} else if (is_array($value)) {
				$result[$id] = $this->generatePageObjects($value, $tree);
			}

		}

		return $result;
	}



	/**
	* Choose one page from those available, preferring the one detailed in $tree
	*/
	private function selectPage ($pagesOnThisLevel, $tree, $level = 0) {
 
		// No preference or preferred item doesn't exist: auto select
		if (!isset($tree[$level]) or !array_key_exists($tree[$level], $pagesOnThisLevel)) {

			// Cut out the rest of the preferred items
			$tree = array_slice($tree, 0, $level);

			// Auto select first item on this level
			$keys = array_keys($pagesOnThisLevel);
			$tree[] = $keys[0];

		}

		// We need to go deeper
		if (is_array($pagesOnThisLevel[$tree[$level]])) {
			return $this->selectPage($pagesOnThisLevel[$tree[$level]], $tree, $level+1);

		// That was it
		} else {
			return array_slice($tree, 0, $level+1);
		}

	}

}

?>