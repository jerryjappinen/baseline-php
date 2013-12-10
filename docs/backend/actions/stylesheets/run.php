<?php

/**
* FLAG
*   - Not very elegant or dynamic
*/
$urlManipulator = new UrlManipulator();

// Find out what preprocessor formats are supported
$allowedFormats = array();
$temp = $servant->settings()->formats('stylesheets');
unset($temp['css']);
foreach ($temp as $type => $extensions) {
	foreach ($extensions as $extension) {
		$allowedFormats[$extension] = $type;
	}
}
unset($temp, $type, $extensions, $extension);

// All stylesheets go here
$stylesheetSets = array(
	'site' => array('format' => false, 'content' => ''),
	'page' => array('format' => false, 'content' => ''),
);

// We need this for URL manipulations
$actionsPath = $servant->paths()->root('domain');



/**
* Site-wide styles
*
* If SCSS or LESS is used, the first such file determines the type used for the whole set. These cannot be mixed within one set.
*/
foreach ($servant->site()->stylesheets('plain') as $path) {

	// Special format is used
	$extension = pathinfo($path, PATHINFO_EXTENSION);
	if (array_key_exists($extension, $allowedFormats)) {

		// Set's format has not been selected yet, we'll do it now
		if (!$stylesheetSets['site']['format']) {
			$stylesheetSets['site']['format'] = $allowedFormats[$extension];

		// Mixing preprocessor formats will fail
		} else if ($stylesheetSets['site']['format'] !== $allowedFormats[$extension]) {
			fail('CSS preprocessor formats cannot be mixed in assets');
		}

	}
	unset($extension);



	// Root is asset directory root
	$rootUrl = $servant->paths()->assets('domain');

	// We can parse relative path
	$relativeUrl = substr((dirname($path).'/'), strlen($servant->paths()->assets('plain')));

	// Get CSS file contents with URLs replaced
	$stylesheetSets['site']['content'] .= $urlManipulator->cssUrls(file_get_contents($servant->paths()->format($path, 'server')), $rootUrl, $relativeUrl, $actionsPath);
}



/**
* Page-specific style files
*
* FLAG
*   - We only want these in read action (we should print this upon request only - needs input support)
*/

// Select page
$page = $servant->sitemap()->select($input->fetch('queue', 'page', array()));

foreach ($page->stylesheets('plain') as $path) {

	// A preprocessor format is used
	$extension = pathinfo($path, PATHINFO_EXTENSION);
	if (array_key_exists($extension, $allowedFormats)) {

		// Set's format has not been selected yet, we'll do it now
		if (!$stylesheetSets['page']['format']) {
			$stylesheetSets['page']['format'] = $allowedFormats[$extension];

		// Mixing specia formats will fail
		} else if ($stylesheetSets['page']['format'] !== $allowedFormats[$extension]) {
			fail('CSS preprocessor formats cannot be mixed in page styles');
		}

	}
	unset($extension);



	// Root is the root pages directory
	$rootUrl = $servant->paths()->pages('domain');

	// We can parse relative path
	$relativeUrl = substr((dirname($path).'/'), strlen($servant->paths()->pages('plain')));

	// Get CSS file contents with URLs replaced
	$stylesheetSets['page']['content'] .= $urlManipulator->cssUrls(file_get_contents($servant->paths()->format($path, 'server')), $rootUrl, $relativeUrl, $actionsPath);
}



/**
* Output
*/

// Site and page styles use the same superset format; parse as one (so variables from site can be used in page styles, for example)
if ($stylesheetSets['site']['format'] and $stylesheetSets['site']['format'] === $stylesheetSets['page']['format']) {
	$stylesheetSets['site']['content'] = $stylesheetSets['site']['content'].$stylesheetSets['page']['content'];
	unset($stylesheetSets['page']);
}

// Parse sets
$output = '';
foreach ($stylesheetSets as $stylesheetSet) {

	// Parse LESS
	if ($stylesheetSet['format'] === 'less') {
		$servant->utilities()->load('less');
		$parser = new lessc();

		// Don't compress in debug mode
		if (!$servant->debug()) {
			$parser->setFormatter('compressed');
		}

		$output .= $parser->parse($stylesheetSet['content']);

	// Parse SCSS
	} else if ($stylesheetSet['format'] === 'scss') {
		$servant->utilities()->load('scss');
		$parser = new scssc();

		// Don't compress in debug mode
		if (!$servant->debug()) {
			$parser->setFormatter('scss_formatter_compressed');
		}

		$output .= $parser->compile($stylesheetSet['content']);

	// Raw CSS, apparently
	} else {
		$output .= $stylesheetSet['content'];
	}

}



// We're done
$action->output(trim($output));

?>