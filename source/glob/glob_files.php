<?php

/**
* Search for files
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

	// Handle filetype input
	$filetypes = array_flatten(to_array($filetypes));
	if (empty($filetypes)) {
		$brace = '';
	} else {
		$brace = '.{'.implode(',', $filetypes).'}';
	}

	// Handle path input
	if (!empty($path)) {
		$path = end_with($path, '/');
	}

	foreach (glob($path.'*'.$brace, GLOB_BRACE) as $value) {
		if (is_file($value)) {
			$result[] = $value;
		}
	}
	natcasesort($result);
	return $result;
}

?>