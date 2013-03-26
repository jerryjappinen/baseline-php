<?php

class TestOfToCamelcase extends UnitTestCase {

	// All letters should be lowercase
	function test_lowercases_all_letters () {
		$test = 'FooFFoFoF_Foo-Foo_fooF';
		$camelcase = to_camelcase($test);
		$this->assertTrue(strtolower($camelcase) === $camelcase);
	}

	// Existing underscores should be left alone
	function test_doesnt_remove_underscores () {
		$test = '__foo_bar_BAR__esa___';
		$this->assertTrue(substr_count($test, '_') === substr_count(to_camelcase($test), '_'));
	}

}

?>