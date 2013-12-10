<?php

/**
* A holder node with children
*/
class ServantCategory extends ServantNode {

	/**
	* Properties
	*/
	protected $propertyChildren 	= null;



	/**
	* Convenience
	*/

	public function category () {
		return true;
	}

	public function endpoint ($format = false) {
		return $this->pick()->endpoint($format);
	}

	public function home () {
		return false;
	}

	public function page () {
		return false;
	}

	public function pick () {
		$child = $this->children(0);
		if ($child->category()) {
			$child = $child->pick();
		}
		return $child;
	}



	/**
	* Allow passing child pages in init
	*/

	public function initialize ($id, $parent = null) {
		$this->setId($id)->setChildren();

		if ($parent) {
			$this->setParent($parent);
		}

		// Support creating children while we're at it
		$children = func_get_args();
		call_user_func_array(array($this, 'addChildren'), array_flatten(array_slice($children, 2)));

		return $this;
	}



	/**
	* Parent node
	*/

	protected function setParent ($category = null) {

		// Set false for root categories
		if (!func_num_args()) {
			$category = false;

		} else {

			if ($this->getServantClass($category) !== 'category') {
				$this->fail('Pages need a category parent to take care of them.');
			}

			// FLAG this behavior isn't very clear...
			$category->addChildren($this);

		}


		return $this->set('parent', $category);
	}



	/**
	* Children
	*/

	protected function setChildren ($pages = array()) {
		return $this->set('children', $pages);
	}

	// Adding child page(s)
	public function addChildren ($pages = array()) {
		$pages = func_get_args();
		$pages = array_flatten($pages);

		// Validate pages
		foreach ($pages as $key => $page) {
			if (!in_array($this->getServantClass($page), array('page', 'category'))) {
				$this->fail('Invalid child passed to '.$this->name().' category.');
			}
		}

		return $this->setChildren(array_merge($this->children(), $pages));
	}

}

?>