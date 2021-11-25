jQuery(document).ready(function ($) {

	// Открыть мобильное меню
	$('#burger-menu').click(function () {
		$('.header-menu').css('transform', 'translate(0, 0)');
		$('.overlay').show();
	});

	// Закрыть мобильное меню
	$('#menu-close').click(function () {
		$('.header-menu').css('transform', 'translate(-260px, 0)');
		$('.overlay').hide();
	});

	$(document).mouseup(function (e) {
		var modal = $('.header-menu');
		var reviews = $('.revies-form');
		var cart = $('.cart-missing');
		var street = $('.cart-delivery');
		var overlay = $('.overlay');
		if (overlay.is(':visible')) {
			if (!modal.is(e.target) && modal.has(e.target).length === 0 && !reviews.is(e.target) && reviews.has(e.target).length === 0 && !cart.is(e.target) && cart.has(e.target).length === 0 && !street.is(e.target) && street.has(e.target).length === 0) {
				modal.css('transform', 'translate(-260px, 0)');
				reviews.hide();
				cart.hide();
                street.hide();
				$('.overlay').hide();
			}
		}
	});



	// Стили для select

	$('#sort').niceSelect();
	//$('#product-qnt').niceSelect();

	// Вид для товаров (list-grid)

	$('.btn-grid').click(function (e) {
		e.preventDefault();
		var items = $('.product-item');
		items.each(function (index, el) {
			$(this).addClass('product-grid');
		});
		$('.btn-list').removeClass('active');
		$(this).addClass('active');
	});

	$('.btn-list').click(function (e) {
		e.preventDefault();
		var items = $('.product-item');
		items.each(function (index, el) {
			$(this).removeClass('product-grid');
		});
		$('.btn-grid').removeClass('active');
		$(this).addClass('active');
	});

	// Страница товара
	// Табы

	$(function () {
		var tab = $('#tabs .tabs-items > div');
		tab.hide().filter(':first').show();

		// Клики по вкладкам.
		$('#tabs .tabs-nav a').click(function () {
			tab.hide();
			tab.filter(this.hash).show();
			$('#tabs .tabs-nav a').removeClass('active');
			$(this).addClass('active');
			return false;
		}).filter(':first').click();

		// Клики по якорным ссылкам.
		$('.tabs-target').click(function () {
			$('#tabs .tabs-nav a[href=' + $(this).data('id') + ']').click();
		});
	});

	// Написать отзыв

	$('#add-review').click(function () {
		$('.revies-form').show();
		$('.overlay').show();
	});

	$('.revies-form__close').click(function () {
		$('.revies-form').hide();
		$('.overlay').hide();
	});

	// Отсутствие товара

	$('.cart-missing__close').click(function () {
		$('.cart-missing').hide();
		$('.overlay').hide();
	});

    $('.cart-delivery__close').click(function () {
        $('.cart-delivery').hide();
        $('.overlay').hide();
    });

	// $('.favorit-item__btn span').click(function (e) {
	// 	e.preventDefault();
	// 	$('.add-block').show();
	// 	$('.overlay').show();
	// 	setTimeout(function () {
	// 		$('.add-block').hide();
	// 		$('.overlay').hide();
	// 	}, 1250);
	// });

    $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results==null){
            return null;
        }
        else{
            return decodeURI(results[1]) || 0;
        }
    };

    $('.best-addCart').click(function (event){
        event.preventDefault();
        $.ajax({
            url: $(this).attr('data-href'),
            success: function(data) {
                cartCount();
                $('.add-block').show();
                $('.overlay').show();
                setTimeout(function () {
                    $('.add-block').hide();
                    $('.overlay').hide();
                }, 1250);
            }
        });
        return false; //for good measure
    });

});
