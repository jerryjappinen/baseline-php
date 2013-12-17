<?php

class TestOfArrayLast extends UnitTestCase {

	function test_last_by_index () {
		$this->assertTrue(array_last(array('foo', 'bar')) === 'bar');
	}

	function test_last_by_numeric_key () {
		$this->assertTrue(array_last(array(2 => 'foo', 90 => 'bar')) === 'bar');
	}

	function test_last_by_string_key () {
		$this->assertTrue(array_last(array('pfft' => 'foo', 'esa' => 'bar')) === 'bar');
	}

	function test_last_child_array () {
		$test = array(
			'pfft' => 'foo',
			'esa' => array(1, 2, 3, 'bar')
		);
		$this->assertTrue(is_array(array_last($test)));
	}

	function test_last_child_array_recursive () {
		$test = array(
			'pfft' => 'foo',
			'esa' => array(1, 2, 3, 'bar')
		);
		$this->assertTrue(array_last($test, true) === 'bar');
	}

}

?>