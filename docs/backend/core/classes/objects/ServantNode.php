<?php

/**
* A traversable node with potential for parents or children
*/
class ServantNode extends ServantObject {

	/**
	* Properties
	*/
	protected $propertyDepth 		= null;
	protected $propertyId 			= null;
	protected $propertyIndex 		= null;
	protected $propertyName 		= null;
	protected $propertyParent 		= null;
	protected $propertyTemplate 	= null;
	protected $propertyTree 		= null;



	/**
	* Convenience
	*/

	public function sibling () {
		$arguments = func_get_args();
		return array_traverse($this->siblings(), $arguments);
	}

	public function siblings () {
		return $this->parent()->children();
	}



	/**
	* Getters
	*/

	public function depth ($includeRoot = false) {
		$depth = $this->getAndSet('depth');
		return $includeRoot ? $depth : $depth-1;
	}

	public function id () {
		$arguments = func_get_args();
		return $this->getOrSet('id', $arguments);
	}

	public function name () {
		$arguments = func_get_args();
		return $this->getOrSet('name', $arguments);
	}

	public function template () {

		$template = $this->getAndSet('template');

		// Bubble
		if (empty($template)) {

			// Parent
			if ($this->parent()) {
				$template = $this->parent()->template();

			// Global
			} else {
				$template = $this->servant()->site()->template();
			}

		}

		return $template;
	}

	public function tree ($includeRoot = false) {
		$arguments = func_get_args();
		$tree = $this->getAndSet('tree');

		// FLAG this behavior is a bit odd, it's a hacky solution
		if (is_bool($includeRoot)) {
			array_shift($arguments);
		}
		if ($includeRoot === false) {
			array_shift($tree);
		}

		return array_traverse($tree, $arguments);
	}

	public function pointer ($includeRoot = false) {
		return implode('/', $this->tree($includeRoot));
	}



	/**
	* Parent(s)
	*/

	public function root () {
		return $this->parents(true, 0);
	}

	public function parents ($includeRoot = false) {
		$arguments = func_get_args();
		$parents = array();

		// Inherit grandparents
		$parent = $this->parent();
		if ($parent) {
			$parents = $parent->parents(true);
			$parents[] = $parent;
		}

		// FLAG this behavior is a bit odd, it's a hacky solution
		if (is_bool($includeRoot)) {
			array_shift($arguments);
		}
		if ($includeRoot === false) {
			array_shift($parents);
		}

		// Traverse parents
		return array_traverse($parents, $arguments);
	}



	/**
	* Setters
	*/

	/**
	* Depth
	*/
	protected function setDepth () {
		return $this->set('depth', count($this->parents(true)));
	}

	/**
	* ID
	*/
	protected function setId ($input) {

		// Allow overriding auto set
		if (is_string($input)) {
			$input = trim_whitespace($input);
			if (!empty($input)) {
				$id = $input;
			}
		}

		// Default
		if (!isset($id)) {
			$this->fail('Invalid ID passed to node.');
		}

		return $this->set('id', $id);
	}

	/**
	* Location of this page relative to its siblings
	*/
	protected function setIndex () {
		$result = 0;
		foreach ($this->siblings() as $i => $sibling) {
			if ($sibling === $this) {
				$result = $i;
				break;
			}
		}
		return $this->set('index', $result);
	}

	/**
	* Human-readable name
	*/
	protected function setName ($input = null) {

		// Allow overriding automatic ID manually
		if (is_string($input)) {
			$input = trim_text($input, true);
			if (!empty($input)) {
				$name = $input;
			}
		}

		// Default
		if (!isset($name)) {

			// Name given in settings
			$replacements = $this->servant()->site()->pageNames();
			$key = $this->pointer();
			if (array_key_exists($key, $replacements)) {
				$name = $replacements[$key];

			// Generate
			} else {
				$conversions = $this->servant()->settings()->namingConvention();
				$name = ucfirst(trim(str_ireplace(array_keys($conversions), array_values($conversions), $this->id())));
			}

		}

		return $this->set('name', $name);
	}

	// Parent node
	protected function setParent ($category) {

		if ($this->getServantClass($category) !== 'category') {
			$this->fail('Pages need a category parent to take care of them.');
		}

		// FLAG this behavior isn't very clear...
		$category->addChildren($this);

		return $this->set('parent', $category);
	}

	// Template
	protected function setTemplate () {
		$template = '';

		// Template defined in settings
		$pageTemplates = $this->servant()->site()->pageTemplates();
		$pointer = $this->pointer();

		if (array_key_exists($pointer, $pageTemplates)) {

			if ($this->servant()->available()->template($pageTemplates[$pointer])) {
				$template = $pageTemplates[$pointer];

			// Template not available
			} else {
				$this->warn('Missing template "'.$template.'" for '.$pointer.'.');

			}

		}

		return $this->set('template', $template);
	}

	// List of parent IDs + own ID, without root
	protected function setTree () {
		$results = array();
		foreach ($this->parents(true) as $parent) {
			$results[] = $parent->id();
		}
		$results[] = $this->id();
		return $this->set('tree', $results);
	}

}

?>