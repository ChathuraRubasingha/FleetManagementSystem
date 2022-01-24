$(function() {
	var didSelect = false;

	$.ui.autocomplete.prototype._renderItem = function (ul, item) {


		var srchTerm = this.term.trim().split(/\s+/).join ('|');
		var strNewLabel = item.label;



	   	regexp = new RegExp ('(' + srchTerm + ')', "ig");
	    var strNewLabel = strNewLabel.replace(regexp,"<strong class='ui-autocomplete-term'>$1</strong>");


		if(item.r_type == 1){
			
			if(item.premise_name) {	
				var strNewLabel_append = item.premise_name.replace(regexp,"<strong class='ui-autocomplete-term'>$1</strong>");		
				strNewLabel += "<span class='text-muted'> - " + strNewLabel_append + "</span>";
				item.value += " - " + item.premise_name;

			}

			if(item.area) {	
	    		var strNewLabel_append = item.area.replace(regexp,"<strong class='ui-autocomplete-term'>$1</strong>");
	    		strNewLabel += "<span class='text-muted'>, " + strNewLabel_append + "</span>";
				item.value += " - " + item.area;	

			}


		} else {

			if(item.desc) {	
	    		var strNewLabel_append = item.desc.replace(regexp,"<strong class='ui-autocomplete-term'>$1</strong>");
	    		strNewLabel += "<span class='text-muted'>, " + strNewLabel_append + "</span>";
				item.value += ", " + item.desc;	
			}

		}



		if(item.r_type == 1){
			strNewLabel = "<i class='icon-food search-icon'></i> <span>"+strNewLabel+"</span>";	
		}
		else if(item.r_type == 2){
			strNewLabel = "<i class='icon-map-marker search-icon'></i> "+strNewLabel;	
		}
		else if(item.r_type == 3){
			strNewLabel = "<i class='icon-tag search-icon'></i> "+strNewLabel;	
		}

		else if(item.r_type == 4){
			strNewLabel = "<i class='icon-arrow-right search-icon'></i> "+strNewLabel;	
		}

	  return $( "<li></li>" )
	  .data( "item.autocomplete", item )
	  .append( "<a>" + strNewLabel + "</a>" )
	  .appendTo( ul );
	};
	
	
	$(".autocomplete").autocomplete({
	source: TASTY.baseUrl + "autocomplete", 
	select: function( event, ui ) {
		if (ui.item) {
	    	didSelect = true;
			if(ui.item.url != null) { window.location.href = ui.item.url; } 
		}
	}, 
	position: {
        offset: '15 -1'
    },
	minLength: 3
	});

	
	

	function doSearch(search_bar) {
		keyword = search_bar.val().toLowerCase();
		if(keyword.length > 0) {
			search_url = TASTY.baseUrl + 'autocomplete/exactmatch/' + encodeURIComponent(keyword).replace(/%20/g, "+");
			
			window.location.href = search_url;	
		} else {
			search_url = TASTY.baseUrl + 'restaurants';
			window.location.href = search_url;	
		}
		

	}

	$('.autocomplete').keydown(function(e){
		
		if(e.keyCode == 13){
			if ( ! didSelect ) {

				e.preventDefault();
				doSearch($(this));

				//return false;
			}
		}

		
	});

	$('#searchButton').click(function() {
		doSearch($('#home_search'));
	});
	
	if($.getUrlVar('q')) {
		$.each(search_words.split(" "), function(idx, val) { jQuery("h4, .location, .types").highlight(val);});	
	}
	
});