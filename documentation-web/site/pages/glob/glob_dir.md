
# glob_dir

**List all directories within a path.** [View source](https://bitbucket.org/Eiskis/baseline.php/src/default/source/glob/glob_dir.php?at=default)

	function glob_dir ($path = '')

...

**Note!** Unlike for the native `glob()`, `glob_files()` only wants the path of a directory and **not** a glob-style pattern.



## Examples

### Basics

Assume this sample directory structure for the following examples.

	documentation/about.md

	documentation/arrays/array_flatten.md
	documentation/arrays/array_traverse.md
	documentation/arrays/limplode.txt
	documentation/arrays/to_array.html

...
