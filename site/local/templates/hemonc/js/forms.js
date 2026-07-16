$(function() {
    $('.main-block-load-header-contacts .callback-form-data').submit(function(e) {
        e.preventDefault();
        var data = $(".main-block-load-header-contacts .callback-form-data").serializeArray();
        var phone;
        for (var item in data) {
            if (data[item].name == "phone") {
                phone = data[item].value;
            }
        }
        $.ajax({
            type: "POST",
            url: "/ajax/",
            data: {
                action: 'form',
                Title: "Обратный звонок",
                Phone: phone,
            },
            beforeSend: function() {
                $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").show();
                $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").animate({
                    opacity: 1
                }, 400);
            },
            success: function(data) {
                $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").animate({
                    opacity: 1
                }, 250, function() {
                    $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").hide();
                    $(".main-block-load-header-contacts")
                        .html(
                            "<div class=\"success-form\">" +
                            "<h2 style=\"font-size:16px;\">Заявка отправлена! Администратор свяжется с вами, чтобы подтвердить её.</h2>" +
                            "</div>");
                });

                SendCalltouchRequestByGet(phone, 'Запрос обратного звонка с сайта КДЛ', '1');
                ym(37372215, 'reachGoal', 'callback-form');
            },
            error: function(data) {
                alert("error");
            }
        });
    });

    $('.main-block-load-bottom-contacts .callback-form-data').submit(function (e) {
        e.preventDefault();
        var data = $(".main-block-load-bottom-contacts .callback-form-data").serializeArray();
        var phone;
        for (var item in data) {
            if (data[item].name == "phone") {
                phone = data[item].value;
            }
        }
        $.ajax({
            type: "POST",
            url: "/ajax/",
            data: {
                action: 'form',
                Title: "Обратный звонок",
                Phone: phone,
            },
            beforeSend: function () {
                $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").show();
                $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").animate({
                    opacity: 1
                }, 400);
            },
            success: function (data) {
                $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").animate({
                    opacity: 1
                }, 250, function() {
                    $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").hide();
                    $(".main-block-load-bottom-contacts")
                        .html(
                            "<div class=\"success-form\">" +
                            "<h2  style=\"font-size:16px;\">Заявка отправлена! Администратор свяжется с вами, чтобы подтвердить её.</h2>" +
                            "</div>");
                });

                SendCalltouchRequestByGet(phone, 'Запрос обратного звонка с сайта КДЛ', '2');
                ym(37372215, 'reachGoal', 'callback-form');
            },
            error: function (data) {
                alert("error");
            }
        });
    });

    $('.main-block-load-page-header-contacts-popup-contacts .callback-form-data').submit(function (e) {
        e.preventDefault();
        var data = $(".main-block-load-page-header-contacts-popup-contacts .callback-form-data").serializeArray();
        var phone;
        for (var item in data) {
            if (data[item].name == "phone") {
                phone = data[item].value;
            }
        }
        $.ajax({
            type: "POST",
            url: "/ajax/",
            data: {
                action: 'form',
                Title: "Обратный звонок",
                Phone: phone,
            },
            beforeSend: function () {
                $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").show();
                $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").animate({
                    opacity: 1
                }, 400);
            },
            success: function (data) {
                $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").animate({
                    opacity: 1
                }, 250, function () {
                    $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").hide();
                    $(".main-block-load-page-header-contacts-popup-contacts")
                        .html(
                            "<div class=\"success-form\">" +
                            "<h2  style=\"font-size:16px;\">Заявка отправлена! Администратор свяжется с вами, чтобы подтвердить её.</h2>" +
                            "</div>");
                });

                SendCalltouchRequestByGet(phone, 'Запрос обратного звонка с сайта КДЛ', '3');
                ym(37372215, 'reachGoal', 'callback-form');
            },
            error: function (data) {
                alert("error");
            }
        });
    });

    $('.main-block-load-reference-contacts .callback-form-data').submit(function (e) {
        e.preventDefault();
        var data = $(".main-block-load-reference-contacts .callback-form-data").serializeArray();
        var phone;
        for (var item in data) {
            if (data[item].name == "phone") {
                phone = data[item].value;
            }
        }
        $.ajax({
            type: "POST",
            url: "/ajax/",
            data: {
                action: 'form',
                Title: "Справка",
                Phone: phone,
            },
            beforeSend: function () {
                $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").show();
                $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").animate({
                    opacity: 1
                }, 400);
            },
            success: function (data) {
                $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").animate({
                    opacity: 1
                }, 250, function () {
                    $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").hide();
                    $(".main-block-load-reference-contacts")
                        .html(
                            "<div class=\"success-form\">" +
                            "<h2 style=\"font-size:16px;\">Заявка отправлена! Администратор свяжется с вами, чтобы подтвердить её.</h2>" +
                            "</div>");
                });

                SendCalltouchRequestByGet(phone, 'Запрос обратного звонка с сайта КДЛ', '4');
                ym(37372215, 'reachGoal', 'callback-form');
            },
            error: function (data) {
                alert("error");
            }
        });
    });

    $('.main-block-load-page-contact-contacts .callback-form-data').submit(function (e) {
        e.preventDefault();
        var data = $(".main-block-load-page-contact-contacts .callback-form-data").serializeArray();
        var phone;
        for (var item in data) {
            if (data[item].name == "phone") {
                phone = data[item].value;
            }
        }
        $.ajax({
            type: "POST",
            url: "/ajax/",
            data: {
                action: 'form',
                Title: "Страницы контакты",
                Phone: phone,
            },
            beforeSend: function () {
                $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").show();
                $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").animate({
                    opacity: 1
                }, 400);
            },
            success: function (data) {
                $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").animate({
                    opacity: 1
                }, 250, function () {
                    $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").hide();
                    $(".main-block-load-page-contact-contacts")
                        .html(
                            "<div class=\"success-form\">" +
                            "<h2 style=\"font-size:16px;\">Заявка отправлена! Администратор свяжется с вами, чтобы подтвердить её.</h2>" +
                            "</div>");
                });

                SendCalltouchRequestByGet(phone, 'Запрос обратного звонка с сайта КДЛ', '5');
                ym(37372215, 'reachGoal', 'callback-form');
            },
            error: function (data) {
                alert("error");
            }
        });
    });

    $('.contacts-main-address .callback-form-data').submit(function (e) {
        e.preventDefault();
        var data = $(".contacts-main-address .callback-form-data").serializeArray();
        var phone;
        for (var item in data) {
            if (data[item].name == "phone") {
                phone = data[item].value;
            }
        }
        $.ajax({
            type: "POST",
            url: "/ajax/",
            data: {
                action: 'form',
                Title: "Страницы контакты",
                Phone: phone,
            },
            beforeSend: function () {
                $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").show();
                $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").animate({
                    opacity: 1
                }, 400);
            },
            success: function (data) {
                $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").animate({
                    opacity: 1
                }, 250, function () {
                    $(".main-block-load .floatingBarsG, .main-block-load .floatingBarsGBG").hide();
                    $(".callback-phone")
                        .html(
                            "<div class=\"success-form\">" +
                            "<h2 style=\"font-size:16px;\">Заявка отправлена! Администратор свяжется с вами, чтобы подтвердить её.</h2>" +
                            "</div>");
                });

                SendCalltouchRequestByGet(phone, 'Запрос обратного звонка с сайта КДЛ', '6');
            },
            error: function (data) {
                alert("error");
            }
        });
    });

    // $(".show-modal-order-reference-date-modal").click(function () {
    //     var id = $(this).attr("data-id");
    //     ShowPersonalDoctorPopup(id);
    //     $("#referenceDateModal").modal("show");
    //     $("#referenceDateModal .modal-content").html('<div class="floatingBarsG floatingBarsG-modal-default">' +
    //         '<div class="blockG rotateG_01"></div>' +
    //         '<div class="blockG rotateG_02"></div>' +
    //         '<div class="blockG rotateG_03"></div>' +
    //         '<div class="blockG rotateG_04"></div>' +
    //         '<div class="blockG rotateG_05"></div>' +
    //         '<div class="blockG rotateG_06"></div>' +
    //         '<div class="blockG rotateG_07"></div>' +
    //         '<div class="blockG rotateG_08"></div>' +
    //         '</div>');
    //     $.ajax({
    //         type: "POST",
    //         url: "/ajax/",
    //         data: {
    //             action: 'GetDoctor',
    //             idDoctor: id,
    //             doctorId: id,
    //         },
    //         success: function (data) {
    //             $("#referenceDateModal .modal-content").html(data);
    //             $('input[type=tel]').mask('+7 (999) 999-99-99');
    //         },
    //         error: function (data) {
    //             alert("error");
    //         }
    //     });
    // });

    // $(".reception-doctor-item-ajax").click(function () {
    //     var id = $(this).attr("data-id");
    //     var formT = $(this).attr("data-type");
    //     var srvPrive = $(this).attr("data-price");

    //     $(".set-time-block-load").html('<div class="floatingBarsGBG floatingBarsGBG-form" style="display: block; opacity: 1;"></div>' +
    //         '<div class="floatingBarsG floatingBarsG-form" style="display: block; opacity: 1; float: none;">' +
    //         '<div class="blockG rotateG_01"></div>' +
    //         '<div class="blockG rotateG_02"></div>' +
    //         '<div class="blockG rotateG_03"></div>' +
    //         '<div class="blockG rotateG_04"></div>' +
    //         '<div class="blockG rotateG_05"></div>' +
    //         '<div class="blockG rotateG_06"></div>' +
    //         '<div class="blockG rotateG_07"></div>' +
    //         '<div class="blockG rotateG_08"></div>' +
    //         '</div>');
    //     $.ajax({
    //         type: "POST",
    //         url: "/ajax/",
    //         data: {
    //             action: 'GetDoctor',
    //             idDoctor: id,
    //             doctorId: id,
    //             inline: true,
    //             // price: srvPrive
    //         },
    //         success: function (data) {
    //             $(".set-time-block-load").html(data);
    //             //$('input[type=tel]').mask('+7 (999) 999-99-99');
    //         },
    //         error: function (data) {
    //             alert("error");
    //         }
    //     });
    // });
});