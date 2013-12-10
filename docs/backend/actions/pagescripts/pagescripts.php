<?php

/**
* Output page-specific scripts
*/
$output = '';

// Select page
$page = $servant->sitemap()->select($input->fetch('queue', 'page', array()));

foreach ($page->scripts('server') as $path) {
	$output .= file_get_contents($path);
}

// Compress
if (!$servant->debug()) {
	$servant->utilities()->load('jshrink');
	$output = Minifier::minify($output, array('flaggedComments' => false));
}

// Output scripts
$action->contentType('js')->output($output);
?>