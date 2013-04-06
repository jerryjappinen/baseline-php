<?php

/**
* List files on the first level of a directory.
*
* @param $path
*	...
*
* @param $filetypes
*	...
*
* @return
*	...
*/
function glob_files ($path = '', $filetypes = array()) {
	$result = array();

	// Accept file type restrictions as a single array or multiple independent values
	$arguments = func_get_args();
	array_shift($arguments);
	$filetypes = array_flatten($arguments);

	// Handle filetype input
	if (empty($filetypes)) {
		$brace = '';
	} else {
		$brace = '.{'.implode(',', $filetypes).'}';
	}

	// Handle path input
	if (!empty($path)) {
		$path = end_with($path, '/');
	}

	// Do the glob()
	foreach (glob($path.'*'.$brace, GLOB_BRACE) as $value) {
		if (is_file($value)) {
			$result[] = $value;
		}
	}

	// Sort results properly
	natcasesort($result);

	return $result;
}

?>