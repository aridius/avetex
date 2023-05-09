function getURLVar(key) {
	var value = [];
	var query = document.location.search.split('?');
	if (query[1]) {
		var part = query[1].split('&');
		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');
			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}
		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
}
$(document).ready(function() {
	// Highlight any found errors
	$('.text-danger').each(function() {
		var element = $(this).parent().parent();
		if (element.hasClass('form-group')) {
			element.addClass('has-error');
		}
	});
		// Currency
	$('#form-currency .currency-select').on('click', function(e) {
		e.preventDefault();
		$('#form-currency input[name=\'code\']').val($(this).attr('name'));
		$('#form-currency').submit();
	});
	// Language
	$('#form-language .language-select').on('click', function(e) {
		e.preventDefault();
		$('#form-language input[name=\'code\']').val($(this).attr('name'));
		$('#form-language').submit();
	});
	/* Search */
	$('#search input[name=\'search\']').parent().find('button').on('click', function() {
		var url = $('base').attr('href') + 'index.php?route=product/search';

		var value = $('header #search input[name=\'search\']').val();

		if (value) {
			url += '&search=' + encodeURIComponent(value);
		}

		location = url;
	});

	$('#search input[name=\'search\']').on('keydown', function(e) {
		if (e.keyCode == 13) {
			$('header #search input[name=\'search\']').parent().find('button').trigger('click');
		}
	});
	// Menu
	// Product List
	$('#list-view').click(function() {
		$('#content .product-grid > .clearfix').remove();
		$('#content .row > .product-grid').attr('class', 'product-layout product-layout_cat product-list col-xs-12');
		$('#grid-view').removeClass('active');
		$('#list-view').addClass('active');
		$('.flex_height_row').addClass('border_list');
		localStorage.setItem('display', 'list');
	});
	// Product Grid
	$('#grid-view').click(function() {
		// What a shame bootstrap does not take into account dynamically loaded columns
		var cols = $('#column-right, #column-left').length;
		if (cols == 2) {
			$('#content .product-list').attr('class', 'cat_heightflex product-layout product-layout_cat product-grid col-lg-6 col-md-6 col-sm-12 col-xs-6');
		} else if (cols == 1) {
			$('#content .product-list').attr('class', 'cat_heightflex product-layout product-layout_cat product-grid col-xl-4 col-lg-4 col-md-6 col-sm-4 col-xs-6');
		} else {
			$('#content .product-list').attr('class', 'cat_heightflex product-layout product-layout_cat product-grid col-lg-five col-md-3 col-sm-4 col-xs-6');
		}
		$('#list-view').removeClass('active');
		$('#grid-view').addClass('active');
		$('.flex_height_row').removeClass('border_list');
		localStorage.setItem('display', 'grid');
	});
	// Checkout
	$(document).on('keydown', '#collapse-checkout-option input[name=\'email\'], #collapse-checkout-option input[name=\'password\']', function(e) {
		if (e.keyCode == 13) {
			$('#collapse-checkout-option #button-login').trigger('click');
		}
	});
	// tooltips on hover
	$('[data-toggle=\'tooltip\']').tooltip({container: 'body',trigger: 'hover'});
	// Makes tooltips work on ajax generated content
	$(document).ajaxStop(function() {
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
	});
});
// Cart add remove functions
var cart = {
	'add': function(product_id, quantity) {
			var cart_header = $('header #cart');
	var cart_scroll = $('#menu_scroll #cart');
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			complete: function() {
				$('#cart > button').button('reset');
				   $('#menu_scroll').removeClass('sticky');
			},			
			success: function(json) {
				$('.alert, .text-danger').remove();
				if (json['redirect']) {
					location = json['redirect'];
				}
				if (json['success']) {
					 	$.magnificPopup.open({
				removalDelay: 500,
				fixedContentPos: true,
				items: {
				src: 'index.php?route=common/aridius_cart/info'
					},
				type: 'ajax',
				removalDelay: 0,
                mainClass: 'my-mfp-zoom-in'
				});
					// Need to set timeout otherwise it wont update the total
					setTimeout(function () {
						$('#cart button > span').html('<span><span class = "cart-item"><span class ="cart-item-after">' + json['total'] + '</span></span></span>');
					}, 100);
	            $('#cart').load('index.php?route=common/cart/info #cart > *');
	            $('#cart2').load('index.php?route=common/cart2/info #cart2 > *');
				
				
	cart_header.load('index.php?route=common/cart/info #cart > *');
	cart_scroll.load('index.php?route=common/cart/info #cart > *');	

					if (json['total'] != 0) {
				$('#cart').addClass('cart_show');
				} else {
				$('#cart').removeClass('cart_show');
				}
				
				
				$('#aridius_cart').load('index.php?route=common/aridius_cart/info #aridius_cart > *', function() {
				carousel_cart_related();
				carousel_cart_viewed();
			});
				}
		},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},

'update': function(product_id, key, flag, maximum, minimum) { 
	$('input[name^= ' + key + ']').each(function() {
	var minimum = Number(minimum);
	if($('input[name^=qua_st]').val() == 1) {
		var maximum2 = 7777;
	} else {
		var maximum2 = Number($(this).attr('data-maximum'));
	}
	var cart_header = $('header #cart');
	var cart_scroll = $('#menu_scroll #cart');
	var q_valc = $('.val_g' + product_id);
	var p_q_val2 = Number((q_valc).val());
	var input = $('input[name=\'' + key + '\']');
	if($('input[name^=qua_st]').val() == 1) {
			if(flag == '+') {
		input.val(parseFloat(input.val())+1);
	} 
	} else {
			if(flag == '+') {
		if ((p_q_val2) <= maximum - 1) {
		input.val(parseFloat(input.val())+1);
			} 
	} 
	}	
	if(flag == '-') {
		if (p_q_val2 > 1) {
		input.val(parseFloat(input.val())-1);
		}
	}
	if (qnty == '') return;
	var qnty = parseFloat(input.val());
	$.ajax({
		type: 'post',
		data: 'quantity['+key+']='+qnty,
		url: 'index.php?route=checkout/cart/edit',
		dataType: 'html',
		beforeSend: function(){
    $('.overlay_cart').html('<div id="preloader_cart"><i class="fa fa-spinner fa-spin"></i></div>');
        },
	success: function(data) {
	cart_header.load('index.php?route=common/cart/info #cart > *');
	cart_scroll.load('index.php?route=common/cart/info #cart > *');
	$('#cart2').load('index.php?route=common/cart2/info #cart2 > *');
	$('#aridius_cart').load('index.php?route=common/aridius_cart/info #aridius_cart > *', function() {
				carousel_cart_related();
				carousel_cart_viewed();
			});
			$('#preloader_cart').remove();

		}
	});
	});
},
'update_valpop': function(product_id, key, flag, maximum, minimum) {
	$('input[name^= ' + key + ']').each(function() {
	var minimum = Number(minimum);
	if($('input[name^=qua_st]').val() == 1) {
		var maximum2 = 7777;
	} else {
		var maximum2 = Number($(this).attr('data-maximum'));
	}
	var cart_header = $('header #cart');
	var cart_scroll = $('#menu_scroll #cart');
	var q_valc = $('.val_g' + product_id);
	var p_q_val2 = Number((q_valc).val());
	var input = $('input[name=\'' + key + '\']');
	if ((p_q_val2) >= maximum2) {
	$(this).val(maximum2);
	} 
    if (p_q_val2 <= 0) {
	$(this).val('1');
	}		
	if (qnty == '') return;
	var qnty = parseFloat(input.val());
	$.ajax({
		type: 'post',
		data: 'quantity['+key+']='+qnty,
		url: 'index.php?route=checkout/cart/edit',
		dataType: 'html',
		beforeSend: function(){
    $('.overlay_cart').html('<div id="preloader_cart"><i class="fa fa-spinner fa-spin"></i></div>');
        },
	success: function(data) {
	cart_header.load('index.php?route=common/cart/info #cart > *');
	cart_scroll.load('index.php?route=common/cart/info #cart > *');
	$('#cart2').load('index.php?route=common/cart2/info #cart2 > *');
	$('#aridius_cart').load('index.php?route=common/aridius_cart/info #aridius_cart > *', function() {
				carousel_cart_related();
				carousel_cart_viewed();
			});
			$('#preloader_cart').remove();
		}
	});
	});
},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			beforeSend: function() {
				$('.overlay_cart').html('<div id="preloader_cart"><i class="fa fa-spinner fa-spin"></i></div>');
				$('#cart > button').button('loading');
			},
			complete: function() {
				$('#cart > button').button('reset');
			},
			success: function(json) {
				// Need to set timeout otherwise it wont update the total
				setTimeout(function () {
					$('#cart button > span').html('<span><span class = "cart-item"><span class ="cart-item-after">' + json['total'] + '</span></span></span>');
				}, 100);
				var now_location = String(document.location.pathname);
				if ((now_location == '/cart/') || (now_location == '/checkout/') || (getURLVar('route') == 'checkout/cart') || (getURLVar('route') == 'checkout/checkout')) {
					location = 'index.php?route=checkout/cart';
				} else {
	            $('#cart').load('index.php?route=common/cart/info #cart > *');
	            $('#cart2').load('index.php?route=common/cart2/info #cart2 > *');
				$('#aridius_cart').load('index.php?route=common/aridius_cart/info #aridius_cart > *', function() {
				carousel_cart_related();
				carousel_cart_viewed();
			});
				}
				
				if (json['total'] != 0) {
				$('#cart').addClass('cart_show');
				} else {
				$('#cart').removeClass('cart_show');
				}
					$('#preloader_cart').remove();

			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}
var cart_category = {
	'add_category': function(product_id, quantity) {
	var quantity = typeof(quantity) != 'undefined' ? quantity : 1;
	var option = $('#optionpr_'+product_id+' input[type=\'text\'], #optionpr_'+product_id+' input[type=\'radio\']:checked, #optionpr_'+product_id+' input[type=\'checkbox\']:checked, #optionpr_'+product_id+' select');
	if ($('#optionpr_'+product_id).length != 0) {
		var data = option.serialize() + '&product_id=' + product_id + '&quantity=' + quantity;
	} else {
		var data = 'product_id=' + product_id + '&quantity=' + quantity;
	}
			$.ajax({
			url: 'index.php?route=checkout/cart_category/add_category',
			type: 'post',
			data: data,
            dataType: 'json',
   beforeSend: function() {
   $('#button-cart').button('loading');
   },
   complete: function() {
   $('#button-cart').button('reset');
   },
			success: function(json) {
			$('.alert, .text-danger').remove();
				if (json['redirect2']) {
					location = json['redirect2'];
				}			
				$('#cart > button').button('reset');
				if (json['error']) {
   for (i in json['error']['option']) {
   var element = $('#input-option' + i.replace('_', '-'));
   if (element.parent().hasClass('input-group')) {
   element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
   } else {
   element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
   }
   }
				}
				if (json['success']) {
					 	$.magnificPopup.open({
				removalDelay: 500,
				fixedContentPos: true,
				items: {
				src: 'index.php?route=common/aridius_cart/info'
					},
				type: 'ajax',
				removalDelay: 0,
                mainClass: 'my-mfp-zoom-in'
				});
					setTimeout(function () {
						$('#cart button > span').html('<span> &nbsp;' + json['total'] + '&nbsp;<span class="caret"></span></span>');
					}, 100);
	            $('#cart').load('index.php?route=common/cart/info #cart > *');
	            $('#cart2').load('index.php?route=common/cart2/info #cart2 > *');
				$('#aridius_cart').load('index.php?route=common/aridius_cart/info #aridius_cart > *', function() {
				carousel_cart_related();
				carousel_cart_viewed();
			});
				}
		},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	 }
}
var voucher = {
	'add': function() {
	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			complete: function() {
				$('#cart > button').button('reset');
			},
			success: function(json) {
				// Need to set timeout otherwise it wont update the total
				setTimeout(function () {
					$('#cart button > span').html('<span> &nbsp;' + json['total'] + '&nbsp;<span class="caret"></span></span>');
				}, 100);
				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}
var wishlist = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=account/wishlist/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
            success: function (json) {

                let id = "('" + product_id + "');";
                let id_2 = "(" + product_id + ")";
                let element = document.querySelectorAll('a[onclick="wishlist.add' + id + '"] > .fag');
                let parent = $(element).closest('.snav');
                $(parent).addClass('active-snav');
                $(element).addClass('active-wish');

                let element_2 = document.querySelectorAll('a[onclick="wishlist.add' + id_2 + '"] > .fag');
                $(element_2).addClass('active-wish');
                let parent_2 = $(element_2).closest('.snav');
                $(parent_2).addClass('active-snav');

                $('.alert').remove();
                if (json['success']) {
                    $("#wishlist").modal('show');
					$("#wishlist .modal-body p").html(json['success']);

				if($('#wish_show div').is('.wish_sh')) {
                    $('#wishlist-total, #wishlist-total2, #wishlist-total3, #wish_log').html(json['total']);
				} else {
					$('#wish_show').html('<div class="mob_cart wish_sh"><span class="cart-item_h"><span class ="cart-item-after_h"><span id="wishlist-total">1</span></span></span></div>');
				}

                }
            },
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'remove': function() {
	}
}
var compare = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=product/compare/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
            success: function (json) {

                let id = "('" + product_id + "');";
                let id_2 = "(" + product_id + ")";
                let element = document.querySelectorAll('a[onclick="compare.add' + id + '"] > .fa.fa-fw.fa-balance-scale');
                let parent = $(element).closest('.snav');
                $(parent).addClass('active-snav');
                $(element).addClass('active-wish');

                let element_2 = document.querySelectorAll('a[onclick="compare.add' + id_2 + '"] > .fa.fa-fw.fa-balance-scale');
                $(element_2).addClass('active-wish');
                let parent_2 = $(element_2).closest('.snav');
                $(parent_2).addClass('active-snav');

                $('.alert').remove();
                if (json['success']) {
                    $("#compare").modal('show');
                    $("#compare .modal-body p").html(json['success']);
                    $('#compare-total, #compare-total2, #compare-total3').html(json['total']);
                }
            },
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'remove': function() {
	}
}
/* Agree to Terms */
$(document).delegate('.agree', 'click', function(e) {
	e.preventDefault();
	$('#modal-agree').remove();
	var element = this;
	$.ajax({
		url: $(element).attr('href'),
		type: 'get',
		dataType: 'html',
		success: function(data) {
			html  = '<div id="modal-agree" class="modal">';
			html += '  <div class="modal-dialog">';
			html += '    <div class="modal-content">';
			html += '      <div class="modal-header">';
			html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
			html += '        <h4 class="modal-title">' + $(element).text() + '</h4>';
			html += '      </div>';
			html += '      <div class="modal-body">' + data + '</div>';
			html += '    </div';
			html += '  </div>';
			html += '</div>';
			$('body').append(html);
			$('#modal-agree').modal('show');
		}
	});
});
// Autocomplete */
(function($) {
	$.fn.autocomplete = function(option) {
		return this.each(function() {
			this.timer = null;
			this.items = new Array();
			$.extend(this, option);
			$(this).attr('autocomplete', 'off');
			// Focus
			$(this).on('focus', function() {
				this.request();
			});
			// Blur
			$(this).on('blur', function() {
				setTimeout(function(object) {
					object.hide();
				}, 200, this);
			});
			// Keydown
			$(this).on('keydown', function(event) {
				switch(event.keyCode) {
					case 27: // escape
						this.hide();
						break;
					default:
						this.request();
						break;
				}
			});
			// Click
			this.click = function(event) {
				event.preventDefault();
				value = $(event.target).parent().attr('data-value');
				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			}
			// Show
			this.show = function() {
				var pos = $(this).position();
				$(this).siblings('ul.dropdown-menu').css({
					top: pos.top + $(this).outerHeight(),
					left: pos.left
				});
				$(this).siblings('ul.dropdown-menu').show();
			}
			// Hide
			this.hide = function() {
				$(this).siblings('ul.dropdown-menu').hide();
			}
			// Request
			this.request = function() {
				clearTimeout(this.timer);
				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			}
			// Response
			this.response = function(json) {
				html = '';
				if (json.length) {
					for (i = 0; i < json.length; i++) {
						this.items[json[i]['value']] = json[i];
					}
					for (i = 0; i < json.length; i++) {
						if (!json[i]['category']) {
							html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
						}
					}
					// Get all the ones with a categories
					var category = new Array();
					for (i = 0; i < json.length; i++) {
						if (json[i]['category']) {
							if (!category[json[i]['category']]) {
								category[json[i]['category']] = new Array();
								category[json[i]['category']]['name'] = json[i]['category'];
								category[json[i]['category']]['item'] = new Array();
							}
							category[json[i]['category']]['item'].push(json[i]);
						}
					}
					for (i in category) {
						html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';
						for (j = 0; j < category[i]['item'].length; j++) {
							html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
						}
					}
				}
				if (html) {
					this.show();
				} else {
					this.hide();
				}
				$(this).siblings('ul.dropdown-menu').html(html);
			}
			$(this).after('<ul class="dropdown-menu"></ul>');
			$(this).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));
		});
	}
})(window.jQuery);