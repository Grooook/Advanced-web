<?php 
	/*
	 *@package	Plugin
	 */

	/** * Plugin Name:       Random announcements
	* Plugin URI:        https://example.com/plugins/random_announcement/ 
	* Description:       Plugin that displays announcement at the beginning of each post.
	* Version:           1.0 
	* Requires at least: 5.0 
	* Requires PHP:      7.2 
	* Author:            Hleb Liaonik, Aliaksandr Nadzeika
	* Author URI:        https://...
	* License:           GPL v2 or later 
	* License URI:       https://www.gnu.org/licenses/gpl-2.0.html

	*/
	include('delete_random_announcement.php');
	function create_announcement_menu_page(){  
		add_menu_page("Adding announcements", "Random announcements", 'manage_options', "announcm", "announcement_admin_page");    
	}                                                                                
	add_action('admin_menu', 'create_announcement_menu_page');   


	function announcement_admin_page(){                                          
		global $_POST; 
		if(isset($_POST['announcement_code'])){ 
			if($_POST['naph_do_change'] == 'Y'){ 
				$announcement_array = get_option('announcements');
				$announcement_name_exist = false;
				foreach ($announcement_array as $key => $value) {
					if ($_POST["announcement_name"] == $key) {
						$announcement_name_exist = true;
						break;
					}
				}
				if($announcement_name_exist){
					echo "<script type='text/javascript'> window.alert('Old ad has been overwritten');
						</script>";
				}

				$announcement_array[$_POST["announcement_name"]] = $_POST['announcement_code']; 
				echo'<div class="notice notice-success is-dismissible"><p>Settings saved.</p></div>'; 
				update_option('announcements', $announcement_array);   
				
			}      
		} 

		 

		echo '<div class="wrap">
		<h1>New announcement befor post</h1>
		<form name="naph_form" method="post">
		<input type="hidden" name="naph_do_change" value="Y">Zaawansowane Technologie Webowe - laboratorium 1
		 	<p>Name of announcement: <input id="announcement_name" name="announcement_name" required></p>
			<textarea id="announcement_code" name="announcement_code" rows="6" cols="50" placeholder="Put your html code of announcement here" required></textarea>
			<p class="submit"><input type="submit" value="Add new announcement"></p>
			</form>
			</div>';

		print_announcement();
		
	}

	function print_announcement(){
		$announcement_array = get_option('announcements');

		echo '<h2 style="text-align:center;margin-bottom:25px;">Announcements</h2>
		
			<table class="wp-list-table widefat plugins">
					<thead>
					<tr style="background-color: #e5faf7;">
						<th scope="col" id="name">Name</th>
						<th scope="col" id="code">Body</th>
						<th scope="col" id="code">Action</th>
					</tr>
					</thead>
					<tbody id="the-list">';
		if(empty($announcement_array)){
			echo'<tr style="background-color: #f6e7e4;">
					<td class="plugin-title column-primary"><span style="color:red;">There are no ads.</span></td>
					<td></td>
					<td></td>
				</tr>';
		}
		else{
			foreach ($announcement_array as $key => $value) {
				echo'<tr style="background-color: #b9fdbf;">
						<td class="plugin-title column-primary"><strong>'.$key.'</td>';
				
				echo 	'<td class="plugin-title column-primary"><strong>'.htmlspecialchars($value).'</strong></td>';
				
				echo	'<td>
							<div class="row-actions visible">
								<span class="activate">
								<a href="delete_random_announcement.php?delete_random_announcement='.$key.'" id="delete" class="delete" >Usuń</a>
								</span>
							</div>

						</td>
					</tr>';

			}
		}
		

		echo	'</table>';

			echo '<h4 style="text-align:left;margin-top:15px;">Created by Hleb Liaonik, Aliaksandr Nadzeika</h4>';
	}


	add_filter("the_content", "add_content_before",1); 
	function add_content_before($content){
		$announcement_array = get_option('announcements'); 

		if (!empty($announcement_array)) {
			
			
			$random_ad = array_rand($announcement_array,1);

			//add action hook
			do_action('setting_announcement', $random_ad);
			

			$custom_content = '<div class="entry-content">
								    <p>';
			$custom_content .= $announcement_array[$random_ad];
			$custom_content .= '</p></div>';

								 
			$custom_content .= $content;

			

			return $custom_content; 
		}
		return $content;
	} 

	



	function naph_register_styles(){ 
		
		wp_register_style('naph_styles', plugins_url('/css/style.css', __FILE__)); 
		
		wp_enqueue_style('naph_styles'); 
	} 
	add_action('init', 'naph_register_styles');

 ?>
