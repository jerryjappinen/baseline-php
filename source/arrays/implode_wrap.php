<?php

/**
* Implode an array, wrapping each item in $prefix and $suffix, optionally separated with glue.
*
* @param $prefix
*	...
*
* @param $suffix
*	...
*
* @param $pieces
*	...
*
* @param $glue
*	...
*
* @return
*	...
*/
function implode_wrap ($prefix = '', $suffix = '', $pieces = array(), $glue = '') {
	$realPrefix = $prefix;
	$realSuffix = $suffix;
	$realPieces = $pieces;
	$realGlue = $glue;

	// Allow giving glue and array in reverse order, like implode() does
	if (is_array($prefix)) {
		$realPieces = $prefix;
		$realPrefix = $suffix;
		$realSuffix = $pieces;
	}

	return empty($pieces) ? '' : $realPrefix.limplode($realSuffix.$realGlue.$realPrefix, $realPieces).$realSuffix;
}

?>