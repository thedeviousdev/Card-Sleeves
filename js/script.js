function update_total() {
 	$.ajax({
	  method: "GET",
	  url: "game_total.php",
	  data: { 'total' : true}
	})
  .done(function( msg ) {
  	$(".total_cards").html(msg);
  });

}

$(document).ready(function() {

	var options = {
		url: "data/games.json",
		adjustWidth: false,
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
		  url: "game_search.php",
		  data: data
		})
	  .done(function( msg ) {
	  	$(".search").html(msg);
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
	  	console.log(msg);
	  	if(msg == 'Game added') {
			 	$.ajax({
				  method: "GET",
				  url: "game_detail.php",
				  data: { 'game' : game_id}
				})
			  .done(function( msg ) {
			  	console.log(msg);
			  	$(".current_games").append(msg);
			  	update_total();
		  });
		}
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
	  	$(".current_games ." + game_id).remove();
	  	update_total();
  });
});