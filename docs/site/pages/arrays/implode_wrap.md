
# implode_wrap

**`implode()` an array, wrapping each item in `$prefix` and `$suffix`, optionally separated with `$glue`.** [View source](https://github.com/Eiskis/Baseline-PHP/blob/master/source/arrays/implode_wrap.php)

	function implode_wrap ($prefix = '', $suffix = '', $pieces = array(), $glue = '')

...



## Examples

### Basics

##### Print out numbers
	implode_wrap('[', ']', array(1, 2, 3), ' - ')
	// Returns '[1] - [2] - [3]'

##### Generate an HTML list

	'<ul>
	'.implode_wrap('<li>', '</li>', array('Foo', 'Bar'), "\n").'</ul>'

	// Returns
	'<ul>
	<li>Foo</li>
	<li>Bar</li>
	</ul>'
