<?php

// Select page
$page = $servant->sitemap()->select($input->fetch('queue', 'page', array()));

// Create custom HTML for sitemap page
$output = '<h1>Sitemap</h1>'.html_dump($sitemap->dump());
$output = $action->nestTemplate($servant->site()->template(), $page, $output);

// Output via template
$action->contentType('html')->output($output);

?>