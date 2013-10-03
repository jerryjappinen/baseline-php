<?php
/**
* Submenu for read action
*/
$menu = '';
if ($servant->action()->isRead()) {

	// Generate menu
	$pages = $servant->pages()->level($servant->page()->tree(0));
	if ($pages) {
		$items = array();
		foreach ($pages as $page) {

			// Name
			$name = $page->name();

			// Children
			$submenu = '';
			$subItems = array();
			if ($page->children() and $page->level() > 1) {
				// Rename category
				$name = $page->categoryName(1);

				// Include all pages on this level
				foreach ($page->siblings() as $subPage) {

					// Child page HTML
					$url = $subPage->readPath('domain');
					$output = '<a href="'.$url.'">'.$subPage->name().'</a>';

					// Mark selected subpage
					$parents = $subPage->parentTree();
					$parent = end($parents);
					if ($servant->page()->tree(1) === $parent and $servant->page()->tree(2) === $subPage->id()) {
						$output = '<li class="selected"><strong>'.$output.'</strong>';
					} else {
						$output = '<li>'.$output;
					}

					// Close HTML
					$output .= '</li>';

					// Add item to submenu
					$subItems[] = $output;
					unset($output);
				}

				$submenu = '<ul class="menu-3">'.implode($subItems).'</ul>';
			}

			// Link HTML
			$url = $page->readPath('domain');
			$output = '<a href="'.$url.'">'.$name.'</a>';

			// Mark selected page
			if ($servant->page()->tree(1) === $page->id()) {
				$output = '<li class="selected"><strong>'.$output.'</strong>';
			} else {
				$output = '<li>'.$output;
			}

			// Close HTML
			$output .= ($submenu ? $submenu : '').'</li>';

			// Add item to menu
			$items[] = $output;
			unset($output);

		}

		// Menu structure
		$menu = '<ul class="menu-2">'.implode($items).'</ul>';

	}

}



/**
* Body content
*/
echo '
<div class="frame-body">
	<div class="frame-container">
		'.($menu ? '<div class="frame-sidebar">'.$menu.'</div>' : '').'
		<div class="frame-article">
			'.$servant->template()->content().'
		</div>
		<div class="clear"></div>
	</div>
</div>';

?>