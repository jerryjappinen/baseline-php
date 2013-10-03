<?php

/**
* Formatting service
*
* Dependencies
*   - servant()->site()->pageNames()
*   - servant()->paths()->documentRoot()
*   - servant()->paths()->root()
*/
class ServantFormat extends ServantObject {



	/**
	* Generate human-readable title for page from string
	*/
	public function pageName ($string) {
		$name = $string;

		// Explicit names given
		$replacements = $this->servant()->site()->pageNames();
		$key = mb_strtolower($string);
		if ($replacements and is_array($replacements) and array_key_exists($key, $replacements)) {
			$name = $replacements[$key];

		// Generate
		} else {
			$name = $this->title($string);
		}

		return $name;
	}



	/**
	* Create human-readable title from something like a filename
	*/
	public function title ($string) {
		$conversions = $this->servant()->settings()->namingConvention();
		return ucfirst(trim(str_ireplace(array_keys($conversions), array_values($conversions), $string)));
	}



	/**
	* Convert a path from one format to another
	*/
	public function path ($path, $resultFormat = null, $originalFormat = null) {

		// Don't do anything if it doesn't make sense
		if ($resultFormat != $originalFormat) {

			// Prefixes
			$documentRoot = $this->servant()->paths()->documentRoot();
			$root = $this->servant()->paths()->root();
			$host = $this->servant()->paths()->host();

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



}

?>