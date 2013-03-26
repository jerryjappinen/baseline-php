<?php
// Root of all problems
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', '1');
date_default_timezone_set('UTC');

// Load Baseline PHP
foreach (glob('baselinephp/*.php') as $path) {
	require_once $path;
}
unset($path);

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

		<p>This is Baseline PHP. Use <em>baselinephp/</em> or <em>baselinephp.php</em>.</p>
		<p>Web site + documentation available at <del><a href="#">eiskis.net/baselinephp</a></del>.</p>

	</body>
</html>
';

?>