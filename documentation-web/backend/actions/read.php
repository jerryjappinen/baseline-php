<?php

// Use page title + content as action content
$servant->action()->output($servant->page()->output());

// Output via template
$servant->action()->outputViaTemplate(true);

?>