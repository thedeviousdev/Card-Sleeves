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

function search(game_id = null) {
  var game = $('.form_search .game-select').val();

  if(game_id !== null)
  	game = game_id;

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
	$('.popup-cart').css('display', 'flex');
});
$(document).on('click', '.open_game', function(e) {
  e.preventDefault();
	var game_id = $(this).text();
	search(game_id);
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
			$(".detail").find('.popup-cart').css('display','flex');
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
		$(".detail").find('.popup-cart').css('display','flex');
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
		$(".detail").find('.popup-cart').css('display','flex');
  });
});

$(document).on('click', '.add', function() {

  var data = {
  	sleeve_list : true
  }

 	$.ajax({
	  method: "POST",
	  url: "sleeve_empty.php",
	  data: data,
    success: function(data) {
	  	// new_sleeve_row(data);
			$(".table").append(data);
    },
	});

	// var game = '<div class="row"><div class="table-cell"><input type="number" name="quantity[]" value="0" step="1"></div><div class="table-cell"><input type="number" name="width[]" value="0" step=".05"></div><div class="table-cell"><input type="number" name="height[]" value="0" step=".05"></div><div class="table-cell"><span class="add">+</span></div></div>';
	// console.log(new_sleeve_row);

	$(this).removeClass('add').addClass('remove');
	$(this).html('-');
	$(this).attr('data-sleeve_id','NULL');
});

$(document).on('click', '.detail .popup-cart', function() {
	$(this).fadeOut();
});

$(document).on('click', '.remove', function() {
	var sleeve_id = $(this).data('sleeve_id');
	var card_nb = $(this).data('card_nb');
	var game_id = $(this).data('game_id');

	if(sleeve_id == 'NULL') {
		$(this).closest('.row').remove();
	}
	else {
		$.ajax({
			method: "POST",
			url: "card_delete.php",
			data: { 
				'sleeve_id' : sleeve_id,
				'card_nb' : card_nb,
				'game_id' : game_id 
			}
		})
		.done(function( msg ) {
			$("[data-sleeve_id='" + sleeve_id + "']").closest('.row').remove();
		});
	}

});


// $(document).on('click', '.btn_add', function() {

// 	var game_id = $(this).data( "game_id" );

// 	if($(this).hasClass('rotate')) { 
// 	 	$.ajax({
// 		  method: "POST",
// 		  url: "game_session.php",
// 		  data: { 'remove_game' : game_id}
// 		})
// 	  .done(function( msg ) {
// 	  	$(".current_games ." + game_id).remove();
// 	  	update_total();
// 	  });

// 	}
// 	else {
// 	 	$.ajax({
// 		  method: "POST",
// 		  url: "game_session.php",
// 		  data: { 'add_game' : game_id}
// 		})
// 	  .done(function( msg ) {
// 	  	if(msg == 'Game added') {
// 			 	$.ajax({
// 				  method: "POST",
// 				  url: "cart_item.php",
// 				  data: { 'game' : game_id}
// 				})
// 			  .done(function( msg ) {
// 			  	$(".current_games").append(msg);
// 			  	update_total();
// 			  });
// 			}
// 	  });
// 	}
// 	$(this).toggleClass('rotate');
// });

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


$(document).on('click', '#add_sleeve_groups_btn', function( event ) {
  event.preventDefault();
  
  var group_id = document.getElementById('sleeve_group').value;
  var qty = document.getElementById('sleeve_qty').value;
  var nb = document.getElementById('sleeve_nb').value;

 	$.ajax({
	  method: "POST",
	  url: "sleeve_groups.php",
	  data: {
	  	sleevegroup: group_id,
	  	sleeveqty: qty,
	  	sleevenb: nb,
	  },
    success: function(data) {
	  	// new_sleeve_row(data);
			$(".table").append(data);
    },
	})
  .done(function( msg ) {});
});


$(document).on('submit', '.card-expander-game-cards-form', function( event ) {
  event.preventDefault();
  var data = $(this).serialize();

 	$.ajax({
	  method: "POST",
	  url: "game_session.php",
	  data: data
	})
  .done(function( msg ) {
  	// if(msg == 'Game added') {
		 	$.ajax({
			  method: "POST",
			  url: "cart_item.php",
			  data: data
			})
		  .done(function( msg ) {
		  	// $(".current_games").append(msg);
		  	update_cart_contents();
		  	update_total();
		  });
		// }
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


$(document).on('click', '.card.is-collapsed', function() {

	$(this).removeClass('is-inactive');


  if ($(this).closest('.card').hasClass('is-collapsed')) {
    $('.card').not($(this).closest('.card')).removeClass('is-expanded').addClass('is-collapsed').addClass('is-inactive');

    $(this).closest('.card').removeClass('is-collapsed').addClass('is-expanded');
    
    if ($('.card').not($(this).closest('.card')).hasClass('is-inactive')) {
      //do nothing
    } else {
      $('.card').not($(this).closest('.card')).addClass('is-inactive');
    }

  } else {
    $(this).closest('.card').removeClass('is-expanded').addClass('is-collapsed');
    $('.card').not($(this).closest('.card')).removeClass('is-inactive');
  }
});

//close card when click on cross
$(document).on('click', '.card-expander-close', function() {

  $('.card').removeClass('is-expanded').addClass('is-collapsed');
  $('.card').removeClass('is-inactive');
  // $('.card').not($(this).closest('.card')).removeClass('is-inactive');

});