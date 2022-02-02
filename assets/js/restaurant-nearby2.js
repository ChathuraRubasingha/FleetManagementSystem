google.maps.visualRefresh = true; // This switches to awesome new map styles

//Seting variables on global scope
var markersArray = Array(), map, directionsDisplay, uMarker, markerCluster, boundaryCircle , lastMarker = false , jsonData = Array(), nearbyAjaxCall = null;
var defCordinates = [6.926696,79.857338];
var defLatLng = new google.maps.LatLng(defCordinates[0],defCordinates[1]);
var directionsService = new google.maps.DirectionsService();
var nearbyIndicator = $("#loading_ind");
var nearbyRestListView = $("#rest-list");
var restCount = $("#nearby-controlls .rest strong");
var sel_cuisine = false;
var faced_cuisine = false;
var clusterStyles = [{
        textColor: '#ffffff',
        url : TASTY.baseUrl + 'assets/img/nearby/cluster_36.png',
        textSize: 14,
        width:36,
        height:36
    }, {
        textColor: '#ffffff',
        url : TASTY.baseUrl + 'assets/img/nearby/cluster_40.png',
        textSize: 15,
        width:40,
        height:40
    }, {
        textColor: '#ffffff',
        url : TASTY.baseUrl + 'assets/img/nearby/cluster_50.png',
        textSize: 16,
        width:50,
        height:50
    }];
var uMarkerImage = {
        url: TASTY.baseUrl + 'assets/img/nearby/main_me.png',
        size: new google.maps.Size(51, 56),
        origin: new google.maps.Point(0,0),
        anchor: new google.maps.Point(25, 56)
    };
var restMarkerImage = {
        url: TASTY.baseUrl + 'assets/img/nearby/rest_small_dot.png',
        size: new google.maps.Size(15, 15),
        origin: new google.maps.Point(0,0),
        anchor: new google.maps.Point(7, 15)
    }
var restMarkerImageSelect = {
        url: TASTY.baseUrl + 'assets/img/nearby/rest_small.png',
        size: new google.maps.Size(35, 45),
        origin: new google.maps.Point(0,0),
        anchor: new google.maps.Point(17, 45)
    }
var mapOptions = {
        zoom: 15,
        center: defLatLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        disableDefaultUI : true,
        zoomControl: true
    };
var markerClusterOptions = {
        gridSize:30, 
        minimumClusterSize : 4, 
        styles:clusterStyles
    };

function initialize() {  
    directionsDisplay = new google.maps.DirectionsRenderer();  
    map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
    google.maps.event.addListener(map, "click", function(){
        hideMapinfobox();
    });
    uMarker = new google.maps.Marker({
        position: defLatLng, 
        map: map,
        icon:uMarkerImage, 
        draggable:true,
        raiseOnDrag:true,
        crossOnDrag:false,
        zIndex:2000
    });
    google.maps.event.addListener(uMarker, "dragend", function(){
        var center = uMarker.getPosition();
        var cordinates = { coords : { latitude : center.lat(), longitude : center.lng() }};
        setCordinates(cordinates);
    });
    
    boundaryCircle = new google.maps.Circle({
        map: map,
        center: defLatLng,
        radius: 2000,    // 10 miles in metres
        strokeColor: "#6ebe10",
        strokeOpacity: 1,
        strokeWeight: 2,
        fillColor: "#18ff00",
        fillOpacity: 0.04,
        clickable: false,
    });
    loadMarkers();

    $("#rest-filter").on('click' , 'li' , function(e){
        $("#rest-filter li").removeClass("selected");
        $(this).addClass("selected");
        sel_cuisine = $(this).find('input').val();
        directionsDisplay.setMap(null);
        loadMarkersForcuisine();
    });
}



function renderNewMarkers()
{
    clearOverlays();

    var ListMarkup = "";



    $.each(jsonData, function(i, restaurant) {

        var myLatlng = new google.maps.LatLng(restaurant.geolat,restaurant.geolng);
        var restMarker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            icon:restMarkerImage
        });

        
        // For infobox
        var HtmlMarkup = "<div id='restInfobox'>";
        var rest_link = TASTY.baseUrl + restaurant.city.slug +"/"+restaurant.slug;
        if(restaurant.thumb == "1")
        {
            HtmlMarkup += "<a href='"+rest_link+"'><div class='bgImg' style='background-image: url(\"" + TASTY.baseUrl + "images/restaurant_thumbnails/" + restaurant.id+ "/" + restaurant.id+ "_thumb.png\");'></div></a>";
        } else {
            HtmlMarkup += "<div class='proxybgImg'></div>";
        }
        HtmlMarkup += "<div class='desc'>";
        HtmlMarkup += "<h3><a href='"+rest_link+"'>" + restaurant.title+ "</a></h3>";
        HtmlMarkup += "<p>" + restaurant.address.trunc(35)+ "</p>";
        var cuisines_html = ""
        $.each(restaurant.cuisines, function(j, cuisine) {
            if(j+1 != restaurant.cuisines.length) { append = ', '; } else { append = ''; }
            cuisines_html += ""+cuisine.name+"" + append;

        });


        HtmlMarkup += "<p class='rest_types'>"+cuisines_html+"</p>";
        HtmlMarkup += "</div><div class='footer'>";
        if(restaurant.distance) {
            HtmlMarkup += "<span class='distance'>Approx within "+restaurant.distance.toFixed(3)+"KM</span>";
        }
        
        if(restaurant.total_review_count > 0) { 
        	HtmlMarkup += "<div class='star-holder'>";
                HtmlMarkup += "<div class='frating'>"; 
                var j = 0;
                while(j < 5) {
                	var active = " active";
                	if(j >= Math.round(restaurant.rating_avg)) { active = "";}
                	HtmlMarkup += "<span class='star"+active+"'></span>";
                	j++;
                }
                HtmlMarkup += "</div>";
                HtmlMarkup += "<span>"+restaurant.total_review_count+" reviews</span>";

            HtmlMarkup += "</div>";
        }

        HtmlMarkup += "</div></div>";


        // List Markup
        if(restaurant.thumb == "1")
        {
            ListMarkup += "<li data-markerid='" + i + "'><div class='rest-image' style='background-image: url(\"" + TASTY.baseUrl + "images/restaurant_thumbnails/" + restaurant.id+ "/" + restaurant.id+ "_smallthumb.png\");'></div><div class='hdrs clearfix'>";
        } else {
            ListMarkup += "<li data-markerid='" + i + "'><div class='rest-image'></div><div class='hdrs clearfix'>";
        }
        ListMarkup += "<h3>" + restaurant.title + "</h3>"
        ListMarkup += "<span class='distance'>~" + restaurant.distance.toFixed(2) + "km</span></div>"
        if(restaurant.total_review_count > 0) { 
            ListMarkup += "<div class='star-holder'>";
                ListMarkup += "<div class='frating'>"; 
                var j = 0;
                while(j < 5) {
                    var active = " active";
                    if(j >= Math.round(restaurant.rating_avg)) { active = "";}
                    ListMarkup += "<span class='star"+active+"'></span>";
                    j++;
                }
                ListMarkup += "</div>";
                if(restaurant.total_review_count == 1){
                    ListMarkup += "<span>"+restaurant.total_review_count+" review</span>";
                } else {
                    ListMarkup += "<span>"+restaurant.total_review_count+" reviews</span>";
                }
                

            ListMarkup += "</div>";
        }
        ListMarkup += "<div class='cuisines'>" + cuisines_html + "</div>";
        ListMarkup += "</li>"; //End List Markup

        var myOptions = {
            alignBottom : true,content: HtmlMarkup,disableAutoPan: false,maxWidth: 0,pixelOffset: new google.maps.Size(-150, -10),zIndex: null,boxClass : 'infoMapBox',boxStyle: { opacity: 1 },closeBoxURL: "",infoBoxClearance: new google.maps.Size(70, 70),isHidden: false,pane: "floatPane",enableEventPropagation: true
        };
        var ib = new InfoBox(myOptions);
        restMarker.ib = ib;
        markersArray.push(restMarker);
        google.maps.event.addListener(restMarker, 'click', (function (restMarker, i) {
            return function () {

                if(lastMarker) {
                    lastMarker.setIcon(restMarkerImage)
                }
                lastMarker = restMarker;

                restMarker.setIcon(restMarkerImageSelect)
                hideMapinfobox();
                ib.open(map, restMarker);

            }
        })(restMarker, i));
    });

    if(jsonData.length == 0) {        
        nearbyRestListView.html( "<h2 class='rest-list-tittle'>No restaurants nearby</h2>" );
    } else if (jsonData.length == 1) {
        nearbyRestListView.html( "<h2 class='rest-list-tittle'>1 Restaurant within 2km </h2><ul>" + ListMarkup + "</ul>" );
    } else {
        nearbyRestListView.html( "<h2 class='rest-list-tittle'>"+ jsonData.length +" Restaurants within 2km </h2><ul>" + ListMarkup + "</ul>" );
    }


    nearbyRestListView.on('click','li',function(e){
        nearbyRestListView.find('li').removeClass('selected');
        $(this).addClass('selected')
        var restMarker = markersArray[$(this).data('markerid')];
        hideMapinfobox();
        restMarker.ib.open(map, restMarker);

        if(lastMarker) {
            lastMarker.setIcon(restMarkerImage)
        }
        lastMarker = restMarker;
        restMarker.setIcon(restMarkerImageSelect)
        
        var start = defLatLng;
        var end = restMarker.getPosition();
        var request = {
            origin:start,
            destination:end,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setMap(map);
                directionsDisplay.setDirections(response);
            }
        });

    });
    //markerCluster = new MarkerClusterer(map, markersArray, markerClusterOptions);
}

function clearOverlays() {
    if(markerCluster){
        markerCluster.clearMarkers();
        markerCluster = null;        
    }
    if(markersArray.length) {
        for (var i = 0; i < markersArray.length; i++ ) {
            markersArray[i].setMap(null);
        }
        markersArray = [];
    }
    hideMapinfobox();
}


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
        loadMarkers();    
    }
}


function setCordinates(cordinates)
{
    defCordinates = [cordinates.coords.latitude,cordinates.coords.longitude];
    defLatLng = new google.maps.LatLng(defCordinates[0],defCordinates[1]);
    //if(!$.cookie('detected_location')) {
    //	setGeoCookie(cordinates);	
    //}
    
    directionsDisplay.setMap(null);
    loadMarkers();
}


function loadMarkers(){
    nearbyIndicator.show();
    var dta = { lat : defCordinates[0], lng : defCordinates[1]}
    if(nearbyAjaxCall)
    {
        nearbyAjaxCall.abort();
    }
    nearbyAjaxCall = $.ajax({
        url: TASTY.baseUrl + 'nearby/data',
        dataType : 'json',
        data: dta,
        type: "GET",
        success:function(data) {            
            jsonData = data.restaurants;
            faced_cuisine = data.available_cuisines;
            centerMapToYou();
            renderNewMarkers();
            populate_cuisine_list();
            nearbyIndicator.hide();
        }, error : function() {
            nearbyIndicator.hide();
        }
    });
}

function loadMarkersForcuisine(){
    nearbyIndicator.show();
    var dta = { lat : defCordinates[0], lng : defCordinates[1]}
    if(nearbyAjaxCall)
    {
        nearbyAjaxCall.abort();
    }
    if (sel_cuisine) {
        dta.cuisine = sel_cuisine
    }
    nearbyAjaxCall = $.ajax({
        url: TASTY.baseUrl + 'nearby/data',
        dataType : 'json',
        data: dta,
        type: "GET",
        success:function(data) {            
            jsonData = data.restaurants;
            faced_cuisine = data.available_cuisines;
            centerMapToYou();
            renderNewMarkers();
            nearbyIndicator.hide();
        }, error : function() {
            nearbyIndicator.hide();
        }
    });
}

function populate_cuisine_list(){
    var list_html = '<li class="selected"> <input type="checkbox" value="0" id="" name=""> All </li>';
    $(faced_cuisine).each(function(i , cuisine){
        list_html += '<li> <input type="checkbox" value="' + cuisine.id + '" id="cuisine' + cuisine.id + '" name="cuisines"> ' + cuisine.title + ' (' + cuisine.count + ') </li>';
    })
    $("#rest-filter ul").html(list_html);
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

function centerMapToYou(){
    map.panTo(defLatLng);
    map.setZoom(15);
    uMarker.setPosition(defLatLng);
    boundaryCircle.setCenter(defLatLng);
}

function hideMapinfobox(){
    $('.infoMapBox').hide();
}

function checkLocationCookie() {
	if($.cookie('detected_location')) {
    	var cordinates = JSON.parse($.cookie("detected_location"));
    	defCordinates = [cordinates.lat, cordinates.lng];
    	defLatLng = new google.maps.LatLng(defCordinates[0],defCordinates[1]);
    	loadMarkers();	
    } else {
		detectLocation();	
    }
}
$(function(){
    initialize();
    $("#footer").hide();
    $("#bestWeb").hide();

    $("#nearby-controlls .you").click(function(){
        centerMapToYou();
    });
    $("#nearby-controlls .detect").click(function(){
	    //checkLocationCookie();
        detectLocation();

    });

    
	//checkLocationCookie();
    detectLocation();
    
});