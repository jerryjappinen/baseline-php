<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', '0');
ini_set('error_log', 'errors.log');
date_default_timezone_set('UTC');



/**
* Welcome
*
* This script is where we route all dynamic requests to.
*
* This is a generic wrapper that clears dangerous globals before running the main program to serve a response for the user.
*/
class Index {

	// Wrapper variables
	private $constantsJson 	= '{}';
	private $debug 			= false;
	private $input 			= array();
	private $paths 			= array();



	/**
	* Basic flow of this wrapper (only runs if global variables aren't cleared)
	*/
	public function __construct () {
		if (isset($_SERVER, $_COOKIE, $_POST, $_GET, $_REQUEST, $_FILES)) {

			// Preparations
			$arguments = func_get_args();
			call_user_func_array(array($this, 'prepare'), $arguments);

			// Get rid of hazardous globals
			// unset($_SERVER);
			unset($_COOKIE, $_POST, $_GET, $_REQUEST, $_FILES, $_SESSION);

			// Run program
			call_user_func(array($this, 'run'));
			return $this;

		}
	}



	/**
	* Prepare parameters for program's initialization before superglobals are cleared
	*/
	private function prepare ($debugHandlerFile, $errorHandlerFile, $helpersDirectory, $classesDirectory, $pathsFile, $constantsDirectory) {

		// Debug mode & errors
		require $debugHandlerFile;
		require $errorHandlerFile;



		// Load helpers
		foreach (glob($helpersDirectory.'*.php') as $path) {
			require_once $path;
		}

		// Load program classes
		foreach (rglob_files($classesDirectory, 'php') as $path) {
			require_once $path;
		}



		// Paths
		require $pathsFile;

		// JSON settings
		$jsons = array();
		foreach (rglob_files($constantsDirectory, 'json') as $path) {
			$jsons[] = unsuffix(unprefix(trim(file_get_contents($path)), '{'), '}');
		}
		$this->constantsJson = '{'.implode(',', $jsons).'}';

		// User input
		$this->input = array(
			'get' => $_GET,
			'post' => $_POST,
			'put' => array(),
			'delete' => array(),
			'files' => $_FILES,
		);



		return $this;
	}



	/**
	* Run the program
	*/
	private function run () {

		// Start and run the main program
		$servant = create_object('ServantMain')->init($this->paths, $this->constantsJson, ($this->debug ? true : false));

		// Input
		$i = $this->input;

		// Serve response
		return $servant->serve($servant->response($i['get'], $i['post'], $i['put'], $i['delete'], $i['files']));

	}

}

new Index(
	'core/debug.php',
	'core/errors.php',
	'core/helpers/',
	'core/classes/',
	'paths.php',
	'constants/'
);
die();

?>