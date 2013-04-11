
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

- Automated tests missing for
	- debug/
		- debug()
		- dump()
		- htmlDump()
	- exceptions/
		- fail()
	- files/
		- move_dir()
		- move_file()
		- remove_dir()
		- remove_file()
		- run_script()
	- glob/
		- glob_dir()
		- glob_files()
		- rglob()
		- rglob_dir()
		- rglob_files()
	- objects/
		- create_object()
	- strings/
		- dont_end_with() *
		- dont_start_with() *
