/* Custom global scripts */
 console.log("Tasty - Where will you eat today ?");
 console.log("If looking under the hood is what you like, we'd love to chat. www.tasty.lk/feedback");
	

$(function () {
	
    //FastClick.attach(document.body);

	$('#ajax-signup-form').hide();
	//.on("click.dropdown-menu",function(a){a.stopPropagation()})

    $("[rel='tooltip']").tooltip();

	$("[rel=popover]").popover();

	reqAuthPopover_settings =  {
    	'html': true,
    	'placement': 'bottom',
    	'content': "Please <a href='"+TASTY.baseUrl+"user/login'>login</a> to Tasty to do that!"
	};
    
    if(!TASTY.isMember) {
	   	$("[rel=reqauth]").popover(reqAuthPopover_settings);
    }

    $('[rel=reqauth], [rel=popover]').click(function(){
    	$('[rel=reqauth], [rel=popover]').not(this).popover('hide'); //all but this
	});

    $(document).click(function (e) {
	    $('[rel=reqauth], [rel=popover]').each(function () {
	        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
	            //$(this).popover('hide');
	            if($(this).data('bs.popover') != undefined) {
		            if ($(this).data('bs.popover').tip().hasClass('in')) {
		                $(this).popover('toggle');
		            }
		            	
	            }
	            
	            return;
	        }
	    });
	});

    $("select").chosen({allow_single_deselect:true, disable_search_threshold: 6, disable_search: true});

    $('.infinite-list').infinitescroll({
            loading: {
            finishedMsg: "<div>No more items...</div>",
            msgText: "<div class='mini-loader'></div>",
        },
        navSelector     : ".pager",
        nextSelector    : ".pager a:last",
        itemSelector    : '.infinite-item',
        bufferPx        : 500,
        debug           : false,
        dataType        : 'html'
    });    

	$("[data-target=#ajaxModal]").click(function (e) {
		e.preventDefault();
		lv_target = $(this).attr('data-target');
		lv_url = $(this).attr('data-link');
		$(lv_target).load(lv_url);
	})


	// Prevent closing the sign in form on click 
	$('#ajax-login').click(function(e) { 
	   e.stopPropagation(); 
	});

	$('.facebookConnectButton').click(function(e) { 
		e.preventDefault();
		
		FB.login(function(response) {
		   // handle the response
		   window.location.reload();
		}, {scope: 'email,publish_stream,publish_actions'});

	});

	$('#link-logout').click(function(e) { 
		e.preventDefault();
	 	if(typeof FB.logout == 'function'){
	        if (FB.getAuthResponse()) {
	         FB.logout(function(response) { window.location.href = TASTY.baseUrl + 'user/logout?r=' + window.location.href; });
	         return;
	        }  
	    };
	 
	    window.location.href = TASTY.baseUrl + 'user/logout';
	    return;  
	});

	$('#ajax-login-form #register-button').click(function(e) { 

		$('#ajax-login-form').hide();
		$('#ajax-signup-form').show();
		$('#ajax-login-header').html("Create Tasty Profile");
		
	});

	$('#ajax-signup-form #register-button-back').click(function(e) { 
		$('#ajax-login-form').show();
		$('#ajax-signup-form').hide();
		$('#ajax-login-header').html("Login to Tasty");
	});


	$('#ajax-login-form').submit(function(e) { 
		$('#login-ajax-wait').removeClass('hide');
		$('#loginButton').hide();

	   	this.timer = setTimeout(function () {
	   		$.get(TASTY.baseUrl + 'user/ajaxlogin', $("#ajax-login-form").serialize(), function(result) {
            	if (result.success) {
					window.location.reload();
            	} else {
            		 $.each(result.errors, function(index, value) {
            		 	if(!value) {
            		 		var controlGroupDiv= $("#" + index).parents('.form-group')
            		 		if(controlGroupDiv.hasClass('has-error')) {
	            		 		controlGroupDiv.removeClass('has-error');
		            			controlGroupDiv.children('label').html('');
		            			controlGroupDiv.children('label').addClass('hide');
            		 		}
	            			
            		 	} else {
	            		 	var controlGroupDiv= $("#" + index).parents('.form-group')
	            			controlGroupDiv.addClass('has-error');
	            			controlGroupDiv.children('label').html(value);
	            			controlGroupDiv.children('label').removeClass('hide');
            		 	}
      					
       					
   					});

            
            	}
            	$('#login-ajax-wait').addClass('hide');
            	$('#loginButton').show();
                	
            },'json');
            
	   	}, 500);

       	return false;

	});

	$('#ajax-signup-form').submit(function(e) { 
		$('#register-ajax-wait').removeClass('hide');
		$('#registerButton').hide();

	   	this.timer = setTimeout(function () {
	   		$.get(TASTY.baseUrl + 'user/ajaxregister', $("#ajax-signup-form").serialize(), function(result) {
            	if (result.success) {
					window.location = TASTY.baseUrl + 'user'
            	} else {

        			var controlGroupDiv= $("#ajax-signup-form .form-group.has-error");
    		 		controlGroupDiv.removeClass('has-error');
        			controlGroupDiv.children('label').html('');

        			controlGroupDiv.children('label').addClass('hide');
    		 		
            		 $.each(result.errors, function(index, value) {
            		 	if(value) {
	            		 	var controlGroupDiv= $("#" + index).parents('.form-group')
	            			controlGroupDiv.addClass('has-error');
	            			controlGroupDiv.children('label').html(value);
	            			controlGroupDiv.children('label').removeClass('hide');
            		 	}
      					
       					
   					});

            
            	}
            	$('#register-ajax-wait').addClass('hide');
            	$('#registerButton').show();
                	
            },'json');
            
	   	}, 500);

       	return false;

	});


});



function setGeoCookie(cordinates)
{	
	
    var coockie = { "lat" : cordinates.coords.latitude, "lng" : cordinates.coords.longitude};
    $.cookie('detected_location', JSON.stringify(coockie), { expires: 1 });
}
