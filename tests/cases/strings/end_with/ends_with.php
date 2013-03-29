<?php

class TestOfEndsWith extends UnitTestCase {

	// Empty strings

	// Empty subject doesn't begin with a non-empty string
	function test_handles_empty_subject () {
		$this->assertTrue(ends_with('', 'foo') === false);
	}

	// Any string ends with an empty string
	function test_handles_empty_substring () {
		$this->assertTrue(ends_with('foo', '') === true);
	}

	// Empty string begins with an empty string
	function test_handles_empty_subject_and_substring () {
		$this->assertTrue(ends_with('', '') === true);
	}



	// URLs
	function test_urls_no_protocol () {
		$this->assertTrue(ends_with('www.domain', '.com') === false);
	}
	function test_urls_has_protocol () {
		$this->assertTrue(ends_with('http://www.domain.com', 'com') === true);
	}
	function test_urls_missing_one_character () {
		$this->assertTrue(ends_with('www.domain.com', 'co') === false);
	}



	// Special characters
	function test_special_characters_slashes_true () {
		$this->assertTrue(ends_with('foo//', '/') === true);
	}
	function test_special_characters_slashes_false () {
		$this->assertTrue(ends_with('foo//', '\\') === false);
	}
	function test_special_characters_subject_has_slashes_false () {
		$this->assertTrue(ends_with('foo//', '_') === false);
	}
	function test_special_characters_substring_has_slashes_false () {
		$this->assertTrue(ends_with('foo', '/') === false);
	}



	// Multibyte
	function test_special_characters_umlaut_true () {
		$this->assertTrue(ends_with('ää', 'ä') === true);
	}
	function test_special_characters_umlaut_false () {
		$this->assertTrue(ends_with('ää', 'a') === false);
	}
	function test_special_characters_subject_has_umlaut () {
		$this->assertTrue(ends_with('aa', 'ä') === false);
	}
	function test_special_characters_substring_has_umlaut () {
		$this->assertTrue(ends_with('aa', 'ä') === false);
	}



	// Basic checks

	// Shorter subject (always false)
	function test_shorter_subject () {
		$this->assertTrue(ends_with('fo', 'ofo') === false);
	}

	// Shorter substring, true
	function test_shorter_substring_true () {
		$this->assertTrue(ends_with('foo', 'oo') === true);
	}

	// Shorter substring, false
	function test_shorter_substring_false () {
		$this->assertTrue(ends_with('foo', 'of') === false);
	}

	// Same length, false
	function test_same_length_false () {
		$this->assertTrue(ends_with('foo', 'oof') === false);
	}

	// Same length, true
	function test_same_length_true () {
		$this->assertTrue(ends_with('foo', 'foo') === true);
	}



	// Case-insensitive check

	// Umlauts
	function test_case_insensitive_umlaut_true () {
		$this->assertTrue(ends_with('ÄÄÄÄ', 'ää', true) === true);
	}
	function test_case_insensitive_umlaut_false () {
		$this->assertTrue(ends_with('ÄÄÄÄ', 'aa', true) === false);
	}

	// Basics
	function test_case_insensitive_true () {
		$this->assertTrue(ends_with('BAR', 'ar', true) === true);
	}

}

?>