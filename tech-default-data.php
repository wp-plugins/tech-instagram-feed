<?php $tech_instagram = array();

$tech_instagram = array(
    'tech_client_id' => '',
    'tech_user_name' => '',
    'tech_feed_width' => '100',
	'tech_feed_width_unit' => '%',
    'tech_feed_height' => '100',
    'tech_feed_height_unit' => '%',
    'tech_feed_background_color' => '#fff'
    
    );

$tech_default_settings  = wp_parse_args(get_option('tech_settings'),$tech_instagram);
update_option('tech_settings',$tech_default_settings);
?>