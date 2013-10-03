<?php

/**
* Files component
*
* Read content of files of various formats
*
* Dependencies
*   - servant()->settings()->formats()
*   - servant()->parse()
*   - servant()->paths()->temp()
*
* FLAG
*   - Is there a better name for this?
*/
class ServantFiles extends ServantObject {



	/**
	* Open and get file contents in a renderable format
	*/
	public function read ($path, $type = '') {

		// Automatic file type detection
		if (empty($type)) {
			$extension = pathinfo($path, PATHINFO_EXTENSION);
			foreach ($this->servant()->settings()->formats('templates') as $key => $extensions) {
				if (in_array($extension, $extensions)) {
					$type = $key;
					break;
				}
			}

		}

		// File must exist
		if (is_file($path)) {

			// Type-specific methods
			$methodName = 'read'.ucfirst($type).'File';
			if (method_exists($this, $methodName)) {
				return call_user_func(array($this, $methodName), $path);

			// Generic fallback
			} else {
				return '<pre>'.file_get_contents($path).'</pre>';
			}

		// File doesn't exist
		} else {
			return '';
		}
	}



	/**
	* Private helpers for each format
	*/

	/**
	* HAML
	*
	* FLAG
	*   - saving PHP files cannot possibly be a good idea...
	*   - uniqid() does not quarantee a unique string (I should create the file in a loop, which cannot possibly be a good idea)
	*/
	private function readHamlFile ($path) {

		// Save and read compiled HAML as PHP
		$tempPath = $this->servant()->paths()->temp('server').uniqid(rand(), true).'.php';
		if ($this->saveProcessedFile($tempPath, $this->servant()->parse()->hamlToPhp(file_get_contents($path)))) {
			$output = $this->readPhpFile($tempPath);

		// Didn't work out
		} else {
			$output = '';
		}

		// Clean up temp file
		remove_file($tempPath);

		return $output;
	}

	/**
	* HTML
	*/
	private function readHtmlFile ($path) {
		return file_get_contents($path);
	}

	/**
	* Jade
	*
	* FLAG
	*   - saving PHP files cannot possibly be a good idea...
	*   - uniqid() does not quarantee a unique string (I should create the file in a loop, which cannot possibly be a good idea)
	*/
	private function readJadeFile ($path) {

		// Save and read compiled Jade as PHP
		$tempPath = $this->servant()->paths()->temp('server').uniqid(rand(), true).'.php';
		if ($this->saveProcessedFile($tempPath, $this->servant()->parse()->jadeToPhp(file_get_contents($path)))) {
			$output = $this->readPhpFile($tempPath);

		// Didn't work out
		} else {
			$output = '';
		}

		// Clean up temp file
		remove_file($tempPath);

		return $output;
	}

	/**
	* Markdown
	*/
	private function readMarkdownFile ($path) {
		return $this->servant()->parse()->markdownToHtml(file_get_contents($path));
	}

	/**
	* PHP
	*/
	private function readPhpFile ($path) {
		return run_script($path, array('servant' => $this->servant()));
	}

	/**
	* RST
	*/
	private function readRstFile ($path) {
		return $this->servant()->parse()->rstToHtml(file_get_contents($path));
	}

	/**
	* Textile
	*/
	private function readTextileFile ($path) {
		return $this->servant()->parse()->textileToHtml(file_get_contents($path));;
	}

	/**
	* Twig
	*/
	private function readTwigFile ($path) {
		return $this->servant()->parse()->twigToHtml(file_get_contents($path));
	}

	/**
	* Wiki markup
	*/
	private function readWikiFile ($path) {
		return $this->servant()->parse()->wikiToHtml(file_get_contents($path));
	}



	/**
	* Templates that compile into PHP are run through a temp file
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

}

?>