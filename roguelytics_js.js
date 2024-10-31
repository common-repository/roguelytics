jQuery(function(){
	jQuery(".tab_select > li").on("click", function(){
		var tab_index = jQuery(this).index() + 1;
		var tab_content = jQuery(this).parent().siblings(".tab_content");

		jQuery(this).parent().children("li").removeClass("active");
		jQuery(this).addClass("active");	

		tab_content.children("li").removeClass("active");
		tab_content.children("li:nth-child(" + tab_index + ")").addClass("active");

		tab_content.height(tab_content.children("li.active").outerHeight(true));
	})

	var roguelytics_site = "https://www.roguelytics.com";

	jQuery("#roguelytics_signin").on("submit", function(e){
		e.preventDefault();
		jQuery.ajax({
         url: roguelytics_site + "/api/v1/login/signin.json",
         type: 'POST',
         crossDomain: true,
         data: jQuery(this).serialize(),
         xhrFields:{
          	withCredentials: true
      	},
         success: function(result) {
            window.location.href = ""
         }
      });
	})
})