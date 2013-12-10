<?php

/**
* Paths service
*/
class ServantPaths extends ServantObject {

	/**
	* Properties
	*/
	protected $propertyDocumentRoot = null;
	protected $propertyRoot 		= null;
	protected $propertyIndex 		= null;
	protected $propertyHost 		= null;

	protected $propertyAssets 		= null;
	protected $propertyData 		= null;
	protected $propertyManifest 	= null;
	protected $propertyPages 		= null;
	protected $propertyTemplates 	= null;

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

			'assets',
			'data',
			'manifest',
			'pages',
			'templates',

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
			return $this->servant()->paths()->format('', $format);
		}
	}

	public function index ($format = null) {
		return $this->getPath('index', $format);
	}

	public function host ($format = null) {
		if ($format === 'url') {
			$format = null;
		}
		return $this->getPath('host', $format);
	}



	/**
	* Other paths
	*/
	public function actions ($format = null) {
		return $this->getPath('actions', $format);
	}
	public function assets ($format = null) {
		return $this->getPath('assets', $format);
	}
	public function cache ($format = null) {
		return $this->getPath('cache', $format);
	}
	public function data ($format = null) {
		return $this->getPath('data', $format);
	}
	public function manifest ($format = null) {
		return $this->getPath('manifest', $format);
	}
	public function pages ($format = null) {
		return $this->getPath('pages', $format);
	}
	public function temp ($format = null) {
		return $this->getPath('temp', $format);
	}
	public function templates ($format = null) {
		return $this->getPath('templates', $format);
	}
	public function utilities ($format = null) {
		return $this->getPath('utilities', $format);
	}



	/**
	* Convenience getters
	*/

	public function action ($action, $format = null) {
		return $this->actions($format).suffix($action, '/');
	}

	public function dataOf ($action, $format = null) {
		return $this->data($format).suffix($action, '/');
	}

	public function endpoint ($action, $format = null, $pathParameters = array()) {
		$arguments = func_get_args();
		unset($arguments[1]);
		return $this->endpoints($format).implode_wrap('', '/', array_flatten($arguments));
	}

	public function endpoints ($format = null) {
		return $this->root($format);
	}

	public function template ($template, $format = null) {
		return $this->templates($format).suffix($template, '/');
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
	* Public helpers
	*/

	/**
	* Convert a path from one format to another
	*/
	public function format ($path, $resultFormat = null, $originalFormat = null) {

		// Don't do anything if it doesn't make sense
		if ($resultFormat != $originalFormat) {

			// Prefixes
			$documentRoot = $this->documentRoot();
			$root = $this->root();
			$host = $this->host();

			// Strip to plain format
			if ($originalFormat === 'server') {
				$path = unprefix($path, $documentRoot.$root);
			} else if ($originalFormat === 'domain') {
				$path = unprefix($path, $root);
			} else if ($originalFormat === 'url') {
				$path = unprefix(unprefix($path, $host), $root);
			}

			// Add prefixes if needed
			if ($resultFormat === 'server') {
				$path = $documentRoot.$root.$path;
			} else if ($resultFormat === 'domain') {
				$path = prefix($root.$path, '/');
			} else if ($resultFormat === 'url') {
				$path = $host.$root.$path;
			}

		}

		return $path;
	}

	/**
	* Sanitize path formatting (results: '', 'foo/', 'foo/bar/')
	*/
	public function sanitize ($path = '', $leadingSlash = false, $trailingSlash = true) {

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



	/**
	* Private helpers
	*/

	private function getPath ($id, $format = null) {
		return ($format ? $this->servant()->paths()->format($this->get($id), $format) : $this->get($id));
	}

	private function setPath ($parameterName, $value) {
		return $this->set($parameterName, $this->sanitize($value));
	}

}

?>