
# to_camelcase

**Convert a string to camelCase.** [View source](https://bitbucket.org/Eiskis/baseline.php/src/default/source/strings/to_camelcase.php?at=default)

	function to_camelcase ($subject, $preserveUppercase = false)

This function accepts a mathematical formula as a string, calculates the result and returns it. When `$forceInteger` is set to `true`, the return value will be rounded to an integer if it would otherwise be a float value. Unless `$preserveUpperCase` is set to true, *consecutive* uppercase letters are downcased and the result string always begins with a lowercase letter.



## Examples

### Basics

##### Dash separators
	to_camelcase('using-dash-separators');
	// Returns 'usingDashSeparators'

##### Dash separators & capital letters
	to_camelcase('Using-Capital-Dash-Separators');
	// Returns 'usingCapitalDashSeparators'

##### Upper-case
	to_camelcase('ALL_UPPER_CASE');
	// Returns 'allUpperCase'

##### "Normal" text
	to_camelcase('normal spaces');
	// Returns 'normalSpaces'

##### Already camelCase
	to_camelcase('alreadyCamelCase');
	// Returns 'alreadyCamelCase'

	to_camelcase('AlreadyCamelCase');
	// Returns 'alreadyCamelCase'

	to_camelcase('AlreadyCamelCase', true);
	// Returns 'AlreadyCamelCase'
