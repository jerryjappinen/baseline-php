<?php

/**
* Footer composition
*/

// Sort pages into pages and categories
$pages = array();
$categories = array();
foreach ($servant->sitemap()->pages() as $node) {
	if ($node->category()) {
		$categories[] = $node;
	} else {
		$pages[] = $node;
	}
}
unset($node);

// Top-level pages
$footerLists[0] = array(
	'<a href="'.$servant->paths()->root('domain').'">'.$servant->site()->name().'</a>',
	'<a href="'.$servant->paths()->endpoint('sitemap', 'domain', $page->tree()).'">Sitemap</a>'
);
foreach ($pages as $node) {
	$footerLists[0][] = '<a href="'.$node->endpoint('domain').'">'.$node->name().'</a>';
}
unset($pages, $node);

// Main categories and pages
$i = 1;
foreach ($categories as $category) {
	$footerLists[$i] = array();

	// Category title
	$footerLists[$i][] = '<a href="'.$servant->paths()->endpoint('read', 'domain', $category->id()).'">'.$category->name().'</a>';

	// Subpages
	$children = $category->children();
	foreach ($children as $child) {
		$footerLists[$i][] = '<a href="'.$child->endpoint('domain').'">'.$child->name().'</a>';
	}
	unset($child);

	$i++;
}

// Definition lists for pages
$footer = '';
foreach ($footerLists as $list) {
	$footer .= '<dl>
		<dt>'.$list[0].'</dt>';
		array_shift($list);
		foreach ($list as $item) {
			$footer .= '<dd>'.$item.'</dd>';
		}
	$footer .= '</dl>';
}

// Menus
$mainmenu = $template->nest('list-toplevelpages');

$submenu = $action->isRead() ? $template->nest('list-submenu') : '';

?>