
# to_array

**Make sure value is array, convert if needed.** [View source](https://bitbucket.org/Eiskis/baseline-php/src/default/source/arrays/to_array.php?at=default)

	function to_array ($value)

If `$value` is already an array, it will be returned untouched. If `$value` is an object, it will be returned converted to array. Otherwise this function will return an array with `$value` as its first item.



## Examples

### Basics

##### Array input is not touched
	to_array(array())
	// Returns array()

##### Single values become the first (and only) item of the return array
	to_array('Some string.')
	// Returns array(0 => 'Some string.')

	to_array(200)
	// Returns array(0 => 200)



### Normalize function parameters

`to_array()` lets you easily normalize any value that you need to use as an array. We could have a method like this:

	public function pickValues ($array) {
		$result = array();
		foreach (to_array($array) as $value) {
			if (isFineByMe($value)) {
				$result[] = $value;
			}
		}
		return $result;
	}

And this is how we'd use it:

##### Without `to_array()`
	$var = 'foo';

	...

	if (!is_array($var)) {
		$var = array($var);
	}

	$newVars = pickValues($var);

##### With to_array()
	$var = 'foo';

	...

	$newVars = pickValues($var);
