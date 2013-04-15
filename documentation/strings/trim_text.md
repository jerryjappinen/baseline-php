
# trim_text

**Trim excess whitespaces, empty lines etc. from a string.** [View source](https://bitbucket.org/Eiskis/baseline-php/src/default/source/strings/trim_text.php?at=default)

	function trim_text ($subject)

This function returns the subject string with no spaces, dashes or underscores. Each word in the subject string now begins with a capitalized letter.



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
