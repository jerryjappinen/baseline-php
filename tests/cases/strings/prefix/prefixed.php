<?php

class TestOfPrefixed extends UnitTestCase {

	// Empty strings

	// Empty subject doesn't begin with a non-empty string
	function test_handles_empty_subject () {
		$this->assertTrue(prefixed('', 'foo') === false);
	}

	// Any string starts with an empty string
	function test_handles_empty_substring () {
		$this->assertTrue(prefixed('foo', '') === true);
	}

	// Empty string begins with an empty string
	function test_handles_empty_subject_and_substring () {
		$this->assertTrue(prefixed('', '') === true);
	}



	// URLs
	function test_urls_no_protocol () {
		$this->assertTrue(prefixed('www.domain.com', 'http://') === false);
	}
	function test_urls_has_protocol () {
		$this->assertTrue(prefixed('http://www.domain.com', 'http://') === true);
	}
	function test_urls_missing_one_character () {
		$this->assertTrue(prefixed('ww.domain.com', 'www') === false);
	}



	// Special characters
	function test_special_characters_slashes_true () {
		$this->assertTrue(prefixed('//foo', '/') === true);
	}
	function test_special_characters_slashes_false () {
		$this->assertTrue(prefixed('//foo', '\\') === false);
	}
	function test_special_characters_subject_has_slashes_false () {
		$this->assertTrue(prefixed('//foo', '_') === false);
	}
	function test_special_characters_substring_has_slashes_false () {
		$this->assertTrue(prefixed('foo', '/') === false);
	}



	// Multibyte
	function test_special_characters_umlaut_true () {
		$this->assertTrue(prefixed('ää', 'ä') === true);
	}
	function test_special_characters_umlaut_false () {
		$this->assertTrue(prefixed('ää', 'a') === false);
	}
	function test_special_characters_subject_has_umlaut () {
		$this->assertTrue(prefixed('aa', 'ä') === false);
	}
	function test_special_characters_substring_has_umlaut () {
		$this->assertTrue(prefixed('aa', 'ä') === false);
	}



	// Basic checks

	// Shorter subject (always false)
	function test_shorter_subject () {
		$this->assertTrue(prefixed('fo', 'foo') === false);
	}

	// Shorter substring, true
	function test_shorter_substring_true () {
		$this->assertTrue(prefixed('foo', 'fo') === true);
	}

	// Shorter substring, false
	function test_shorter_substring_false () {
		$this->assertTrue(prefixed('foo', 'oo') === false);
	}

	// Same length, false
	function test_same_length_false () {
		$this->assertTrue(prefixed('foo', 'oof') === false);
	}

	// Same length, true
	function test_same_length_true () {
		$this->assertTrue(prefixed('foo', 'foo') === true);
	}



	// Case-insensitive check

	// Umlauts
	function test_case_insensitive_umlaut_true () {
		$this->assertTrue(prefixed('ÄÄÄÄ', 'ää', true) === true);
	}
	function test_case_insensitive_umlaut_false () {
		$this->assertTrue(prefixed('ÄÄÄÄ', 'aa', true) === false);
	}

	// Basics
	function test_case_insensitive_true () {
		$this->assertTrue(prefixed('FOO', 'fo', true) === true);
	}

}

?>