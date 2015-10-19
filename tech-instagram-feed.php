<?php
/*
Plugin Name: Tech Instagram Feed
Description: This plugin allows to fetch the instagram media in your wordpress site.
Version: 1.6.2
Author: Techvers
Author URI: http://techvers.com/
License: GPLv2 or later
Text Domain: tech
*/

define( 'TECH_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'TECH_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

add_action('admin_menu', 'tech_admin_menu_pages');
add_action( 'admin_init', 'tech_plugin_scripts' );
function tech_plugin_scripts(){
	if( is_admin() ){
	wp_register_script('tech-instagram-admin-easytab',TECH_PLUGIN_URL.'lib/js/admin-js/jquery.easytabs.min.js');
	wp_register_script('tech-instagram-admin-custom-js',TECH_PLUGIN_URL.'lib/js/admin-js/admin-custom-js.js');
	wp_register_script( 'custom-script-handle', plugins_url(  'lib/js/admin-js/tech-color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
	wp_register_style('admin_style',TECH_PLUGIN_URL.'lib/style/admin-panel-style.css');
	// Add the color picker css file       
	wp_enqueue_style( 'wp-color-picker' );  
	// Include our custom jQuery file with WordPress Color Picker dependency
	 
    }
}

//call default data
require_once(TECH_PLUGIN_DIR.'/tech-default-data.php');

//call shortcode file
require_once(TECH_PLUGIN_DIR.'/tech-shortcode.php');

function tech_admin_menu_pages(){
    
    
    $tech_instaram_hook_suffix = add_menu_page(__('Tech Instagram Feed','tech'), __('Tech Instagram Feed','tech'), 'manage_options', 'tech-instagram', 'tech_instagram_output' );
    //add_submenu_page('my-menu', 'Settings', 'Whatever You Want', 'manage_options', 'my-menu' );
    //add_submenu_page('my-menu', 'Submenu Page Title2', 'Whatever You Want2', 'manage_options', 'my-menu2' );

	add_action('admin_print_scripts-' . $tech_instaram_hook_suffix, 'tech_instagram_admin_scripts');
	
	}

function tech_instagram_admin_scripts() {
        /* Link our already registered script to a page */
        wp_enqueue_script( 'tech-instagram-admin-easytab' );
		wp_enqueue_script( 'tech-instagram-admin-custom-js' );
		wp_enqueue_script( 'custom-script-handle' );
		wp_enqueue_style( 'wp-color-picker' ); 
		wp_enqueue_style( 'admin_style' ); 
    }

function tech_instagram_output()
{
?>
	<body>
 <h2>Tech Instagram Feed</h2>
<div id="tab-container" class='tab-container'>
 <ul class='etabs'>
   <li class='tab'><a href="#tabs1-Gsettings">General Settings</a></li>
   <li class='tab'><a href="#tabs1-Design">Design Customization</a></li>
    <li class='tab'><a href="#tabs1-cssandjs">Custom css and js</a></li>
 </ul>
 <div class='panel-container'>
  <div id="tabs1-Gsettings">
  <?php if(isset($_POST['Gsettings'])){
	  $tech_settings = array();
    $tech_settings = get_option('tech_settings');
    $tech_settings['tech_client_id'] = $_POST['tech_client_id'];
    $tech_settings['tech_user_name'] = explode (",",$_POST['tech_user_name']);
        
        // update options
        update_option('tech_settings',$tech_settings);

}?>
  <form  name="tech_form" method="post"><?php $tech_settings = get_option('tech_settings');?>

<table class="form-table">
        <tr valign="top">
        <th scope="row"><label>Client Id :</label></th>
        <td><input type="text" id="tech_client_id"  name="tech_client_id" value="<?php esc_attr_e($tech_settings['tech_client_id']); ?>" /><a class="help-client-link" href="http://help.dimsemenov.com/kb/wordpress-royalslider-faq/wp-how-to-get-instagram-client-id-and-client-secret-key" target="_blank"> Get client id</a></td>
        </tr>
         
        <tr valign="top">
        <th scope="row"><label>User Id :</label></th>
        <td><input type="text" id="tech_user_name" name="tech_user_name" value="<?php esc_attr_e(implode(",",$tech_settings['tech_user_name'])); ?>" /><span> add multiple user Id seprate with comma (,).</span></td>
        </tr>
		
       
    </table>
    
 
    <input type="submit" name="Gsettings" value="Save Changes" class="button button-primary"/>
</form> 



  </div>
   <div id="tabs1-Design">
   
   <?php
if(isset($_POST['Csettings'])){
	$tech_settings = array();
$tech_settings = get_option('tech_settings');

$tech_settings['tech_feed_width'] = $_POST['tech_feed_width'];
$tech_settings['tech_feed_width_unit'] = $_POST['tech_feed_width_unit'];
$tech_settings['tech_feed_height'] = $_POST['tech_feed_height'];
$tech_settings['tech_feed_height_unit'] = $_POST['tech_feed_height_unit'];
$tech_settings['tech_feed_background_color'] = $_POST['tech_feed_background_color'];
$tech_settings['tech_feed_number_feeds'] = $_POST['tech_feed_number_feeds'];
$tech_settings['tech_feed_column'] = $_POST['tech_feed_column'];
$tech_settings['tech_feed_header_information'] = $_POST['tech_feed_header_information'];
$tech_settings['tech_media_resolution'] = $_POST['tech_media_resolution'];
$tech_settings['tech_load_more_button_text'] = $_POST['tech_load_more_button_text'];
if (isset($_POST['sortby'])){	
 
  $tech_settings['tech_feed_sortby'] = $_POST['sortby'] ;
}
update_option('tech_settings',$tech_settings);	

	
}
//#0573c6

   ?>
  
<form name="custom_form" method="post"><?php $tech_settings = get_option('tech_settings'); 
//print_r($tech_settings);
//wp_die();
?>
 <h2>Customize Feed Area and Photos</h2>
    <table class="form-table">
		
        <tr valign="top">
        <th scope="row"><label>Width of feed area:</label></th>
            <td>
                <input type="text" id="tech_feed_width"  name="tech_feed_width" value="<?php esc_attr_e($tech_settings['tech_feed_width']); ?>" size="5" />
                <select name="tech_feed_width_unit">
                    <option value="px" <?php if($tech_settings['tech_feed_width_unit'] == "px") echo 'selected="selected"' ?> ><?php _e('px'); ?></option>
                    <option value="%" <?php if($tech_settings['tech_feed_width_unit'] == "%") echo 'selected="selected"' ?> ><?php _e('%'); ?></option>
                </select>
            </td>
			<th scope="row"><label>Sort By:</label></th>
            <td><input type="radio"  name="sortby" value="nosort" <?php if($tech_settings['tech_feed_sortby']=='nosort'){echo 'checked';}?>>Newest to oldest</td> 
			<td><input type="radio"  name="sortby" value="random"<?php if($tech_settings['tech_feed_sortby']=='random'){echo 'checked';}?>>Random</td>
			<td><input type="radio" name="sortby" value="oldest"<?php if($tech_settings['tech_feed_sortby']=='oldest'){echo 'checked';}?>> Oldest to newest</td>
        </tr>
         
        <tr valign="top">
        <th scope="row"><label>Height of feed area:</label></th>
            <td>
                <input type="text" id="tech_feed_height"  name="tech_feed_height" value="<?php esc_attr_e($tech_settings['tech_feed_height']); ?>" size="5" />
                <select name="tech_feed_height_unit">
                    <option value="px" <?php if($tech_settings['tech_feed_height_unit'] == "px") echo 'selected="selected"' ?> ><?php _e('px'); ?></option>
                    <option value="%" <?php if($tech_settings['tech_feed_height_unit'] == "%") echo 'selected="selected"' ?> ><?php _e('%'); ?></option>
                </select>
            </td>
			<th scope="row"></label>Number of feeds:</label></th>
			<td><input type="text" name="tech_feed_number_feeds" value="<?php esc_attr_e($tech_settings['tech_feed_number_feeds']); ?>">
        <br>
		
			<th scope="row"><label>Media Column:</label></th>
            <td>
                <select name="tech_feed_column" style="width:70%">
                    <option value="1" <?php if($tech_settings['tech_feed_column'] == "1") echo 'selected="selected"' ?> ><?php _e('1'); ?></option>
                    <option value="2" <?php if($tech_settings['tech_feed_column'] == "2") echo 'selected="selected"' ?> ><?php _e('2'); ?></option>
					<option value="3" <?php if($tech_settings['tech_feed_column'] == "3") echo 'selected="selected"' ?> ><?php _e('3'); ?></option>
                    <option value="4" <?php if($tech_settings['tech_feed_column'] == "4") echo 'selected="selected"' ?> ><?php _e('4'); ?></option>
					<option value="5" <?php if($tech_settings['tech_feed_column'] == "5") echo 'selected="selected"' ?> ><?php _e('5'); ?></option>
                    <option value="6" <?php if($tech_settings['tech_feed_column'] == "6") echo 'selected="selected"' ?> ><?php _e('6'); ?></option>
					<option value="7" <?php if($tech_settings['tech_feed_column'] == "7") echo 'selected="selected"' ?> ><?php _e('7'); ?></option>
                    <option value="8" <?php if($tech_settings['tech_feed_column'] == "8") echo 'selected="selected"' ?> ><?php _e('8'); ?></option>
					<option value="9" <?php if($tech_settings['tech_feed_column'] == "9") echo 'selected="selected"' ?> ><?php _e('9'); ?></option>
                    <option value="10" <?php if($tech_settings['tech_feed_column'] == "10") echo 'selected="selected"' ?> ><?php _e('10'); ?></option>
                </select>
            </td>
		</tr>
		
		 
		
        
		
        <tr valign="top">
        <th scope="row"><label>Feed background color:</label></th>
            <td>
                <input type="text" name="tech_feed_background_color" value="<?php esc_attr_e($tech_settings['tech_feed_background_color']);?>" class="tech-color-field" />
            </td>
			
			 <th scope="row"><label>Show Header:</label></th>
            <td>
					 <select name="tech_feed_header_information">
                    <option value="yes" <?php if($tech_settings['tech_feed_header_information'] == "yes") echo 'selected="selected"' ?> ><?php _e('Yes'); ?></option>
                    <option value="no" <?php if($tech_settings['tech_feed_header_information'] == "no") echo 'selected="selected"' ?> ><?php _e('No'); ?></option>
                </select>
            </td>
			<th scope="row"><label>Media Resolution:</label></th>
            <td>
                <select name="tech_media_resolution" style="width:70%">
                    <option value="Thumbnail" <?php if($tech_settings['tech_media_resolution'] == "Thumbnail") echo 'selected="selected"' ?> ><?php _e('Thumbnail'); ?></option>
                   <option value="LowResolution" <?php if($tech_settings['tech_media_resolution'] == "LowResolution") echo 'selected="selected"' ?> ><?php _e('Medium'); ?></option>
                    <option value="StandardResolution" <?php if($tech_settings['tech_media_resolution'] == "StandardResolution") echo 'selected="selected"' ?> ><?php _e('Standard'); ?></option>
                </select>
            </td>
			 
        </tr>
		<tr valign="top">
			<th scope="row"><label>Load more button text:</label></th>
            <td>
           <input type="text" name="tech_load_more_button_text" value="<?php esc_attr_e($tech_settings['tech_load_more_button_text']); ?>">
            </td>
		</tr>
		
       
			
       
    </table>
	
	 
     <input type="submit" name="Csettings" value="Save Changes" class="button button-primary"/>
</form>
  </div>
  <div id="tabs1-cssandjs">
   <?php
if(isset($_POST['CustomCssAndJs'])){
$tech_settings = array();
$tech_settings = get_option('tech_settings');
$tech_settings['tech_insta_custom_css'] = $_POST['tech_insta_custom_css'];
    $tech_settings['tech_insta_custom_js'] = $_POST['tech_insta_custom_js'];
	update_option('tech_settings',$tech_settings);
}
?>

<form  name="CustomCssAndJs" method="post"><?php $tech_settings = get_option('tech_settings'); ?>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<td style="padding-bottom: 0;">
						<strong style="font-size: 15px;">Custom CSS</strong><br><strong style="font-size: 12px;"></td>
				</tr>
				<tr valign="top">
					<td>
						<textarea name="tech_insta_custom_css" id="tech_insta_custom_css"   style="width: 70%;" rows="7"><?php  esc_attr_e(stripslashes( $tech_settings['tech_insta_custom_css'])); ?></textarea>
					</td>
				</tr>
				<tr valign="top">
					<td style="padding-bottom: 0;">
						<strong style="font-size: 15px;">Custom JavaScript</strong><br><strong style="font-size: 12px;"></td>
				</tr>
				<tr valign="top">
					<td>
						<textarea name="tech_insta_custom_js" id="tech_insta_custom_js"  style="width: 70%;" rows="7"><?php esc_attr_e(stripslashes( $tech_settings['tech_insta_custom_js'])); ?></textarea>
					</td>
				</tr>
			</tbody>
		</table>
	
 

    <input type="submit" name="CustomCssAndJs" value="Save Changes" class="button button-primary"/>
	
	
	
</form> 

  

  </div>
 </div>
</div>

</body>
<?php
	
}


?>