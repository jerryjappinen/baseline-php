<?php

/**
* Manipulate URLs to point to right places on the domain
*
* FLAG
*   - Doing a LOT of replacements here, more could probably be done in one go
*   - Protocols should not be hardcoded
*   - Linking to actions or assets/pages/template folders could be done with pseudo protocol syntax: "actions://", "pages://", "assets://"
*		-> This could be used internally: use one of these as a default root when there are root-relative URLs
*/
class UrlManipulator {

	/**
	* URLs in HTML
	*/
	public function htmlUrls ($string, $srcRootPath, $srcRelativePath = '', $hrefRootPath = null, $hrefRelativePath = '', $actionsPath = null) {

		// Fallbacks
		if (!is_string($hrefRootPath)) {
			$hrefRootPath = $srcRootPath;
			$hrefRelativePath = $srcRelativePath;
		}
		if (!is_string($actionsPath)) {
			$actionsPath = $hrefRootPath;
		}

		// Escaped URLs should be turned to URL friendly
		// array('/','\\'), array('%252F','%255C')

		return preg_replace(array(

			// // 1 src=" ... \/ ... "
			// '/(src)\s*=\s*[\"\'](?:\/)([^"\']*)[\"\']/U',

			// // 2 src=" ... \\ ... "
			// '/(src)\s*=\s*[\"\'](?:\/)([^"\']*)[\"\']/U',

			// 3 src="/foo"
			'/(src)\s*=\s*[\"\'](?:\/)(?!\/)([^"\']*)[\"\']/U',

			// 4 src="//foo" points to actions
			'/(src)\s*=\s*[\"\'](?:\/\/)([^"\']*)[\"\']/U',

			// 5 src="foo", but not src="http://foo"
			'/(src)\s*=\s*[\"\'](?!\/|http:|https:|skype:|ftp:|#|mailto:|tel:)([^"\']*)[\"\']/U',

			// 6 href="/bar"
			'/(href)\s*=\s*[\"\'](?:\/)(?!\/)([^"\']*)[\"\']/U',

			// 7 href="//bar" points to actions
			'/(href)\s*=\s*[\"\'](?:\/\/)([^"\']*)[\"\']/U',

			// 8 href="bar", but not href="http://bar"
			'/(href)\s*=\s*[\"\'](?!\/|http:|https:|skype:|ftp:|#|mailto:|tel:)([^"\']*)[\"\']/U',

		), array(
			// '%252F',											// 1
			// '%255C',											// 2
			'\\1'.'="'.$srcRootPath.'\\2"',						// 3
			'\\1'.'="'.$actionsPath.'\\2"',						// 4
			'\\1'.'="'.$srcRootPath.$srcRelativePath.'\\2"',	// 5
			'\\1'.'="'.$hrefRootPath.'\\2"',					// 6
			'\\1'.'="'.$actionsPath.'\\2"',						// 7
			'\\1'.'="'.$hrefRootPath.$hrefRelativePath.'\\2"',	// 8
		), $string);

	}



	/**
	* URLs in CSS
	*/
	public function cssUrls ($string, $rootPath, $relativePath = '', $actionsPath = null) {

		// Fallbacks
		if (!is_string($actionsPath)) {
			$actionsPath = $hrefRootPath;
		}

		return preg_replace(array(

			// 1 url( ... \\ ... )
			// '/url\(\s*("|\')?([^"\')]*)("|\')?\)/',

			// 2 url( ... \\ ... )
			// '/url\(\s*("|\')?([^"\')]*)("|\')?\)/',

			// 3 url(/foo) - root-relative internal URLs
			'/url\(\s*("|\')?(?:\/)(?!\/)([^"\')]*)("|\')?\)/',

			// 4 url(//foo) - URLs to actions
			'/url\(\s*("|\')?(?:\/\/)([^"\')]*)("|\')?\)/',

			// 5 url(foo) - relative internal URLs
			'/url\(\s*("|\')?(?!\/|http:|https:|skype:|ftp:|#|mailto:|tel:)([^"\')]*)("|\')?\)/',

		), array(
			// '%252F',									// 1
			// '%255C',									// 2
			'url("'.$rootPath.'\\2")',					// 3
			'url("'.$actionsPath.'\\2")',				// 4
			'url("'.$rootPath.$relativePath.'\\2")',	// 5
		), $string);

	}

}

?>