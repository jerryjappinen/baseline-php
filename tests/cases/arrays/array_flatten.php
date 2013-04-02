<?php

class TestOfArrayFlatten extends UnitTestCase {

	private function hasChildArrays ($array) {
		$result = false;
		foreach ($array as $value) {
			if (is_array($value)) {
				$result = true;
			}
		}
		return $result;
	}



	// Handles all values
	function test_leaves_empty_values () {
		$this->assertTrue(array_flatten(array('', array('', 0, false, null))) === array('', '', 0, false, null));
	}
	function test_discards_empty_child_arrays () {
		$this->assertTrue(array_flatten(array(array(array(), array(array(), array())), array())) === array());
	}



	// Output must never have child arrays
	function test_leaves_no_child_arrays_empty () {
		$this->assertTrue(!$this->hasChildArrays(array_flatten(array())));
	}
	function test_leaves_no_child_arrays_one_item () {
		$this->assertTrue(!$this->hasChildArrays(array_flatten(array(1))));
	}
	function test_leaves_no_child_arrays_four_items () {
		$this->assertTrue(!$this->hasChildArrays(array_flatten(array(1, 'a', 400, 'foo'))));
	}
	function test_leaves_no_child_arrays_arrays () {
		$this->assertTrue(!$this->hasChildArrays(array_flatten(array(1, array('a', 400, 'foo'), array('bar', 'blah')))));
	}
	function test_leaves_no_child_arrays_empty_arrays () {
		$this->assertTrue(!$this->hasChildArrays(array_flatten(array(), array(), array())));
	}
	function test_leaves_no_child_arrays_two_levels () {
		$this->assertTrue(!$this->hasChildArrays(array_flatten(array(1, 2, 3), array(array(1, 2, 4), array('foo', 'bar'), array()) )));
	}
	function test_leaves_no_child_arrays_three_levels () {
		$this->assertTrue(!$this->hasChildArrays(array_flatten(array(1, 2, 3), array(array(1, 2, 4), array(array('foo', 'bar', array(123)))))));
	}



	// Keys

	// Output has numerical indexes
	function test_discards_keys_by_default () {

		$test = array(
			1 => 'foo',
			'bar' => '100',
			'some id' => array(
				0 => 1,
				1 => 2,
				'bar' => array(
					array(),
					array(),
				),
				2 => 3,
			),
			'more' => 'values'
		);

		$keysAreNumerical = true;
		$i = 0;
		foreach (array_keys(array_flatten($test)) as $key) {
			if ($key !== $i) {
				$keysAreNumerical = false;
				break;
			}
			$i++;
		}

		$this->assertTrue($keysAreNumerical);
	}

	// Output preserves keys as much as possible when asked
	function test_preserves_keys_when_asked () {

		$test = array(
			'meh' => 'foo',
			'bar' => '100',
			'some id' => array(
				'wat' => 1,
				'noes' => 2,
				'bar' => array(
					array(),
					array(),
				),
				'bar' => 3,
			),
			'bar' => 'values'
		);

		$this->assertTrue(array_keys(array_flatten($test, false, true)) === array('meh', 'bar', 'wat', 'noes'));
	}

}

?>