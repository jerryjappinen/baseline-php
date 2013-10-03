<?php

/**
* FLAG
*   - Not very elegant or dynamic
*/
$urlManipulator = new UrlManipulator();

// Allowed superset file extensions, mapped to their format
$allowedFormats = array();
$temp = $servant->settings()->formats('stylesheets');
unset($temp['css']);
foreach ($temp as $type => $extensions) {
	foreach ($extensions as $extension) {
		$allowedFormats[$extension] = $type;
	}
}
unset($temp, $type, $extensions, $extension);

// All stylesheets for site go here
$stylesheetSets = array(
	'theme' => array('format' => false, 'content' => ''),
	'site' => array('format' => false, 'content' => ''),
);

// We need this for URL manipulations
$actionsPath = $servant->paths()->root('domain');



/**
* Theme's style files
*
* If SCSS or LESS is used, the first such file determines the type used for the whole set. These cannot be mixed within one set.
*/
foreach ($servant->theme()->stylesheets('plain') as $path) {

	// Special format is used
	$extension = pathinfo($path, PATHINFO_EXTENSION);
	if (array_key_exists($extension, $allowedFormats)) {

		// Set's format has not been selected yet, we'll do it now
		if (!$stylesheetSets['theme']['format']) {
			$stylesheetSets['theme']['format'] = $allowedFormats[$extension];

		// Mixing specia formats will fail
		} else if ($stylesheetSets['theme']['format'] !== $allowedFormats[$extension]) {
			fail('CSS preprocessor formats cannot be mixed in a theme package');
		}

	}
	unset($extension);



	// Root is theme directory root
	$rootUrl = $servant->theme()->path('domain');

	// We can parse relative path
	$relativeUrl = substr((dirname($path).'/'), strlen($servant->theme()->path('plain')));

	// Get CSS file contents with URLs replaced
	$stylesheetSets['theme']['content'] .= $urlManipulator->cssUrls(file_get_contents($servant->format()->path($path, 'server')), $rootUrl, $relativeUrl, $actionsPath);
}



/**
* Site's style files
*/
foreach ($servant->pages()->current()->stylesheets('plain') as $path) {

	// Special format is used
	$extension = pathinfo($path, PATHINFO_EXTENSION);
	if (array_key_exists($extension, $allowedFormats)) {

		// Set's format has not been selected yet, we'll do it now
		if (!$stylesheetSets['site']['format']) {
			$stylesheetSets['site']['format'] = $allowedFormats[$extension];

		// Mixing specia formats will fail
		} else if ($stylesheetSets['site']['format'] !== $allowedFormats[$extension]) {
			fail('CSS preprocessor formats cannot be mixed in site styles');
		}

	}
	unset($extension);



	// Root is site directory root
	$rootUrl = $servant->pages()->path('domain');

	// We can parse relative path
	$relativeUrl = substr((dirname($path).'/'), strlen($servant->pages()->path('plain')));

	// Get CSS file contents with URLs replaced
	$stylesheetSets['site']['content'] .= $urlManipulator->cssUrls(file_get_contents($servant->format()->path($path, 'server')), $rootUrl, $relativeUrl, $actionsPath);
}



/**
* Output
*/

// Theme and site styles use the same superset format; parse as one (so variables from theme can be used in site styles, for example)
if ($stylesheetSets['theme']['format'] and $stylesheetSets['theme']['format'] === $stylesheetSets['site']['format']) {
	$stylesheetSets['theme']['content'] = $stylesheetSets['theme']['content'].$stylesheetSets['site']['content'];
	unset($stylesheetSets['site']);
}

// Parse sets
$output = '';
foreach ($stylesheetSets as $stylesheetSet) {

	// Special format is used
	if ($stylesheetSet['format']) {
		$methodName = $stylesheetSet['format'].'ToCss';

		// Parse if possible
		if (method_exists($servant->parse(), $methodName)) {
			$output .= $servant->parse()->$methodName($stylesheetSet['content']);
		} else {
			fail(strtoupper($stylesheetSet['format']).' stylesheets are not supported.');
		}

	// Raw CSS
	} else {
		$output .= $stylesheetSet['content'];
	}

}



// We're done
$servant->action()->output(trim($output));

?>