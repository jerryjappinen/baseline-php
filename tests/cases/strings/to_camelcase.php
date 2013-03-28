<?php

class TestOfToCamelcase extends UnitTestCase {

	// Leave no dashes

	// Dashes should be removed from start
	function test_remove_dashes_from_start () {
		$this->assertTrue(substr_count(to_camelcase('-foo'), '-') === 0);
	}

	// Dashes should be removed from end
	function test_remove_dashes_from_end () {
		$this->assertTrue(substr_count(to_camelcase('foo-'), '-') === 0);
	}

	// Dashes should be removed from middle
	function test_remove_dashes_from_middle () {
		$this->assertTrue(substr_count(to_camelcase('fo-o'), '-') === 0);
	}

	// Consecutive dashes should be removed from start
	function test_remove_consecutive_dashes_from_start () {
		$this->assertTrue(substr_count(to_camelcase('----foo'), '-') === 0);
	}

	// Consecutive dashes should be removed from end
	function test_remove_consecutive_dashes_from_end () {
		$this->assertTrue(substr_count(to_camelcase('foo----'), '-') === 0);
	}

	// Consecutive dashes should be removed from middle
	function test_remove_consecutive_dashes_from_middle () {
		$this->assertTrue(substr_count(to_camelcase('fo----o'), '-') === 0);
	}



	// Leave no underscores

	// Underscores should be removed from start
	function test_remove_underscores_from_start () {
		$this->assertTrue(substr_count(to_camelcase('_foo'), '_') === 0);
	}

	// Underscores should be removed from end
	function test_remove_underscores_from_end () {
		$this->assertTrue(substr_count(to_camelcase('foo_'), '_') === 0);
	}

	// Underscores should be removed from middle
	function test_remove_underscores_from_middle () {
		$this->assertTrue(substr_count(to_camelcase('fo_o'), '_') === 0);
	}

	// Consecutive underscores should be removed from start
	function test_remove_consecutive_underscores_from_start () {
		$this->assertTrue(substr_count(to_camelcase('____foo'), '_') === 0);
	}

	// Consecutive underscores should be removed from end
	function test_remove_consecutive_underscores_from_end () {
		$this->assertTrue(substr_count(to_camelcase('foo____'), '_') === 0);
	}

	// Consecutive underscores should be removed from middle
	function test_remove_consecutive_underscores_from_middle () {
		$this->assertTrue(substr_count(to_camelcase('fo____o'), '_') === 0);
	}



	// Leave no spaces

	// Spaces should be removed from start
	function test_remove_spaces_from_start () {
		$this->assertTrue(substr_count(to_camelcase(' foo'), ' ') === 0);
	}

	// Spaces should be removed from end
	function test_remove_spaces_from_end () {
		$this->assertTrue(substr_count(to_camelcase('foo '), ' ') === 0);
	}

	// Spaces should be removed from middle
	function test_remove_spaces_from_middle () {
		$this->assertTrue(substr_count(to_camelcase('fo o'), ' ') === 0);
	}

	// Consecutive spaces should be removed from start
	function test_remove_consecutive_spaces_from_start () {
		$this->assertTrue(substr_count(to_camelcase('  foo'), ' ') === 0);
	}

	// Consecutive spaces should be removed from end
	function test_remove_consecutive_spaces_from_end () {
		$this->assertTrue(substr_count(to_camelcase('foo  '), ' ') === 0);
	}

	// Consecutive spaces should be removed from middle
	function test_remove_consecutive_spaces_from_middle () {
		$this->assertTrue(substr_count(to_camelcase('fo  o'), ' ') === 0);
	}



	// Capital letters

	// Lowercases capital letter at start
	function test_lowercase_capital_letter_at_start () {
		$this->assertTrue(substr(to_camelcase('FOO'), 0, 1) === 'f');
	}

	// Lowercases multibyte capital letter at start
	function test_lowercase_capital_letter_at_start_multibyte () {
		$this->assertTrue(mb_substr(to_camelcase('Ääää'), 0, 1) === 'ä');
	}

	// Lowercases capital letter at start after trimming special characters
	function test_lowercase_capital_letter_at_start_after_trimming () {
		$this->assertTrue(substr(to_camelcase(' -_ FOO'), 0, 1) === 'f');
	}

	// Lowercases multibyte capital letter at start after trimming special characters
	function test_lowercase_capital_letter_at_start_after_trimming_multibyte () {
		$this->assertTrue(mb_substr(to_camelcase(' -_ Ääää'), 0, 1) === 'ä');
	}

	// Uppercases capital letter after underscore
	function test_uppercase_capital_letter_after_underscore () {
		$this->assertTrue(to_camelcase('foo_bar') === 'fooBar');
	}

	// Uppercases multibyte capital letter after underscore
	function test_uppercase_capital_letter_after_underscore_multibyte () {
		$this->assertTrue(to_camelcase('politische_ökonomie') === 'politischeÖkonomie');
	}

	// Uppercases capital letter after dash
	function test_uppercase_capital_letter_after_dash () {
		$this->assertTrue(to_camelcase('foo-bar') === 'fooBar');
	}

	// Uppercases multibyte capital letter after dash
	function test_uppercase_capital_letter_after_dash_multibyte () {
		$this->assertTrue(to_camelcase('politische-ökonomie') === 'politischeÖkonomie');
	}

	// Uppercases capital letter after space
	function test_uppercase_capital_letter_after_space () {
		$this->assertTrue(to_camelcase('foo-bar') === 'fooBar');
	}

	// Uppercases multibyte capital letter after space
	function test_uppercase_capital_letter_after_space_multibyte () {
		$this->assertTrue(to_camelcase('politische-ökonomie') === 'politischeÖkonomie');
	}

}

?>