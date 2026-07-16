// Константы
var BIG_WIDTH = 1199;
var MEDIUM_WIDTH = 767;
var SMALL_WIDTH = 320;

var ww = $(window).width();
var wh = window.innerHeight ? window.innerHeight : $(window).height();

(function ($) {
    var MODAL_POSITION_INNER = 'inner';
    var MODAL_POSITION_OUTER = 'outer';

    var modal_defaults = {
        closePos: MODAL_POSITION_INNER
    };

    var methods = {
        bindHref: function () {
            this.on('click', function (e) {
                $($(this).attr('href')).modal('show');
                e.preventDefault();
            });
        },
        bindData: function () {
            this.on('click', function (e) {
                $($(this).data('modal')).modal('show');
                e.preventDefault();
            });
        },
        show: function (modal) {
            // Ежели нам не дали в функцию модалку - пускай это будет текущий элемент
            if (modal == undefined)
                modal = this;

            // Проверим инициализацию модалки и если не инициализирована - создадим темплейт
            if (!modal.hasClass('modal-initialized')) {
                var $modalTemplate = $('<div class="modal modal-initialized"><div class="modal-container"><div class="modal-overlay"></div></div></div></div>');
                $modalTemplate.find('.modal-container').append(modal.detach());
                var $buttonClose = $('<button class="modal-close"></button>');
                if (modal_defaults.closePos === MODAL_POSITION_INNER)
                    modal.append($buttonClose);
                else
                    modal.parent().append($buttonClose);
                var id = modal.attr('id');
                modal.attr('id', '');
                $modalTemplate.attr('id',id);
                $('body').append($modalTemplate);

                modal = $modalTemplate.fadeIn();
            }

            // Делаем модалку видимой
            modal.addClass('visible');
            // Ищем кнопку закрытия модалки и подложку и вешаем на них событие закрытия модалки
            modal.find('.modal-close, .modal-overlay').click(function (event) {
                modal.modal('hide');
                event.preventDefault();
            });


            // Если высота окна меньше чем высота модалки то запрещаем скроллить html (модалка скроллится)
            if ($(window).height() < modal.find('.modal-container')["0"].clientHeight + 300) {
                $('html').addClass('modal-overflow');
            }

            modal.find('.slick-slider').slick('setPosition');
        },
        hide: function (modal) {
            if (modal == undefined)
                modal = this;

            if (!modal.hasClass('modal-initialized')) return;

            var ifr = modal.find('iframe');
            if(ifr.length){
                ifr.parent().append(ifr.detach());
            }

            var vid = modal.find('video');
            if(vid.length){
                vid.get(0).pause();
            }

            // Скрываем модалку
            modal.removeClass('visible');
            // Выключаем слушатели событий нажатия с кнопок и подложки
            modal.find('.modal-close, .modal-overlay').off();
            // Возвращаем возможность скроллинга html
            $('html').removeClass('modal-overflow');
        },
        getScrollbarWidth: function(){
            var documentWidth = parseInt(document.documentElement.clientWidth);
            var windowsWidth = parseInt(window.innerWidth);
            return windowsWidth - documentWidth;
        },
        setOption: function(opt){
            modal_defaults = $.extend(JSON.parse(JSON.stringify(modal_defaults)),opt);
        }
    };

    if($.insertRule != undefined){
        var sbw = methods.getScrollbarWidth();
        $.insertRule(['.modal-overflow'],'padding-right: '+sbw+'px;');
    }

    $.fn.modal = function (method) {
        // логика вызова метода
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else {
            $.error('Метод с именем ' + method + ' не существует для jQuery.modal');
        }
    };
})(jQuery);

$(function () {
    // Slick section
    if ($.fn.slick != undefined) {
        // Для добавления в слайдер счётчика слайдов.
        $('.slick-countered').on('init', function (e, slick) {
            $(this).append('<span class="slick-counter">' + ((slick.currentSlide + 1) + ' / ' + slick.$slides.length) + '</span>');
        }).on('beforeChange', function (e, slick, curr, next) {
            $(this).find('.slick-counter').html((next + 1) + ' / ' + (slick.$slides.length));
        });

        $('.slick-filtered').on('init',function(e, slick){
            var $me = $(slick.$slider);
            var $par = $me.parents('.slick-filter-block');
            var $buttons = $par.find('.slick-filter-nav button');
            $buttons.click(function(e){
                var flt = $(this).data('filter');
                slick.slickUnfilter();
                slick.slickFilter(flt);
                slick.slickGoTo(0);
                $(this).addClass('active').siblings().removeClass('active');

                e.preventDefault();
            });

            if($buttons.length > 0) $buttons.eq(0).trigger('click');
        });

        $('.recommend-block .img-slider').slick({
            infinite: true,
            centerMode: true,
            slidesToScroll: 1,
            slidesToShow: 1,
            variableWIdth: true,
            adaptiveHeight: false,
            dots: false,
            arrows: false,
            focusOnSelect: true,
            centerPadding: 0,
            speed: 300,
            autoplay: true,
            autoplaySpeed: 5000,
            asNavFor: '.recommend-block .txt-slider'
        });

        $('.recommend-block .txt-slider').slick({
            infinite: true,
            fade: true,
            dots: false,
            arrows: false,
            asNavFor: '.recommend-block .img-slider',
            adaptiveHeight: true
        });

        $('.reception-slider').slick({
            mobileFirst: true,
            infinite: false,
            dots: false,
            arrows: false,
            adaptiveHeight: false,
            variableWidth: true,
            slidesToShow: 1,
            //slidesToScroll: 1,
            swipeToSlide: true,
            responsive: [
                {
                    breakpoint: MEDIUM_WIDTH,
                    settings: {
                        slidesToShow: 4
                    }
                },{
                    breakpoint: BIG_WIDTH,
                    settings: {
                        slidesToShow: 4
                    }
                },
                {
                    breakpoint: 1216,
                    settings: {
                        slidesToShow: 5
                    }
                },
                {
                    breakpoint: 1360,
                    settings: {
                        slidesToShow: 6
                    }
                },
                {
                    breakpoint: 1520,
                    settings: {
                        slidesToShow: 7
                    }
                },
                {
                    breakpoint: 1680,
                    settings: {
                        slidesToShow: 8
                    }
                }
            ]
        });

        $('.image-slider-block-slider').slick({
            infinite: true,
            //slidesToShow: 3,
            slidesToScroll: 1,
            variableWidth: true,
            adaptiveHeight: false,
            dots: true,
            arrows: false,
            mobileFirst: true,
            responsive: [
                {
                    breakpoint: BIG_WIDTH,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 1359,
                    settings: {
                        slidesToShow: 3
                    }
                }
            ]
        });

        $('.our-features-slider').slick({
            infinite: true,
            dots: false,
            arrows: false,
            slidesToScroll: 1,
            variableWidth: false,
            adaptiveHeight: true
        });

        $('.doctor-services-price-slider').slick({
            infinite: false,
            dots: false,
            arrows: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            adaptiveHeight: true,
            variableWidth: false
        });

        $('.slick-slide').bind('touchstart', function(){ return true; });
    }

    if($.fn.masonry != undefined && ww > MEDIUM_WIDTH){
        $('.masonry').masonry({
            gutter: 16
        });
    }
});

function pagerLoadMore() {
    var targetContainer = $('#page_elements_container'),
        url =  $('.load_more').attr('data-url');
    if (url !== undefined) {
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'html',
            success: function(data){
                $('.load_more').remove();
                var elements = $(data).find('#page_elements_item'),
                    pagination = $(data).find('.load_more');
                targetContainer.append(elements);
                targetContainer.append(pagination);

                $('.masonry').masonry('reloadItems');
                $('.masonry').masonry({
                    gutter: 16
                });
            }
        })
    }
}

function onWindowScroll() {
    if (screen.width > 500 || $('#mobile-maps').length === 0) {
        return;
    }

    var posY = $('#mobile-maps').position().top;
    if ($(window).scrollTop() > posY - 500) {
        if ($('#mobile-maps').data('ready') === false) {
            $('#mobile-maps').data('ready', true);
            $('iframe#ma').attr('src', 'https://yandex.ru/map-widget/v1/?um=constructor%3Aeb79d98a19062654c6a21bd567f728f8b1851938916f13191ba073c212c8d65a&amp;source=constructor');
            $('iframe#mb').attr('src', 'https://yandex.ru/map-widget/v1/?um=constructor%3A9aba82a32d146e5f78c4a1e6bc5bfaa0a0f90d93a607d638f2cb783ec5ea6579&amp;source=constructor');
            $('iframe#mc').attr('src', 'https://yandex.ru/map-widget/v1/?um=constructor%3Adb1285349e2bad73e9fa9bccb876282d00dde124a5fd7f91504ed1c5fc283645&amp;source=constructor');
            $('iframe#md').attr('src', 'https://yandex.ru/map-widget/v1/?um=constructor%3Ad76ac9028edcb4d68f5014fee6fbc32b9f75b382a1d7ed29bab553aa58e3bf04&amp;source=constructor');
        }
    }
}

$(document).ready(function () {
    if ($('.slick-slider').length > 0) {
        $('.slick-slider').fadeIn();
    }

    // $(window).scroll(function () {
    //     onWindowScroll();
    // });

    checkCookiesInfo();

    $('.header__desc-burger').click(function() {
        $(this).toggleClass('active');
        $('.header__submenu').slideToggle();
        $('.serivce__navigation').toggleClass('--hidden');
    })

    $('.header__burger').click(function() {
        $('.header__mobile').slideToggle();
        $(this).toggleClass('active')
        return false;
    })

    $('.header__mobile-toggler-text').click(function() {
        $(this).parent().next().slideToggle();
    })

    $('.header__mobile-toggler').click(function() {
        $(this).parent().next().slideToggle();
    })
});
