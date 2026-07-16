// Константы
var BIG_WIDTH = 1199;
var MEDIUM_WIDTH = 767;
var SMALL_WIDTH = 320;

// Убери лишние 2 слеша чтобы подключить модуль
////=require components/insertRule.js
////=require components/double_tap.js
/**
 * Модальное окно
 * Показать: $(modal_selector).modal('show');
 * Скрыть: $(modal_selector).modal('hide');
 * Забиндить по нажатию на ссылку по href: $(link_selector).modal('bindHref');
 * Забиндить по нажатию на ссылку по data: $(link_selector).modal('bindData');
 */

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
            if ($(window).height() < modal.find('.modal-container')["0"].clientHeight) {
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
////=require components/accordion.js
/**
 * Модуль табов
 */

(function ($) {
    $.fn.tabs = function () {
        this.each(function(i,v){
            var $tabRoot = $(v);
            var $tabNav = $tabRoot.children('.tabs-nav');
            var $tabCont = $tabRoot.children('.tabs-container');
            var btns = $tabNav.children();
            var tabs = $tabCont.children('.tabs-item');
            if(btns.length == 0 || tabs.length == 0) return;

            btns.eq(0).addClass('active');
            tabs.eq(0).addClass('active');
            btns.click(function(e){
                btns.removeClass('active');
                tabs.removeClass('active').fadeOut();
                var ind = $(this).index();
                btns.eq(ind).addClass('active');
                tabs.eq(ind).fadeIn(200).addClass('active');
            });
        });
    }
})(jQuery);
////=require components/parallax.js
////=require components/select.js
////=require components/anim.js
/**
 * Модуль плавающего хедера с функцией "показать/скрыть" при прокрутке
 */

(function ($) {
    var lst = 0;
    var defaults = {
        offset: 60, // Расстояние от верха страницы до хедера, с которого отключается фиксация.
        offFrom: 0 // Выключать фиксацию хедера начиная (исключая) с этого значения. 0 - не выключать (MobileFirst)
    };

    $.fn.floatHeader = function(opt){
        var options = $.extend(JSON.parse(JSON.stringify(defaults)), opt);
        var $hdr = this;
        var offset = $hdr.height() + options.offset;
        var $win = $(window);
        var ww = $win.width();

        $win.scroll(function(e){
            if(options.offFrom > 0 && ww <= options.offFrom || options.offFrom == 0){
                var st = $win.scrollTop();
                var delta = lst - st;

                if (st > offset) {
                    $hdr.addClass('fix');
                } else {
                    $hdr.removeClass('fix up down');
                }

                if ($hdr.hasClass('fix')) {
                    if (delta > 0) {
                        $hdr.removeClass('down').addClass('up');

                        if ($(this).scrollTop() < $hdr.height() + offset) {
                            $hdr.removeClass('up').addClass('down');
                        }
                    } else if (delta < 0 && $hdr.hasClass('up')) {
                        $hdr.removeClass('up').addClass('down');
                    }
                }

                lst = st;
            }
        });

        return this;
    }
})(jQuery);
////=require components/tooltip.js
////=require components/inputFile.js

var ww = $(window).width();
var wh = window.innerHeight ? window.innerHeight : $(window).height();

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

        $('.calculation-slider').slick({
            mobileFirst: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: false,
            infinite: false,
            variableWidth: false,
            adaptiveHeight: false,
            edgeFriction: 0,
            responsive: [
                {
                    breakpoint: MEDIUM_WIDTH,
                    settings: {
                        slidesToShow: 3
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

    //if ($.fn.mask != undefined) {
    //    $('input[type=tel]').mask('+7 (999) 999-99-99');
    //}

    if($.fn.datetimepicker != undefined){
        $('[data-datetimepicker]').each(function(i,v){
            var $me = $(v);
            $me.datetimepicker($me.data('datetimepicker'));
        });
    }

    var $ph = $('.page-header');
    $ph.floatHeader();

    $ph.find('.burger').click(function (e) {
        $('.page-header-popup').removeClass('visible');

        if (!$ph.hasClass('expanded')) {
            $('.page-header-menu').addClass('visible');
            $ph.addClass('expanded');
            $('html').css({overflow: 'hidden'});
        } else {
            $ph.removeClass('expanded');
            $('html').css({overflow: ''});
        }

        e.preventDefault();
    });

    $ph.find('button.tel').click(function (e) {
        $('.page-header-popup').removeClass('visible');
        $('.page-header-contacts').addClass('visible');
        $ph.addClass('expanded');
        $('html').css({
            overflow: 'hidden'
        });

        e.preventDefault();
    });

    $('.tabs').tabs();

    $('.vertical-tabs-block .trigger').click(function(e){
        var $me = $(this).parents('li');

        $me.addClass('selected').siblings().removeClass('selected');
        $me.parents('ol').css({
            minHeight: $me.children('ul').outerHeight()
        });
    });

    $('.vertical-tabs-block .selected .trigger').trigger('click');

    var $recBlock = $('.reception-block');
    if($recBlock.length){
        var $recSlid = $recBlock.find('.reception-slider');
        var $setTime = $recBlock.find('.set-time-block');

        // $recSlid.find('.reception-doctor-item').click(function(e){
        //     $recSlid.removeClass('visible').css({display: ''});
        //     $setTime.fadeIn(200).addClass('visible');
        //     e.preventDefault();
        // });

        // $setTime.find('.reception-doctor-item .sel').click(function(e){
        //     $setTime.removeClass('visible').css({display: ''});
        //     $recSlid.fadeIn(200).addClass('visible');
        // });
    }

    var $fltrs = $('.blog-themes-list-nav li');
    if($fltrs.length > 0){
        var $itms = $('.blog-themes-list-content > *');

        $fltrs.click(function(e){
            var $me = $(this);
            var dat = $me.data('filter');

            if(dat != undefined){
                $itms.fadeOut(100);
                setTimeout(function(){
                    $itms.filter(dat).fadeIn(100);
                },100);
            }else{
                $itms.fadeIn(100);
            }

            $fltrs.removeClass('active');
            $me.addClass('active');
        });
    }

    if($.fn.masonry != undefined && ww > MEDIUM_WIDTH){
        $('.masonry').masonry({
            gutter: 16
        });
    }

    $('.hide-after').click(function(e){
        $(this).detach();
        e.preventDefault();
    });

    // $('.accordion').accordion({doubleClickTo: MEDIUM_WIDTH});
    $('[data-modal]').modal('bindData');

    // Поддержка встроенных свг для IE. Должна быть после всех скриптов
    // if (navigator.userAgent.match(/Trident\/7.0/i)) {
    //     var spriteSheetName = "svg-symbols.svg";
    //
    //     //(function (doc) {
    //     var xhr = new XMLHttpRequest();
    //     xhr.onload = function () {
    //         var body = document.getElementsByTagName('body')[0];
    //         var div = document.createElement('div');
    //         div.style.display = 'none';
    //         div.innerHTML = this.responseText;
    //         body.appendChild(div);
    //     };
    //     xhr.open('get', 'assets/images/' + spriteSheetName, true);
    //     xhr.send();
    //
    //     var svgs = document.getElementsByTagNameNS('http://www.w3.org/2000/svg', 'use');
    //
    //     try {
    //         for (var v in svgs) {
    //             svgs[v].setAttributeNS('http://www.w3.org/1999/xlink', 'href', '#' + svgs[v].getAttributeNS('http://www.w3.org/1999/xlink', 'href').split('#')[1]);
    //         }
    //     } catch (er) {
    //         console.log(er.message);
    //     }
    // }
});

function CommonForm($scope, $http, url, callback) {
    return function () {
        $scope.submitProcess = true;
        $http.post(url, $scope.model)
            .then(function (resp) {
                $scope.resp = resp.data;
                $scope.submitProcess = false;
                if (callback) {
                    callback();
                }
            });
    }
}

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