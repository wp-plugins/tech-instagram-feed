var j = 0,k = 0;
var MediaUrlArray = [];
function InstaPagination()
{
	var PaginationUrl;
	var MediaWidth = TechInstagram.MediaWidth;
	var MediaFeedSprtBy  = TechInstagram.MediaFeedSortBy;	
	var MediaResolution  = TechInstagram.MediaResolution;
	 if(j == 0){var MediaUrl = TechInstagram.Pagination;
	}else{var MediaUrl = MediaUrlArray;
	}
	var LoadMoreDisable = MediaUrl.length;

	jQuery.each(MediaUrl,function(i,val){
	jQuery.ajax({
    type: "GET",
    dataType: "jsonp",
    cache: false,
    url: val,
    success: function (x) {
	var feed = x.data;
	PaginationUrl = x.pagination.next_url;
	MediaUrlArray[i] = PaginationUrl;
	if(PaginationUrl == undefined){k++;}
	if(LoadMoreDisable == k){
		jQuery('.flowbutton').css("visibility", "hidden");	
		}
		
		if(MediaFeedSprtBy == 'random'){RandomeFeed(feed);		
		} else if(MediaFeedSprtBy == 'oldest'){ReverseFeed(feed);		
		}
	jQuery.each(feed, function(index){
		
		if(MediaResolution == 'Thumbnail'){
			var post_image_src = this.images.thumbnail.url;
		}else if(MediaResolution == 'LowResolution'){
			var post_image_src = this.images.low_resolution.url;
		}else if(MediaResolution == 'StandardResolution'){
			var post_image_src = this.images.standard_resolution.url;
		}
        
		var post_image_link = this.link;
		var caption_text  = this.caption;
		
		var InstaMedia = '<div class="instagram-unit '+MediaWidth+'"><a class="custom_instagram_widget" target="blank" href="'+post_image_link+'"><img src="'+post_image_src+'" alt="'+caption_text+'" /></a></div>';
		jQuery('.loadbutton').before(InstaMedia);
			
   });
	},
});
		
});
 //}
 j++;
}

function RandomeFeed(feedmedia) {
	  var currentIndex = feedmedia.length, temporaryValue, randomIndex ;
	  while (0 !== currentIndex) {
		randomIndex = Math.floor(Math.random() * currentIndex);
		currentIndex -= 1;
		temporaryValue = feedmedia[currentIndex];
		feedmedia[currentIndex] = feedmedia[randomIndex];
		feedmedia[randomIndex] = temporaryValue;
	  }
	return feedmedia;
}
function ReverseFeed(feedmedia){
	return feedmedia.reverse();
}
