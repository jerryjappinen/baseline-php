<?php

/**
* Parser component
*
* Convert template formats into HTML, scripts into PHP, stylesheets into CSS
*
* Dependencies
*   - utilities()->load()
*/
class ServantParse extends ServantObject {

	/**
	* HAML to PHP
	*/
	public function hamlToPHP ($haml) {
		$this->servant()->utilities()->load('mthaml');
		$parser = new MtHaml\Environment('php');
		return $parser->compileString($haml, '');
	}

	/**
	* Jade to PHP
	*/
	public function jadeToPhp ($jade) {
		$this->servant()->utilities()->load('jade');
		$parser = new Jade\Jade(true);
		return $parser->render($jade);
	}

	/**
	* Markdown to HTML
	*/
	public function markdownToHtml ($markdown) {
		$this->servant()->utilities()->load('markdown');
		return Markdown($markdown);
	}

	/**
	* Less to CSS
	*/
	public function lessToCss ($less) {
		$this->servant()->utilities()->load('less');
		$parser = new lessc();
		$parser->setFormatter('compressed');
		return $parser->parse($less);
	}

	/**
	* RST to HTML
	*
	* FLAG
	*   - parser is incomplete
	*/
	public function rstToHtml ($rst) {
		$this->servant()->utilities()->load('rst');
		return RST($rst);
	}

	/**
	* SCSS to CSS
	*/
	public function scssToCss ($scss) {
		$this->servant()->utilities()->load('scss');
		$parser = new scssc();
		$parser->setFormatter('scss_formatter_compressed');
		return $parser->compile($scss);
	}

	/**
	* Textile to HTML
	*/
	public function textileToHtml ($textile) {
		$this->servant()->utilities()->load('textile');
		return create_object(new Textile())->textileThis($textile);
	}

	/**
	* Twig to HTML
	*/
	public function twigToHtml ($twig) {
		$this->servant()->utilities()->load('twig');
		return create_object(new Twig_Environment(new Twig_Loader_String()))->render($twig, array('servant' => $this->servant()));
	}

	/**
	* Plain text to HTML
	*/
	public function txtToHtml ($txt) {
		return $this->markdownToHtml($txt);
	}

	/**
	* Wiki markup to HTML
	*
	* FLAG
	*   - parser is incomplete
	*/
	public function wikiToHtml ($wiki) {
		$this->servant()->utilities()->load('wiky');
		$parser = new wiky;
		$html = $parser->parse($wiki);
		return $html ? $html : '';
	}

}

?>