<?php

	ob_end_flush();

	echo '1<br />';
	flush();
	
	sleep(1);

	echo '2<br />';
	flush();
	
	ob_start();

?>
