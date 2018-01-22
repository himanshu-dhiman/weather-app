<head>
	<link rel="stylesheet" href="src/css/bootstrap.min.css">
	<script src="src/js/bootstrap.min.js"></script>
	<script src="src/js/jquery-3.3.1.min.js"></script>
</head>

<input class="form-control" type="text" id="query" /><button>search</button><br />
<div id="results">

</div>

<script type="text/javascript">
$(document).ready(function() {
    var url = 'http://autocomplete.wunderground.com/aq?query=';
    var query;
    $('#query').typeahead(function() {
        query = $("#query").val();
        $.getJSON(url + query + '&cb=?', function(json) {
        	console.log(json.RESULTS);
            $.each(json.RESULTS, function(i, location) {
                $("#results").append('<p>' + location.name + '</p>');
            });
        });
    });
});
</script>