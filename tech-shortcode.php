<?php
function tech_shortcode_function(){
add_action( 'wp_footer', 'tech_custom_css' );
function tech_custom_css() {
							$tech_settings = get_option('tech_settings');
							$CustomStyle = $tech_settings[ 'tech_insta_custom_css' ];
							if( !empty($CustomStyle) ) echo '<!-- Tech intagram Custom css -->';
							if( !empty($CustomStyle) ) echo "\r\n";
							if( !empty($CustomStyle) ) echo '<style type="text/css">';
							if( !empty($CustomStyle) ) echo "\r\n";
							if( !empty($CustomStyle) ) echo stripslashes($CustomStyle);
							if( !empty($CustomStyle) ) echo "\r\n";
							if( !empty($CustomStyle) ) echo '</style>';
							if( !empty($CustomStyle) ) echo "\r\n";
								
							}
			
			
add_action( 'wp_footer', 'tech_custom_js' );
function tech_custom_js() {
							 $tech_settings = get_option('tech_settings');
							 $CustomJs = $tech_settings[ 'tech_insta_custom_js' ];
							if( !empty($CustomJs) ) echo '<!-- Tech Instagram JS -->';
							if( !empty($CustomJs) ) echo "\r\n";
							if( !empty($CustomJs) ) echo '<script type="text/javascript">';
							if( !empty($CustomJs) ) echo "\r\n";
							if( !empty($CustomJs) ) echo "jQuery( document ).ready(function($) {";
							if( !empty($CustomJs) ) echo "\r\n";
							if( !empty($CustomJs) ) echo "\r\n";
							if( !empty($CustomJs) ) echo stripslashes($CustomJs);
							if( !empty($CustomJs) ) echo "\r\n";
							if( !empty($CustomJs) ) echo "\r\n";
							if( !empty($CustomJs) ) echo "});";
							if( !empty($CustomJs) ) echo "\r\n";
							if( !empty($CustomJs) ) echo '</script>';
							if( !empty($CustomJs) ) echo "\r\n";
						}		

wp_enqueue_style('techstyle',TECH_PLUGIN_URL.'lib/style/tech_style.css');
	
  $tech_settings = get_option('tech_settings');
 // print_r($tech_settings);
  $user_name = $tech_settings['tech_user_name'];
  $clientId  = $tech_settings['tech_client_id'];
  $feed_background_color = $tech_settings['tech_feed_background_color'];
  $feed_section_height = $tech_settings['tech_feed_height'];
  $feed_section_height_unit = $tech_settings['tech_feed_height_unit'];
  $feed_section_width = $tech_settings['tech_feed_width'];
  $feed_section_width_unit = $tech_settings['tech_feed_width_unit'];
  $FeedSortBy = $tech_settings['tech_feed_sortby'];
  $FeedCount  = $tech_settings['tech_feed_number_feeds'];
  $FeedLayout = $tech_settings['tech_feed_column'];
  $UserHeader = $tech_settings['tech_feed_header_information'];
  $MediaResolution  = $tech_settings['tech_media_resolution'];
  $LodMoreButtonText = $tech_settings['tech_load_more_button_text'];
  
  if($feed_section_width_unit == 'px' || $feed_section_height_unit == 'px' ){
	  
	 $overfllow = 'hidden';
  }else{
	  $overfllow = 'visible';
  }
  
  if($FeedLayout == 1){ 
  $MediaWidth = 'instagram-unit-col1';
  } else if( $FeedLayout == 2){ 
  $MediaWidth = 'instagram-unit-col2';
  } else if( $FeedLayout == 3){ 
  $MediaWidth = 'instagram-unit-col3';
  } else if( $FeedLayout == 4){
	  $MediaWidth = 'instagram-unit-col4';
  } else if( $FeedLayout == 5){ 
  $MediaWidth = 'instagram-unit-col5';
  } else if( $FeedLayout == 6){ 
  $MediaWidth = 'instagram-unit-col6';
  } else if( $FeedLayout == 7){
	$MediaWidth = 'instagram-unit-col7';
  } else if( $FeedLayout == 8){
	  $MediaWidth = 'instagram-unit-col8';
  } else if( $FeedLayout == 9){
	  $MediaWidth = 'instagram-unit-col9';
  } else if( $FeedLayout == 10){ 
  $MediaWidth = 'instagram-unit-col10';
  }
  
  // radon instagram feed
 function shuffle_array($arr) {
    if (!is_array($arr)) return $arr;
    shuffle($arr);
    foreach ($arr as $key => $a) {
        if (is_array($a)) {
            $arr[$key] = shuffle_array($a);
        }
    }

    return $arr;
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
  
  $i=1;
  $k=0;
 foreach($user_name as $user){
	 //print(sizeof($user_name));
  
  // get user id from user name 
	$resultid = TechInstagramData("https://api.instagram.com/v1/users/search?q=$user&client_id=$clientId");
	$resultid = json_decode($resultid);
	$userId = $resultid->data[0]->id;

	// get user media 
		$TechUserMedia = TechInstagramData("https://api.instagram.com/v1/users/$userId/media/recent/?client_id=$clientId&count=$FeedCount");
		$TechUserMedia = json_decode($TechUserMedia);
		
		$NextUrl[] = $TechUserMedia->pagination->next_url;

		$TechUserMedia = $TechUserMedia->data;
		
	if($i == 1){
		
	 // get user information
	$resultuserdata = TechInstagramData("https://api.instagram.com/v1/users/$userId/?client_id=$clientId");
	$resultuserdata = json_decode($resultuserdata);
?>
	
<div class="techinstagramlink-content" style="height:'<?php echo $feed_section_height.$feed_section_height_unit;?>' width:'<?php echo $feed_section_width.$feed_section_width_unit;?>'">
<?php if($UserHeader != 'no'){?><a class="techinstagram-header" href="http://instagram.com/<?php echo $resultuserdata->data->username;?>" target="_blank"> 
<img class="techinstagram-header-pic" src="<?php echo $resultuserdata->data->profile_picture; ?>" alt="<?php echo $resultuserdata->data->username;?>"> 
<span class="techinstagram-header-name"><?php echo $resultuserdata->data->username;?> </span> <span class="techinstagram-header-logo"></span> </a><?php }?>
<?php if($UserHeader != 'no'){?><div class="techinstagram-panel"><span class="techinstagram-panel-posts techinstagram-panel-counter"> 
<i class="techinstagram-panel-counter-value"><?php echo $resultuserdata->data->counts->media;?></i>
<span class="techinstagram-panel-counter-label">posts</span> </span>
<span class="techinstagram-panel-subsribers techinstagram-panel-counter"> <i class="techinstagram-panel-counter-value"><?php echo $resultuserdata->data->counts->followed_by;?></i> 
<span class="techinstagram-panel-counter-label">followers</span> </span> 
<span class="techinstagram-panel-following techinstagram-panel-counter"> <i class="techinstagram-panel-counter-value"> <?php echo $resultuserdata->data->counts->follows;?></i> 
<span class="techinstagram-panel-counter-label">following</span> </span> 
<a class="techinstagram-panel-subscribe" href="http://instagram.com/<?php echo $resultuserdata->data->username;?>" target="_blank">Follow</a> </div><?php }?>
<div class="tech_insta_feed" style="padding:3px; overflow-x:<?php echo $overfllow;?>; background-color:<?php echo $feed_background_color;?>; height:<?php echo $feed_section_height.$feed_section_height_unit;?>; width:<?php echo $feed_section_width.$feed_section_width_unit;?>;">
<?php	
	}	
		if($FeedSortBy=='random'){	
		$TechUserMedia =  shuffle_array($TechUserMedia);
		}else if($FeedSortBy=='oldest'){
			$TechUserMedia = array_reverse($TechUserMedia);
		}

  foreach ($TechUserMedia as $post) {
		if($MediaResolution == 'Thumbnail'){
			$MediaResolutionUrl = $post->images->thumbnail->url;
		}else if($MediaResolution == 'LowResolution'){
			$MediaResolutionUrl = $post->images->low_resolution->url;
		}else if($MediaResolution == 'StandardResolution'){
			$MediaResolutionUrl = $post->images->standard_resolution->url;
		}
	  ?>
       <div class="instagram-unit <?php echo $MediaWidth; ?>"><a  target="blank" href="<?php echo $post->link ?>">
        <img src="<?php echo $MediaResolutionUrl; ?>">
     </a></div><?php
   

  }
  if($i == sizeof($user_name)){?>
  <div class="loadbutton">
  <input type="button" class="flowbutton" onClick="InstaPagination()" value='<?php echo $LodMoreButtonText; ?>'>
  </div>
  </div></div>
  

  <?php
  } 
  $i++;
 }
 
 $InstaSettings = array(
	    "Pagination" => $NextUrl,
	    "MediaWidth" => $MediaWidth,
		"MediaFeedSortBy" => $FeedSortBy,
		"MediaResolution" => $MediaResolution
	  );
 
    wp_register_script( "scripts", plugin_dir_url( __FILE__ ) . "lib/js/tech-instagram-js.js" );
    wp_enqueue_script( "scripts" );
    wp_localize_script( "scripts", "TechInstagram", $InstaSettings );
 
 foreach($NextUrl as $MediaUrl){
	 
  if(str_word_count($MediaUrl)==0){
	 $k++;
	if($k == sizeof($user_name)) {
	 ?><script>jQuery('.flowbutton').css("visibility", "hidden");	</script><?php
	 }}
	  
  }
  
}// end shortcode
add_shortcode('techinstagram','tech_shortcode_function')
?>