var url = 'http://autocomplete.wunderground.com/aq?query=';

jQuery(document).ready(function() {
	jQuery('.search-container').on('click', '.search-button', function() {
		query_location();
	});
	
	jQuery('.result-list').on('click', '.list-item', function() {
		var this_obj=jQuery(this);
		add_location(this_obj);
	});

	jQuery('.del-button-row').on('click', '.del-button', function() {
		var this_obj=jQuery(this);
		del_location(this_obj);
	})
});


function query_location() {
	jQuery('#results_section').show();
	jQuery('#results').empty();
	var query = jQuery("#query").val();
	jQuery.getJSON(url + query + '&cb=?', function(json) {
		if (jQuery.isEmptyObject(json.RESULTS)) {
			jQuery("#results").html('<p class="list-item">No Data Found for your Request</p>');
		} else {
			jQuery.each(json.RESULTS, function(i, location) {
				jQuery("#results").append('<p><a class="list-item" href="#" data-name="' + location.name + '" data-link="' + location.l + '" data-country="' + location.c + '">' + location.name + '</a></p>');
			});
		}
	});
}

function add_location(this_obj) {
	var datastring = {
		action: 'add_location',
		country: this_obj.data("country"),
		link: this_obj.data("link"),
		name: this_obj.data("name")
	}
	jQuery.ajax({
		type: 'POST', 
		url: 'ajax.php',
		data: datastring,
		success: function(result){
			var json = jQuery.parseJSON(result);
			if( json.status == "success") {
				window.location.href = 'weather.php';
			} else {
				alert('Some error occured');
			}
		}
	});
}

function del_location(this_obj) {
	var tab_id = this_obj.data("tab_id");
	var datastring = {
		action: 'del_location',
		id: this_obj.data("id")
	}
	jQuery.ajax({
		type: 'POST', 
		url: 'ajax.php',
		data: datastring,
		success: function(result){
			var json = jQuery.parseJSON(result);
			if( json.status == "success") {
				jQuery('#nav_link-' + tab_id + ', #location-' + tab_id).hide();
				tab_id = tab_id-1;
				if ( (tab_id) == '-1') {
					window.location.href = 'index.php';
				} else {
					jQuery('#nav_link-' + tab_id + ', #location-' + tab_id).addClass('active show');
				}
			} else {
				alert('Some error occured');
			}
		}
	});
}