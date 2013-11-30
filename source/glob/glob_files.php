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
	$files = array();

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
		$path = preg_replace('/(\*|\?|\[)/', '[$1]', suffix($path, '/'));
	}

	// Do the glob()
	foreach (glob($path.'*'.$brace, GLOB_BRACE) as $value) {
		if (is_file($value)) {
			$files[] = $value;
		}
	}

	// Sort results
	usort($files, 'strcasecmp');

	return $files;
}

?>