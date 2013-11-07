<?php

class TestOfLimplode extends UnitTestCase {

	// Works like implode without last glue
	function test_is_like_implode_with_empty_array () {
		$glue = ', ';
		$test = array();
		$this->assertTrue(limplode($glue, $test) === implode($glue, $test));
	}
	function test_is_like_implode_with_one_item () {
		$glue = ', ';
		$test = array(1);
		$this->assertTrue(limplode($glue, $test) === implode($glue, $test));
	}
	function test_is_like_implode_with_two_items () {
		$glue = ', ';
		$test = array(1, 2);
		$this->assertTrue(limplode($glue, $test) === implode($glue, $test));
	}
	function test_is_like_implode_with_three_items () {
		$glue = ', ';
		$test = array(1, 2, 3);
		$this->assertTrue(limplode($glue, $test) === implode($glue, $test));
	}
	function test_is_like_implode_with_four_items () {
		$glue = ', ';
		$test = array(1, 2, 3, 4);
		$this->assertTrue(limplode($glue, $test) === implode($glue, $test));
	}



	// Outputs sensible strings when last glue is given
	function test_empty_array_last_glue () {
		$this->assertTrue(limplode(', ', array(), ' and ') === '');
	}
	function test_one_item_last_glue () {
		$this->assertTrue(limplode(', ', array(1), ' and ') === '1');
	}
	function test_two_items_last_glue () {
		$this->assertTrue(limplode(', ', array(1, 2), ' and ') === '1, 2');
	}
	function test_three_items_last_glue () {
		$this->assertTrue(limplode(', ', array(1, 2, 3), ' and ') === '1, 2 and 3');
	}
	function test_four_items_last_glue () {
		$this->assertTrue(limplode(', ', array(1, 2, 3, 4), ' and ') === '1, 2, 3 and 4');
	}

	// Reverse argument order
	function test_reverse_argument_order () {
		$this->assertTrue(limplode(', ', array(1, 2, 3, 4)) === limplode(array(1, 2, 3, 4), ', '));
	}
	function test_reverse_argument_order_last_glue () {
		$this->assertTrue(limplode(', ', array(1, 2, 3, 4), ' and ') === limplode(array(1, 2, 3, 4), ', ', ' and '));
	}

}

?>