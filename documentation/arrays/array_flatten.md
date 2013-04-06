
# array_flatten

**Flatten an array, either keeping or discarding content of child arrays.** [View source](https://bitbucket.org/Eiskis/baseline-php/src/default/source/arrays/array_flatten.php?at=default)

	function array_flatten (array $array, $removeChildren = false, $preserveKeys = false)

This funtion returns the input `$array` with no child arrays. By default, all keys are discarded (the new returned array will have new indexes) and non-array calues in any child arrays are included on the same level as their parents.

When `$removeChildren` is set to `true`, all child arrays are removed. When `$preserveKeys` is set to `true`, keys in `$array` as well as any child arrays are preserved. Enabling both is a safe way of removing child arrays without losing associations.

**Note!** When preserving keys, it's possible that some values are lost. Some child arrays might include values with the same keys as 



## Examples

### Basics

##### Flatten a multi-dimensional array
	array_flatten(array(
		1,
		2,
		array(
			'a',
			'b'
		)
	))
	// Returns array(1, 2, 'a', 'b')

##### Empty child arrays are discarded
	array_flatten(array('value', array()))
	// Returns array('value')

##### Keys are ditched by default
	array_flatten(array(
		'a' => 'val 1',
		'b' => 'val 2',
		'c' => 'val 3'
	))
	/* Returns
	array(
		0 => 'val 1',
		1 => 'val 2',
		2 => 'val 3'
	)
	*/
