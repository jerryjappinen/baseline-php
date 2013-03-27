<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', '1');
ini_set('log_errors', '1');



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
				color: #0d0d0d;
				font-family: sans-serif;
				padding: 5%;
				max-width: 50em;
				margin: 0 auto;
			}
		</style>
	</head>
	<body>

		<h1>Welcome to Baseline PHP!</h1>

		<p>This is Baseline PHP. Include <a href="scripts/generate-release.php?dontsave">baseline.php</a> in your project or dive deeper:</p>
		';



		// Output something using Baseline PHP
		$files = array();
		foreach (rglob_files('source', 'php') as $file) {
			$files[] = to_camelcase(dont_end_with(basename($file), '.php')).'()';
		}
		echo htmlDump($files);



		echo '
		<p>Web site + documentation available at <del><a href="#">eiskis.net/baselinephp</a></del>.</p>

		<p>Run automated tests with <a href="tests/">tests/</a>.</p>

		<p>There are some scripts under <a href="scripts/">scripts/</a> for repeated tasks like generating a single distributable file from the source files.</p>

	</body>
</html>
';

die();

?>