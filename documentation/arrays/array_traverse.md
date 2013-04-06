
# array_traverse

**Traverse a a multidimensional array based on given keys.** [View source](https://bitbucket.org/Eiskis/baseline-php/src/default/source/arrays/array_flatten.php?at=default)

	function array_traverse (array $subject, $keys = array() [, $secondKey ...])

This function lets you traverse a multidimensional array with provided keys. Keys can be provided as a single array in the second parameter, or as multiple independent parameters.

If a value for the provided keys is not set, `null` is returned.



## Examples

### Basics

	$test = array(
		'a' => array(
			'b' => array(
				'c' => 'foo'
			)
		),
		'b' => array(
			'bar',
			'blah',
			array()
		)
	);

We're using this sample array for the these basic examples.

	// Instead of `$array['a']['b']['c']`, we can write
	array_traverse($test, array('a', 'b', 'c'))
	// Returns 'foo'

	// Keys can also be provided as independent parameters
	array_traverse($test, 'b')
	// Returns array('bar', 'blah', array())

	// Numerical keys work as expected
	array_traverse($test, 'b', 0)
	// Returns 'bar'

	// If the key is not in the subject array...
	array_traverse($test, 'b', 0, 0)
	// Returns null

	array_traverse(array(1, 2, 3), array())
	// Returns array(1, 2, 3)



### Getter methods with optional traversing

When writing getter methods for a class, we can use `array_traverse` to spice getter methods up for any properties that have multidimensional arrays as values. In a CMS, for example, we might have a bunch of categorized pages:

##### MyCMS.php

	public function getPages() {
		$arguments = function_get_args();
		return array_traverse($this->pages, $arguments);
	}

##### Another script

	$var = new MyCMS();

	// $this->setPages(...) here

	$allPages = $this->getPages();
	$pagesInFirstCategory = $this->getPages(0);
	$pagesInFirstSubCategory = $this->getPages(0, 0);
