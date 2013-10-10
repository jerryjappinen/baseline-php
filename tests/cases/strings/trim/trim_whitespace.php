<?php

class TestOfTrimWhitespace extends UnitTestCase {

	// Trims whitespace at ends
	function test_trims_whitespace_at_start () {
		$this->assertTrue('foobar' === trim_whitespace('	    foobar'));
	}
	function test_trims_newlines_at_start () {
		$this->assertTrue('foobar' === trim_whitespace("\n\n\n\n".'foobar'));
	}
	function test_trims_whitespace_and_newlines_at_start () {
		$this->assertTrue('foobar' === trim_whitespace("\n\n".'	    '."\n\n".'foobar'));
	}
	function test_trims_whitespace_at_end () {
		$this->assertTrue('foobar' === trim_whitespace('foobar	    '));
	}
	function test_trims_newlines_at_end () {
		$this->assertTrue('foobar' === trim_whitespace('foobar'."\n\n\n\n"));
	}
	function test_trims_whitespace_and_newlines_at_end () {
		$this->assertTrue('foobar' === trim_whitespace('foobar'."\n\n".'	    '."\n\n"));
	}

	// Empty lines
	function test_trims_all_newlines () {
		$this->assertTrue('foobar' === trim_whitespace('foo'."\n\n".'bar'));
	}
	function test_trims_empty_lines () {
		$this->assertTrue('foobar' === trim_whitespace('foo'."\n\n".'       '."\n\n".'bar'));
	}

	// Whitespace
	function test_trims_tabs () {
		$this->assertTrue('foobar' === trim_whitespace('foo'.'		'.'bar'));
	}
	function test_trims_all_whitespace () {
		$this->assertTrue('foobar' === trim_whitespace('foo'.'    '.'bar'));
	}

}

?>