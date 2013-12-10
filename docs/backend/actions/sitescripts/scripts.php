<?php

// All global scripts of the site
$output = '';
foreach ($servant->site()->scripts('server') as $file) {
	$output .= file_get_contents($file);
}

// Output scripts
$action->contentType('js')->output($output);
?>