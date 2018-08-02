/**
 * Makes "skip to content" link work correctly in IE9, Chrome, and Opera
 * for better accessibility.
 *
 * @link http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
 */

 jQuery(document).ready(app_ajax )
 
 
 function app_ajax() {

	jQuery( ".form-process" ).on("submit",ajax_call);
	//
}
function ajax_call(e){
	e.preventDefault();
// used to upload files to server using ajax
	var form_data = new FormData(this);
	//fr.append("file","99");
	

	var d={
			action:'test_responce',
			
		};
		/*jQuery.post(mrb_ajax_process_object.ajax_url,data, function(responce){
			alert("my first ajax from server"+ responce);
			
		})*/
		jQuery.ajax({
				type:"post",
				dataType:"html",
				url: mrb_ajax_process_object.ajax_url,
				data:form_data,
				contentType:false,
				//cache:false,
				processData:false,
			
			success: function(re){
				jQuery('.message').html(re);
			},
			error: function(XMLHttpRquest, textStatus,  errorThrown ){
				jQuery('.message').html("Request failed "+ errorThrown);
			}
			})
		return false;
}
 /*

(app_ajax)(jQuery); 
 //jQuery(app_ajax);

 

function menu_link(e){
	if(jQuery(e.target).is("a")){
		alert("a tag");
	}
alert("will  "+ e.target.nodeName+ "  ");
	jQuery(".spinner").show();
	e.preventDefault();
	
			jQuery.ajax({
				type:"post",
				dataType:"html",
				url: myAjax.ajaxurl,
				data:{action:'my_ajax', ref:jQuery(this).attr("href")}
			,
			success: ajax_loaded
			}
	)
	
	
	//return 0;
}

function ajax_loaded(responce){
				  jQuery("#responce-msg").html(responce);
				  jQuery(".spinner").hide();	
					}



*/