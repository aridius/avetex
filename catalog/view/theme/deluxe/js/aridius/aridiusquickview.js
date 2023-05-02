function Spinner_page(click) {
	if (click) {
		$('#Spinner_page').html('<i class="fa fa-spinner fa-pulse fa_size"></i>');
		$('#Spinner_page').show();
	} else {
		$('#Spinner_page').html('');
		$('#Spinner_page').hide();
	}
}
function quickview_open(id) {
	$('body').prepend('<div id="Spinner_page"></div><div class="bag_quickview"></div>');
	$.ajax({
type:'post',
data:'aridius_quickview=1',
url:'index.php?route=product/product&product_id='+id,
	beforeSend: function() {
			Spinner_page(true); 
		},
complete: function() {
			$('.bag_quickview').hide();
			$('#Spinner_page').hide();
			   $('#menu_scroll').removeClass('sticky');
			Spinner_page(false); 
		},		
success:function (data) {
			$('.bag_quickview').hide();
			$data = $(data);
			var new_data = $(data).find('#quickview').html();
			$.magnificPopup.close(); 
			$.magnificPopup.open({
items: {
src: new_data,
type: 'inline'
		},
callbacks : {
open: function() {
		get_timerpopup(true);
					},
close: function() {
		get_timerpopup(false);

					}
				}
			});
		}
	});
}