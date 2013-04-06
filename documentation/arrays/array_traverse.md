
# array_traverse

**Traverse a a multidimensional array based on given keys.** [View source](https://bitbucket.org/Eiskis/baseline-php/src/default/source/arrays/array_flatten.php?at=default)

	function array_traverse (array $subject, $keys [, $secondKey ...])

This function lets you traverse a multidimensional array with provided keys. Keys can be provided as a single array in the second parameter, or as multiple independent parameters.

If a value for the provided keys is not set, `null` is returned.



## I/O examples

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

<table>

	<tr>
		<th scope="col">Input</th>
		<th scope="col">Return value</th>
		<th scope="col">Notes</th>
	</tr>

	<tr>
		<td><code>array_traverse($test, array('a', 'b', 'c'))</code></td>
		<td><code>'foo'</code></td>
		<td>This would be the same as `$array['a']['b']['c']`</td>
	</tr>

	<tr>
		<td><code>array_traverse($test, 'b')</code></td>
		<td><code>array('bar', 'blah', array())</code></td>
		<td>Second parameter will be turned into an array automatically</td>
	</tr>

	<tr>
		<td><code>array_traverse($test, array('b', 0))</code></td>
		<td><code>'bar'</code></td>
		<td>Numeric keys work as expected</td>
	</tr>

	<tr>
		<td><code>array_traverse($test, array('b', 0, 0))</code></td>
		<td><code>null</code></td>
		<td></td>
	</tr>

	<tr>
		<td><code>array_traverse(array(1, 2, 3), array())</code></td>
		<td><code>array(1, 2, 3)</code></td>
		<td></td>
	</tr>

</table>



## Real-life examples

### Getter methods with traversing

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
