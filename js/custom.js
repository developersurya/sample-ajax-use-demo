var admin_url =  myAjax.ajaxurl;
var nonce = myAjax.nonce;
			jQuery(function($){
				//console.log(admin_url);
				var select = $('#category_parent');
				//var security = nonce;// checking nonce foro security 
				select.change(function(){
					selectedVal = select.val();
					//console.log(selectedVal);
					//debugger;
					$.ajax({
						type: "POST",
						url:admin_url,
						data:{action: "get_cat_selected", selectedcat:selectedVal,security:nonce},
						
						success: function(response) {
							
							   $('.resultshere').html(response);
							
							}
										
						
					});
				});
			});