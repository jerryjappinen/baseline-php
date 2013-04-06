
# limplode

**`implode()` with optional last glue parameter.** [View source](https://bitbucket.org/Eiskis/baseline-php/src/default/source/arrays/limplode.php?at=default)

	function limplode ($glue = '', $pieces = array(), $lastGlue = false)

This function works exactly like the native `implode()`, glueing array items into a string. However, it also accepts an optional third parameter, which will be used as the glue between the *last* (hence the name) two array items when there are three or more.

Like with `implode()`, this function accepts `$glue` and `$pieces` in reversed order as well. This does not affect the use of `$lastGlue`.



## I/O examples

<table>

	<tr>
		<th scope="col">Input</th>
		<th scope="col">Return value</th>
		<th scope="col">Notes</th>
	</tr>

	<tr>
		<td><code>limplode(', ', array(1, 2, 3))</code></td>
		<td><code>'1, 2, 3'</code></td>
		<td>Works exactly like `implode()`</td>
	</tr>

	<tr>
		<td><code>limplode(', ', array(1, 2, 3), ' and ')</code></td>
		<td><code>'1, 2 and 3'</code></td>
		<td></td>
	</tr>

	<tr>
		<td><code>limplode(', ', array(1, 2), ' and ')</code></td>
		<td><code>'1, 2'</code></td>
		<td>`$glue` is used over `$lastGlue` when there are not enough array items.</td>
	</tr>

	<tr>
		<td><code>limplode(array(1, 2, 3))</code></td>
		<td><code>'123'</code></td>
		<td>Reversed parameter order supported.</td>
	</tr>

	<tr>
		<td><code>limplode(array(1, 2, 3), ', ', ' and ')</code></td>
		<td><code>'1, 2 and 3'</code></td>
		<td>Reversed parameter order supported.</td>
	</tr>

</table>



## Real-life examples

### Output listings for humans

When we have a list of items that we want to list for a user, we should try to make the output feel as close to natural language as possible. `limplode()` helps a little with this:

	// Hey, Jerry, we found results in Home, Documentation, Contact pages.
	echo 'Hey, '.$user['name'].', we found results in '.implode(', ', $searchResults).' pages.';

	// Hey, Jerry, we found results in Home, Documentation and Contact pages.
	echo 'Hey, '.$user['name'].', we found results in '.limplode(', ', $searchResults, ' and ').' pages.';

It's a small thing, but small things add up.
