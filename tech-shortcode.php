<?php
function tech_shortcode_function(){

wp_enqueue_style('techstyle',TECH_PLUGIN_URL.'lib/style/tech_style.css');
	
  $tech_settings = get_option('tech_settings');
  //print_r($tech_settings);
  $user_name = $tech_settings['tech_user_name'];
  $clientId  = $tech_settings['tech_client_id'];
  $feed_background_color = $tech_settings['tech_feed_background_color'];
  $feed_section_height = $tech_settings['tech_feed_height'];
  $feed_section_height_unit = $tech_settings['tech_feed_height_unit'];
  $feed_section_width = $tech_settings['tech_feed_width'];
  $feed_section_width_unit = $tech_settings['tech_feed_width_unit'];
  
  if($feed_section_width_unit == 'px' || $feed_section_height_unit == 'px' ){
	  
	 $overfllow = 'hidden';
  }else{
	  $overfllow = 'visible';
  }
 
  function TechInstagramData($url){
  $ch = curl_init();
    curl_setopt_array($ch, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => 2
    ));

    $TechFeedData = curl_exec($ch);
    curl_close($ch);
    return $TechFeedData;

  }
  // get user id from user name 
  $resultid = TechInstagramData("https://api.instagram.com/v1/users/search?q=$user_name&client_id=$clientId");
  $resultid = json_decode($resultid);
	$userId = $resultid->data[0]->id;
	
	
	// get user information
	$resultuserdata = TechInstagramData("https://api.instagram.com/v1/users/$userId/?client_id=$clientId");
	$resultuserdata = json_decode($resultuserdata);
 
	 // get user media 
	  $TechUserMedia = TechInstagramData("https://api.instagram.com/v1/users/$userId/media/recent/?client_id=$clientId&count=50");
	  $TechUserMedia = json_decode($TechUserMedia);
  
  
 
echo '<div class="techinstagramlink-content" style="height:'.$feed_section_height.''.$feed_section_height_unit.'; width:'.$feed_section_width.''.$feed_section_width_unit.'">
<a class="techinstagram-header" href="http://instagram.com/'.$resultuserdata->data->username.'/" target="_blank"> 
<img class="techinstagram-header-pic" src="'.$resultuserdata->data->profile_picture.'" alt="'.$resultuserdata->data->username.'"> 
<span class="techinstagram-header-name">'.$resultuserdata->data->username.'</span> <span class="techinstagram-header-logo"></span> </a>
<div class="techinstagram-panel"><span class="techinstagram-panel-posts techinstagram-panel-counter"> 
<i class="techinstagram-panel-counter-value">'.$resultuserdata->data->counts->media.'</i>
<span class="techinstagram-panel-counter-label">posts</span> </span>
<span class="techinstagram-panel-subsribers techinstagram-panel-counter"> <i class="techinstagram-panel-counter-value">'.$resultuserdata->data->counts->followed_by.'</i> 
<span class="techinstagram-panel-counter-label">followers</span> </span> 
<span class="techinstagram-panel-following techinstagram-panel-counter"> <i class="techinstagram-panel-counter-value">'.$resultuserdata->data->counts->follows.'</i> 
<span class="techinstagram-panel-counter-label">following</span> </span> 
<a class="techinstagram-panel-subscribe" href="http://instagram.com/'.$resultuserdata->data->username.'/" target="_blank">Follow</a> </div>
<div style="padding:3px; margin-top:34px; overflow-x:'.$overfllow.'; background-color: '.$feed_background_color.'; height:'.$feed_section_height.''.$feed_section_height_unit.'; width:'.$feed_section_width.''.$feed_section_width_unit.'">';
  
  foreach ($TechUserMedia->data as $post) {
    
        echo '<div class="instagram-unit"><a  target="blank" href="'.$post->link.'">
        <img src="'.$post->images->standard_resolution->url.'">
     </a></div>';
   

  }
  echo '</div></div>';
}// end shortcode
add_shortcode('techinstagram','tech_shortcode_function')
?>