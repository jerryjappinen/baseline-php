
# log_dump

**Silently log a `dump()`'d object or variable to error log.** [View source](https://github.com/Eiskis/Baseline-PHP/blob/master/source/debug/log_dump.php)

	function log_dump ($value [, $anotherValue])

This function calls [dump()](dump) for the input parameters and writes the return value into error log. Remember that the location of the log can be defined in `php.ini`.
