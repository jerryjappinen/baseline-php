<?php

class TestOfStartWith extends UnitTestCase {

	// Doesn't add anything

	// Doesn't add substring if it's already at the start
	function test_leaves_alone_if_starts_with_prefix () {
		$this->assertTrue(start_with('/foo', '/') === '/foo');
	}

	// Works with spaces
	function test_leaves_alone_if_starts_with_prefix_spaces () {
		$this->assertTrue(start_with(' foo', ' ') === ' foo');
	}

	// Works with newlines
	function test_leaves_alone_if_starts_with_prefix_newlines () {
		$this->assertTrue(start_with("\n\n".'foo', "\n\n") === "\n\n".'foo');
	}



	// Adds prefix as expected

	// Can add newlines properly
	function test_can_add_newlines () {
		$this->assertTrue(start_with('foo', "\n\n") === "\n\n".'foo');
	}

	// Doesn't care about converting integers to strings
	function test_can_add_integers () {
		$this->assertTrue(start_with('foo', 123) === '123foo');
	}

	// Avoids duplicate substrings
	function test_trims_prefix () {
		$this->assertTrue(start_with('ol', 'Lo') === 'Lol');
	}
	function test_trims_prefix_on_short_subject () {
		$this->assertTrue(start_with('ol', 'Loo') === 'Lool');
	}
	function test_trims_prefix_on_short_prefix () {
		$this->assertTrue(start_with('://www.foo.bar', 'http://') === 'http://www.foo.bar');
	}



	// Case-insensitive checking

	function test_disregard_case_in_prefix () {
		$this->assertTrue(start_with('integer', 'INTE', true) === start_with('integer', 'inte', true));
	}
	function test_disregard_case_in_subject () {
		$this->assertTrue(strtolower(start_with('INTEGER', 'inte', true)) === strtolower(start_with('integer', 'inte', true)));
	}
	function test_disregard_case_in_prefix_when_adding_only_part () {
		$this->assertTrue(strtolower(start_with('eger', 'INTE', true)) === strtolower(start_with('eger', 'inte', true)));
	}
	function test_disregard_case_in_subject_when_adding_only_part () {
		$this->assertTrue(strtolower(start_with('EGER', 'inte', true)) === strtolower(start_with('eger', 'inte', true)));
	}

}

?>