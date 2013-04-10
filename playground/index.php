<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', '1');
ini_set('log_errors', '1');
mb_internal_encoding('UTF-8');



/**
* Try out misc. stuff with Baseline PHP functions
*/

// Used for loading source files
function loadSourceFiles ($root) {
	$files = array();

	// Files first
	foreach (glob($root.'*') as $path) {
		if (is_file($path)) {
			$files[] = $path;
		}
	}

	// Then subdirectories
	foreach (glob($root.'*', GLOB_ONLYDIR) as $path) {
		$path = $path.'/';
		if (is_dir($path)) {
			$files = array_merge($files, loadSourceFiles($path));
		}
	}

	return $files;
}



// Load release
// require_once '../baseline.php';

// Load from source
foreach (loadSourceFiles('../source/') as $file) {
	require_once $file;
}



$dump = array(

	// Trim text
	trim_text('foo bar'),
	trim_text('    foo bar   '),
	trim_text('    foo     bar   '),
	trim_text("\n\n".'    fo'."\n".'o  '."\n\n\n\n\n".'   bar   '."\n\n"),

	// // Array flatten
	// array_flatten(array()),
	// array_flatten(array('', array('', 0, false, null))),
	// array_flatten(array(1, 2, 3)),
	// array_flatten(array(1, 2, array('a', 'b'), 3)),

	// // Limplode
	// limplode(', ', array(), ' and '),
	// limplode(', ', array(1), ' and '),
	// limplode(', ', array(1, 2), ' and '),
	// limplode(', ', array(1, 2, 3), ' and '),
	// limplode(', ', array(1, 2, 3, 4), ' and '),
	// limplode(', ', array(1, 2, array(), 3, 4), ' and '),

	// // Dont end with
	// dont_end_with('Foo', ''),
	// dont_end_with('Foo', 'o'),
	// dont_end_with('Bar', 'ar'),
	// dont_end_with('Bar', 'rfoo'),
	// dont_end_with('foo', 'afoo'),

	// dont_end_with('www.eiskis.net/', '/'),
	// dont_end_with('www.eiskis.net/search', '/'),
	// dont_end_with('www.eiskis.net/search/', '/'),
	// dont_end_with('www.eiskis.net/search/', '/search/'),
	// dont_end_with('jerry', '- jerry'),

	// // Ends with
	// 'ends_with' => array(
	// 	ends_with('äää', ''),
	// 	ends_with('äää', 'ä'),
	// 	ends_with('äää', 'Ä'),
	// 	ends_with('äää', 'a'),
	// 	ends_with('äää', 'A'),
	// 	ends_with('äää', 'ö'),
	// ),
	// 'ends_with_2' => array(
	// 	ends_with('ÄÄÄ', ''),
	// 	ends_with('ÄÄÄ', 'Ä'),
	// 	ends_with('ÄÄÄ', 'ä'),
	// 	ends_with('ÄÄÄ', 'A'),
	// 	ends_with('ÄÄÄ', 'a'),
	// 	ends_with('ÄÄÄ', 'ö'),
	// ),

	// // Starts with
	// 'starts_with' => array(
	// 	starts_with('äää', ''),
	// 	starts_with('äää', 'ä'),
	// 	starts_with('äää', 'Ä'),
	// 	starts_with('äää', 'a'),
	// 	starts_with('äää', 'A'),
	// 	starts_with('äää', 'ö'),
	// ),
	// 'starts_with_2' => array(
	// 	starts_with('ÄÄÄ', ''),
	// 	starts_with('ÄÄÄ', 'Ä'),
	// 	starts_with('ÄÄÄ', 'ä'),
	// 	starts_with('ÄÄÄ', 'A'),
	// 	starts_with('ÄÄÄ', 'a'),
	// 	starts_with('ÄÄÄ', 'ö'),
	// ),

	// // Start with
	// 'start_with' => array(
	// 	start_with('integer', 'INT', true),
	// 	start_with('integer', 'int', true),
	// 	start_with('eger', 'INTEG', true),
	// 	start_with('eger', 'integ', true),
	// 	start_with('/path/foo', '//'),
	// 	start_with('fooo', 'ofo'),
	// 	start_with('tp://index.php', 'http://'),
	// 	start_with('tp://index.php', 'http://'),
	// 	start_with('ol', 'Looo'),
	// ),

	// // End with
	// 'end_with' => array(
	// 	end_with('integer', 'eger'),
	// 	end_with('eger', 'eger'),
	// 	end_with('eger', 'egereger'),
	// 	end_with('/path/foo/', '//'),
	// 	end_with('fo', 'ofo'),
	// 	end_with('index.', '.php'),
	// 	end_with('domain.com/', '/search/'),
	// 	end_with('Lo', 'ol'),
	// ),

	// // To camelCase
	// 'to_camelcase' => array(
	// 	to_camelcase('-foo'),
	// 	to_camelcase('_snake_case'),
	// 	to_camelcase('using-dash-separators'),
	// 	to_camelcase('Using-Capital-Dash-Separators'),
	// 	to_camelcase('ALL_UPPER_CASE'),
	// 	to_camelcase('normal spaces'),
	// 	to_camelcase('alreadyCamelCase'),
	// 	to_camelcase('Öö_ääkkösiä'),
	// ),

	// // To camelCase, preserve capitals off
	// 'to_camelcase_preserve_capitals' => array(
	// 	to_camelcase('-foo', true),
	// 	to_camelcase('_snake_case', true),
	// 	to_camelcase('using-dash-separators', true),
	// 	to_camelcase('Using-Capital-Dash-Separators', true),
	// 	to_camelcase('ALL_UPPER_CASE', true),
	// 	to_camelcase('normal spaces', true),
	// 	to_camelcase('alreadyCamelCase', true),
	// 	to_camelcase('Öö_ääkkösiä', true),
	// ),

	// // To camelCase, preserve capitals off
	// 'from_camelcase' => array(
	// 	// from_camelcase('FooBARblah'),
	// 	// from_camelcase('Foo Bar Blah'),
	// 	// from_camelcase('FooBarBlah'),
	// 	// ucfirst(from_camelcase('FooBarBlah')).'.',
	// 	// ucwords(from_camelcase('FooBarBlah')),
	// 	from_camelcase(array(123)),
	// ),

);



// Print test page
header('Content-Type: text/html; charset=utf-8');
echo '
<html>
	<head>
		<title>Baseline PHP</title>
		<link rel="stylesheet" href="prism.css" media="screen">
		<style type="text/css">

			body {
				background-color: #f2f2f2;
				color: #373f45;
				font-family: sans-serif;
				padding: 5% 5% 8em 5%;
				max-width: 65em;
				margin: 0 auto;
				font-weight: 200;
				line-height: 1.6;
			}

			pre {
				background-color: #fff;
				box-shadow: 0 1px 1px 1px #ddd;
				padding: 1.5em;
			}

			h1 {
				font-weight: 100;
			}

		</style>
	</head>
	<body class="language-javascript">

		<h1>Baseline PHP</h1>

		'.html_dump($dump).'

		<script src="prism.js"></script>
	</body>
</html>
';

?>