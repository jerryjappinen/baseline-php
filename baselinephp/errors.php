<?php

// Shorthand error throwing
function fail ($message, $code = null) {
	throw new Exception($message, isset($code) ? $code : 500);
}

?>