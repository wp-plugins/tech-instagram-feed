var j = 0,k = 0;
var MediaUrlArray = [];
function InstaPagination()
{
	var PaginationUrl;
	var MediaWidth = TechInstagram.MediaWidth;	
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
	jQuery.each(feed, function(index){
        var post_image_src = this.images.low_resolution.url;
		var post_image_link = this.link;
		var caption_text  = this.caption;
		MediaUrlArray[i] = PaginationUrl;
		var testdiv = '<div class="instagram-unit '+MediaWidth+'"><a class="custom_instagram_widget" target="blank" href="'+post_image_link+'"><img src="'+post_image_src+'" alt="'+caption_text+'" /></a></div>';
		jQuery('.tech_insta_feed').append(testdiv);
			
   });
	},
});
		var index = MediaUrlArray.indexOf(undefined);
		if(index == -1)
		{k++;}
		if(LoadMoreDisable == k)
		{
		jQuery('.flowbutton').css("visibility", "hidden");	
		}
});
 //}
 j++;
}