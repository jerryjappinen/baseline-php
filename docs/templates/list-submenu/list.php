<?php
$output = '';



/**
* Level 2+3 menu
*/
$mainCategory = $page->parents(false, 0);
if ($mainCategory) {

	$items = array();
	foreach ($mainCategory->children() as $node) {

		// Name
		$name = $node->name();

		// Children
		$submenu = '';
		$subItems = array();
		if ($node->children()) {

			// Rename category
			$name = $node->name();

			// Include all pages on this level
			foreach ($node->children() as $subNode) {

				// Child page HTML
				$url = $subNode->endpoint('domain');
				$listItem = '<a href="'.$url.'">'.htmlspecialchars($subNode->name()).'</a>';

				// Mark selected subNode
				if ($page->parents(false, 1) === $node and $page === $subNode) {
					$listItem = '<li class="selected"><strong>'.$listItem.'</strong>';
				} else {
					$listItem = '<li>'.$listItem;
				}

				// Close HTML
				$listItem .= '</li>';

				// Add item to submenu
				$subItems[] = $listItem;
				unset($listItem);
			}

			$submenu = '<ul>'.implode($subItems).'</ul>';
		}

		// Link HTML
		$url = $node->endpoint('domain');
		$listItem = '<a href="'.$url.'">'.htmlspecialchars($name).'</a>';

		// Mark selected page
		if ($page->parents(false, 1) === $node or $page === $node) {
			$listItem = '<li class="selected"><strong>'.$listItem.'</strong>';
		} else {
			$listItem = '<li>'.$listItem;
		}

		// Close HTML
		$listItem .= ($submenu ? $submenu : '').'</li>';

		// Add item to menu
		$items[] = $listItem;
		unset($listItem);

	}

	// Menu structure
	$output = '<ul>'.implode($items).'</ul>';

}

echo $output;
?>