
# trim_text

**Trim excess whitespaces, empty lines etc. from a string.** [View source](https://bitbucket.org/Eiskis/baseline-php/src/default/source/strings/trim_text.php?at=default)

	function trim_text ($string)


This function accepts a mathematical formula as a string, calculates the result and returns it. When `$forceInteger` is set to `true`, the return value will be rounded to an integer if it would otherwise be a float value.



## Examples

### Basics

##### Trim excess whitespace and empty lines
	trim_text('


		This is my favorite M  O  V  I   E!!





		YYYEEEEEAAAAAAAHHH!!!!
	');

	/* Returns
	'This is my favorite M O V I E!!

	YYYEEEEEAAAAAAAHHH!!!!'
	*/
