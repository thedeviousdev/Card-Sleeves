$(document).ready(function() {

	var options = {
		url: "data/games.json",
		list: {
			match: {
				enabled: true
			}
		}
		// data: json_data
	};

	$(".game-select").easyAutocomplete(options);

	$( ".form_search" ).submit(function( event ) {
	  event.preventDefault();
    var data = $(this).serialize();

	 	$.ajax({
		  method: "GET",
		  url: "search_game.php",
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

		 	$.ajax({
			  method: "GET",
			  url: "game_detail_list.php",
			  data: { 'game' : game_id}
			})
		  .done(function( msg ) {
		  	$(".current_games").append(msg);
	  });
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