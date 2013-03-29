
Baseline PHP 0.1
================

- Web site & docs
	- http://www.eiskis.net/baseline-php/
- Source & issues
	- http://bitbucket.org/Eiskis/baseline-php/
- By Jerry Jäppinen
	- Released under LGPL
	- eiskis@gmail.com
	- http://eiskis.net/
	- @Eiskis



Usage
-----

Simply include all Baseline PHP in the beginning of your PHP script:

	require_once 'baseline.php';

You can now use Baseline PHP's functions in the script.



Documentation
-------------

Documentation is available online at http://eiskis.net/baseline-php/



TODO
----

- starts_with() and ends_with() should work like their counterparts
- dont_start_with() and dont_end_with() should match their counterparts, removing any parts of substrings
- tests missing for
	- arrays/
		- array_flatten()
		- array_traverse()
		- limplode()
	- debug/
	- exceptions/
	- files/
	- glob/
	- objects/
	- strings/
		- dont_end_with() *
		- dont_start_with() *
		- from_camelcase() *
		- shorthand_decode() *
