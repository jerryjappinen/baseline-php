<?php

class TestOfStartWith extends UnitTestCase {

	// Doesn't add anything

	// Doesn't add substring if it's already at the start
	function test_leaves_alone_if_starts_with () {
		$prefix = 'foo';
		$test = $prefix.'/bar/';
		$this->assertTrue(start_with($test, $prefix) === $test);
	}

	// Works with spaces
	function test_understands_spaces () {
		$prefix = '      ';
		$test = $prefix.'foo/bar/';
		$this->assertTrue(start_with($test, $prefix) === $test);
	}

	// Works with newlines
	function test_understands_newlines () {
		$prefix = "\n\n";
		$test = $prefix.'foo/bar/';
		$this->assertTrue(start_with($test, $prefix) === $test);
	}



	// Adds prefix as expected

	// Can add newlines properly
	function test_can_add_newlines () {
		$prefix = "\n\n";
		$test = 'foo/bar/';
		$this->assertTrue(start_with($test, $prefix) === $prefix.$test);
	}

	// Doesn't care about converting integers to strings
	function test_can_add_integers () {
		$prefix = 123;
		$test = '/foo';
		$this->assertTrue(start_with($test, $prefix) === '123/foo');
	}

}

?>