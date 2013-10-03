<?php

// We'll override default include order here
foreach (array(
	'Dumper',
	'Lexer',
	'Node',
	'Parser',
	'Jade',
) as $name) {
	include_once 'Jade/'.$name.'.php';
}
