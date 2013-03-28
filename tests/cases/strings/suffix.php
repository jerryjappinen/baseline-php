<?php

class TestOfSuffix extends UnitTestCase {

	// Doesn't add anything

	// Doesn't add substring if it's already at the end
	function test_leaves_alone_if_ends_with_suffix () {
		$this->assertTrue(suffix('foobar', 'bar') === 'foobar');
	}

	// Works with spaces
	function test_leaves_alone_if_ends_with_suffix_spaces () {
		$this->assertTrue(suffix('foo ', ' ') === 'foo ');
	}

	// Works with newlines
	function test_leaves_alone_if_ends_with_suffix_newlines () {
		$this->assertTrue(suffix('foo'."\n\n", "\n\n") === 'foo'."\n\n");
	}



	// Adds suffix as expected

	// Can add newlines properly
	function test_can_add_newlines () {
		$this->assertTrue(suffix('foo', "\n\n") === 'foo'."\n\n");
	}

	// Doesn't care about converting integers to strings
	function test_can_add_integers () {
		$this->assertTrue(suffix('foo', 123) === 'foo123');
	}

	// Always adds suffix, as instructed
	function test_no_trimming_of_suffix_on_duplicate_substrings () {
		$this->assertTrue(suffix('Lo', 'ol') === 'Lool');	// o's don't merge
	}
	function test_no_trimming_of_suffix_on_short_subject () {
		$this->assertTrue(suffix('Lo', 'ool') === 'Loool');	// o's don't merge
	}
	function test_no_trimming_of_suffix_on_short_suffix () {
		$this->assertTrue(suffix('www.domain.', '.com') === 'www.domain..com');
	}



	// Case-insensitive checking

	function test_disregard_case_in_suffix () {
		$this->assertTrue(suffix('integer', 'EGER', true) === suffix('integer', 'eger', true));
	}
	function test_disregard_case_in_subject () {
		$this->assertTrue(strtolower(suffix('INTEGER', 'eger', true)) === strtolower(suffix('integer', 'eger', true)));
	}

}

?>