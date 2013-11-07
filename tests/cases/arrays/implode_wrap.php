<?php

class TestOfImplodeWrap extends UnitTestCase {

	// // Outputs sensible strings when last glue is given
	function test_empty_array () {
		$this->assertTrue(implode_wrap('<li>', '</li>', array()) === '');
	}
	function test_empty_array_glue () {
		$this->assertTrue(implode_wrap('<li>', '</li>', array(), ' - foo - ') === '');
	}
	function test_one_item () {
		$this->assertTrue(implode_wrap('[', ']', array(1)) === '[1]');
	}
	function test_one_item_glue () {
		$this->assertTrue(implode_wrap('[', ']', array(1), ' - ') === '[1]');
	}
	function test_two_items () {
		$this->assertTrue(implode_wrap('[', ']', array(1, 2)) === '[1][2]');
	}
	function test_two_items_glue () {
		$this->assertTrue(implode_wrap('[', ']', array(1, 2), ' - ') === '[1] - [2]');
	}

	// Reverse argument order
	function test_reverse_argument_order () {
		$pieces = array('Foo', 'Bar', 'JJ');
		$prefix = '<li>';
		$suffix = '</li>';
		$this->assertTrue(implode_wrap($prefix, $suffix, $pieces) === implode_wrap($pieces, $prefix, $suffix));
	}
	function test_reverse_argument_order_glue () {
		$pieces = array('Foo', 'Bar', 'JJ');
		$prefix = '<li>';
		$suffix = '</li>';
		$glue = "\n";
		$this->assertTrue(implode_wrap($prefix, $suffix, $pieces, $glue) === implode_wrap($pieces, $prefix, $suffix, $glue));
	}

}

?>