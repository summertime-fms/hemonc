var isPost = false;

function initDoctorDialog(docId, clnId, isModal) {
    //$(".modal-close").click(function () {
    //    $(".popup-fixed-container").removeClass("v-visible");
    //});

    $('.reception-form-data').submit(function (e) {
        e.preventDefault();

        $(".reception-form-data button").attr("disabled", "disabled");

        var pPhone = $("#phone").val();
        var tData = $('#totalData').val();
        var docName = $('#doctorName').val(); 
        
        if (docId !== '' && tData !== '' && pPhone !== '' && pPhone.length >= 10
            //&& document.getElementById('chk-confirm').checked
        ) {

            $.ajax({
                type: "POST",
                url: "/ajax/",
                data: {
                    action: 'SetOrder',
                    doctorid: docId,
                    clinicId: clnId,
                    datetime: tData,
                    patient: pPhone
                },
                beforeSend: function () {
                    $("#referenceDateModal .floatingBarsG-form, #referenceDateModal .floatingBarsGBG-form").show();
                    $("#referenceDateModal .floatingBarsG-form, #referenceDateModal .floatingBarsGBG-form").animate({
                        opacity: 1
                    },
                        400);

                    $(".set-time-block-load .floatingBarsG-time-load, .set-time-block-load .floatingBarsGBG-time-load").show();
                    $(".set-time-block-load .floatingBarsG-time-load, .set-time-block-load .floatingBarsGBG-time-load").animate({
                        opacity: 1
                    }, 400);

                },
                
                success: function (data) {
                    if (isModal !== null && isModal !== undefined && isModal) {
                        onModalSuccess(data);
                    } else {
                        onInlineSuccess(data);
                    }

                    SendCalltouchRequest(pPhone, 'Запись на прием с сайта КДЛ', '[' + tData + '] doctor : ' + docName);
                    ym(37372215, 'reachGoal', 'Запись на прием');
                },


                error: function (data) {
                    console.error("error -> " + data);
                }
            });
        }
    });

    if ($.fn.mask != undefined) {
        $('input[type=tel]').mask('+7 (999) 999-99-99');
    }

    $('.reception-form-data').data('docid', docId);

    document.getElementById('phone').addEventListener("keyup", function () { CheckDoctorForm(); });
    //document.getElementById('chk-confirm').addEventListener("click", function () { CheckDoctorForm() });
}

function scrollMonthPrev() {

    $('.dnc-calendar__months-list').css('left', '0');
};

function scrollMonthNext() {

    $('.dnc-calendar__months-list').css('left', '-150%');
};

function selectDay(ctrl) {

    if ($(ctrl).data('enabled') === "enabled") {

        $('.dnc-calendar__day--selected').removeClass('dnc-calendar__day--selected');
        $(ctrl).addClass('dnc-calendar__day--selected');

        $(".reception-form-data button").attr("disabled", "disabled");
        
        
        $(".floatingBarsGBG-time, .floatingBarsG-time, .disable-calc").show();
        $(".floatingBarsGBG-time, .floatingBarsG-time").stop().animate({ opacity: 1 }, 400);


        $('.dnc-time-select__hour--selected').data('timedisplay', '');
        $('.dnc-time-select__hour--selected').data('time', '');

        updateDateTimeDisplay();
        
        var date = $(ctrl).data('date');
        var id = $('.reception-form-data').data('docid');
        var umbrId = $('.reception-form-data').data('umbrdocid');

        if (!isPost) {

            isPost = true;
            
            try {
                $.ajax({
                    type: "POST",
                    url: "/ajax/",
                    data: {
                        action: 'GetHours',
                        doctorID: id,
                        idDoctor: umbrId,
                        date: date
                    },
                    success: function(data) {
                        isPost = false;
                        
                        //$('.lds-spinner-back').css('opacity', 0);
                        //window.setTimeout(function () {
                        //    $('.lds-spinner-back').css('visibility', 'hidden');
                        //}, 550);

                        $('.dnc-time-container').html(data);

                        $(".floatingBarsGBG-time, .floatingBarsG-time").stop().animate({
                                opacity: 0
                            },
                            400,
                            function() {
                                $(".floatingBarsGBG-time, .floatingBarsG-time, .disable-calc").hide();
                            });
                    },
                    error: function() {
                        isPost = false;
                        
                        $(".floatingBarsGBG-time, .floatingBarsG-time").stop().animate({
                                opacity: 0
                            },
                            400,
                            function() {
                                $(".floatingBarsGBG-time, .floatingBarsG-time, .disable-calc").hide();
                            });
                    }
                });
            } catch (err) {
                $("#err").html(err);
            }
        }
    }
}

function selectHour(ctrl) {

    if ($(ctrl).data('enabled') === "enabled") {

        $('.dnc-time-select__hour--selected').removeClass('dnc-time-select__hour--selected');
        $(ctrl).addClass('dnc-time-select__hour--selected');

        updateDateTimeDisplay();
        CheckDoctorForm();
    }
}

function updateDateTimeDisplay() {

    var dateCtrl = $('.dnc-calendar__day--selected');
    var timeCtrl = $('.dnc-time-select__hour--selected');

    var dateSel = dateCtrl.length > 0 ? dateCtrl.data('datedisplay') : "";
    var timeSel = timeCtrl.length > 0 ? timeCtrl.data('timedisplay') : "";

    var datecode = dateCtrl.length > 0 ? dateCtrl.data('date') : "";
    var timecode = timeCtrl.length > 0 ? timeCtrl.data('time') : "";

    $("#priem-day").html(dateSel);
    $('#priem-time').html(timeSel);

    $(".result-date-time-order").html(dateSel + ", " + timeSel);
    $('.doctor-record-success__date').html(dateSel + " в " + timeSel);

    var td = datecode + "" + timecode;

    $('.dnc-calendar').data('total', td);

    $('#totalData').val(td);
    
    CheckDoctorForm();
}

function CleanPhone(phone) {
    
    if (phone === null || phone === undefined || phone === "")
        return "";

    phone = phone.split("+").join("")
        .split("+").join("")
        .split("-").join("")
        .split("(").join("")
        .split(")").join("")
        .split("_").join("")
        .split(" ").join("");

    return phone;
}

function CheckPhoneNumber(id) {

    var pPhone = CleanPhone(document.getElementById(id).value); // $("#" + id).val();
    return (pPhone !== '' && pPhone.length >= 11);
}

function CheckDoctorForm() {

    var dateCtrl = $('.dnc-calendar__day--selected');
    var timeCtrl = $('.dnc-time-select__hour--selected');

    var dateSel = dateCtrl.length > 0 ? dateCtrl.data('datedisplay') : "";
    var timeSel = timeCtrl.length > 0 ? timeCtrl.data('timedisplay') : "";
    
    var totalData = $('.dnc-calendar').data('total'); 
    var pPhone = CleanPhone($('#phone').val());
    
    if (totalData !== '' && totalData.length > 10 && pPhone !== '' && pPhone.length >= 11
    ) {
        $(".reception-form-data button").removeAttr("disabled");
    } else {
        $(".reception-form-data button").attr("disabled", "disabled");
    }
}

function CheckCallbackDoctorForm() {

    var pPhone = CleanPhone(document.getElementById("phone").value);

    if (pPhone !== '' && pPhone.length >= 11) {
        $(".reception-form-data button").removeAttr("disabled");
    } else {
        $(".reception-form-data button").attr("disabled", "disabled");
    }
}

// function CheckCallbackForm() {

//     var pPhone = CleanPhone(document.getElementById("phone-clb").value);

//     if (pPhone !== '' && pPhone.length >= 11) {
//         $(".callback-phone button").removeAttr("disabled");
//         console.log(" -> Callback enabled");
//     } else {
//         $(".callback-phone button").attr("disabled", "disabled");
//         console.log(" -> Callback disabled");
//     }
// }

function onModalSuccess(data) {

    $("#referenceDateModal .floatingBarsG-form, #referenceDateModal .floatingBarsGBG-form").animate({
        opacity: 0
    }, 250, function () {
        $("#referenceDateModal .floatingBarsG-form, #referenceDateModal .floatingBarsGBG-form").hide();

        if (data === "Ok") {
            $(".set-time-block").html(
                "<div class=\"success-form\">" +
                "<h2>Заявка отправлена! Администратор свяжется с вами, чтобы подтвердить её.</h2>" +
                "</div>");
        } else {
            $(".set-time-block").html(
                "<div class=\"success-form\" style=\"color: red !important;\">" +
                "<h2>Ошибка при записи!<br/>Пожалуйста, позвоните или напишите в чат, и администраторы вас запишут.</h2 > " +
                "</div>");
        }
    });
}

function onInlineSuccess(data) {

    $(".set-time-block-load .floatingBarsG-time-load, .set-time-block-load .floatingBarsGBG-time-load").animate({
        opacity: 0
    }, 250, function () {
        $(".set-time-block-load .floatingBarsG-time-load, .set-time-block-load .floatingBarsGBG-time-load").hide();

        if (data === "Ok") {
            $(".set-time-block-load").html(
                "<div class=\"success-form\">" +
                "<h2>Заявка отправлена! Администратор свяжется с вами, чтобы подтвердить её.</h2>" +
                "</div>");
        } else {
            $(".set-time-block-load").html(
                "<div class=\"success-form\" style=\"color: red !important;\">" +
                "<h2>Ошибка при записи!<br/>Пожалуйста, позвоните или напишите в чат, и администраторы вас запишут.</h2>" +
                "</div>");
        }
    });
}

function checkPhoneKey(key) {
    return (key >= '0' && key <= '9') || key == '+' || key == '(' || key == ')' || key == '-' ||
            key == 'ArrowLeft' || key == 'ArrowRight' || key == 'Delete' || key == 'Backspace';
}