<?php

/**
* Full template
*/

$frame = '
<div class="row row-header">
	<div class="row-content buffer clear-after">
		<h1><a href="'.$servant->paths()->root('domain').'">'.$servant->site()->name().'</a></h1>
		'.$mainmenu.'
	</div>
</div>

<div class="row row-body">
	<div class="row-content buffer clear-after">
	';

		if ($submenu) {

			$frame .= '
			<div class="column three submenu">'.$submenu.'</div>

			<div class="column nine last article">
				'.$template->content().'
			</div>
			';

		} else {

			$frame .= '
			<div class="article">
				'.$template->content().'
			</div>
			';

		}

		$frame .= '
	</div>
</div>

<!--
<div class="row row-footer">
	<div class="row-content buffer clear-after">
		'.$footer.'
	</div>
</div>
-->

<!-- Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');
  ga(\'create\', \'UA-3911404-6\', \'servantframework.com\');
  ga(\'send\', \'pageview\');
</script>

';

echo $template->nest('html', $frame);
?>