<?php

class TestOfCalculateString extends UnitTestCase {

	// Integers should work
	function test_preserves_integers () {
		$test = 5;
		$this->assertTrue(calculate_string($test) === $test);
	}

	// Floats should work
	function test_preserves_floats () {
		$test = 5.238732;
		$this->assertTrue(calculate_string($test) === $test);
	}

	// Float should become integers when requested
	function test_forces_integers_when_asked () {
		$test = calculate_string('4/3', true);
		$this->assertTrue(is_int($test));
	}
	function test_forces_integers_when_asked_float () {
		$test = calculate_string(8.2223, true);
		$this->assertTrue(is_int($test));
	}

}

?>