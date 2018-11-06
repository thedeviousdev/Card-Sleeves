function update_cart_contents() {
 	$.ajax({
	  method: "POST",
	  url: "cart_total.php",
	  data: { 'total' : true }
	})
  .done(function( msg ) {
  	$(".current_games").html(msg);
  });
}

function update_total() {
 	$.ajax({
	  method: "POST",
	  url: "game_total.php",
	  data: { 'total' : true }
	})
  .done(function( msg ) {
  	$(".total_cards").html(msg);
  });
}

function decodeHtml(html) {
    var txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
}

$(document).ready(function() {

	var options = {
		url: "data/games.json",
		adjustWidth: false,
		list: {
			match: {
				enabled: true
			},

			onClickEvent: function() {
				search();
			}	
		},
		getValue: function(element) {
			return decodeHtml(element);
		}
	};

	$(".game-select").easyAutocomplete(options);

	function search() {
    var game = $('.form_search .game-select').val();

    var data = {
    	game : game
    }

	 	$.ajax({
		  method: "POST",
		  url: "game_search.php",
		  data: data
		})
	  .done(function( msg ) {
	  	$(".search").html(msg);
	  });		
	}

	$( ".form_search" ).submit(function( event ) {
	  event.preventDefault();
	  search();
	});

	$( ".form_search_edit" ).submit(function( event ) {
	  event.preventDefault();
    var data = $(this).serialize();

	 	$.ajax({
		  method: "POST",
		  url: "game_search_edit.php",
		  data: data
		})
	  .done(function( msg ) {
	  	$(".search").html(msg);
	  });
	});

});

$(document).on('click', '#clear', function() {

 	$.ajax({
	  method: "POST",
	  url: "cart_empty.php"
	})
  .done(function( msg ) {
  	update_cart_contents();
  	update_total();
  });
});
$(document).on('click', '.import', function(e) {
	e.preventDefault();
	$('.popup').css('display', 'flex');
});

$(document).on('click', 'footer span', function() {
	var page = $(this).data('page');
	var game_name = $('.search_result').data('game_name');

  var data = {
  	game : game_name,
  	page : page
  }
  
 	$.ajax({
	  method: "POST",
	  url: "game_search.php",
	  data: data
	})
  .done(function( msg ) {
  	$(".search").html(msg);
	  $(".search").animate({ scrollTop: 0 }, "slow");
  });
});

$(document).on('click', '.reveal', function() {
	$('aside').toggleClass('open');
});

$(document).on('submit', '.bgg_search_form', function( event ) {
  event.preventDefault();
  var data = $(this).serialize();

 	$.ajax({
	  method: "POST",
	  url: "bgg_search.php",
	  data: data
	})
  .done(function( msg ) {
		$(".detail").append(msg);
  });
});

$(document).on('submit', '.cart_item_form', function( event ) {
  event.preventDefault();
  var data = $(this).serialize();
	var game_id = $(this).find('input[name="game_id"]').val();

 	$.ajax({
	  method: "POST",
	  url: "game_update.php",
	  data: data
	})
  .done(function( msg ) {

		$.ajax({
		method: "POST",
		url: "game_detail_edit.php",
		data: { 'game' : game_id}
		})
		.done(function( msg ) {
			$(".detail").html(msg);
			$(".detail").find('.popup').css('display','flex');
		});
  });
});

$(document).on('click', '#verify', function() {

  var id = $(this).data('id');
  var value = $(this).data('value');

  var data = {
  	id : id,
  	verify : value
  }

 	$.ajax({
	  method: "POST",
	  url: "game_verify.php",
	  data: data
	})
  .done(function( msg ) {
		$(".detail").html(msg);
		$(".detail").find('.popup').css('display','flex');
  });
});

$(document).on('click', '#delete', function() {

  var id = $(this).data('id');

  var data = {
  	id : id
  }

 	$.ajax({
	  method: "POST",
	  url: "game_delete.php",
	  data: data
	})
  .done(function( msg ) {
		$(".detail").html(msg);
		$(".detail").find('.popup').css('display','flex');
  });
});

$(document).on('click', '.add', function() {
	var game = '<div class="row"><div class="table-cell"><input type="number" name="quantity[]" value="0" step="1"></div><div class="table-cell"><input type="number" name="width[]" value="0" step=".05"></div><div class="table-cell"><input type="number" name="height[]" value="0" step=".05"></div><div class="table-cell"><span class="add">+</span></div></div>';
	$(".table").append(game);
	$(this).removeClass('add').addClass('remove');
	$(this).html('-');
	$(this).attr('data-card_id','NULL');
});

$(document).on('click', '.detail .popup', function() {
	$(this).fadeOut();
});

$(document).on('click', '.remove', function() {
	var card_id = $(this).data('card_id');

	if(card_id == 'NULL') {
		$(this).closest('.row').remove();
	}
	else {
		$.ajax({
			method: "POST",
			url: "card_delete.php",
			data: { 'card_id' : card_id}
		})
		.done(function( msg ) {
			$("[data-card_id='" + card_id + "']").closest('.row').remove();
		});
	}

});


$(document).on('click', '.btn_add', function() {

	var game_id = $(this).data( "game_id" );

	if($(this).hasClass('rotate')) { 
	 	$.ajax({
		  method: "POST",
		  url: "game_session.php",
		  data: { 'remove_game' : game_id}
		})
	  .done(function( msg ) {
	  	$(".current_games ." + game_id).remove();
	  	update_total();
	  });

	}
	else {
	 	$.ajax({
		  method: "POST",
		  url: "game_session.php",
		  data: { 'add_game' : game_id}
		})
	  .done(function( msg ) {
	  	if(msg == 'Game added') {
			 	$.ajax({
				  method: "POST",
				  url: "cart_item.php",
				  data: { 'game' : game_id}
				})
			  .done(function( msg ) {
			  	$(".current_games").append(msg);
			  	update_total();
			  });
			}
	  });
	}
	$(this).toggleClass('rotate');
});

$(document).on('click', '.add_game span', function() {

 	$.ajax({
	  method: "POST",
	  url: "bgg_search_form.php"
	})
  .done(function( msg ) {
		$(".detail").html(msg);
  });
});

$(document).on('click', '.view', function() {
		var game_id = $(this).data( "game_id" );

		$.ajax({
		method: "POST",
		url: "game_detail_edit.php",
		data: { 'game' : game_id}
		})
		.done(function( msg ) {
			$(".detail").html(msg);
		});
});

$(document).on('click', '.btn_remove', function() {

		var game_id = $(this).data( "game_id" );

	 	$.ajax({
		  method: "POST",
		  url: "game_session.php",
		  data: { 'remove_game' : game_id}
		})
	  .done(function( msg ) {
	  	$(".current_games ." + game_id).remove();
	  	$(".search_result").find("[data-game_id='" + game_id + "']").removeClass('rotate');
	  	update_total();
  });
});

$(document).on('submit', '.bgg_user_import', function( event ) {
  event.preventDefault();
  var data = $(this).serialize();

 	$.ajax({
	  method: "POST",
	  url: "bgg_user_owned_search.php",
	  data: data
	})
  .done(function( msg ) {
  	if(msg != 'Invalid') {
	  	update_cart_contents();
	  	update_total();
	  	$('.user_import').fadeOut();
	  	$('.error').hide();
	  }
	  else 
	  	$('.error').show();

  });
});

$(document).on('click', '.close', function( event ) {
	$('.user_import').fadeOut();
});