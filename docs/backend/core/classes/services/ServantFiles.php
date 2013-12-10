<?php

/**
* File reader service
*
* Read content of files of various templating formats
*
* DEPENDENCIES
*   ServantSettings -> formats
*   ServantPaths 	-> temp
*
* FLAG
*   - Add support for LESS and SCSS
*/
class ServantFiles extends ServantObject {



	/**
	* Open and get file contents in a renderable format
	*
	* FLAG
	*   - Add support for reading multiple files with shared scriptVariables
	*/
	public function read ($files, $scriptVariables = array()) {

		// Run each file
		$output = '';
		foreach (array_flatten(to_array($files)) as $file) {
			if (is_string($file) and is_file($file)) {

				// Run file
				$reader = $this->readFile($file, $scriptVariables);
				$output .= $reader['output'];
				$scriptVariables = $reader['scriptVariables'];
				unset($reader);

			}
		}


		return $output;
	}






	/**
	* Private helpers
	*/

	/**
	* Read individual file, with format-specific reader if available
	*/
	private function readFile ($path, $scriptVariables) {
		$result = '';

		// Detect file type
		$type = '';
		$extension = pathinfo($path, PATHINFO_EXTENSION);

		// FLAG I should take all formats into account, not just templates
		$formats = $this->servant()->settings()->formats('templates');
		foreach ($formats as $key => $extensions) {
			if (in_array($extension, $extensions)) {
				$type = $key;
				break;
			}
		}

		// Type-specific methods
		$methodName = 'read'.ucfirst($type).'File';
		if ($type and method_exists($this, $methodName)) {
			$result = call_user_func(array($this, $methodName), $path, $scriptVariables);

		// Generic fallback (reads file as direct output)
		} else {
			$result = array(
				'output' => file_get_contents($path),
				'scriptVariables' => $scriptVariables,
			);
		}

		return $result;
	}

	/**
	* Templates that compile into PHP are evaluated through a temp file
	*/
	private function saveProcessedFile ($path, $content) {

		// Create directory if it doesn't exist
		$directory = dirname($path);
		if (!is_dir($directory)) {
			mkdir($directory, 0777, true);
		}

		// File might already exist
		if (is_file($path)) {
			return false;
		} else {
			return file_put_contents($path, $content);
		}

	}





	/**
	* Format-specific readers
	*/

	/**
	* HAML
	*
	* FLAG
	*   - saving PHP files cannot possibly be a good idea...
	*   - uniqid() does not quarantee a unique string (I should create the file in a loop, which cannot possibly be a good idea)
	*/
	private function readHamlFile ($path, $scriptVariables = array()) {

		// Save and read compiled HAML as PHP
		$tempPath = $this->servant()->paths()->temp('server').uniqid(rand(), true).'.php';
		if ($this->saveProcessedFile($tempPath, $this->convertHamlToPhp(file_get_contents($path)))) {
			$result = $this->readPhpFile($tempPath, $scriptVariables);

		// Didn't work out
		} else {
			$result = array(
				'output' => '',
				'scriptVariables' => $scriptVariables,
			);
		}

		// Clean up temp file
		remove_file($tempPath);

		return $result;
	}

	/**
	* HTML
	*/
	private function readHtmlFile ($path, $scriptVariables = array()) {
		return array(
			'output' => file_get_contents($path),
			'scriptVariables' => $scriptVariables,
		);
	}

	/**
	* Jade
	*
	* FLAG
	*   - saving PHP files cannot possibly be a good idea...
	*   - uniqid() does not quarantee a unique string (I should create the file in a loop, which cannot possibly be a good idea)
	*/
	private function readJadeFile ($path, $scriptVariables = array()) {

		// Save and read compiled Jade as PHP
		$tempPath = $this->servant()->paths()->temp('server').uniqid(rand(), true).'.php';
		if ($this->saveProcessedFile($tempPath, $this->convertJadeToPhp(file_get_contents($path)))) {
			$result = $this->readPhpFile($tempPath, $scriptVariables);

		// Didn't work out
		} else {
			$result = array(
				'output' => '',
				'scriptVariables' => $scriptVariables,
			);
		}

		// Clean up temp file
		remove_file($tempPath);

		return $result;
	}

	/**
	* Markdown
	*/
	private function readMarkdownFile ($path, $scriptVariables = array()) {
		return array(
			'output' => $this->convertMarkdownToHtml(file_get_contents($path), $scriptVariables),
			'scriptVariables' => $scriptVariables,
		);
	}

	/**
	* PHP
	*/
	private function readPhpFile () {

		// Check for the file
		$file = func_get_arg(0);
		if (is_file($file)) {
			unset($file);

			// Set script variables
			foreach (func_get_arg(1) as $____key => $____value) {
				if (is_string($____key) and !in_array($____key, array('____key', '____value'))) {
					${$____key} = $____value;
				}
			}
			unset($____key, $____value);

			// Prepare output buffer
			ob_start();

			// Include script
			include func_get_arg(0);

			// Store script variables, potentially treated by the script
			$scriptVariables = get_defined_vars();

			// Catch output reliably
			$output = ob_get_contents();
			if (!is_string($output)) {
				$output = '';
			}

			// Clear buffer
			ob_end_clean();

		}

		// Return any output
		return array(
			'output' => $output,
			'scriptVariables' => $scriptVariables,
		);

	}

	/**
	* RST
	*/
	private function readRstFile ($path, $scriptVariables = array()) {
		return array(
			'output' => $this->convertRstToHtml(file_get_contents($path), $scriptVariables),
			'scriptVariables' => $scriptVariables,
		);
	}

	/**
	* Textile
	*/
	private function readTextileFile ($path, $scriptVariables = array()) {
		return array(
			'output' => $this->convertTextileToHtml(file_get_contents($path), $scriptVariables),
			'scriptVariables' => $scriptVariables,
		);
	}

	/**
	* Twig
	*/
	private function readTwigFile ($path, $scriptVariables = array()) {
		return array(
			'output' => $this->convertTwigToHtml(file_get_contents($path), $scriptVariables),
			'scriptVariables' => $scriptVariables,
		);
	}

	/**
	* Wiki markup
	*/
	private function readWikiFile ($path, $scriptVariables = array()) {
		return array(
			'output' => $this->convertWikiToHtml(file_get_contents($path), $scriptVariables),
			'scriptVariables' => $scriptVariables,
		);
	}






	/**
	* Format-to-format converters for output
	*/

	/**
	* PHP from HAML
	*/
	private function convertHamlToPhp ($haml, $scriptVariables = array()) {
		$this->servant()->utilities()->load('mthaml');
		$parser = new MtHaml\Environment('php');
		return $parser->compileString($haml, '');
	}

	/**
	* PHP from Jade
	*/
	private function convertJadeToPhp ($jade, $scriptVariables = array()) {
		$this->servant()->utilities()->load('jade');
		$parser = new Jade\Jade(true);
		return $parser->render($jade);
	}

	/**
	* HTML from Markdown
	*/
	private function convertMarkdownToHtml ($markdown, $scriptVariables = array()) {
		$this->servant()->utilities()->load('markdown');
		return Markdown($markdown);
	}

	/**
	* HTML from RST
	*
	* FLAG
	*   - parser is incomplete
	*/
	private function convertRstToHtml ($rst, $scriptVariables = array()) {
		$this->servant()->utilities()->load('rst');
		return RST($rst);
	}

	/**
	* HTML from Textile
	*/
	private function convertTextileToHtml ($textile, $scriptVariables = array()) {
		$this->servant()->utilities()->load('textile');
		return create_object('Textile')->textileThis($textile);
	}

	/**
	* HTML from Twig
	*
	* FLAG
	*   - Retrieving changed variables is not possible
	*/
	private function convertTwigToHtml ($twig, $scriptVariables = array()) {
		$this->servant()->utilities()->load('twig');
		return create_object('Twig_Environment', create_object('Twig_Loader_String'))->render($twig, $scriptVariables);
	}

	/**
	* HTML from Plain text
	*/
	private function convertTxtToHtml ($txt, $scriptVariables = array()) {
		return $this->markdownToHtml($txt);
	}

	/**
	* HTML from Wiki markup
	*
	* FLAG
	*   - parser is incomplete
	*/
	private function convertWikiToHtml ($wiki, $scriptVariables = array()) {
		$this->servant()->utilities()->load('wiky');
		$parser = new wiky;
		$html = $parser->parse($wiki);
		return $html ? $html : '';
	}



}

?>