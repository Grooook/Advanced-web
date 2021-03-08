
<?php

	if(isset($_GET['delete_random_announcement'])){
		$announcement_array = get_option('announcements');
		unset($announcement_array[$_GET['delete_random_announcement']]);
		update_option('announcements', $announcement_array); 
		if(isset($_SERVER['HTTP_REFERER'])){
			echo "string";
			$previous = $_SERVER['HTTP_REFERER'];
			echo $previous;
			header('Location: '.$previous);
		}
		exit;
	}
	// if(isset($_SERVER['HTTP_REFERER'])){
	// 	$previous = $_SERVER['HTTP_REFERER'];
	// 	header('Location: '.$previous);
	// }

	
?>