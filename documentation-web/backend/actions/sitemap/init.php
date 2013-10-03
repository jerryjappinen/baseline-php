<?php

// Create page tree in HTML
if (!function_exists('createNestedLists')) {
	function createNestedLists ($servant, $map) {
		$result = '';
		foreach ($map as $id => $value) {

			// Children
			// FLAG doesn't detect arrays with only one item (these should be presented as individual pages)
			if (is_array($value)) {
				$result .= '<li>'.$servant->format()->pageName($id).createNestedLists($servant, $value).'</li>';

			// Pages
			} else {
				$result .= '<li>'.$value->name().'</li>';
			}

		}
		return '<ol>'.$result.'</ol>';
	}
}

?>