
# trim_whitespace

**Trim all whitespace, line breaks etc. from a string..** [View source](https://bitbucket.org/Eiskis/baseline.php/src/default/source/strings/trim/trim_whitespace.php?at=default)

	function trim_whitespace ($subject)



## Examples

### Basics

##### Trim all whitespace and all empty lines
	trim_whitespace('


				This is my favorite M  O  V  I   E!!

					
					
							 	       

		YYYEEEEEAAAAAAAHHH!!!!
	');

	/* Returns
	'ThisismyfavoriteMOVIE!!YYYEEEEEAAAAAAAHHH!!!!'
	*/
