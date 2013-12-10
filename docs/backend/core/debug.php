<?php

/**
* Detect debug mode
*/
if (isset($_SERVER) and isset($_SERVER['REMOTE_ADDR']) and in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) {
	$this->debug = true;
}

?>