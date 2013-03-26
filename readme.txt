
Baseline PHP
============

- Web site & docs
	- http://www.eiskis.net/baselinephp/
- Source & issues
	- http://bitbucket.org/Eiskis/baseline-php/
- By Jerry Jäppinen
	- Released under LGPL
	- eiskis@gmail.com
	- http://eiskis.net/
	- @Eiskis



Usage
-----

Include all Baseline PHP files in the beginning of your PHP script:

	foreach (glob('baselinephp/*.php') as $path) {
		require_once $path;
	}
	unset($path);



Documentation
-------------

Documentation is available online at http://eiskis.net/baselinephp/



General TODO notes
------------------

- Stop hardcoding class names when validating object type
	- e.g. in ServantArticle, ServantObject
- Add caching
- Set some headers
- Detect localhost to go into debug mode
	- caching disabled
	- debug log visible
