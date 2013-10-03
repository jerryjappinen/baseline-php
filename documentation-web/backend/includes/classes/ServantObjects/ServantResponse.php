<?php

class ServantResponse extends ServantObject {

	/**
	* Properties
	*/
	protected $propertyBody 			= null;
	protected $propertyBrowserCacheTime = null;
	protected $propertyContentType 		= null;
	protected $propertyCors 			= null;
	protected $propertyExisting 		= null;
	protected $propertyHeaders 			= null;
	protected $propertyPath 			= null;
	protected $propertyStatus 			= null;
	protected $propertyStore 			= null;



	/**
	* Wrapper methods
	*/

	/**
	* Send a response
	*
	* FLAG
	* - Should this be done in ServantMain()?
	* - need to sort out when action is run... maybe its execution should be all under init(), and action isn't even created until we know response doesn't already exist
	* - it's shitty when I have to check if response exists everywhere, but I need to just assume action isn't run then
	*/
	public function serve () {
		$cacheEnabled = $this->servant()->settings()->cache('server') > 0;

		// Response has been saved
		if ($cacheEnabled and $this->existing()) {
			$output = file_get_contents($this->existing('server'));

		// Response needs to be generated
		} else {

			// Run action
			try {
				$this->servant()->action()->run();

			// If it fails, we create error output like gentlemen
			// FLAG we should switch to an error action at this point
			} catch (Exception $exception) {
				$message = $exception->getCode() < 500 ? $exception->getMessage() : 'We\'re sorry. We\'ll try to fix it as soon as possible.';
				$this->servant()->action()->contentType('html')->status(500)->outputViaTemplate(true)->output('<h1>Something went wrong :(</h1><p>'.$message.'</p>');
			}

			// Get action's output, possibly via template
			if ($this->servant()->action()->outputViaTemplate()) {
				$output = $this->servant()->template()->output();
			} else {
				$output = $this->servant()->action()->output();
			}

			// Store if needed
			if ($this->contentType() < 400 and $cacheEnabled and !$this->existing()) {
				$this->store($output);
			}

		}

		// Send headers & print body
		foreach ($this->headers() as $value) {
			header($value);
		}
		echo $output;

		return $this;
	}



	/**
	* Special getters
	*/

	/**
	* Paths in any format
	*/

	public function existing ($format = null) {
		$path = $this->getAndSet('existing');
		if ($format and !empty($path)) {
			$path = $this->servant()->format()->path($path, $format);
		}
		return $path;
	}

	public function path ($format = null) {
		$path = $this->getAndSet('path');
		if ($format) {
			$path = $this->servant()->format()->path($path, $format);
		}
		return $path;
	}



	/**
	* Setters
	*/

	/**
	* Max browser cache time in seconds comes from global settings.
	*/
	protected function setBrowserCacheTime () {
		return $this->set('browserCacheTime', $this->servant()->settings()->cache('browser')*60);
	}



	/**
	* Get content type from action
	*
	* FLAG
	*   - request settings()->defaults('contentType')?
	*/
	protected function setContentType () {

		// Read content type from file extension
		if ($this->existing()) {
			$contentType = pathinfo($this->existing(), PATHINFO_EXTENSION);

		// Get content type from action
		} else {
			$contentType = $this->servant()->action()->contentType();
		}

		// Invalid
		if (!$this->servant()->settings()->contentTypes($contentType)) {
			$this->fail('No valid content type determined');

		// Valid
		} else {
			return $this->set('contentType', $contentType);
		}
	}



	/**
	* CORS is always on for now.
	*/
	protected function setCors () {
		return $this->set('cors', true);
	}



	/**
	* Path to saved response, if one exists (otherwise empty string).
	*
	* NOTE
	* - Action isn't run when a response already exists
	*/
	protected function setExisting () {
		$result = '';

		// Look for a file that matches criteria work
		$path = $this->basePath('server');
		$potential = glob($path.'.*.*');
		if (!empty($potential)) {
			$path = $potential[0];
		}

		// File exists and is not too old
		if (is_file($path) and filemtime($path) < time()+($this->servant()->settings()->cache('server')*60)) {
			$result = $this->servant()->format()->path($path, 'plain', 'server');
		}

		return $this->set('existing', $result);
	}



	/**
	* Relevant response items converted to HTTP header strings.
	*/
	protected function setHeaders () {

		// This is what's included
		$headers = array(
			'browserCacheTime' => '',
			'contentType' => '',
			'cors' => '',
			'status' => '',
		);

		// Run internal methods for getting valid strings
		foreach ($headers as $key => $value) {
			$headers[$key] = $this->servant()->httpHeaders()->$key();
		}

		return $this->set('headers', $headers);
	}



	/**
	* Where to look for or save the response content
	*/
	protected function setPath () {

		// Existing response
		if ($this->existing()) {
			$path = $this->existing();

		// Response doesn't exist, we'll be creating a new one
		// FLAG this is dangerous, action must have been run
		} else {
			$path = $this->basePath().'.'.$this->status().'.'.$this->contentType();
		}

		return $this->set('path', $path);
	}



	/**
	* Status
	*/
	protected function setStatus () {

		// Read status from filename
		if ($this->existing()) {
			$status = explode('.', basename($this->existing()));
			$status = $status[count($status)-2];

		// Get status from action
		} else {
			$status = $this->servant()->action()->status();
		}


		// Invalid status
		if (!$this->servant()->settings()->statuses($status)) {
			$this->fail('Invalid status code given');

		// Valid status
		} else {
			return $this->set('status', $status);
		}
	}



	/**
	* Private helpers
	*/

	/**
	* Base path of saved response.
	*
	* Includes cache folder path, site ID, action ID and page tree. Used by path() and existing().
	*/
	private function basePath ($format = null) {

		// Base dir from settings
		$path = $this->servant()->paths()->cache($format);

		// Action's get their own dir
		$path .= $this->servant()->action()->id().'/';

		// Each page gets their own file
		$path .= implode('/', $this->servant()->pages()->current()->tree());

		return $path;
	}

	/**
	* Save text content
	*/
	private function store ($content) {
		$filepath = $this->path('server');
		$directory = dirname($filepath);

		// Create directory if it doesn't exist
		if (!is_dir($directory)) {
			mkdir($directory, 0777, true);
		}

		file_put_contents($filepath, $content);

		return $this;
	}

}

?>