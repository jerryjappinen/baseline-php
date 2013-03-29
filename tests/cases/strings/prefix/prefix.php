<?php

class TestOfPrefix extends UnitTestCase {

	// Doesn't add anything

	// Doesn't add substring if it's already at the start
	function test_leaves_alone_if_starts_with_prefix () {
		$this->assertTrue(prefix('foobar', 'foo') === 'foobar');
	}

	// Works with spaces
	function test_leaves_alone_if_starts_with_prefix_spaces () {
		$this->assertTrue(prefix(' foo', ' ') === ' foo');
	}

	// Works with newlines
	function test_leaves_alone_if_starts_with_prefix_newlines () {
		$this->assertTrue(prefix("\n\n".'foo', "\n\n") === "\n\n".'foo');
	}



	// Adds prefix as expected

	// Can add newlines properly
	function test_can_add_newlines () {
		$this->assertTrue(prefix('foo', "\n\n") === "\n\n".'foo');
	}

	// Doesn't care about converting integers to strings
	function test_can_add_integers () {
		$this->assertTrue(prefix('/foo', 123) === '123/foo');
	}

	// Always adds prefix, as instructed
	function test_no_trimming_of_prefix_on_duplicate_substrings () {
		$this->assertTrue(prefix('ool', 'Lo') === 'Loool');	// o's don't merge
	}
	function test_no_trimming_of_prefix_on_short_subject () {
		$this->assertTrue(prefix('ol', 'Loo') === 'Loool');	// o's don't merge
	}
	function test_no_trimming_of_prefix_on_short_prefix () {
		$this->assertTrue(prefix('://www.foo.bar', 'http://') === 'http://://www.foo.bar');
	}



	// Case-insensitive checking

	function test_disregard_case_in_prefix () {
		$this->assertTrue(prefix('integer', 'INTE', true) === prefix('integer', 'inte', true));
	}
	function test_disregard_case_in_subject () {
		$this->assertTrue(strtolower(prefix('INTEGER', 'inte', true)) === strtolower(prefix('integer', 'inte', true)));
	}

}

?>