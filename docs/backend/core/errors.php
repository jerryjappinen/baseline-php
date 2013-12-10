<?php

/**
* Primitive, last-resort error handling behavior
*/



/**
* Debug features on localhost
*/
if ($this->debug) {
	ini_set('display_errors', '1');
	error_reporting(error_reporting() & ~E_NOTICE);



/**
* Last-resort error handling in production
*/
} else {

	// Error handler functions
	function handleError ($errorNumber, $errorString) {
		return handleFubar($errorNumber, $errorString);
	}
	function handleException ($exception) {
		return handleFubar($exception->getCode(), $exception->getMessage());
	}
	function handleFubar ($code = 500, $message = '') {
		header('HTTP/1.1 500 Internal Server Error');
		header('Content-Type: text/html; charset=utf-8');
		echo '
		<html>
			<head>
				<title>Server error :(</title>
				<style type="text/css">
					body {
						background-color: #0a74a5;
						color: #fff;
						font-family: sans-serif;
						padding: 10%;
						max-width: 50em;
						margin: 0 auto;
						font-weight: 200;
					}
					h1 {
						font-weight: 200;
						font-size: 2.6em;
					}
				</style>
			</head>
			<body>
				<h1>Something went wrong :(</h1>
				<p>We\'ve been notified now, and will fix this as soon as possible.</p>
			</body>
		</html>
		';

		die();
		return false;
	}
	set_error_handler('handleError');
	set_exception_handler('handleException');

}

?>