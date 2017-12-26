$(document).ready(function() {
 	$(".game-select").chosen({no_results_text: "Oops, nothing found!"});

	$( ".form_search" ).submit(function( event ) {
	  event.preventDefault();
    var data = $(this).serialize();

	 	$.ajax({
		  method: "GET",
		  url: "add_game.php",
		  data: data
		})
	  .done(function( msg ) {
	  	$(".search_result").html(msg);
	  });
	});

});

$(document).on('click', '.btn_add', function() {

		var game_id = $(this).data( "game_id" );

	 	$.ajax({
		  method: "GET",
		  url: "game_session.php",
		  data: { 'add_game' : game_id}
		})
	  .done(function( msg ) {
	  	var search = $(".search_result").html();
	  	$(".search_result").html("");

	  	$(".current_games").append(search);
  });
});

$(document).on('click', '.btn_remove', function() {

		var game_id = $(this).data( "game_id" );

	 	$.ajax({
		  method: "GET",
		  url: "game_session.php",
		  data: { 'remove_game' : game_id}
		})
	  .done(function( msg ) {
	  	$("." + game_id).remove();
  });
});