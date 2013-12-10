<?php
if ($servant->debug() and $servant->warnings()->count()) {
	echo '<div style="margin: 0; position: relative; top: 0; left: 0; width: 100%; z-index: 9999;">
		<div style="padding: 2em; background: #C92816; color: #f3f3f3;" onlick="">
			<h2 style="margin: 0.5em 0;">'.$servant->warnings()->count().' warning'.(($servant->warnings()->count() > 1) ? 's' : '').'</h2>
			<ul>'.implode_wrap('<li style="margin: 0.5em 0">', '</p>', $servant->warnings()->all()).'</ul>
		</div>
	</div>';
}
?>