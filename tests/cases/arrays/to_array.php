<?php

class TestOfToArray extends UnitTestCase {

	// Output must always be an array

	// Int
	function test_makes_array_from_int () {
		$this->assertTrue(is_array(to_array(299)));
	}

	// Float
	function test_makes_array_from_float () {
		$this->assertTrue(is_array(to_array(18.299)));
	}

	// String
	function test_makes_array_from_string () {
		$this->assertTrue(is_array(to_array('someString')));
	}

	// Object
	function test_makes_array_from_object () {
		$this->assertTrue(is_array(to_array(new UnitTestCase)));
	}

	// Array
	function test_makes_array_from_array () {
		$this->assertTrue(is_array(to_array(array(1, 2, 3))));
	}

}

?>