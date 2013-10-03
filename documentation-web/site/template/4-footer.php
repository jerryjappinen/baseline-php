<?php

// Sort pages into pages and categories
$pages = array();
$categories = array();
foreach ($servant->pages()->map() as $key => $value) {
	if (is_array($value)) {
		$categories[] = $key;
	} else {
		$pages[] = $value;
	}
}



// Top-level pages
$footer[0] = array(
	'<a href="'.$servant->paths()->root('domain').'">'.$servant->site()->name().'</a>',
	'<a href="'.$servant->paths()->userAction('sitemap', 'domain', $servant->page()->tree()).'">Sitemap</a>'
);
foreach ($pages as $page) {
	$footer[0][] = '<a href="'.$page->readPath('domain').'">'.$page->categoryName(0).'</a>';
}
unset($page);



// Main categories and pages
$i = 1;
foreach ($categories as $categoryId) {
	$footer[$i] = array();

	// Category title
	$footer[$i][] = '<a href="'.$servant->paths()->userAction('read', 'domain', $categoryId).'">'.$servant->format()->pageName($categoryId).'</a>';

	// Subpages
	foreach ($servant->pages()->level($categoryId) as $page) {
		$footer[$i][] = '<a href="'.$page->readPath('domain').'/">'.$page->categoryName(1).'</a>';
	}
	unset($page);

	$i++;
}



// Footer
echo '
<div class="frame-footer">
	<div class="frame-container">
		';

		// Definition lists for pages
		foreach ($footer as $list) {
			echo '<dl>
				<dt>'.$list[0].'</dt>';
				array_shift($list);
				foreach ($list as $item) {
					echo '<dd>'.$item.'</dd>';
				}
			echo '</dl>';
		}

		echo '
		<div class="clear"></div>
	</div>
</div>
<div class="clear"></div>
';

?>