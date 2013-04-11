<?php

class TestOfTrimText extends UnitTestCase {

	// Trims whitespace at ends
	function test_trims_whitespace_at_start () {
		$this->assertTrue(trim_text('foobar') === trim_text('	    foobar'));
	}
	function test_trims_newlines_at_start () {
		$this->assertTrue(trim_text('foobar') === trim_text("\n\n\n\n".'foobar'));
	}
	function test_trims_whitespace_and_newlines_at_start () {
		$this->assertTrue(trim_text('foobar') === trim_text("\n\n".'	    '."\n\n".'foobar'));
	}
	function test_trims_whitespace_at_end () {
		$this->assertTrue(trim_text('foobar') === trim_text('foobar	    '));
	}
	function test_trims_newlines_at_end () {
		$this->assertTrue(trim_text('foobar') === trim_text('foobar'."\n\n\n\n"));
	}
	function test_trims_whitespace_and_newlines_at_end () {
		$this->assertTrue(trim_text('foobar') === trim_text('foobar'."\n\n".'	    '."\n\n"));
	}

	// Empty lines
	function test_trims_excess_newlines () {
		$this->assertTrue(trim_text('foo'."\n\n".'bar') === trim_text('foo'."\n\n\n\n\n\n\n\n".'bar'));
	}
	function test_trims_empty_lines () {
		$this->assertTrue(trim_text('foo'."\n\n".'bar') === trim_text('foo'."\n\n".'       '."\n\n".'bar'));
	}

	// Whitespace
	function test_trims_tabs () {
		$this->assertTrue(trim_text('foo bar') === trim_text('foo'.'	'.'bar'));
	}
	function test_trims_excess_whitespace () {
		$this->assertTrue(trim_text('foo bar') === trim_text('foo'.'    '.'bar'));
	}

}

?>