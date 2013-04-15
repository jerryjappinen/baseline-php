<?php

class TestOfToBoolean extends UnitTestCase {

	// Falses
	function test_integer_negative_as_false () {
		$this->assertTrue(to_boolean(-1) === false);
	}
	function test_integer_0_as_false () {
		$this->assertTrue(to_boolean(0) === false);
	}
	function test_string_0_as_false () {
		$this->assertTrue(to_boolean('0') === false);
	}
	function test_integer_0_0_as_false () {
		$this->assertTrue(to_boolean(0.0) === false);
	}
	function test_string_0_0_as_false () {
		$this->assertTrue(to_boolean('0.0') === false);
	}
	function test_string_false_as_false () {
		$this->assertTrue(to_boolean('fALsE') === false);
	}
	function test_empty_array_as_false () {
		$this->assertTrue(to_boolean(array()) === false);
	}



	// Trues
	function test_float_0_1_as_true () {
		$this->assertTrue(to_boolean(0.1) === true);
	}
	function test_integer_one_as_true () {
		$this->assertTrue(to_boolean(1) === true);
	}
	function test_integer_positive_as_true () {
		$this->assertTrue(to_boolean(2) === true);
	}
	function test_string_0_1_as_true () {
		$this->assertTrue(to_boolean('0.1') === true);
	}
	function test_non_empty_array_as_true () {
		$this->assertTrue(to_boolean(array('')) === true);
	}

}

?>