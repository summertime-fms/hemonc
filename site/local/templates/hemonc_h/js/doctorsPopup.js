function SelectDoctorPopup() {
    // $('.header__mobile').slideUp();

    // $(".doctors-popup-content").html($(".loading-block-hidden").html());
    // $(".doctors-popup-bg").fadeIn();

    $("#referenceDateModal").modal("show");
    $("#referenceDateModal .modal-content").html('<div class="floatingBarsG floatingBarsG-modal-default">' +
        '<div class="blockG rotateG_01"></div>' +
        '<div class="blockG rotateG_02"></div>' +
        '<div class="blockG rotateG_03"></div>' +
        '<div class="blockG rotateG_04"></div>' +
        '<div class="blockG rotateG_05"></div>' +
        '<div class="blockG rotateG_06"></div>' +
        '<div class="blockG rotateG_07"></div>' +
        '<div class="blockG rotateG_08"></div>' +
        '</div>');

    $.ajax({
        type: "POST",
        url: '/ajax/',
        data: {
            action: 'DoctorsSelectPopup',
            //doctorid: docId,
            //datetime: tData,
            //patient: pPhone
        },
        beforeSend: function () {
            //$("#referenceDateModal .floatingBarsG-form, #referenceDateModal .floatingBarsGBG-form").show();
            //$("#referenceDateModal .floatingBarsG-form, #referenceDateModal .floatingBarsGBG-form").animate({
            //        opacity: 1
            //    },
            //    400);

            //$(".set-time-block-load .floatingBarsG-time-load, .set-time-block-load .floatingBarsGBG-time-load").show();
            //$(".set-time-block-load .floatingBarsG-time-load, .set-time-block-load .floatingBarsGBG-time-load").animate({
            //    opacity: 1
            //}, 400);
        },
        success: function (data) {
            $("#referenceDateModal .modal-content").html('<div class="doctors-popup-content">' + data + '</div>');

            // $(".doctors-popup-content").html(data);
        },
        error: function (data) {
            console.error("error -> " + data);
        }
    });

    ym(37372215, 'reachGoal', 'doctors-form');
}

function CloseDoctorsPopup() {
    $("#referenceDateModal").modal("hide");
    $("#referenceDateModal .modal-content").html('<div class="floatingBarsG floatingBarsG-modal-default">' +
        '<div class="blockG rotateG_01"></div>' +
        '<div class="blockG rotateG_02"></div>' +
        '<div class="blockG rotateG_03"></div>' +
        '<div class="blockG rotateG_04"></div>' +
        '<div class="blockG rotateG_05"></div>' +
        '<div class="blockG rotateG_06"></div>' +
        '<div class="blockG rotateG_07"></div>' +
        '<div class="blockG rotateG_08"></div>' +
        '</div>');

    // $('.doctors-popup-bg').fadeOut();
    // $(".doctors-popup-content").html('');

    //$('.doctors-popup-bg').fadeTo("slow", 0,
    //    function (data) {
    //        $(".doctors-popup-content").html('');
    //        $('.doctors-popup-bg').fadeOut();
    //});
}

function ShowPersonalDoctorPopup(id) {
    // $('.header__mobile').slideUp();

    // CloseDoctorsPopup();    

    //var id = $(this).attr("data-id");
    $("#referenceDateModal").modal("show");
    $("#referenceDateModal .modal-content").html('<div class="floatingBarsG floatingBarsG-modal-default">' +
        '<div class="blockG rotateG_01"></div>' +
        '<div class="blockG rotateG_02"></div>' +
        '<div class="blockG rotateG_03"></div>' +
        '<div class="blockG rotateG_04"></div>' +
        '<div class="blockG rotateG_05"></div>' +
        '<div class="blockG rotateG_06"></div>' +
        '<div class="blockG rotateG_07"></div>' +
        '<div class="blockG rotateG_08"></div>' +
        '</div>');

    $.ajax({
        type: "POST",
        url: "/ajax/",
        data: {
            action: 'GetDoctor',
            doctorId: id
        },
        success: function (data) {
            $("#referenceDateModal .modal-content").html(data);
            $('input[type=tel]').mask('+7 (999) 999-99-99');
        },
        error: function (data) {
            alert("error");
        }
    });

    ym(37372215, 'reachGoal', 'doctor-form-' + id);
}

function ShowCallBackPopup() {
    // $('.header__mobile').slideUp();

    $("#referenceMailModal").modal("show");
    ym(37372215, 'reachGoal', 'callback-form');
}