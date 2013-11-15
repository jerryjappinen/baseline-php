<?php

class TestOfArrayFirst extends UnitTestCase {

	function first_by_index () {
		$this->assertTrue(array_first(array('foo', 'bar')) === 'foo');
	}

	function first_by_numeric_key () {
		$this->assertTrue(array_first(array(2 => 'foo', 90 => 'bar')) === 'foo');
	}

	function first_by_string_key () {
		$this->assertTrue(array_first(array('pfft' => 'foo', 'esa' => 'bar')) === 'foo');
	}

}

?>