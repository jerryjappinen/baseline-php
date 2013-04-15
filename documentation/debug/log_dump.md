
# log_dump

**Silently log a `dump()`'d object or variable to error log.** [View source](https://bitbucket.org/Eiskis/baseline.php/src/default/source/debug/log_dump.php?at=default)

	function log_dump ($value [, $anotherValue])

This function calls [dump()](dump) for the input parameters and writes the return value into error log. Remember that the location of the log can be defined in `php.ini`.
