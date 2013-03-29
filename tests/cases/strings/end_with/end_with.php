<?php

class TestOfEndWith extends UnitTestCase {

	// Doesn't add anything

	// Doesn't add substring if it's already at the end
	function test_leaves_alone_if_ends_with_suffix () {
		$this->assertTrue(end_with('foo/', '/') === 'foo/');
	}

	// Works with spaces
	function test_leaves_alone_if_ends_with_suffix_spaces () {
		$this->assertTrue(end_with('foo ', ' ') === 'foo ');
	}

	// Works with newlines
	function test_leaves_alone_if_ends_with_suffix_newlines () {
		$this->assertTrue(end_with('foo'."\n\n", "\n\n") === 'foo'."\n\n");
	}



	// Adds suffix as expected

	// Can add newlines properly
	function test_can_add_newlines () {
		$this->assertTrue(end_with('foo', "\n\n") === 'foo'."\n\n");
	}

	// Doesn't care about converting integers to strings
	function test_can_add_integers () {
		$this->assertTrue(end_with('foo', 123) === 'foo123');
	}

	// Avoids duplicate substrings
	function test_trims_suffix () {
		$this->assertTrue(end_with('Lo', 'ol') === 'Lol');
	}
	function test_trims_suffix_on_short_subject () {
		$this->assertTrue(end_with('Loo', 'ol') === 'Lool');
	}
	function test_trims_suffix_on_short_suffix () {
		$this->assertTrue(end_with('www.foo.bar', '.bar/') === 'www.foo.bar/');
	}



	// Case-insensitive checking

	function test_disregard_case_in_suffix () {
		$this->assertTrue(end_with('integer', 'EGER', true) === end_with('integer', 'eger', true));
	}
	function test_disregard_case_in_subject () {
		$this->assertTrue(strtolower(end_with('INTEGER', 'eger', true)) === strtolower(end_with('integer', 'eger', true)));
	}
	function test_disregard_case_in_suffix_when_adding_only_part () {
		$this->assertTrue(strtolower(end_with('inte', 'EGER', true)) === strtolower(end_with('inte', 'eger', true)));
	}
	function test_disregard_case_in_subject_when_adding_only_part () {
		$this->assertTrue(strtolower(end_with('INTE', 'eger', true)) === strtolower(end_with('inte', 'eger', true)));
	}

}

?>