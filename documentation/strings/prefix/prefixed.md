
# prefixed

**Check if a string has a prefix.** [View source](https://bitbucket.org/Eiskis/baseline-php/src/default/source/strings/prefix/prefixed.php?at=default)

	function prefixed ($subject, $prefix, $caseInsensitive = false)

...



## Examples

### Basics

	prefix('domain.com', 'www')
	// Returns false

	prefix('www.domain.com', 'www')
	// Returns true

	prefix('HTTP://www.domain.com', 'http://')
	// Returns false

	prefix('HTTP://www.domain.com', 'http://', true)
	// Returns true
