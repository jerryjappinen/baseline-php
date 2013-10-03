<?php

/**
* Page component
*
* Dependencies
*   - servant()->action()->id()
*   - servant()->files()->read()
*   - servant()->format()->pageName()
*   - servant()->format()->path()
*   - servant()->paths()->root()
*   - servant()->utilities()->load()
*/
class ServantPage extends ServantObject {

	/**
	* Properties
	*/
	protected $propertyChildren 	= null;
	protected $propertyId 			= null;
	protected $propertyIndex 		= null;
	protected $propertyIsCurrent 	= null;
	protected $propertyIsHome 		= null;
	protected $propertyIsMaster 	= null;
	protected $propertyLevel 		= null;
	protected $propertyName 		= null;
	protected $propertyOutput 		= null;
	protected $propertyReadPath 	= null;
	protected $propertyPages 		= null;
	protected $propertyParentTree 	= null;
	protected $propertySiblings 	= null;
	protected $propertyTree 		= null;
	protected $propertyType 		= null;

	// Files
	protected $propertyScripts 		= null;
	protected $propertyStylesheets 	= null;
	protected $propertyTemplate 	= null;




	/**
	* Select ID when initializing
	*/
	public function initialize ($pages, $tree = null) {

		// Load utilities
		$this->servant()->utilities()->load('urls');

		// Required items
		$this->setPages($pages);

		// Generate tree
		if ($tree) {
			$this->setTree($tree);
		}

		return $this;
	}



	/**
	* Convenience
	*/

	/**
	* Generate a name based on one of the top-level parents
	*/
	public function categoryName ($level = 0) {
		$parent = $this->tree($level);
		if (isset($parent)) {
			$name = $this->servant()->format()->pageName($parent);
		} else {
			$name = $this->name();
		}
		return $name;
	}



	/**
	* Public getters
	*/

	public function readPath ($format = false) {
		$path = $this->getAndSet('readPath');
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

	public function template ($format = false) {
		$path = $this->getAndSet('template');
		if ($format) {
			$path = $this->servant()->format()->path($path, $format);
		}
		return $path;
	}



	/**
	* Setters
	*
	* NOTE
	*   - ->pages() and ->tree() determine most of these
	*/

	/**
	* Siblings can be thought of as children if a page is master page
	*/
	protected function setChildren () {
		$children = array();

		// Is master page
		if ($this->level() > 0 and $this->index() === 0 and $this->siblings()) {
			$children = $this->siblings();
			array_shift($children);
		}

		return $this->set('children', $children);
	}

	protected function setId () {
		$tree = $this->tree();
		return $this->set('id', end($tree));
	}

	/**
	* Location of this page relative to its siblings
	*/
	protected function setIndex () {
		$keys = array_flip(array_keys($this->siblings()));
		return $this->set('index', $keys[$this->id()]);
	}

	/**
	* Is this the current page?
	*/
	protected function setIsCurrent () {
		return $this->set('isCurrent', $this->pages()->current() === $this);
	}

	/**
	* Is this the home page?
	*/
	protected function setIsHome () {
		$topLevel = $this->pages()->level();
		$pageKeys = array_keys($topLevel);
		return $this->set('isHome', $topLevel[$pageKeys[0]] === $this);
	}

	/**
	* Category main page
	*/
	protected function setIsMaster () {
		return $this->set('isMaster', ($this->level() > 0 and $this->index() === 0) ? true : false);
	}

	/**
	* Depth of this page in the page tree (starts from 1)
	*/
	protected function setLevel () {
		return $this->set('level', (count($this->tree()) -1));
	}

	/**
	* Human-readable name, generated from ID
	*/
	protected function setName () {
		return $this->set('name', $this->servant()->format()->pageName($this->id()));
	}

	/**
	* Return template content as a string
	*
	* FLAG URL manipulation should be done in read action (as in stylesheets and scripts)
	*/
	protected function setOutput () {
		$urlManipulator = new UrlManipulator();

		// Root path for src attributes
		$srcUrl = $this->pages()->path('domain');

		// Root path for hrefs
		$hrefUrl = $this->servant()->paths()->root('domain').$this->servant()->action()->id().'/';

		// Relative location for SRC urls
		$relativeSrcUrl = unprefix(dirname($this->template('plain')), $this->pages()->path('plain'), true);
		if (!empty($relativeSrcUrl)) {
			$relativeSrcUrl .= '/';
		}

		// Relative location for HREF urls
		$relativeHrefUrl = implode('/', $this->parentTree());
		if (!empty($relativeHrefUrl)) {
			$relativeHrefUrl .= '/';
		}

		// Base URL to point to actions on the domain
		$actionsUrl = $this->servant()->paths()->root('domain');

		// Read content from source file
		$fileContent = $this->servant()->files()->read($this->template('server'));

		// Save file content with manipulated URLs
		return $this->set('output', $urlManipulator->htmlUrls($fileContent, $srcUrl, $relativeSrcUrl, $hrefUrl, $relativeHrefUrl, $actionsUrl));
	}

	/**
	* ServantPages object
	*/
	protected function setPages ($pages) {
		return $this->set('pages', $pages);
	}

	/**
	* Parent IDs
	*/
	protected function setParentTree () {
		$tree = $this->tree();
		array_pop($tree);
		return $this->set('parentTree', $tree);
	}

	/**
	* Path to this page in read action
	*/
	protected function setReadPath () {
		return $this->set('readPath', $this->servant()->paths()->userAction('read', 'plain', $this->tree()));
	}

	/**
	* Paths to script files under pages, relevant to this page
	*/
	protected function setScripts () {
		return $this->set('scripts', $this->filterPageFiles('scripts'));
	}

	/**
	* All pages on this level of the page tree. Includes this page.
	*
	* FLAG
	*   - should contain page objects
	*/
	protected function setSiblings () {
		$siblings = $this->pages()->map($this->parentTree());
		return $this->set('siblings', $siblings ? $siblings : array());
	}

	/**
	* Paths to stylesheet files under pages, relevant to this page
	*/
	protected function setStylesheets () {
		return $this->set('stylesheets', $this->filterPageFiles('stylesheets'));
	}

	/**
	* Path to the template file
	*
	* FLAG
	*   - Template path shouldn't come from pages(), it's backwards o_O
	*/
	protected function setTemplate () {
		return $this->set('template', $this->pages()->templates($this->tree()));
	}

	protected function setTree ($tree = array()) {

		// No source file, so we can't really do this
		if (!$this->pages()->templates($tree)) {
			$this->fail('This page does not exist');
		}

		return $this->set('tree', $tree);
	}

	protected function setType () {
		return $this->set('type', pathinfo($this->template(), PATHINFO_EXTENSION));
	}



	/**
	* Private helpers
	*/

	// Select the files under pages that are relevant for this page (i.e. stylesheets or scripts)
	private function filterPageFiles ($type) {
		$results = array();

		// FLAG legacy, don't need to traverse all files
		$formats = $this->servant()->settings()->formats($type);
		$allFiles = array();
		foreach (rglob_files($this->pages()->path('server'), $formats) as $file) {
			$allFiles[] = $this->servant()->format()->path($file, false, 'server');
		}

		// Allowed paths
		$allowed = array();
		foreach ($this->tree() as $key => $path) {
			if ($key > 0) {
				$allowed[] = $allowed[$key-1].$path.'/';
			} else {
				$allowed[] = $path.'/';
			}
		}
		// Also include root path
		array_unshift($allowed, '');
		unset($key, $path);

		// Traverse all files, accept the ones on allowed levels
		foreach ($allFiles as $value) {
			$base = unprefix(dirname($value).'/', $this->pages()->path(), true);
			if (in_array($base, $allowed)) {
				$results[] = $value;
			}
		}

		return $results;
	}

}

?>