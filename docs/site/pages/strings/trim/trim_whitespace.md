
# trim_whitespace

**Trim all whitespace, line breaks etc. from a string.** [View source](https://github.com/Eiskis/Baseline-PHP/blob/master/source/strings/trim/trim_whitespace.php)

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
