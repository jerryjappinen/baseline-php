<?php

class TestOfGlobFiles extends UnitTestCase {

	// Test files
	private $sandboxPath = 'temp/glob_files/';
	private function prepare () {
		test_helper_purge_dir($this->sandboxPath);
		mkdir($this->sandboxPath.'foo', 0777, true);
		mkdir($this->sandboxPath.'bar', 0777, true);
		file_put_contents($this->sandboxPath.'bar.json', '{"bar": "foo"}');
		file_put_contents($this->sandboxPath.'bar.txt', 'bar');
		file_put_contents($this->sandboxPath.'foo.html', '<h1>foo</h1>');
		file_put_contents($this->sandboxPath.'bar/bar.json', '{"bar": "foo"}');
		file_put_contents($this->sandboxPath.'bar/bar.txt', 'bar');
		file_put_contents($this->sandboxPath.'bar/foo.json', '{"foo": "foo"}');
		file_put_contents($this->sandboxPath.'bar/foo.txt', 'foo');
	}
	private function clear () {
		test_helper_purge_dir($this->sandboxPath);
	}



	// Basic output
	function test_lists_files_as_array () {
		$this->prepare();
		$this->assertTrue(is_array(glob_files($this->sandboxPath)));
		$this->clear();
	}
	function test_lists_all_files_by_default () {
		$this->prepare();
		$glob = glob_files($this->sandboxPath);
		$result = array($this->sandboxPath.'bar.txt', $this->sandboxPath.'bar.json', $this->sandboxPath.'foo.html');
		$comparison = array_diff($glob, $result);
		$this->assertTrue(empty($comparison));
		$this->clear();
	}
	function test_filters_by_file_type () {
		$this->prepare();
		$glob = glob_files($this->sandboxPath, 'txt');
		$result = array($this->sandboxPath.'bar.txt');
		$comparison = array_diff($glob, $result);
		$this->assertTrue(empty($comparison));
		$this->clear();
	}
	function test_filters_by_file_types () {
		$this->prepare();
		$glob = glob_files($this->sandboxPath, 'txt', 'json');
		$result = array($this->sandboxPath.'bar.txt', $this->sandboxPath.'bar.json');
		$comparison = array_diff($glob, $result);
		$this->assertTrue(empty($comparison));
		$this->clear();
	}



	// Input parameters
	function test_accepts_path_without_trailing_slash () {
		$this->prepare();
		$this->assertTrue(glob_files($this->sandboxPath) === glob_files(substr($this->sandboxPath, 0, strlen($this->sandboxPath)-1)));
		$this->clear();
	}
	function test_accepts_one_file_type_as_array_or_independent_value () {
		$this->prepare();
		$this->assertTrue(glob_files($this->sandboxPath, 'txt') === glob_files($this->sandboxPath, array('txt')));
		$this->clear();
	}
	function test_accepts_more_file_type_as_array_or_independent_values () {
		$this->prepare();
		$this->assertTrue(glob_files($this->sandboxPath, 'txt', 'json') === glob_files($this->sandboxPath, array('txt', 'json')));
		$this->clear();
	}



	// Non-existent array
	function test_non_existent_dir_returns_empty_array () {
		$this->prepare();
		$glob = glob_files($this->sandboxPath.'esa/');
		$this->assertTrue(is_array($glob) and empty($glob));
		$this->clear();
	}

}

?>