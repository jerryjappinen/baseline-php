<?php

/**
* Shorthand for creating a new object, making chainable object creation possible.
*
* @param $classname
*	Name of the object's class as a string
*
* @param $parameter [, $parameter2 ...] (optional)
*	Any number of parameters to be passed to the constructor of the new object.
*
* @return
*	The newly created object.
*/
function create_object ($classname, $parameter = null) {
	$parameters = func_get_args();
	$classname = array_shift($parameters);
	$class = new ReflectionClass($classname);
	return $class->newInstanceArgs($parameters);
}

?>