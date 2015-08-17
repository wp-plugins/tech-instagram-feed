<?php $tech_instagram = array();

$tech_instagram = array(
    'tech_client_id' => 'c1ff1f16cad744b6b8406ae3afe1d071',
    'tech_user_name' => '',
    'tech_feed_width' => '100',
	'tech_feed_width_unit' => '%',
    'tech_feed_height' => '100',
    'tech_feed_height_unit' => '%',
    'tech_feed_background_color' => '#fff',
	'tech_feed_sortby' => 'nosort',
	'tech_feed_number_feeds' => '20'
    
    );

$tech_default_settings  = wp_parse_args(get_option('tech_settings'),$tech_instagram);
update_option('tech_settings',$tech_default_settings);
?>