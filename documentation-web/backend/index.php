<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', '0');
ini_set('error_log', 'errors.log');
date_default_timezone_set('UTC');



/**
* Welcome to Servant
*
* This script is where we route all dynamic requests to. It creates an instance of Servant and runs it to serve a response.
*/
class Index {
	public function __construct () {
		if (isset($_SERVER, $_COOKIE, $_POST, $_GET, $_REQUEST, $_FILES)) {
			try {

				// Arbitrary preparations
				$arguments = func_get_args();
				$preparation = call_user_func_array(array($this, 'prepare'), $arguments);

				// Get rid of hazardous globals
				unset($_SERVER, $_COOKIE, $_POST, $_GET, $_REQUEST, $_FILES);

				// Run program
				call_user_func_array(array($this, 'run'), $preparation);
				return $this;

			} catch (Exception $e) {
				die();				
			}
		}
	}



	/**
	* Prepare parameters for program's initialization before superglobals are cleared
	*/
	private function prepare ($errorHandlerFile, $helpersDirectory, $classesDirectory, $pathsFile, $constantsDirectory) {

		// Errors
		require $errorHandlerFile;

		// Load helpers
		foreach (glob($helpersDirectory.'*.php') as $path) {
			require_once $path;
		}

		// Load servant classes
		foreach (rglob_files($classesDirectory, 'php') as $path) {
			require_once $path;
		}



		// Paths
		$paths = array();
		require $pathsFile;

		// JSON settings
		$jsons = array();
		foreach (rglob_files($constantsDirectory, 'json') as $path) {
			$jsons[] = unsuffix(unprefix(file_get_contents($path), '{'), '}');
		}
		$constantsJson = '{'.implode(',', $jsons).'}';

		// User input
		$input = $_GET;



		// These will be passed to the runner
		return array($paths, $constantsJson, $input);
	}



	/**
	* Run the program
	*/
	private function run ($paths, $constants, $input) {

		// Start and run a Servant instance
		$servant = new ServantMain();
		$servant->init($paths, $constants, $input);
		$servant->run();

	}

}

new Index(
	'includes/errors.php',
	'includes/helpers/',
	'includes/classes/',
	'includes/paths.php',
	'includes/constants/'
);
die();

?>