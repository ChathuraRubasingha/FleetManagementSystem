var currentURL = null;

$(function(){

	// if($.cookie('restlisttype') == 'grid-view') {
	// 	_switchGrid();
	// } else {

	// }



	$('#soryByDistance').click(function(e) {
		
		//if(!$.cookie('detected_location')) {
			e.preventDefault();
			currentURL = TASTY.baseUrl + 'restaurants?sort=n';
	    	detectLocation();	
	    //}	
	});

	$('#select-location').change(function() {

		if($(this).val()) {
			var url = TASTY.baseUrl + $(this).val() + '/restaurants';
		} else {
			var url = TASTY.baseUrl + 'restaurants';
		}

		if(getUrlVars()['q']) {
			url += "?q="+getUrlVars()['q'];
		}
  		window.location = url;
  		
	});

	$('#select-price-range').change(function() {
		window.location = $(this).val();
  		
	});


	$('#select-area').change(function() {

		var city = $('#select-location').val();

		if($(this).val()) {
			var url = TASTY.baseUrl + city + '/restaurants/area/' + $(this).val();
		} else {
			var url = TASTY.baseUrl + city + '/restaurants';
		}

		if(getUrlVars()['q']) {
			url += "?q="+getUrlVars()['q'];
		}
  		window.location = url;
	});

	$('#select-cuisine').change(function() {
		var city = $('#select-location').val();
		var area = $('#select-area').val();

		var url = TASTY.baseUrl;

		if(city) {
			url += city + '/restaurants/';	
		} else {
			url += 'restaurants/index.html';	
		}

		if(area) {
			url += 'area/'+area+'/';	
		}


		var pathArray = window.location.pathname.split( 'index.html' );
		var cuisines = pathArray[3];
		
		var cur_cuisine = $(this).val();
		var new_cuisines = Array();
		//BootstrapDialog.alert(cuisines);
		if(cuisines) {
			cuisines = cuisines.split('_');
			for(var i=0; i< cuisines.length; i++)
			{
				if(cuisines[i] != cur_cuisine) {
					new_cuisines.push(cur_cuisine);
				}
			}
			
			
		} else {
			new_cuisines.push($(this).val());
		}

		if($(this).val()) {
			url += 'cuisine/' + new_cuisines.join();	
		}

		if(getUrlVars()['q']) {
			url += "?q="+getUrlVars()['q'];
		}

		window.location = url;
		//window.location = url + window.location.search;
  		
  		
	});

});

function detectLocation(options) {
    //options = { success : function  , fail : function , error : function }

    if (navigator.geolocation) {
        var timeoutVal = 10 * 1000 * 1000;
        navigator.geolocation.getCurrentPosition(
            setCordinates, 
            displayError,
            { enableHighAccuracy: true, timeout: timeoutVal, maximumAge: 0 }
        );
    }
    else {
        displayError('Your Browser doesnt support GeoLocation API');
    }
}

function displayError(error) {
    var errors = { 
        1: 'Permission denied',
        2: 'Position unavailable',
        3: 'Request timeout'
    };
    BootstrapDialog.alert("Error: " + errors[error.code]);
    loadMarkers();
}

function setCordinates(cordinates)
{	


    //if(!$.cookie('detected_location')) {
    	//setGeoCookie(cordinates);	
    	window.location = currentURL+'&lat='+cordinates.coords.latitude+'&lng='+cordinates.coords.longitude;
    //}
}
if(getUrlVars()['sort'] == 'n') {

	geocoder = new google.maps.Geocoder();
	latlng = new google.maps.LatLng(lat, lng);
	$('#subheading').text('Checking...');
	  geocoder.geocode({'latLng': latlng}, function(results, status) {
	    if (status == google.maps.GeocoderStatus.OK) {
	      if (results[1]) {
	        address = results[1].formatted_address;

	      } else {
	        //address = 'Unknown Address';
	      }
	    } else {
	      //BootstrapDialog.alert('Geocoder failed due to: ' + status);
	      //address = 'Unknown Address';
	    }
	    $('#subheading').text(address);
	    
	  });	
	
}


function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}