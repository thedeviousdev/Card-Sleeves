$(document).ready(function() {
 	$(".game-select").chosen({no_results_text: "Oops, nothing found!"});

	$( "form" ).submit(function( event ) {
	  event.preventDefault();
    var data = $(this).serialize();
    // alert(data);

	 	$.ajax({
		  method: "GET",
		  url: "game_detail.php",
		  data: data
		})
	  .done(function( msg ) {
	  	$(".search_result").html(msg);
	    // alert( "Data Saved: " + msg );
	  });
	});

});