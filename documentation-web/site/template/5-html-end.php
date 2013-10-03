<?php

// Path to scripts action
$tree = array();
if ($servant->action()->isRead()) {
	$tree = $servant->page()->tree();
}

// End it all
echo '
			<script src="'.$servant->paths()->userAction('scripts', 'domain', $tree).'"></script>
		</div>
	</body>
</html>
';

?>