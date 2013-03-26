<?php

class TestOfToArray extends UnitTestCase {

	// String input results in array
	function test_to_array_makes_array_from_string () {
		$test = 'someString';
		$this->assertTrue(is_array(to_array($test)));
	}

	// Array from any object
	function test_to_array_makes_array_from_object () {
		$test = new UnitTestCase;
		$this->assertTrue(is_array(to_array($test)));
	}

}

?>