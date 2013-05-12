<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', '1');
ini_set('log_errors', '1');
mb_internal_encoding('UTF-8');



/**
* Try out misc. stuff with Baseline.php
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



// Create test data
$dump = array();
require_once 'dump.php';



// Print test page
header('Content-Type: text/html; charset=utf-8');
echo '
<html>
	<head>
		<title>Baseline.php</title>
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
				padding: 4em;
			}

			h1 {
				font-weight: 100;
			}

		</style>
	</head>
	<body class="language-javascript">

		'.html_dump($dump).'

		<script src="prism.js"></script>
	</body>
</html>
';

?>