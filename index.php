<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', '1');
ini_set('log_errors', '1');
mb_internal_encoding('UTF-8');
date_default_timezone_set('UTC');



// Load Baseline PHP
require_once 'baseline.php';

// Print welcome page
header('Content-Type: text/html; charset=utf-8');
echo '
<html>
	<head>
		<title>Baseline PHP</title>
		<style type="text/css">
			body {
				background-color: #fafafa;
				color: #333;
				font-family: sans-serif;
				padding: 5%;
				max-width: 50em;
				margin: 0 auto;
			}
			a, a:visited {
				color: #0080bf;
			}
		</style>
	</head>
	<body>

		<h1>Welcome to Baseline PHP!</h1>

		<p>This is Baseline PHP. Include <a href="release/?dontsave">baseline.php</a> in your project or dive deeper:</p>

		<h3>Available functions</h3>
		<ul>
		';

		// Output list based on source files
		$files = array();
		foreach (rglob_files('source', 'php') as $file) {
			echo '<li><code>'.to_camelcase(unsuffix(basename($file), '.php')).'()</code></li>';
		}



		echo '
		</ul>

		<p>Web site + documentation available at <a href="#">eiskis.net/baselinephp</a>.</p>

		<p>Run automated tests with <a href="tests/">tests/</a>.</p>

		<p>There are some scripts under <a href="scripts/">scripts/</a> for repeated tasks like generating a single distributable file from the source files.</p>

	</body>
</html>
';

die();

?>