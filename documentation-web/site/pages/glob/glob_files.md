
# glob_files

**List files on the first level of a directory.** [View source](https://bitbucket.org/Eiskis/baseline.php/src/default/source/glob/glob_files.php?at=default)

	function glob_files ($path = '', $filetypes = array() [, $secondFiletype ...])

This function returns a list of files on the first level of a given directory. Files can optionally be filtered with one or more file extensions. Files are returned in the same format as with the native `glob()`.

**Note!** Unlike for the native `glob()`, `glob_files()` only wants the path of a directory and **not** a glob-style pattern.



## Examples

### Basics

	documentation/about.md

	documentation/arrays/array_flatten.md
	documentation/arrays/array_traverse.md
	documentation/arrays/limplode.txt
	documentation/arrays/to_array.html

Assume this sample directory structure for the following examples.

##### List files
	glob_files('documentation')
	// Returns array('about.md')

	glob_files('documentation/arrays/', array('md'))
	// Returns array('documentation/arrays/array_flatten.md', 'documentation/arrays/array_traverse.md')
	
##### File types can be given as independent values
	glob_files('documentation/arrays/', 'txt', 'html')
	// Returns array('documentation/arrays/limplode.txt', 'documentation/arrays/to_array.txt')

##### Non-existing path returns an empty array
	glob_files('documentation/somefolder')
	// Returns array()



### Comparison to glob()

##### File listing with `glob()`

	// Assume (only) files have extensions
	$files = glob('my/folder/*.*');

	// Strict checking
	$files = array();
	foreach(glob('my/folder/*') as $path) {
		if (is_file($path)) {
			$files[] = $path;
		}
	}

##### File listing with `glob_files()`
	$files = glob_files('my/folder/');
