<?php

/**
* Site-wide styles
*
* If SCSS or LESS is used, the first such file determines the type used for the whole set. These cannot be mixed within one set.
*/
$allowedFormats = array();
$temp = $servant->settings()->formats('stylesheets');
unset($temp['css']);
foreach ($temp as $type => $extensions) {
	foreach ($extensions as $extension) {
		$allowedFormats[$extension] = $type;
	}
}
unset($temp, $type, $extensions, $extension);



/**
* URL manipulation
*/
$actionsPath = $servant->paths()->root('domain');
$assetsRootUrl = $servant->paths()->assets('domain');
$urlManipulator = new UrlManipulator();



/**
* Go through files
*/
$styles = array('format' => false, 'content' => '',);
foreach ($servant->site()->stylesheets('plain') as $path) {

	// Special format is used
	$extension = pathinfo($path, PATHINFO_EXTENSION);
	if (array_key_exists($extension, $allowedFormats)) {

		// Set's format has not been selected yet, we'll do it now
		if (!$styles['format']) {
			$styles['format'] = $allowedFormats[$extension];

		// Mixing preprocessor formats will fail
		} else if ($styles['format'] !== $allowedFormats[$extension]) {
			fail('CSS preprocessor formats cannot be mixed in assets');
		}

	}
	unset($extension);

	// We can parse relative path
	$relativeUrl = substr((dirname($path).'/'), strlen($servant->paths()->assets('plain')));

	// Get CSS file contents with URLs replaced
	$styles['content'] .= $urlManipulator->cssUrls(file_get_contents($servant->paths()->format($path, 'server')), $assetsRootUrl, $relativeUrl, $actionsPath);

}



/**
* Output
*/
$output = '';

// Parse LESS
if ($styles['format'] === 'less') {
	$servant->utilities()->load('less');
	$parser = new lessc();

	// Don't compress in debug mode
	if (!$servant->debug()) {
		$parser->setFormatter('compressed');
	}

	$output .= $parser->parse($styles['content']);

// Parse SCSS
} else if ($styles['format'] === 'scss') {
	$servant->utilities()->load('scss');
	$parser = new scssc();

	// Don't compress in debug mode
	if (!$servant->debug()) {
		$parser->setFormatter('scss_formatter_compressed');
	}

	$output .= $parser->compile($styles['content']);

// Raw CSS, apparently
} else {
	$output .= $styles['content'];
}

$action->output(trim($output));

?>