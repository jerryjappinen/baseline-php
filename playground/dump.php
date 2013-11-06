<?php

/**
* Run a script file cleanly (no visible variables left around).
*
* @param 1 ($path)
*   Path to a file.
*
* @param 2 ($scriptVariables)
*   Array of variables and values to be created for the script.
*
* @param 3 ($queue)
*   Array of other scripts to include, with variables carried over from previous scripts. When a missing file is encountered, execution on the queue stops.
*
* @return 
*   String content of output buffer after the script has run, false on failure.
*/
function run_scripts () {
	$output = false;

	$path = func_get_arg(0);
	if (is_file($path)) {
		unset($path);

		// Set up variables for the script
		foreach (func_get_arg(1) as $____key => $____value) {
			if (is_string($____key) and !in_array($____key, array('____key', '____value'))) {
				${$____key} = $____value;
			}
		}
		unset($____key, $____value);

		// Run each script
		ob_start();

		// Include script
		include func_get_arg(0);

		// Store script variables
		$definedVars = get_defined_vars();

		// Catch output reliably
		$output = ob_get_contents();
		if ($output === false) {
			$output = '';
		}

		// Clear buffer
		ob_end_clean();

		// More scripts to include
		if (func_num_args() > 2) {

			// Normalize queue
			$queue = func_get_arg(2);
			$queue = array_flatten(to_array($queue));
			$next = array_shift($queue);

			// Run other scripts
			$others = run_scripts($next, $definedVars, $queue);
			if ($others) {
				return $output.$others;
			}

		}

	}

	// Return any output
	return $output;
}

$testFiles = rglob_files('run_scripts/', 'php');
// $testFiles[2] = 'run_scripts/NOTREAL.php';
$testFirst = array_shift($testFiles);
$testVars = array(
	'esa' => 'pekka'
);
$dump = run_scripts($testFirst, $testVars, $testFiles);
// $dump = array(

	// trim_whitespace(' 



	// 	asd		00	 asoi dopaskpd ksaölk dölaks dölaskdöla skdoj

	// 	'),

// 	// Trim text
// 	trim_text('foo bar'),
// 	trim_text('    foo bar   '),
// 	trim_text('    foo     bar   '),
// 	trim_text("\n\n".'         f  		d		d	  o '."\n".' o  '."\n\n\n\n\n\n".'   bar   '."\n\n", true),
// 	trim_text('


// 				This is my favorite M  O  V  I   E!!


    	  	 	 	 
    	  	 	 	 
    	  	 	 	 


// YY  Y E E E E E     AAAAAAAHHH!!!!
// ', true),

	// // Array flatten
	// array_flatten(array()),
	// array_flatten(array('', array('', 0, false, null))),
	// array_flatten(array(1, 2, 3)),
	// array_flatten(array(1, 2, array('a', 'b'), 3)),

	// // Limplode
	// limplode(', ', array(), ' and '),
	// limplode(', ', array(1), ' and '),
	// limplode(', ', array(1, 2), ' and '),
	// limplode(', ', array(1, 2, 3), ' and '),
	// limplode(', ', array(1, 2, 3, 4), ' and '),
	// limplode(', ', array(1, 2, array(), 3, 4), ' and '),

	// // Dont end with
	// dont_end_with('Foo', ''),
	// dont_end_with('Foo', 'o'),
	// dont_end_with('Bar', 'ar'),
	// dont_end_with('Bar', 'rfoo'),
	// dont_end_with('foo', 'afoo'),

	// dont_end_with('www.eiskis.net/', '/'),
	// dont_end_with('www.eiskis.net/search', '/'),
	// dont_end_with('www.eiskis.net/search/', '/'),
	// dont_end_with('www.eiskis.net/search/', '/search/'),
	// dont_end_with('jerry', '- jerry'),

	// // Ends with
	// 'ends_with' => array(
	// 	ends_with('äää', ''),
	// 	ends_with('äää', 'ä'),
	// 	ends_with('äää', 'Ä'),
	// 	ends_with('äää', 'a'),
	// 	ends_with('äää', 'A'),
	// 	ends_with('äää', 'ö'),
	// ),
	// 'ends_with_2' => array(
	// 	ends_with('ÄÄÄ', ''),
	// 	ends_with('ÄÄÄ', 'Ä'),
	// 	ends_with('ÄÄÄ', 'ä'),
	// 	ends_with('ÄÄÄ', 'A'),
	// 	ends_with('ÄÄÄ', 'a'),
	// 	ends_with('ÄÄÄ', 'ö'),
	// ),

	// // Starts with
	// 'starts_with' => array(
	// 	starts_with('äää', ''),
	// 	starts_with('äää', 'ä'),
	// 	starts_with('äää', 'Ä'),
	// 	starts_with('äää', 'a'),
	// 	starts_with('äää', 'A'),
	// 	starts_with('äää', 'ö'),
	// ),
	// 'starts_with_2' => array(
	// 	starts_with('ÄÄÄ', ''),
	// 	starts_with('ÄÄÄ', 'Ä'),
	// 	starts_with('ÄÄÄ', 'ä'),
	// 	starts_with('ÄÄÄ', 'A'),
	// 	starts_with('ÄÄÄ', 'a'),
	// 	starts_with('ÄÄÄ', 'ö'),
	// ),

	// // Start with
	// 'start_with' => array(
	// 	start_with('integer', 'INT', true),
	// 	start_with('integer', 'int', true),
	// 	start_with('eger', 'INTEG', true),
	// 	start_with('eger', 'integ', true),
	// 	start_with('/path/foo', '//'),
	// 	start_with('fooo', 'ofo'),
	// 	start_with('tp://index.php', 'http://'),
	// 	start_with('tp://index.php', 'http://'),
	// 	start_with('ol', 'Looo'),
	// ),

	// // End with
	// 'end_with' => array(
	// 	end_with('integer', 'eger'),
	// 	end_with('eger', 'eger'),
	// 	end_with('eger', 'egereger'),
	// 	end_with('/path/foo/', '//'),
	// 	end_with('fo', 'ofo'),
	// 	end_with('index.', '.php'),
	// 	end_with('domain.com/', '/search/'),
	// 	end_with('Lo', 'ol'),
	// ),

	// // To camelCase
	// 'to_camelcase' => array(
	// 	to_camelcase('-foo'),
	// 	to_camelcase('_snake_case'),
	// 	to_camelcase('using-dash-separators'),
	// 	to_camelcase('Using-Capital-Dash-Separators'),
	// 	to_camelcase('ALL_UPPER_CASE'),
	// 	to_camelcase('normal spaces'),
	// 	to_camelcase('alreadyCamelCase'),
	// 	to_camelcase('Öö_ääkkösiä'),
	// ),

	// // To camelCase, preserve capitals off
	// 'to_camelcase_preserve_capitals' => array(
	// 	to_camelcase('-foo', true),
	// 	to_camelcase('_snake_case', true),
	// 	to_camelcase('using-dash-separators', true),
	// 	to_camelcase('Using-Capital-Dash-Separators', true),
	// 	to_camelcase('ALL_UPPER_CASE', true),
	// 	to_camelcase('normal spaces', true),
	// 	to_camelcase('alreadyCamelCase', true),
	// 	to_camelcase('Öö_ääkkösiä', true),
	// ),

	// // To camelCase, preserve capitals off
	// 'from_camelcase' => array(
	// 	// from_camelcase('FooBARblah'),
	// 	// from_camelcase('Foo Bar Blah'),
	// 	// from_camelcase('FooBarBlah'),
	// 	// ucfirst(from_camelcase('FooBarBlah')).'.',
	// 	// ucwords(from_camelcase('FooBarBlah')),
	// 	from_camelcase(array(123)),
	// ),

// );

?>