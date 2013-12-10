
# create_object

**Shorthand for creating a new object, making chainable object creation possible.** [View source](https://bitbucket.org/Eiskis/baseline.php/src/default/source/misc/create_object.php)

	function create_object ($classname, $parameter = null)

...



## Examples

### Method chaining

	// Returns MyClass->foo()
	create_object('MyClass', 'param1')->foo();
