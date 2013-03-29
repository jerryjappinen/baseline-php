<?php


/**
* Remove one file
*
* @param $path
*	...
*
* @return
*	...
*/
function remove_file ($path) {
	if (is_file($path)) {
		unlink($path);
		return true;
	}
	return false;
}

?>