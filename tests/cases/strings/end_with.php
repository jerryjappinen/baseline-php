<?php

class TestOfEndWith extends UnitTestCase {

	// Doesn't add anything

	// Doesn't add substring if it's already at the end
	function test_leaves_alone_if_ends_with () {
		$this->assertTrue(end_with('/bar/foo/', 'foo/') === '/bar/foo/');
	}

	// Works with spaces
	function test_leaves_alone_if_ends_with_spaces () {
		$this->assertTrue(end_with('foo'.'      ', '      ') === 'foo'.'      ');
	}

	// Works with newlines
	function test_leaves_alone_if_ends_with_newlines () {
		$this->assertTrue(end_with('foo'."\n\n", "\n\n") === 'foo'."\n\n");
	}



	// Avoids duplicate substrings
	function test_trims_substring () {
		$this->assertTrue(end_with('Lo', 'ol') === 'Lol');
	}
	function test_trims_substring_on_short_substring () {
		$this->assertTrue(end_with('Loo', 'ol') === 'Lool');
	}
	function test_trims_substring_on_short_subject () {
		$this->assertTrue(end_with('Lo', 'ool') === 'Lool');
	}



	// Respects fast checks
	function test_on_check_only_once_doesnt_trim_substring () {
		$this->assertTrue(end_with('Lo', 'ol', true) === 'Lool');
	}
	function test_on_check_only_once_doesnt_trim_substring_on_short_substring () {
		$this->assertTrue(end_with('Loo', 'ol', true) === 'Loool');
	}
	function test_on_check_only_once_doesnt_trim_substring_on_short_subject () {
		$this->assertTrue(end_with('Lo', 'ool', true) === 'Loool');
	}



	// Adds substring as expected

	// Can add newlines properly
	function test_can_add_newlines () {
		$this->assertTrue(end_with('foo', "\n\n") === 'foo'."\n\n");
	}

	// Doesn't care about converting integers to strings
	function test_can_add_integers () {
		$prefix = 123;
		$test = 'foo';
		$this->assertTrue(end_with($test, $prefix) === 'foo123');
	}

}

?>