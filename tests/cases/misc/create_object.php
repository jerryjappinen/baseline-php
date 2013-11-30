<?php

class MyTestClass {
	public $foo = '';
	public function __construct ($param1 = '', $param2 = '') {
		$foo = ''.$param1.($param2 ? ' + '.$param2 : '');
		$this->foo = $foo;
		return $foo;
	}
	public function bar () {
		return $this->foo;
	}
}

class TestOfCreateObject extends UnitTestCase {

	function test_returns_an_object () {
		$this->assertTrue(is_object(create_object('MyTestClass')));
	}
	function test_returns_object_of_right_class () {
		$this->assertTrue(get_class(create_object('MyTestClass')) === 'MyTestClass');
	}

	// Parameters
	function test_passes_parameter () {
		$this->assertTrue(create_object('MyTestClass', 'esa')->bar() === 'esa');
	}
	function test_passes_parameters () {
		$this->assertTrue(create_object('MyTestClass', 'esa', 'pekka')->bar() === 'esa + pekka');
	}
	function test_passes_no_parameters () {
		$this->assertTrue(create_object('MyTestClass')->bar() === '');
	}

}

?>