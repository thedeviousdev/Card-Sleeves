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

	$( ".form_search_edit" ).submit(function( event ) {
	  event.preventDefault();
    var data = $(this).serialize();

	 	$.ajax({
		  method: "GET",
		  url: "game_search_edit.php",
		  data: data
		})
	  .done(function( msg ) {
	  	$(".search").html(msg);
	  });
	});

	// $( ".cart_item_form" ).submit(function( event ) {
	//   event.preventDefault();
 //    var data = $(this).serialize();

	//  	$.ajax({
	// 	  method: "GET",
	// 	  url: "game_update.php",
	// 	  data: data
	// 	})
	//   .done(function( msg ) {
	//   	$(".detail").html(msg);
	//   });
	// });

});


$(document).on('submit', '.bgg_search_form', function( event ) {
  event.preventDefault();
  var data = $(this).serialize();

 	$.ajax({
	  method: "GET",
	  url: "bgg_search.php",
	  data: data
	})
  .done(function( msg ) {
  	console.log(msg);
		$(".detail").append(msg);
  });
});

$(document).on('submit', '.cart_item_form', function( event ) {
  event.preventDefault();
  var data = $(this).serialize();
	var game_id = $(this).find('input[name="game_id"]').val();

 	$.ajax({
	  method: "GET",
	  url: "game_update.php",
	  data: data
	})
  .done(function( msg ) {

		$.ajax({
		method: "GET",
		url: "game_detail_edit.php",
		data: { 'game' : game_id}
		})
		.done(function( msg ) {
			console.log(msg);
			$(".detail").html(msg);
			$(".detail").find('.popup').css('display','flex');
		});
  });
});

$(document).on('click', '.add', function() {
	var game = '<div class="row"><div class="table-cell"><input type="number" name="quantity[]" value="0" step=".25"></div><div class="table-cell"><input type="number" name="width[]" value="0" step=".25"></div><div class="table-cell"><input type="number" name="height[]" value="0" step=".25"></div><div class="table-cell"><span class="add">+</span></div></div>';
	$(".table").append(game);
	$(this).removeClass('add').addClass('remove');
	$(this).html('-');
	$(this).attr('data-card_id','NULL');
});

$(document).on('click', '.popup', function() {
	$(this).fadeOut();
});

$(document).on('click', '.remove', function() {
	var card_id = $(this).data('card_id');
	console.log(card_id);

	if(card_id == 'NULL') {
		console.log('if');
		$(this).closest('.row').remove();
	}
	else {
		console.log('else');
		$.ajax({
			method: "GET",
			url: "card_delete.php",
			data: { 'card_id' : card_id}
		})
		.done(function( msg ) {
	  	console.log(msg);
	  	// This isn't removing the element
	  	// $("ul").find("[data-slide='" + current + "']"); 
			$("[data-card_id='" + card_id + "']").closest('.row').remove();
		});
	}

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
				  url: "cart_item.php",
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

$(document).on('click', '.add_game span', function() {

 	$.ajax({
	  method: "GET",
	  url: "bgg_search_form.php"
	})
  .done(function( msg ) {
  	console.log('click');
		$(".detail").html(msg);
  });
});

$(document).on('click', '.view', function() {
		var game_id = $(this).data( "game_id" );

		$.ajax({
		method: "GET",
		url: "game_detail_edit.php",
		data: { 'game' : game_id}
		})
		.done(function( msg ) {
			// console.log(msg);
			$(".detail").html(msg);
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