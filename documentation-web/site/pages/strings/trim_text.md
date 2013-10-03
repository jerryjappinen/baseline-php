
# trim_text

**Trim excess whitespaces, empty lines etc. from a string.** [View source](https://bitbucket.org/Eiskis/baseline.php/src/default/source/strings/trim_text.php?at=default)

	function trim_text ($subject, $singleLine = false)

This function trims excess whitespace and empty lines from a subject string. When `$singleLine` is set to true, all line breaks will be stripped.



## Examples

### Basics

##### Trim excess whitespace and excess empty lines
	trim_text('


				This is my favorite M  O  V  I   E!!

					
					
							 	       

		YYYEEEEEAAAAAAAHHH!!!!
	');

	/* Returns
	'This is my favorite M O V I E!!

	YYYEEEEEAAAAAAAHHH!!!!'
	*/

##### Leave no linebreaks
	trim_text('


				This is my favorite M  O  V  I   E!!

					
					
							 	       

		YYYEEEEEAAAAAAAHHH!!!!
	', true);

	/* Returns
	'This is my favorite M O V I E!! YYYEEEEEAAAAAAAHHH!!!!'
	*/
