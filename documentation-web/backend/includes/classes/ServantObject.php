<?php

class ServantObject {



	/**
	* Properties
	*/
	private $propertyMain = null;

	/**
	* servant
	*
	* Include a reference to main Servant object
	*/
	protected function servant () {
		$main = $this->get('main');
		return $main === null ? $this : $main;
	}



	/**
	* Magic methods
	*/

	/**
	* _call
	*
	* When calling an inaccessible method, the fallback is getAndSet()
	*/
	public function __call ($id, $arguments) {
		return $this->getAndSet($id, $arguments);
	}

	/**
	* __construct
	*/
	public function __construct ($main) {

		// Take in Servant object
		if (get_class($main) === 'ServantMain') {
			$this->set('main', $main);

		} else {
			return $this->fail('New objects need a main Servant instance ('.$this.')');
		}

		return $this;
	}

	/**
	* toString
	*
	* When object is used as string, return a name
	*/
	public function __toString () {
		if (method_exists($this, 'id')) {
			$name = $this->id();
			return get_class($this).(empty($name) ? '' : ': '.$name);
		} else {
			return get_class($this);
		}
	}

	/**
	* init
	*
	* Generic initializer, calls object's custom initializer if one exists
	*/
	public function init () {

		// Also run the optional class-specific method
		if (method_exists($this, 'initialize')) {
			$arguments = func_get_args();
			call_user_func_array(array($this, 'initialize'), $arguments);
		}

		return $this;
	}



	/**
	* Generic functionality
	*/

	/**
	* Find out if key exists within traversable property; optionally check for specific value
	*/
	protected function assert ($id, $tree = null, $target = null) {
		$value = $this->get($id, $tree);
		if ($value === null) {
			return false;
		} else if (isset($target) and $value !== $target) {
			return false;
		} else {
			return true;
		}
	}

	/**
	* Call a property-specific setter
	*/
	protected function callSetter ($id, $arguments = array()) {
		$setterName = $this->setterName($id);
		if (method_exists($this, $setterName)) {
			return call_user_func_array(array($this, $setterName), to_array($arguments));
		} else {
			return $this->fail(get_class($this).' property "'.$id.'" is missing a setter');
		}
	}

	/**
	* Output object content for debugging
	*/
	public function dump () {
		$results = array();

		// Accept input in various ways
		$arguments = func_get_args();
		$arguments = array_flatten($arguments);

		// Return what was asked
		$properties = array();
		if ($arguments and !empty($arguments)) {
			$properties = $arguments;

		// Default to dumping all available properties (does not use custom getters)
		} else {
			$classProperties = get_class_vars(get_class($this));
			unset($classProperties[$this->propertyName('main')]);
			foreach (array_keys($classProperties) as $key => $value) {
				$properties[] = $this->unPropertyName($value);
			}
		}

		// Get values
		foreach ($properties as $property) {
			$value = $this->get($property);

			// call __toString() of child ServantObjects
			if (is_object($value) and is_subclass_of($value, 'ServantObject')) {
				$results[$property] = ''.$value;
			} else {
				$results[$property] = $value;
			}

		}

		// Only one thing was asked for
		if ($arguments and !empty($arguments) and count($results) === 1) {
			$results = $results[0];
		}

		return $results;
	}

	/**
	* Report failure, throw an error
	*/
	protected function fail ($message, $code = 500) {
		throw new Exception($message, $code);
		return $this;
	}

	/**
	* Generic getter with traversing options
	*/
	protected function get ($id, $tree = null) {
		$propertyName = $this->propertyName($id);
		$value = $this->$propertyName;
		if (is_array($value) and !empty($tree)) {
			return array_traverse($value, array_flatten($tree));
		}
		return $value;
	}

	/**
	* Generic property setter, can be used in setter methods
	*/
	protected function set ($id, $value) {
		$propertyName = $this->propertyName($id);
		if ($value === null) {
			return $this->fail('Properties cannot be null');
		} else {
			$this->$propertyName = $value;
		}
		return $this;
	}

	/**
	* See if a property has a dedicated setter
	*/
	protected function setterExists ($id) {
		return method_exists($this, $this->setterName($id));
	}



	/**
	* Wrapper methods
	*/

	/**
	* Getter that calls (auto) setter when needed
	*/
	protected function getAndSet ($id, $tree = null) {
		if ($this->get($id) === null) {
			$this->callSetter($id);
		}
		return $this->get($id, $tree);
	}

	/**
	* Getter that calls (auto) setter when needed
	*/
	protected function assertAndSet ($id, $tree = null, $target = null) {
		if ($this->get($id) === null) {
			$this->callSetter($id);
		}
		return $this->assert($id, $tree);
	}

	/**
	* Get if values are not provided, but forward to setting if they are
	*/
	protected function getOrSet ($id, $arguments = null) {
		if (empty($arguments)) {
			return $this->get($id);
		} else {
			return $this->callSetter($id, $arguments);
		}
	}

	/**
	* Getter that can check if a key exists
	*/
	protected function getOrAssert ($id, $tree = null, $target = null) {
		if (empty($tree)) {
			return $this->get($id);
		} else {
			return $this->assert($id, $tree, $target);
		}
	}



	/**
	* Private helpers
	*/

	// Naming convention helpers
	private function className ($id) {
		return $this->generateName('Servant', $id);
	}
	private function unClassName ($id) {
		return $this->parseGeneratedName('Servant', $id);
	}
	private function propertyName ($id) {
		return $this->generateName('property', $id);
	}
	private function unPropertyName ($id) {
		return $this->parseGeneratedName('property', $id);
	}
	private function setterName ($id) {
		return $this->generateName('set', $id);
	}
	private function unSetterName ($id) {
		return $this->parseGeneratedName('set', $id);
	}

	// Generating/parsing names for things
	private function generateName ($prefix, $name) {
		return $prefix.ucfirst($name);
	}
	private function parseGeneratedName ($prefix, $name) {
		$base = unprefix($name, $prefix, true);
		$name = strtolower(substr($base, 0, 1)).substr($base, 1);
		return $name;
	}

}

?>