<?php
// Development helpers

// Dump values
function dump ($value) {
	return var_export($value, true);
}

// Dump values into HTML tags
function htmlDump ($value) {
	return '<pre>'.dump($value).'</pre>';
}

// Silently log to error log
function debug ($value) {
	$displayErrors = ini_get('display_errors');
	ini_set('display_errors', '0');
	error_log("\n\n\n".dump($value), 0)."\n\n";
	ini_set('display_errors', $displayErrors);
}
?>