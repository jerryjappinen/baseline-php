<?php

class TestOfUnprefix extends UnitTestCase {

	// Empties
	function test_handles_empties () {
		$this->assertTrue(unprefix('', '') === '');
	}
	function test_handles_empty_subject () {
		$this->assertTrue(unprefix('', 'foo') === '');
	}
	function test_handles_empty_prefix () {
		$this->assertTrue(unprefix('foo', '') === 'foo');
	}

	// Works with spaces etc.
	function test_handles_spaces () {
		$this->assertTrue(unprefix('  foo', '  ') === 'foo');
	}
	function test_handles_newlines () {
		$this->assertTrue(unprefix("\n\n".'foo', "\n\n") === 'foo');
	}

	// Doesn't remove anything from the wrong end
	function test_only_removes_from_end () {
		$this->assertTrue(unprefix('abba', 'a') === 'bba');
	}
	function test_doesnt_remove_suffix () {
		$this->assertTrue(unprefix('bar', 'r') === 'bar');
	}

}

?>