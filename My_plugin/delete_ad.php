
<?php

	if(isset($_GET['delete_ad'])){
		$ad_array = get_option('html_code');
		unset($ad_array[$_GET['delete_ad']]);
		update_option('html_code', $ad_array); 
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