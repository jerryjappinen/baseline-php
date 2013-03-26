<?php

class TestOfToBoolean extends UnitTestCase {

	// Falses

	// 0
	function test_integer_0_as_false () {
		$test = 0;
		$this->assertTrue(to_boolean($test) === false);
	}

	// '0'
	function test_string_0_as_false () {
		$test = '0';
		$this->assertTrue(to_boolean($test) === false);
	}

	// 0.0
	function test_integer_0_0_as_false () {
		$test = 0.0;
		$this->assertTrue(to_boolean($test) === false);
	}

	// '0.0'
	function test_string_0_0_as_false () {
		$test = '0.0';
		$this->assertTrue(to_boolean($test) === false);
	}

	// 'fALse'
	function test_string_false_as_false () {
		$test = 'fALsE';
		$this->assertTrue(to_boolean($test) === false);
	}

	// Empty array
	function test_empty_array_as_false () {
		$test = array();
		$this->assertTrue(to_boolean($test) === false);
	}



	// Trues

	// '0.1'
	function test_string_0_1_as_true () {
		$test = '0.1';
		$this->assertTrue(to_boolean($test) === true);
	}

	// Non-empty array
	function test_non_empty_array_as_true () {
		$test = array('');
		$this->assertTrue(to_boolean($test) === true);
	}

}

?>