<?php

class ServantPaths extends ServantObject {

	/**
	* Properties
	*/
	protected $propertyDocumentRoot = null;
	protected $propertyRoot 		= null;
	protected $propertyIndex 		= null;
	protected $propertyHost 		= null;

	protected $propertyPages 		= null;
	protected $propertyManifest 	= null;
	protected $propertyTemplate 	= null;
	protected $propertyTheme 		= null;

	protected $propertyActions 		= null;
	protected $propertyCache 		= null;
	protected $propertyTemp 		= null;
	protected $propertyUtilities 	= null;



	/**
	* Kickstart all paths
	*/
	public function initialize ($paths) {

		// These paths are needed
		$pathKeys = array(
			'documentRoot',
			'root',
			'host',
			'index',

			'pages',
			'manifest',
			'template',
			'theme',

			'actions',
			'cache',
			'temp',
			'utilities',
		);

		$results = array();
		$missing = array();

		// Check required paths against against input
		foreach ($pathKeys as $key) {

			// See if input has a value
			if (isset($paths[$key]) and is_string($paths[$key])) {

				// Custom setter
				if ($this->setterExists($key)) {
					$this->callSetter($key, $paths[$key]);

				// Generic setter
				} else {
					$this->setPath($key, $paths[$key]);
				}

			// Path is missing
			} else {
				$missing[] = $key;
			}

		}

		// Error out with report
		if (!empty($missing)) {
			$this->fail('Some paths are missing ("'.limplode('", "', $missing, '" and "').'")');
		}

		return $this;
	}



	/**
	* Public getters
	*/

	/**
	* Root paths
	*/

	public function documentRoot () {
		return $this->get('documentRoot');
	}

	public function root ($format = null) {
		if (!$format) {
			return $this->get('root');
		} else {
			return $this->servant()->format()->path('', $format);
		}
	}

	public function index ($format = null) {
		return $this->getPath('index', $format);
	}

	public function host ($format = null) {
		return $this->getPath('host', $format);
	}



	/**
	* Other paths
	*/
	public function actions ($format = null) {
		return $this->getPath('actions', $format);
	}
	public function cache ($format = null) {
		return $this->getPath('cache', $format);
	}
	public function manifest ($format = null) {
		return $this->getPath('manifest', $format);
	}
	public function temp ($format = null) {
		return $this->getPath('temp', $format);
	}
	public function template ($format = null) {
		return $this->getPath('template', $format);
	}
	public function theme ($format = null) {
		return $this->getPath('theme', $format);
	}
	public function utilities ($format = null) {
		return $this->getPath('utilities', $format);
	}



	/**
	* Convenience getters
	*/

	public function action ($action, $format = null) {
		return $this->actions($format).$action.'/';
	}

	public function userAction ($action, $format = null, $pathParameters) {

		// Accept parameters as a single array or multiple independent values
		$arguments = func_get_args();
		array_shift($arguments);
		array_shift($arguments);
		$pathParameters = array_flatten($arguments);

		// Add parameters to URL
		$pathParameters = (empty($pathParameters) ? '' : implode('/', $pathParameters).'/');

		return $this->userActions($format).$action.'/'.$pathParameters;
	}

	public function userActions ($format = null) {
		return $this->root($format);
	}



	/**
	* Setters
	*/

	protected function setDocumentRoot ($input) {
		return $this->set('documentRoot', $this->sanitize($input, true));
	}

	protected function setManifest ($input) {
		return $this->set('manifest', $this->sanitize($input, false, false));
	}



	/**
	* Private helpers
	*/

	private function getPath ($id, $format = null) {
		return ($format ? $this->servant()->format()->path($this->get($id), $format) : $this->get($id));
	}

	private function setPath ($parameterName, $value) {
		return $this->set($parameterName, $this->sanitize($value));
	}

	/**
	* Sanitize path formatting (results: '', 'foo/', 'foo/bar/')
	*/
	private function sanitize ($path = '', $leadingSlash = false, $trailingSlash = true) {

		// Meaningful starting value
		if (is_string($path)) {
			$result = $path;
		} else {
			$result = '';
		}

		// Slash prefix
		if ($leadingSlash) {
			$result = prefix($result, '/');
		} else {
			$result = unprefix($result, '/');
		}

		// Valid paths get a trailing slash
		if (!empty($result) and $trailingSlash) {
			$result = suffix($result, '/');
		}

		return $result;
	}

}

?>