<?php

// All scripts for site
$output = '';

// Merge all scripts from theme
foreach ($servant->theme()->scripts('server') as $path) {
	$output .= file_get_contents($path);
}

// Merge scripts from site
foreach ($servant->pages()->current()->scripts('server') as $path) {
	$output .= file_get_contents($path);
}

// Compress
// FLAG this is a hack
if ($servant->settings()->cache('server')) {
	$servant->utilities()->load('jshrink');
	$output = Minifier::minify($output, array('flaggedComments' => false));
}

// Output scripts
$servant->action()->contentType('js')->output($output);
?>