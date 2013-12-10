<?php
/**
* Warnings
*/
class ServantWarnings extends ServantObject {

	/**
	* Properties
	*/
	protected $propertyAll = null;



	/**
	* Convenience
	*/

	public function count () {
		return $this->servant()->debug() ? count($this->all()) : 0;
	}

	public function trigger ($input = null) {
		if ($this->servant()->debug()) {

			// Add each warning to the list
			$input = func_get_args();
			foreach (array_flatten($input) as $message) {
				$this->add($message);
			}

		}

		return $this;
	}



	/**
	* Getters
	*/

	public function all () {
		return $this->servant()->debug() ? $this->getAndSet('all') : array();
	}



	/**
	* Setters
	*/

	protected function setAll ($input = null) {
		if ($this->servant()->debug()) {

			// Add if we have an array
			$result = array();
			if ($input and is_array($input)) {
				$result = $input;
			}

			$this->set('all', $result);

		}

		return $this;
	}

	protected function add ($message) {
		if ($this->servant()->debug()) {

			// Set if we have a string
			if (is_string($message)) {
				$all = $this->all();
				$all[] = $message;
				$this->setAll($all);

			} else {
				$this->fail('Invalid warning message passed to warning service.');
			}

		}

		return $this;
	}

}

?>