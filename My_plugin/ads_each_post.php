<?php 
	/*
	 *@package	Plugin
	 */

	/** * Plugin Name:       Ads each post
	* Plugin URI:        https://example.com/plugins/Ads each post/ 
	* Description:       Plugin that displays ads at the beginning of each post.
	* Version:           1.0 
	* Requires at least: 5.0 
	* Requires PHP:      7.2 
	* Author:            Hleb Liaonik, Aliaksandr Nadzeika
	* Author URI:        https://...
	* License:           GPL v2 or later 
	* License URI:       https://www.gnu.org/licenses/gpl-2.0.html

	*/
	include('delete_ad.php');
	function naph_admin_actions_register_menu(){  
		add_options_page("Ads each post", "New ad befor post", 'manage_options', "naph", "naph_admin_page");    
	}                                                                                
	add_action('admin_menu', 'naph_admin_actions_register_menu');   


	function naph_admin_page(){                                          
		global $_POST; 
		if(isset($_POST['html_code'])){ 
			if($_POST['naph_do_change'] == 'Y'){ 
				$ad_array = get_option('html_code');
				$ad_name_exist = false;
				foreach ($ad_array as $key => $value) {
					if ($_POST["ad_name"] == $key) {
						$ad_name_exist = true;
						break;
					}
				}
				if($ad_name_exist){
					echo "<script type='text/javascript'> window.alert('Old ad has been overwritten');
						</script>";
				}

				$ad_array[$_POST["ad_name"]] = $_POST['html_code']; 
				echo'<div class="notice notice-success is-dismissible"><p>Settings saved.</p></div>'; 
				update_option('html_code', $ad_array);   
				
			}      
		} 

		$ad_array = get_option('html_code'); 

		echo '<div class="wrap">
		<h1>New ad befor post</h1>
		<form name="naph_form" method="post">
		<input type="hidden" name="naph_do_change" value="Y">Zaawansowane Technologie Webowe - laboratorium 1
		 	<p>Name of ad: <input id="ad_name" name="ad_name" required></p>
			<textarea id="html_code" name="html_code" rows="6" cols="50" placeholder="Put your html code of ad here" required></textarea>
			<p class="submit"><input type="submit" value="Add new advertising"></p>
			</form>
			</div>';

		print_adds();
		
	}

	function print_adds(){
		$adds_array = get_option('html_code');

		echo '<table class="wp-list-table widefat plugins">
					<thead>
					<tr style="background-color: #e5faf7;">
						<td></td>
						<th scope="col" id="name" >Advertising</th>
					</tr>
					</thead>
					<tbody id="the-list">';
		if(empty($adds_array)){
			echo'<tr style="background-color: #f6e7e4;">
					<th></th>
					<td class="plugin-title column-primary"><span style="color:red;">There are no ads.</span></td>
				</tr>';
		}
		else{
			foreach ($adds_array as $key => $value) {
				echo'<tr style="background-color: #b9fdbf;">
							<th></th>
							<td class="plugin-title column-primary"><strong>';
				echo $key;
				echo	'</strong>
						<div class="row-actions visible"><span class="activate">
							
							<a href="delete_ad.php?delete_ad='.$key.'" id="delete" class="delete" >Usuń</a></span></div>

						</td>
					</tr>';

			}
		}
		echo '<tfoot>
					<tr style="background-color: #e5faf7;">
						<td></td>
						<th scope="col" class="manage-column column-name column-primary">Created by Hleb Liaonik, Aliaksandr Nadzeika</th>
					</tr>
				</tfoot>

			</table>
';
	
	}


	add_filter("the_content", "add_content_before",1); 
	function add_content_before($content){
		$adds_array = get_option('html_code'); 

		if (!empty($adds_array)) {
			
			
			$random_ad = array_rand($adds_array,1);

			$custom_content = '<div class="entry-content">
								    <p>';
			$custom_content .= $adds_array[$random_ad];
			$custom_content .= '</p></div>';

								 
			$custom_content .= $content;


			return $custom_content; 
		}
		return $content;
	} 

	



	function naph_register_styles(){ 
		//register style
		wp_register_style('naph_styles', plugins_url('/css/style.css', __FILE__)); 
		//enable style (load in meta of html)
		wp_enqueue_style('naph_styles'); 
	} 
	add_action('init', 'naph_register_styles');

 ?>
