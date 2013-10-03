<?php

/**
* HTML head
*/
echo '
<!DOCTYPE html>
<html lang="'.$servant->site()->language().'">
	<head>
		';

		// Basic meta stuff
		echo '
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<style type="text/css">
			@-ms-viewport{width: device-width;}
			@-o-viewport{width: device-width;}
			@viewport{width: device-width;}
		</style>
		';

		// Site title
		echo '
		<title>'.(!$servant->page()->isHome() ? $servant->page()->name().' &ndash; ' : '').$servant->site()->name().'</title>
		<meta name="application-name" content="'.$servant->site()->name().'">
		';



		// Custom web site icon
		$icon = $servant->site()->icon('domain');
		if (!$icon) {
			$icon = $servant->theme()->icon('domain');
		}
		if ($icon) {
			$extension = pathinfo($icon, PATHINFO_EXTENSION);

			// .ico for browsers
			if ($extension === 'ico') {
				echo '<link rel="shortcut icon" href="'.$icon.'" type="image/x-icon">';

			// Images for browsers, iOS, Windows 8
			} else {
				echo '
				<link rel="icon" href="'.$icon.'" type="'.$servant->settings()->contentTypes($extension).'">
				<link rel="apple-touch-icon-precomposed" href="'.$icon.'" />
				<meta name="msapplication-TileImage" content="'.$icon.'"/>';
				// echo '<meta name="msapplication-TileColor" content="#d83434"/>';
			}

			unset($extension);
		}
		unset($icon);



		// Stylesheets, possibly page-specific
		$tree = array();
		if ($servant->action()->isRead()) {
			$tree = $servant->page()->tree();
		}
		echo '<link rel="stylesheet" href="'.$servant->paths()->userAction('stylesheets', 'domain', $tree).'" media="screen">';
		unset($tree);

		echo '
	</head>
';



/**
* Body starts
*/

// Create classes for body
$i = 1;
$classes = array();
$tree = $servant->page()->tree();
foreach ($tree as $value) {
	$classes[] = 'page-'.implode('-', array_slice($tree, 0, $i));
	$i++;
}
unset($tree, $i, $value);

// Body tag
echo '<body class="level-'.count($servant->page()->tree()).' index-'.$servant->page()->index().' '.implode(' ', $classes).'"><div class="frame">';
unset($classes);

?>