<?php

class TestOfFromCamelcase extends UnitTestCase {

	// Leave no uppercase characters
	function test_remove_uppercase () {
		$test = from_camelcase('fooBar');
		$this->assertTrue($test === strtolower($test));
	}
	function test_remove_uppercase_from_start () {
		$test = from_camelcase('FooBar');
		$this->assertTrue($test === strtolower($test));
	}
	function test_remove_uppercase_from_end () {
		$test = from_camelcase('FooBaR');
		$this->assertTrue($test === strtolower($test), $test);
	}
	function test_remove_uppercase_no_uppercase () {
		$test = from_camelcase('foo');
		$this->assertTrue($test === strtolower($test));
	}



	// Doesn't break with edge cases
	function test_trims_whitespace () {
		$this->assertTrue(from_camelcase('  barFoo ') === 'bar foo');
	}
	function test_handles_empty_string () {
		$this->assertTrue(from_camelcase('') === '');
	}
	function test_handles_empty_string_after_trimming () {
		$this->assertTrue(from_camelcase('   ') === '');
	}
	function test_handles_only_special_characters () {
		$this->assertTrue(from_camelcase('/()]]>barFoo<[[()\'') === '/()]]>bar foo<[[()\'');
	}

}

?>