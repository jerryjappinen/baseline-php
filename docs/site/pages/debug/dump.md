
# dump

**Dump objects or variables into a (mostly) human-readable format.** [View source](https://github.com/Eiskis/Baseline-PHP/blob/master/source/debug/dump.php)

	function dump ($value [, $anotherValue])

This function uses the native `var_export()` to return a string representation of the input parameters. Note that it doesn't print the output like `var_export()` does by default.



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
