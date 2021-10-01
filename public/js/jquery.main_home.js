window.onpageshow = function(event) {
    if (event.persisted) {
        location.reload();
    }
};
"use strict";
jQuery(document).ready(function($) {

    $('#slt_province').select2();
    $('#slt_district').select2();
    $('#slt_ward').select2();

    jQuery.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var check = false;
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },""
    );
    $("#check_out_frm").validate({
        rules: {
           full_name: "required",
           phone: {
              required: true,
              regex: '^0[0-9]{9,9}$'
           },
           address: "required",
        },
        messages: {
           full_name: "Nhập tên của bạn",
           phone:"SĐT không đúng định dạng",
           address: "Nhập địa chỉ"
        },
    });
    
    $("#check_out_frm #submit").on('click', function(){
        if($("#check_out_frm").valid()){
            //stop submitting the form to see the disabled button effect
            $('#check_out_frm').submit();
            $('#check_out_frm .loading').addClass('loader');
            //disable the submit button
        } 
    });
    $('select[name="filter_cate"]').on('change', function(){
        var order = $(this).val();
        var current_url = window.location.href;
        var n = current_url.indexOf("?");
        var check_order_a = current_url.indexOf("ordersort=pricea");
        var check_order_d = current_url.indexOf("ordersort=priced");
        var check_page_isset = current_url.indexOf("page=");
        if(n != -1){
            var conect = '&';
        } else{
            var conect = '?';
        }
        if(order != ""){
            if(check_order_a != -1){
                current_url = current_url.replace('pricea', order);
                current_url = current_url.replace('pricea', order);
            } else if(check_order_d != -1){
                current_url = current_url.replace('priced', order);
                current_url = current_url.replace('priced', order);
            } else{
                if(check_page_isset != -1){
                    current_url += conect+'ordersort='+order;
                } else{
                    current_url += conect+'ordersort='+order+'&page=1';
                }
            }
        } 
        window.location.href = current_url;
    });
    $('input#quantity').on('input',function(e){
        $('#btn_cart_primary').attr('data-quantity', $(this).val());
        $('#buy_now_single_button').attr('data-quantity', $(this).val());
    });
    $('.btn-search-mobi').on('click', function(){
        if($('.header_head_group .box_search_header').hasClass('active')){
            $('.header_head_group .box_search_header').removeClass('active');
        }else{
            $('.header_head_group .box_search_header').addClass('active');
        }
    });
    
    $( "#search_input" ).autocomplete({
        source: function( request, response ) {
            $.ajax( {
                url: "/autocomplete",
                dataType: "json",
                data: {
                    query_string: request.term
                },
                success: function(data) {
                    response($.map(data.suggestions, function (item) {
                        return {
                            label: item.title,
                            url: item.url,
                            type: item.type
                        };
                    }));
                }
            } );
        },
        minLength: 2,
        select: function( event, ui ) {
            window.location = ui.item.url;
        }
    });

    //popup page
    var cat = $.cookie("check");
     if (cat != 'true') {
        $(window).load(function () {
            setTimeout(function(){
                $('#jPopup').show();
            },3000);
            $.cookie("check", 'true', {expires: 1});
        });
    } 
    $('#jPopup .close').on('click', function(){
        $('#jPopup').hide();
    });

     /*Menu check has child*/
    $("#category_products_menu_static li a").each(function(){
        if($(this).parent().children("ul").length){
            $(this).addClass("sub");
        }
    });

    /*Menu mobile check has child*/
    $(".category_menu_product_home_read_moblie li a").each(function(){
        if($(this).parent().children("ul").length){
            $(this).parent().append("<span class='arr-mn-mobi arr-extend'><i class='fa fa-chevron-down' aria-hidden='true'></i></span>");
        }
    });
    
    $(".category_menu_product_home_read_moblie li .arr-extend").on('click', function(){
        if($(this).parent().hasClass('active')){
            $(this).parent().removeClass('active');
        }else{
            $(this).parent().addClass('active');
        }
    });

    //check form register
    $('#email').on('change', function(){
        var data = {
          'email' : $('#email').val(),
          '_token': getMetaContentByName("_token")
        };
        $.ajax({
            url: site+'/ajax/check-register',
            type: "post",
            data: data,
            success:function(result){
              if(result == 1){
                $("#error-form-email").html('Email đã được sử dụng.');
                $('.btn-submit-customer').attr("disabled", true);
              }
              else{
                $("#error-form-email").html('');
                $('.btn-submit-customer').attr("disabled", false);
              }
            }
        });
    });
    $('#phone').on('change', function(){
        var data = {
          'phone' : $('#phone').val(),
          '_token': getMetaContentByName("_token")
        };
        $.ajax({
            url: site+'/ajax/check-register',
            type: "post",
            data: data,
            success:function(result){
              if(result == 1){
                $("#error-form-phone").html('Số điện thoại đã được sử dụng.');
                $('.btn-submit-customer').attr("disabled", true);
              }
              else{
                $("#error-form-phone").html('');
                $('.btn-submit-customer').attr("disabled", false);
              }
            }
        });
    });
    /*
    $( window ).load(function() {
        $('.sec-dadapick .product-grid-4').ready(function() {
                var maxHeight_col = -1;
                $(this).find('.product-item .pro-info').each(function() {
                    if($(this).outerHeight() > maxHeight_col)
                        maxHeight_col = $(this).outerHeight();
                });
            $(this).find('.product-item .pro-info').css({'height':+maxHeight_col});
        });
    });
    */
    $('.btn_edit').on('click', function(){
        $('.btn_update').addClass('active');
        $('.btn_cancel').addClass('active');
        $('.btn_edit_form').addClass('active');
        $('.avatar-wrapper').addClass('active');
        $('.avatar_user').addClass('active');
        $('.avatar-upload .avatar-edit').addClass('active');
        //remove attr
        $('.edit_profile input[name="avatar_upload"]').removeAttr("disabled");
        $('.edit_profile input[name="full_name"]').removeAttr("disabled");
        $('.edit_profile input[name="phone"]').removeAttr("disabled");
        $('.edit_profile input[name="last_name"]').removeAttr("disabled");
        $('.edit_profile input[name="address"]').removeAttr("disabled");
        $('.edit_profile textarea[name="about_me"]').removeAttr("disabled");
        $('.edit_profile select').removeAttr("disabled");
    });

    $('.btn_cancel input[type="button"]').on('click', function(){
        location.reload();
    });

	$(document).on('click','.choose_variable-item_li',function(){
		$('.choose_variable .choose_variable-item_li').removeClass('action');
		$(this).addClass('action');
		var id_img=$(this).attr("attrid");
		if($('img#images_variable_'+id_img).length>0)
		{
			var img_change=$(this).find('img#images_variable_'+id_img).attr('src');
			//alert(img_change);
			//alert($(this).closest('.product-item').find('.item-thumb').find('img').attr('src'));
			$(this).closest('.product-item').find('.item-thumb').find('img').attr('src',img_change); 
		}
	});
	$('a.images-rotation').hover(
		function(){
			var image_src_change=$(this).attr('data-images');
			//setTimeout(function(){
				$(this).find('img').attr('src',image_src_change); 
			//},510);
			
		},function(){
			var image_src_current=$(this).attr('data-default');
			$(this).find('img').attr('src',image_src_current); 
		}
	);
	
	$('input.radio_variabe[type="radio"]').click(function(e){
        //alert('ok');
        var radio=$(this);
        var name_attr=radio.attr('name-variabe');
        var id_radio=radio.attr('variableID');
        //var code=$('.code_'+id_radio).val();
        //var description=$('.description_variable_'+id_radio).val();
        //var class_image=".class_"+name_attr;
        //console.log(class_image);
		$('#xzoom-thumbs a').find('img.variabe-item_'+id_radio).trigger('click');
        //$('#xzoom-thumbs a').find('img').removeClass('xactive');
		//$('#xzoom-thumbs a img.variabe-item_'+id_radio).addClass('xactive');
        //$('#sku_product_view').html(code);
        //$('#description_single_product').html(description);
    });
	
    //rewrite url pagenavi
    $('.pagination a').each(function(){
        var old_href_pagenavi = $(this).attr('href');
        var url_current = window.location.href; 
        var check_1 = url_current.replace('?','isset');
        if(check_1 != url_current){
            var last_word = old_href_pagenavi.length;
            var last_word_current_url = url_current.length;
            var cut_word = old_href_pagenavi.lastIndexOf('?');
            var check_position_page = url_current.indexOf('page=');
            var page_number_navi = url_current.substring(check_position_page, last_word_current_url);
            var check_2 = url_current.replace('page=','isset');
            var c = check_2.normalize();
            var b= url_current.normalize();
            if(c === b){
                var word = old_href_pagenavi.substring(cut_word, last_word);
                word = word.replace('?','&');
                var new_url = url_current+word;
            }
            else{
                var page_number = old_href_pagenavi.substring(old_href_pagenavi.indexOf('page='), last_word);
                var new_url = url_current.replace(page_number_navi,page_number);
                console.log(page_number_navi);
            }
            $(this).attr('href', new_url);
        }
    });

    $('.categories_list .title_block').on('click', function(){
        if($('.filter').hasClass('active')){
            $('.filter').removeClass('active');
        }
        else{
            $('.filter').addClass('active');
        }
    });


    $.ajaxSetup({ cache: false});
    headerStyle();
	$(".chat_fb").click(function() {
		$('.fchat').toggle('slow');
    });
	/*
	if ($(window).width() > 768) {
            setTimeout(function () {
                var width = $(".header3").height();
                $('.main-container').css("margin-top", width);
            }, 200)
            
    }
    if ($(window).width() < 768) {
            setTimeout(function () {
                var width = $(".header3").height();
                $('.main-container').css("margin-top", width);
            }, 200)
            
    }
    $(window).on('scroll resize', function(){
        var height_header = $('header').height();
        $('#main-container').css("padding-top", height_header);
    });
    $(window).on('load', function(){
        var height_header = $('header').height();
        $('#main-container').css("padding-top", height_header);
    });
    */
    $(window).on('load', function(){
        $('.addthis_inline_share_toolbox span.at-label').html('Chia sẽ');
    });
	 $(window).on('load resize', function(){
		/*xzoom gallery*/
		if(window.innerWidth>768){
			var img=$("#xzoom-default").height();
		}
		else{
			var img=$("#xzoom-default").width();
		}
		$('#xzoom-default').trigger("mouseover");
	 });	
    $('#size_sp_choose').click(function () {
         $("#size_sp_click").animate({
                height: 'toggle'
         });
    });
    /*End xzoom gallery*/
    var max_width_default = $("#singleProductImg").width();
    $('#xzoom-img').css("max-width", max_width_default);
    $('.thumb-nav-xzoom').css("max-width", max_width_default);

    $('.slide-page').on('init', function(slick) {
        if(!$('.loading-slider').hasClass('active')){
            $('.loading-slider').addClass('active');
        }
    }).slick({
        dots: true,
        infinite: true,
        speed: 600,
        fade: true,
        cssEase: 'linear',
        autoplay: true,
        autoplaySpeed:4000,
        arrows: true,
        prevArrow: '<div class="slick-prev"></div>',
        nextArrow: '<div class="slick-next"></div>'
    });
/*
    $('.thumb-nav-xzoom').on('afterChange', function(event, slick, currentSlide){
        var src = '';
        src = $(this).find($('li.slick-current img')).attr('src');
        $('#xzoom-default').attr('xoriginal', src);
        $('#xzoom-default').attr('src', src);
      });
    $('.thumb-nav-xzoom').slick({
        dots: false,
        autoplay: true,
        autoplaySpeed: 3000,
        infinite: true,
        centerMode: false,
        variableWidth: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: '<div class="slick-prev"></div>',
        nextArrow: '<div class="slick-next"></div>',
    });

 */
    $('.img_detail_product').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        asNavFor: '.img_detail_product_nav'
    });
    $('.img_detail_product_nav').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.img_detail_product',
        dots: true,
        centerMode: false,
        focusOnSelect: true,
        arrows: true,
    });
    $('.daily-deal-slider').slick({
        dots: false,
        infinite: true,
        speed: 600,
        autoplay: false,
        arrows: true,
        prevArrow: '<div class="slick-prev"></div>',
        nextArrow: '<div class="slick-next"></div>'
    });
	$('.home_slider_products').slick({
        dots: false,
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        prevArrow: '<button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button>',
        nextArrow: '<button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button>',
        autoplaySpeed: 2000,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 800,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.dada-videos-list').slick({
        dots: false,
        infinite: true,
        slidesToShow: 2,
        slidesToScroll: 1,
        autoplay: true,
        prevArrow: '<button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button>',
        nextArrow: '<button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button>',
        autoplaySpeed: 4000,
        responsive: [
            {
                breakpoint: 360,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

	$('.home_read_products_session').slick({
        dots: false,
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        prevArrow: '<button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button>',
        nextArrow: '<button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button>',
        autoplaySpeed: 2000,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 800,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
        ]
    });
    $('.ls-related-product').slick({
        dots: false,
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        arrows: false,
        responsive: [
            {
                breakpoint: 800,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
        ]
    });
    $('.home_product_new_item').slick({
        dots: false,
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        prevArrow: '<button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button>',
        nextArrow: '<button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button>',
        autoplaySpeed: 2000,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 800,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.home_product_best_seller').slick({
        dots: false,
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        prevArrow: '<button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button>',
        nextArrow: '<button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button>',
        autoplaySpeed: 2000,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 800,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
        ]
    });
    
    $('.home_product_dada_pick').slick({
        dots: false,
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        prevArrow: '<button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button>',
        nextArrow: '<button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button>',
        autoplaySpeed: 2000,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 800,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
        ]
    });

    var url_home = 'https://www.dadabeauty.vn/'
    //ajax load product-size
    $('.list_size input[type="checkbox"]').on('click', function(){
        var size = [];
        $('.list_size input[type="checkbox"]:checked').each(function(i){
          size[i] = $(this).val();
        });
        var cate_slug = $('.cate-slug').val();
        var data = {
            'size' : size,
            'cate_slug' : cate_slug
        };
        $.ajax({
            url: 'ajax/get-cate-on-size',
            type: "GET",
            data: data,
            success:function(result){
                $(".list_theme_category").html(result);
            }
        });
    });

    $("#backtop-btn").click(function(e){
        e.preventDefault();
        $("body,html").animate({scrollTop:0},500);
    });

    //validation form customer
    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var check = false;
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },""
    );
    $("#customer-register").validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            full_name: "required",
            email: "required",
            password: "required",
            password_confirmation: "required",
            phone: "required",
            address: "required"
        },
        messages: {
            full_name: "Nhập họ và tên",
            email: "Nhập địa chỉ E-mail",
            password : "Nhập mật khẩu",
            password_confirmation : "Nhập mật khẩu xác nhận",
            phone: "Nhập số điện thoại",
            address: "Nhập địa chỉ của bạn",
        },
        errorElement : 'div',
        errorLabelContainer: '.errorTxt',
        invalidHandler: function(event, validator) {
            $('html, body').animate({
                scrollTop: 0
            }, 500);
        }
    });
    $(window).scroll(function(){ $(this).scrollTop()>100?$("#back-top").fadeIn():$("#back-top").fadeOut().fadeOut()}),$("html, body").on("click","#back-top",function(){return $("html, body").animate({scrollTop:0},600),!1;});
	/*
	 window.onscroll = function() {
        fnScrollFixed();
    };
	*/
	$(window).on("load resize scroll",function(e){
		fnScrollFixed();
	});
    $(window).on('load resize', function () {
		
        var vs_980= window.matchMedia("only screen and (max-width: 980px)");
        if(vs_980.matches){
            //$('.main-header').addClass('fixed-header');
            $(window).on('scroll', function() {
                headerStyle();
            });
        }else{
            $(window).on('scroll', function() {
                headerStyle();
            });
        }
    });

    $('span.toc_toggle a').click(function(event) {
        event.preventDefault();
        $(this).toggleClass('active');
        $('ul.toc_list').toggle();
    });
    $('ul.toc_list li a').click(function (event) {
        var href_link=$(this).attr('href');
        $('body,html').animate({
            scrollTop:$(href_link).offset().top
        }, 800);
        $('header#header').removeClass('scrolled');
        event.preventDefault();
        return false;
    });


    $("#menu_btn").delegate("a#show_menu_hover","click", function(e) {
        e.preventDefault();
        if($("#sidr-right-menu").hasClass("right")) {

            $('#sidr-right-menu').removeClass('right');
            $('#page').removeClass('right');
            $('header#branding').removeClass('icon_menu_fixed');

        }else {

            $('#sidr-right-menu').addClass('right');
            $('#page').addClass('right');
            $('header#branding').addClass('icon_menu_fixed');

        }
    });

    $("#primary-menu").delegate(".plus,.prevent","click", function(e) {
        e.preventDefault();
        if($(this).hasClass("minus")) {
            $(this).parent().find('ul').slideUp();
            $(this).removeClass('minus');
        }else{
            $(this).addClass('minus');
            $(this).parent().find('ul').slideDown();

        }
    });

    var $megamenu_options = {
        activeClass: 'open',
        fadeInDuration: 150,
        fadeOutDuration: 'normal',
        hoverTimeout: 450
    };
    $(window).on('load resize', function () {
        var vs_767= window.matchMedia("only screen and (max-width: 767px)");
        if(vs_767.matches){
            $('ul#primary-menu>li>ul').removeClass('mega_menu');
            $('ul#primary-menu>li>ul').removeClass('animated');
            $('ul#primary-menu>li>ul').removeClass('fadeOutDown');
            //$('#primary-menu').Megadropdown($megamenu_options);
		}else{
            $('ul#primary-menu>li>ul').addClass('mega_menu');
            $('ul#primary-menu>li>ul').addClass('animated');
            $('#primary-menu').Megadropdown($megamenu_options);
		}
	});
    /*
    if($('#jssor_1').length>0){
        var width_full=1140;
        jssor_1_slider_init(width_full,'jssor_1');
    }
    new WOW().init();
    */

    $('#slt_province').on('change', function(){
        if($('#slt_province').val() == ''){
           return; 
        } else{
            var data_type = {
              '_token': getMetaContentByName("_token"),
              'data': $('#slt_province').val()
            };
            $.ajax({
              url: '/ajax/get-district',
              type: 'POST',
              data: data_type,
              dataType:'html',
              beforeSend: function() {
              },
              success:function(data) {
                $('#slt_district').html(data);
              },
              complete: function(){
              },
              error: function(errorThrown){
                  console.log(errorThrown);
              }
            });
        }
    });

    $('#slt_district').on('change', function(){
        if($('#slt_district').val() == ''){
           return; 
        } else{
            var data_type = {
              '_token': getMetaContentByName("_token"),
              'data': $('#slt_district').val()
            };
            $.ajax({
              url: '/ajax/get-ward',
              type: 'POST',
              data: data_type,
              dataType:'html',
              beforeSend: function() {
              },
              success:function(data) {
                $('#slt_ward').html(data);
              },
              complete: function(){
              },
              error: function(errorThrown){
                  console.log(errorThrown);
              }
            });
        }
    });

    $('#type_shipping').on('change', function(){
        if($('#type_shipping').val() == ''){
           return; 
        } else{
            var arr = [];
            var data_type = {
              '_token': getMetaContentByName("_token"),
              'data': $('#type_shipping').val()
            };
            $.ajax({
              url: '/ajax/get-fee-shipping',
              type: 'POST',
              data: data_type,
              dataType:'html',
              beforeSend: function() {
              },
              success:function(data) {
                arr = JSON.parse(data);
                if(isFreeShip == 1){
                    $('#shipping-fee').html('Miễn phí giao hàng');
                    $('#shipping_fee').val(0);
                } else{
                    $('#shipping-fee').html(arr['fee_html']);
                    $('#shipping_fee').val(arr['fee']);
                    $('span.woocommerce-Price-amount').html(arr['cart_total']);
                }
              },
              complete: function(){
              },
              error: function(errorThrown){
                  console.log(errorThrown);
              }
            });
        }
    });

   $('.toggle-menu').jPushMenu({closeOnClickLink: false});
   $(".flexnav").flexNav({ 'animationSpeed' : 'fast' });


   
 // $('.classlist input[type=radio]').change(function() {
  //       var arr = {};
  //       
  //       $('.classlist input[type=radio]').each(function () {
  //           if( $(this).is(":checked") ) {
  //               arr[$(this).attr("data-parent-slug")] =$(this).attr("date-title");
  //           }
  //       })
  //       //$('a#btn_cart_primary').attr('data-option',JSON.stringify(arr));
		// $('a#btn_cart_primary').attr('data-option',JSON.stringify(arr));
		// $('a#buy_now_single').attr('data-option',JSON.stringify(arr));
		// $('a#buy_now_single_button').attr('data-option',JSON.stringify(arr));
		
		// //$('a.addToCart_btn').attr('data-option',JSON.stringify(arr));
  //   });
    $('.classlist input[type=radio]').change(function() {
        var arr = {};
        var array_checked = [];
        var price_id = "";
        //var price="";
        var array_variable={};
        var i=0;
        $('.choose_variable  input[type=radio]').each(function () {
            if ($(this).is(":checked")) {
                price_id += $(this).attr("variableid") + "_";
                array_variable='{"parent_title":"'+$(this).attr("data-parent-name")+'","parent_id":'+$(this).attr("data-parent-id")+',"title":"'+$(this).attr("date-title")+'","id":'+$(this).attr("variableid")+'}';
                arr[i] = array_variable;
                i++;
            }
        });
        price_id = price_id.slice(0, -1);
        if ($("#price_variable_query_" + price_id).length > 0){
            if ($("#price_variable_query_" + price_id).val() != "") {
                $(".price_primary_container").html(formatNumber($("#price_variable_query_" + price_id).val(), '.', ','));
                $('a#btn_cart_primary').attr('data-price',$("#price_variable_query_" + price_id).val());
                $('a#buy_now_single_button').attr('data-price',$("#price_variable_query_" + price_id).val());
            } else {
                $(".price_primary_container").html($("#price_current_view").val());
            }
        }
        $('a#btn_cart_primary').attr('data-option',JSON.stringify(arr));
        $('a#buy_now_single_button').attr('data-option',JSON.stringify(arr));
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.qty-down').click(function(e) {
        if($(this).parent().find('.qty-val').val()>1){
            var id_product = $(this).parent().find('.qty-val').attr("data-id-pro");
            var newQty = parseInt($(this).parent().find('.qty-val').val()) - 1;
            $(this).parent().find('.qty-val').val(newQty);
        }
        var sendInfo = {
            '_token': $('input[name=_token]').val(),
            'qty' : newQty,
            'id_product': id_product
        };
        var arr = [];
        $.ajax({
            type: 'POST',
            url: '/ajax-update-cart',
            data: sendInfo,
            success: function(result) {
                arr = JSON.parse(result);
                $('#td-cart_total').html(number_format(arr['total'])+'<span class="woocommerce-Price-currencySymbol"> ₫</span>');
                $('span[data-total-id="'+id_product+'"]').html(arr['new_price']+'<span class="woocommerce-Price-currencySymbol"> ₫</span>');
                $('#total_price_cart').html(arr['total']+' <span class="woocommerce-Price-currencySymbol"> ₫ (Chưa bao gồm phí giao hàng)</span>');
            }
        });
        e.preventDefault();
    });
    $('.qty-up').click(function(e) {
        var id_product = $(this).parent().find('.qty-val').attr("data-id-pro");
        var newQty = parseInt($(this).parent().find('.qty-val').val()) + 1;
        $(this).parent().find('.qty-val').val(newQty);
        var sendInfo = {
            '_token': $('input[name=_token]').val(),
            'qty' : newQty,
            'id_product': id_product
        };
        $.ajax({
            type: 'POST',
            url: '/ajax-update-cart',
            data: sendInfo,
            success: function(result) {
                arr = JSON.parse(result);
                $('#td-cart_total').html(number_format(arr['total'])+'<span class="woocommerce-Price-currencySymbol"> ₫</span>');
                $('span[data-total-id="'+id_product+'"]').html(arr['new_price']+'<span class="woocommerce-Price-currencySymbol"> ₫</span>');
                $('#total_price_cart').html(arr['total']+' <span class="woocommerce-Price-currencySymbol"> ₫ (Chưa bao gồm phí giao hàng)</span>');
            }
        });
        e.preventDefault();
    });
});

function fnSetSearchValue(type, value){
    var url = location.protocol + '//' + location.host + location.pathname;
    url = url + "?";

    var urlParams = new URLSearchParams(window.location.search);

    var allParams = urlParams.toString();

    var page = "";
    if (getUrlParameter("page") != "") {
        page = "page=" + getUrlParameter("page");

        allParams = allParams.replace("&"+page, "");

        allParams= allParams.replace(page, "");
    }

    if (getUrlParameter(type) != "") {
        allParams = allParams.replace(getUrlParameter(type),value);
    }
    else {
        if (allParams == "") {
            allParams = type + "=" + value;
        }
        else {        
            allParams = allParams + "&" + type + "=" + value;
        }
    }
    var newUrl = url + allParams;
    window.location.href = newUrl;
}

function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
};

function Load_Releated_Cate_Theme($slug,$page,e){
	//history.pushState(null, null, '#' + id);
    $=jQuery;
	e.preventDefault();
	var sendInfo = {
        '_token': $('input[name=_token]').val(),
            'category' : $slug,
            'page':  $page,
            'load':  'auto'
    };
	$.ajax({
        url: '/ajax/load-theme',
		type: 'POST',
        data: sendInfo,
		dataType:'html',
        beforeSend: function() {
			if($page>1){
				$('body,html').animate({
					scrollTop:$('#row_releated_theme_category').offset().top-40
				}, 800);
			}
            $('#row_releated_theme_category').html('<p class="tai">Đang tải dữ liệu..</p></p><div id="loader"></div>');
        },
        success:function(data) {
            $('#row_releated_theme_category').html(data);
        },
        complete: function(){
            $(".html5lightbox").html5lightbox();
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });
}
function Load_Releated_Cate_post($slug,$slug1,$page,e){
	var $=jQuery;
	e.preventDefault();
    $.ajax({
        type: 'post',
        url: '/ajax/load-post',
        data: {
            '_token': $('input[name=_token]').val(),
            'category_current' : $slug,
            'category_parent' : $slug1,
            'page':  $page,
            'load':  'auto'
        },
        dataType:"html",
        beforeSend: function() {
			if($page>1){
				$('body,html').animate({
					scrollTop:$('#row_releated_theme_category').offset().top-40
				}, 800);
			}
            $('#row_releated_theme_category').html('<p class="tai">Đang tải dữ liệu..</p></p><div id="loader"></div>');
        },
        success:function(data) {
            $('#row_releated_theme_category').html(data);
			//return false;
        },
        complete: function(){
            $(".html5lightbox").html5lightbox();
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });
	return false;
}
function addQuantityDetail(quan){
    var crQuan = $("#quantity").val()*1;
    var newQuan = crQuan+quan;
    if(newQuan<=0){
        newQuan =1;
    }
    $("#quantity").val(newQuan);
    $('#btn_cart_primary').attr('data-quantity',newQuan);
    $('#buy_now_single_button').attr('data-quantity', newQuan);
}
function fnScrollFixed(){
   var $=jQuery;
   
	var $scrollingDiv = $("#fixed_content_detail");
	var w= $(".main-container").width();
	var h= $(window).innerHeight() - $(".header3").height();
	var containerw = $(".container").width();
	var delta = (w-containerw)/2 ;
	var contentwidth =$("#fixed_content_detail").width() + 30;
	var ctheight = $(".main-container").height();
	var le = $("#singleProductImg").width() + delta;
	var $scrollingDiv = $("#fixed_content_detail");
	//console.log('width:'+$scrollingDiv.width());
    if (window.innerWidth > 767) {
		if($('#endfixed').length>0){
			var y = $(window).scrollTop(),
				maxY = $('#endfixed').offset().top,
				scrollHeight = $scrollingDiv.height();
			//console.log('Max:'+maxY+'Scroll:'+y+'height:'+scrollHeight);
			//debugger;
			if($(window).scrollTop() > 80){
				if((y + scrollHeight) >= maxY){
					//console.log('hieht:'+scrollHeight);
					$('#fixed_content_detail').css({top: maxY - (y + scrollHeight), position:'fixed', width: $scrollingDiv.width()});
				} else {
					$('#fixed_content_detail').css({top: 95, position:'fixed', width: $scrollingDiv.width()});
				}
			} else {
				$('#fixed_content_detail').css({position: 'static', width: '90%'});
			}
			if(y< (maxY-scrollHeight - 230) ){
				if(($(window).scrollTop())>0) {
					//$scrollingDiv.css({"marginTop": (($(window).scrollTop()) - 70) + "px"});
					//$scrollingDiv
					//.stop()
					//.animate({"marginTop": (($(window).scrollTop()) - 70) + "px"}, "slow" );
				}
				else{
					//$scrollingDiv.css({"marginTop": (($(window).scrollTop())) + "px"});
					//$scrollingDiv
					// .stop()
					// .animate({"marginTop": (($(window).scrollTop())) + "px"}, "slow" );
				}
			}
		}	
    } 
    return true;
}
function cartAction(action,product_code,quantity,variable) {
    var queryString = "";
    var token=jQuery('#token').val();
    if(token =='' || token === undefined){
        token=jQuery('meta[name="csrf-token"]').attr('content');
    }
    if(action != "") {
        switch(action) {
            case "add":
				//console.log(avariable);
                if (isEmpty(variable)){
                    queryString = '_token='+ token +'&action='+action+'&code='+ product_code+'&quantity='+quantity;
                }else{
                    queryString = '_token='+ token +'&action='+action+'&code='+ product_code+'&quantity='+quantity+'&variable='+JSON.stringify(variable);
                }
                //queryString = '_token='+ token +'&action='+action+'&code='+ product_code+'&quantity='+quantity+'&variable='+JSON.stringify(variable);
                break;
            case "remove":
                queryString = '_token='+ token +'&action='+action+'&code='+ product_code;
                break;
            case "update":
                if (typeof avariable === "undefined"){
                    queryString = '_token='+ token +'&action='+action+'&code='+ product_code+'&quantity='+quantity;
                }else{
                    queryString = '_token='+ token +'&action='+action+'&code='+ product_code+'&quantity='+quantity+'&variable='+JSON.stringify(variable);
                }

                break;
            case "empty":
                queryString = '_token='+token+'&action='+action;
                break;
        }
    }

    var arr = [];
    jQuery.ajax({
        url: "ajax/ajax_action_cart",
        data:queryString,
        type: "POST",
        datatype: 'json',
        success:function(result){
            arr = JSON.parse(result);
            if(arr['status']=='ok'){
                // alert('Thêm vào giỏ hàng thành công!');
                //location.reload();
                // $(".nav_login_resign_group_header .shopping-cart").addClass('cart_show');
                $('#modal_addtocart').modal('show');
                setTimeout(function(){ $('#modal_addtocart').modal('hide'); }, 2000);
            } else if(arr['status']=='limit') {
                alert('Bạn đã mua đủ số lượng sản phẩm của sự kiện lần này.');
            } else if(arr['status']=='outofstock'){
                alert('Vui lòng liên hệ để đặt hàng.');
            } else if(arr['status']=='needlogin'){
                alert('Bạn cần đăng nhập để mua sản phẩm này.');
                $('#myModal').modal('show');
            } else{
                alert(arr['status']);
                location.reload();
            }   
        },
        error:function (){}
    });
    setTimeout(function(){
        jQuery.ajax({
            url: "ajax/ajax_load_cart",
            type: "GET",
            datatype: 'html',
            success:function(result){
                $('.shopping-cart').html(result);
                var count_item_cart = $('.shopping-cart .basel-cart-number').html();
                console.log(count_item_cart);
                $('.icon_cart_mobi .basel-cart-number').html(count_item_cart);
            },
            error:function (){}
        });
    }, 1300);
}

function xemthongsoSize() {
    jQuery(".publicImageSize").toggleClass("hidden");
}
function xemthongsoSize2() {
    jQuery(".publicImageSize2").toggleClass("hidden");
}
function fnCheckColorSize(){

}
function alertView(title,alertText){
	var $=jQuery;
	 $.jAlert({
	  'title': title,
	  'content': alertText,
	  'theme': 'blue',
	  'closeOnClick': true,
	  'backgroundColor': 'white',
	  'btns': [
		{'text':'OK', 'theme':'blue'}
		 ]
	 });
}
function headerStyle(){
    var $=jQuery;
    if($('.main-header').length){
        var windowpos = $(window).scrollTop();
        if (windowpos >= 100) {
            //$('.main-header').addClass('fixed-header');
            $('#back-top').fadeIn(300);
        } else {
            //$('.main-header').removeClass('fixed-header');
            $('#back-top').fadeOut(300);
        }
    }
}
function addToWishList(id_product) {
    (function ($) {
        if (!islogin) {
            $('#myModal').modal('show');
            return false;
        }
        var sendInfo = {
            '_token': getMetaContentByName("_token"),
            'id_product': id_product,
          };
        $.ajax({
            url: site+'/ajax/post-to-wishlist',
            type: "POST",
            data: sendInfo,
            cache: false,
            success: function (html) {
                if (html == 1) {
                    alert('Đã thêm vào danh sách yêu thích.');
                    location.reload(true);
                } else {
                    alert('Đã xoá khỏi danh sách yêu thích.');
                    location.reload(true);
                }
            }
        });
        return false;
    })(jQuery);
}
function postRating(id_product) {
    (function ($) {
        if (!islogin) {
            $('#myModal').modal('show');
            return false;
        }
        var rating = $('input[name="ratings[1]"]:checked').val();
        if(isEmpty(rating)){
            return false;
        }
        var sendInfo = {
            '_token': getMetaContentByName("_token"),
            'id_product': id_product,
            'rating': rating,
          };
        $.ajax({
            url: site+'/customer/post-reviews',
            type: "POST",
            data: sendInfo,
            cache: false,
            success: function (html) {
                if (html == 1) {
                    alert('Cám ơn bạn đã đánh giá.');
                    location.reload(true);
                } else {
                    alert('Bạn đã đánh giá sản phẩm này.');
                }
            }
        });
        return false;
    })(jQuery);
}
function check_code_discount(){
    (function ($) {
        var arr = [];
        var code_discount = $('input[name="discount_code"]').val();
        var sendInfo = {
            '_token': getMetaContentByName("_token"),
            'code_discount': code_discount,
          };
        $.ajax({
            url: site+'/ajax/check-discount-code',
            type: "POST",
            data: sendInfo,
            cache: false,
            success: function (html) {
                if(html==0){
                    $('span.discount-error').html('Mã giảm giá không hợp lệ hoặc đã hết hạn.');
                } else if(html == -1){
                    $('span.discount-error').html('Mã giảm giá không áp dụng cho gói combo.');
                } else{
                    arr = JSON.parse(html);
                    $('span.discount-error').html('');
                    $('span.discount-success').html('Mã giảm giá đã áp dụng');
                    $('span#total_price_cart').html(arr['price_discount']+'(Chưa bao gồm phí giao hàng)');
                    $('span.price_discount').html('Giảm -'+arr['discount']);
                }
            }
        });
    })(jQuery);
}
function getMetaContentByName(name,content){
   var content = (content==null)?'content':content;
   return document.querySelector("meta[name='"+name+"']").getAttribute(content);
}
function isEmpty(obj) {
    for(var key in obj) {
        if(obj.hasOwnProperty(key))
            return false;
    }
    return true;
}
function formatNumber(nStr, decSeperate, groupSeperate){
    nStr += '';
    x = nStr.split(decSeperate);
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + groupSeperate + '$2');
    }
    return x1 + x2;
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