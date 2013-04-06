
# debug

**Silently log a `dump()`'d object or variable to error log.** [View source](https://bitbucket.org/Eiskis/baseline-php/src/default/source/debug/debug.php?at=default)

	function debug ($value [, $anotherValue])

This function calls [dump()](dump) for the input parameters and writes the return value into error log. Remember that the location of the log can be defined in `php.ini`.



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
