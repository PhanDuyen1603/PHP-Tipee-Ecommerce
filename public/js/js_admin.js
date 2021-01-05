jQuery(document).ready(function($){
	$('#selectall').click(function() {
		var checkboxes = $('#table_index').find(':checkbox');
		if($(this).is(':checked')) {
			//checkboxes.attr('checked', 'checked');
			$(':checkbox').prop('checked',true);
		} else {
			//checkboxes.removeAttr('checked');
			$(':checkbox').prop('checked',false);
		}
	});
});

function select_all() {
    (function ($) {
        var checkboxes = $('#table_index').find(':checkbox').each(function(){
        	if($(this).is(':checked')) {
				//checkboxes.attr('checked', 'checked');
				$(':checkbox').prop('checked',true);
			} else {
				//checkboxes.removeAttr('checked');
				$(':checkbox').prop('checked',false);
			}
        });
    })(jQuery);
}
function delete_id(type) {
    (function ($) {
        arr = new Array();
        var con = 0;
		$('input[name="seq_list[]"]:checked').each(function(){
			arr = $('input:checkbox').serializeArray();
			arr.push({ name: "_token", value: getMetaContentByName('csrf-token') });
			arr.push({ name: "type", value: type });
		}); //each
        $.ajax({
            type: "POST",
            url: admin_url+"/delete-id",
            data: arr ,//pass the array to the ajax call
            cache: false,
            beforeSend: function() {
                
            },
            success: function(){
                location.reload();
            }
        });//ajax
    })(jQuery);
}
function update_theme_fast(product_id) {
    (function ($) {
    	var origin_price=$('#origin-price-'+product_id).val();
	    var promotion_price=$('#promotion-price-'+product_id).val();
	    // var order_short=$('#order_short-'+product_id).val();
        var start_event = $('#start-event-'+product_id).val();
        var end_event = $('#end-event-'+product_id).val();
	    // if(order_short !=''){
	    //     order_short=parseInt($('#order_short-'+product_id).val());
	    // }else{
	    //     order_short=0;
	    // }
	    $.ajax({
            type: "POST",
            url: admin_url+"/ajax/process_theme_fast",
            data: {
                '_token': getMetaContentByName('csrf-token'),
                'id' : product_id,
                'origin_price':origin_price,
                'promotion_price':promotion_price,
                // 'order_short':order_short,
                'start_event': start_event,
                'end_event': end_event
            },
            dataType:"text",
            cache: false,
            beforeSend: function(){

            },
            success: function(status){
                $('#alert_'+product_id).html(status);
                $('#alert_'+product_id).show();
          	}
        });//ajax
    })(jQuery);
}
function new_item_click(product_id) {
    (function ($) {
        if($('#toggle-new-item-'+product_id+':checkbox:checked').length > 0){
            var check = 1;
        }else{
            var check = 0;
        }
        $.ajax({
            type: "POST",
            url: admin_url+"/ajax/process_new_item",
            data: {
                '_token': getMetaContentByName('csrf-token'),
                'check' : check,
                'sid':product_id
            },
            dataType:"text",
            cache: false,
            beforeSend: function() {
	            
            },
            success: function(status)
            {
                
            }
        });//ajax
    })(jQuery);
}

function flash_sale_click(product_id) {
    (function ($) {
        if($('#toggle-flash-sale-'+product_id+':checkbox:checked').length > 0){
            var check = 1;
        }else{
            var check = 0;
        }
        $.ajax({
            type: "POST",
            url: admin_url+"/ajax/process_flash_sale",
            data: {
                '_token': getMetaContentByName('csrf-token'),
                'check' : check,
                'sid':product_id
            },
            dataType:"text",
            cache: false,
            beforeSend: function() {
	            
            },
            success: function(status)
            {
                
            }
        });//ajax
    })(jQuery);
}

function sale_top_week_click(product_id) {
    (function ($) {
        if($('#toggle-sale-top-week-'+product_id+':checkbox:checked').length > 0){
            var check = 1;
        }else{
            var check = 0;
        }
        $.ajax({
            type: "POST",
            url: admin_url+"/ajax/process_sale_top_week",
            data: {
                '_token': getMetaContentByName('csrf-token'),
                'check' : check,
                'sid':product_id
            },
            dataType:"text",
            cache: false,
            beforeSend: function() {
	            
            },
            success: function(status)
            {
                
            }
        });//ajax
    })(jQuery);
}

function propose_click(product_id) {
    (function ($) {
        if($('#toggle-propose-'+product_id+':checkbox:checked').length > 0){
            var check = 1;
        }else{
            var check = 0;
        }
        $.ajax({
            type: "POST",
            url: admin_url+"/ajax/process_propose",
            data: {
                '_token': getMetaContentByName('csrf-token'),
                'check' : check,
                'sid':product_id
            },
            dataType:"text",
            cache: false,
            beforeSend: function() {
	            
            },
            success: function(status)
            {
                
            }
        });//ajax
    })(jQuery);
}

function store_status_click(product_id) {
    (function ($) {
        if($('#toggle-store-status-'+product_id+':checkbox:checked').length > 0){
            var check = 1;
        }else{
            var check = 0;
        }
        $.ajax({
            type: "POST",
            url: admin_url+"/ajax/process_store_status",
            data: {
                '_token': getMetaContentByName('csrf-token'),
                'check' : check,
                'sid':product_id
            },
            dataType:"text",
            cache: false,
            beforeSend: function() {
	            
            },
            success: function(status)
            {
                
            }
        });//ajax
    })(jQuery);
}

function loadFile(event){
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
}

function loadFileIcon(event){
    var output = document.getElementById('output_icon');
    output.src = URL.createObjectURL(event.target.files[0]);
}

function loadFileSlishow_pc(event){
    var output = document.getElementById('output_slishow_pc');
    output.src = URL.createObjectURL(event.target.files[0]);
}

function loadFileSlishow_mobile(event){
    var output = document.getElementById('output_slishow_mobile');
    output.src = URL.createObjectURL(event.target.files[0]);
}

function getMetaContentByName(name,content){
   var content = (content==null)?'content':content;
   return document.querySelector("meta[name='"+name+"']").getAttribute(content);
}

function number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
        var k = Math.pow(10, prec);
        return '' + Math.round(n * k) / k;
    };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}