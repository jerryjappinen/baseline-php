<?php

class TestOfArrayTraverse extends UnitTestCase {

	// Returns null on failure
	function test_returns_null_when_missing_index () {
		$this->assertTrue(array_traverse(array(1, 2, 3), array(4)) === null);
	}
	function test_returns_null_when_missing_key () {
		$this->assertTrue(array_traverse(array('a' => 1, 'b' => 2), array('c')) === null);
	}
	function test_returns_null_when_missing_key_second_level () {
		$this->assertTrue(array_traverse(array('a' => 1, 'b' => 2, 'c' => array(1, 2, 3)), array('c', 4)) === null);
	}

	// Returns the expected values
	function test_returns_expected_values_single_level () {
		$test = array('a' => 1, 'b' => 2);
		$this->assertTrue(array_traverse($test, 'b') === 2);
	}
	function test_returns_expected_values_single_two_levels () {
		$test = array('a' => 1, 'b' => array(1, 2, 3), 'c' => 'foo');
		$this->assertTrue(array_traverse($test, 'b', 1) === 2);
	}
	function test_returns_expected_values_single_three_levels () {
		$test = array('a' => 1, 'b' => array(1, array('key' => 'bar'), 3), 'c' => 'foo');
		$this->assertTrue(array_traverse($test, 'b', 1, 'key') === 'bar');
	}

	// $keys can be provided in a number of different ways
	function test_accepts_keys_as_single_key () {
		$test = array('a' => 1, 'b' => 2);
		$this->assertTrue(array_traverse($test, 'b') === array_traverse($test, array('b')));
	}
	function test_accepts_keys_as_two_keys () {
		$test = array('a' => 1, 'b' => 2, 'c' => array(1, 2, 3));
		$this->assertTrue(array_traverse($test, 'c', 0) === array_traverse($test, array('c', 0)));
	}
	function test_accepts_keys_as_multiple_arrays () {
		$test = array('a' => 1, 'b' => 2, 'c' => array(1, 2, 3));
		$this->assertTrue(array_traverse($test, array('c'), array(0)) === array_traverse($test, array('c', 0)));
	}
	function test_accepts_integer_keys_as_strings () {
		$test = array(1, 2, array('a', 'b', 'c'));
		$this->assertTrue(array_traverse($test, 2, 0) === array_traverse($test, '2', '0'));
	}
	function test_accepts_string_keys_as_integers () {
		$test = array('1' => 1, '2' => array('1' => 'foo', '2' => 'bar'));
		$this->assertTrue(array_traverse($test, 2, 1) === array_traverse($test, '2', '1'));
	}

}

?>