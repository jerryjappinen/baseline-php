<?php

// Compress
if (!$servant->debug()) {
	$servant->utilities()->load('jshrink');
	$js = Minifier::minify($js, array('flaggedComments' => false));
}

$action->status(200)->contentType('js')->output($js);

?>