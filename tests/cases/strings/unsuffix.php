<?php

class TestOfUnsuffix extends UnitTestCase {

	// Empties
	function test_handles_empties () {
		$this->assertTrue(unsuffix('', '') === '');
	}
	function test_handles_empty_subject () {
		$this->assertTrue(unsuffix('', 'foo') === '');
	}
	function test_handles_empty_suffix () {
		$this->assertTrue(unsuffix('foo', '') === 'foo');
	}

	// Works with spaces etc.
	function test_handles_spaces () {
		$this->assertTrue(unsuffix('foo  ', '  ') === 'foo');
	}
	function test_handles_newlines () {
		$this->assertTrue(unsuffix('foo'."\n\n", "\n\n") === 'foo');
	}

	// Doesn't remove anything from the wrong end
	function test_only_removes_from_end () {
		$this->assertTrue(unsuffix('abba', 'a') === 'abb');
	}
	function test_doesnt_remove_prefix () {
		$this->assertTrue(unsuffix('foo', 'f') === 'foo');
	}

}

?>