<?php

class TestOfCalculateString extends UnitTestCase {

	// Integers should work
	function test_calculate_string_preserves_integers () {
		$test = calculate_string(5);
		$this->assertTrue($test === 5);
	}

	// Floats should work
	function test_calculate_string_preserves_floats () {
		$test = calculate_string(5.238732);
		$this->assertTrue($test === 5.238732);
	}

	// Float should become integers when requested
	function test_calculate_string_forces_integers_when_asked () {
		$test = calculate_string(8.2223, true);
		$this->assertTrue($test === 8);
	}

}

?>