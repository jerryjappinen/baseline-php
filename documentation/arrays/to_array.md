
# to_array

**Make sure value is array, convert if needed.** [View source](https://bitbucket.org/Eiskis/baseline-php/src/default/source/arrays/to_array.php?at=default)

	function to_array ($value)

If `$value` is already an array, it will be returned untouched. If `$value` is an object, it will be returned converted to array. Otherwise this function will return an array with `$value` as its first item.



## I/O examples

<table>

	<tr>
		<th scope="col">Input</th>
		<th scope="col">Return value</th>
		<th scope="col">Notes</th>
	</tr>

	<tr>
		<td><code>to_array(array())</code></td>
		<td><code>array()</code></td>
		<td>Array input is not touched</td>
	</tr>

	<tr>
		<td><code>to_array('Some string.')</code></td>
		<td><code>array(0 => 'Some string.')</code></td>
		<td></td>
	</tr>

	<tr>
		<td><code>to_array(200)</code></td>
		<td><code>array(0 => 200)</code></td>
		<td></td>
	</tr>

</table>



## Real-life examples

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

##### Without to_array()
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
