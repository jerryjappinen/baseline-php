<?php

class TestOfToArray extends UnitTestCase {

	// Output must always be an array
	function test_makes_array_from_int () {
		$this->assertTrue(is_array(to_array(299)));
	}
	function test_makes_array_from_float () {
		$this->assertTrue(is_array(to_array(18.299)));
	}
	function test_makes_array_from_string () {
		$this->assertTrue(is_array(to_array('someString')));
	}
	function test_makes_array_from_object () {
		$this->assertTrue(is_array(to_array(new UnitTestCase)));
	}
	function test_makes_array_from_array () {
		$this->assertTrue(is_array(to_array(array(1, 2, 3))));
	}



	// Single values result in arrays with only one level and one item
	function test_makes_single_level_array_from_int () {
		$this->assertTrue(to_array(123) === array(123));
	}
	function test_makes_single_level_array_from_float () {
		$this->assertTrue(to_array(123.228) === array(123.228));
	}
	function test_makes_single_level_array_from_string () {
		$this->assertTrue(to_array('some string') === array('some string'));
	}

	// Leaves array untouched
	function test_leaves_array_untouched () {
		$this->assertTrue(to_array(array(1, 2, 3)) === array(1, 2, 3));
	}
	function test_leaves_array_untouched_assoc () {
		$this->assertTrue(to_array(array('a' => 1, 'b' => 2, 'c' => 3)) === array('a' => 1, 'b' => 2, 'c' => 3));
	}
	function test_leaves_array_untouched_multidimensional () {
		$this->assertTrue(to_array(array('a' => 1, 'b' => 2, 'c' => array(1, 2, 3))) === array('a' => 1, 'b' => 2, 'c' => array(1, 2, 3)));
	}

}

?>