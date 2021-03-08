<?php
    

	/**
    * Plugin Name:       Counting announcements
	* Plugin URI:        https://example.com/plugins/counting_announcements/ 
	* Description:       Plugin that counts announcement after loading article.
	* Version:           1.0 
	* Requires at least: 5.0 
	* Requires PHP:      7.2 
	* Author:            Hleb Liaonik, Aliaksandr Nadzeika
	* Author URI:        https://...
	* License:           GPL v2 or later 
	* License URI:       https://www.gnu.org/licenses/gpl-2.0.html

	*/


    function create_couting_announcement_menu_page(){  
		add_menu_page("Counting announcements", "Counting announcements", 'manage_options', "announcments", "counting_announcement_admin_page");    
	}                                                                                
	add_action('admin_menu', 'create_couting_announcement_menu_page');

    function counting_announcement_admin_page(){
        
        echo '<h1 style="text-align:center">Statistics of announcements</h1>';
        
        $statistics_array = get_option('statistics');

        if(empty($statistics_array)){
            echo '  <div class="info">
                        Brak ogłoszeń!
                    </div>';
        }else{

            $announcement_array = get_option('announcements');

            echo '  <table class="wp-list-table widefat plugins">
                        <thead>
                            <tr style="background-color: #e5faf7;">
						        <th scope="col" id="name">Name</th>
						        <th scope="col" id="code">Body</th>
						        <th scope="col" id="counter">Counter</th>
					        </tr>
                        </thead>
                        <tbody>';
                        
            foreach ($statistics_array as $key => $value) {
				echo'<tr style="background-color: #b9fdbf;">
						<td class="column-primary">'.$key.'</td>';
				if(array_key_exists($key, $announcement_array)){
                    echo 	'<td class="column-primary">'.htmlspecialchars($announcement_array[$key]).'</td>';
                }else{
                    echo 	'<td class="column-primary" style="background-color:#f44336;">Ogłoszenie było usunięte</td>';
                }

				echo 	'<td class="column-primary">'.$value.'</td>';

				echo	'</tr>';

			}

            echo '          </tbody>
                    </table>';
        }
    }


    function increment_announcement($name_announcement){
        $statistics_array = get_option('statistics');
        if(!empty($statistics_array)){
            
            if(array_key_exists($name_announcement, $statistics_array)){
                $statistics_array[$name_announcement] += 1;
            }else{
                $statistics_array[$name_announcement] = 1;
            }
        
        }else{
            $statistics_array[$name_announcement] = 1;   
        }
        update_option('statistics', $statistics_array);   
    }
    add_action('setting_announcement', 'increment_announcement');


    function register_styles(){ 
		
		wp_register_style('my_styles', plugins_url('/css/style.css', __FILE__)); 
		
		wp_enqueue_style('my_styles'); 
	} 
	add_action('init', 'register_styles');

?>