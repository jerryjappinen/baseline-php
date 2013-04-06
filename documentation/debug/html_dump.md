
# html_dump

**`dump()` objects or variables wrapped in HTML's `<pre>` tags.** [View source](https://bitbucket.org/Eiskis/baseline-php/src/default/source/debug/html_dump.php?at=default)

	function html_dump ($value [, $anotherValue])

This function works exactly like [dump()](dump), but the return value is wrapped in HTML's `<pre>` tags.



## Examples

##### Dump one value
	dump('Foo bar');
	// Returns 'Foo bar'

##### Multiple values will be dumped as an array

	$test = array(1, 2, 3);
	$test2 = 'bar';
	dump($test, $test2);

	/* Returns
	'array (
	  0 => 
	  array (
	    0 => 1,
	    1 => 2,
	    2 => 3,
	  ),
	  1 => 'bar',
	)'
	*/
