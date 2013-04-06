
# glob_files

**List files on the first level of a directory.** [View source](https://bitbucket.org/Eiskis/baseline-php/src/default/source/glob/glob_files.php?at=default)

	function glob_files ($path = '', $filetypes = array())

This function returns a list of files on the first level of a given directory. Files can optionally be filtered with one or more file extensions. Files are returned in the same format as with the native `glob()`.

**Note!** Unlike for the native `glob()`, `glob_files()` only wants the path of a directory and **not** a glob-style pattern.



## I/O examples

##### Example directory contents

	documentation/about.md

	documentation/arrays/array_flatten.md
	documentation/arrays/array_traverse.md
	documentation/arrays/limplode.txt
	documentation/arrays/to_array.html

<table>

	<tr>
		<th scope="col">Input</th>
		<th scope="col">Return value</th>
		<th scope="col">Notes</th>
	</tr>

	<tr>
		<td><code>glob_files('documentation')</code></td>
		<td><code>array('about.md')</code></td>
		<td></td>
	</tr>

	<tr>
		<td><code>glob_files('documentation/arrays/', array('md'))</code></td>
		<td><code>array('documentation/arrays/array_flatten.md', 'documentation/arrays/array_traverse.md')</code></td>
		<td></td>
	</tr>

	<tr>
		<td><code>glob_files('documentation/arrays/', 'txt', 'html')</code></td>
		<td><code>array('documentation/arrays/limplode.txt', 'documentation/arrays/to_array.txt')</code></td>
		<td>File types can be given as independent values.</td>
	</tr>

	<tr>
		<td><code>glob_files('documentation/somefolder')</code></td>
		<td><code>array()</code></td>
		<td>Non-existing path returns an empty array.</td>
	</tr>

</table>



## Real-life examples

### Make listing files saner

##### With `glob()`

	// Assume (only) files have extensions
	$files = glob('my/folder/*.*');

	// Strict checking
	$files = array();
	foreach(glob('my/folder/*') as $path) {
		if (is_file($path)) {
			$files[] = $path;
		}
	}

##### With `glob_files()`
	$files = glob_files('my/folder/');
