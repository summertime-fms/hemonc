<style>
    .hemonc2__callback {
        padding: 5rem 0;
        background: #F4FDFF;
    }

    @media screen and (max-width: 768px) {
    .hemonc2__callback {
            padding: 2rem 0;
        }
    }

    .hemonc2__callback-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8rem;
    }

    @media screen and (max-width: 768px) {
    .hemonc2__callback-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
    }

    .hemonc2__callback-title {
        color: var(--h, #0F2531);
        font-family: 'Gerbera', sans-serif;
        font-size: 2rem;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    @media screen and (max-width: 768px) {
    .hemonc2__callback-title {
            font-size: 1.5rem;
        }
    }

    .hemonc2__callback-form {
        margin-top: 2rem;
    }

    .hemonc2__callback-wrapper {
        position: relative;
        margin-bottom: .62rem;
    }

    .hemonc2__callback-wrapper input, .hemonc2__callback-type {
        padding: .75rem 1rem;
        background: var(--white, #FFF);
        box-shadow: 0px 4px 24px 0px rgba(130, 163, 170, 0.10);
        width: 100%;
        outline: none;
        border: none;
        color: var(--h, #0F253124);
        font-family: 'Gerbera', sans-serif;
        font-size: 1rem;
        font-style: normal;
        font-weight: 300;
        line-height: normal;
    }

    .hemonc2__callback-wrapper input::placeholder {
        opacity: .24;
    }

    .hemonc2__callback-type {
        position: relative;
    }

    .hemonc2__callback-type:after {
        content: '';
        position: absolute;
        top: .69rem;
        right: 1rem;
        background-size: 100%;
        background-repeat: no-repeat;
        background-position: center;
        width: 1.5rem;
        height: 1.5rem;
        background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M7 9L12.5 14.5L18 9" stroke="%230F2531"/></svg>');
    }

    .hemonc2__callback-select {
        position: absolute;
        left: 0;
        top: 100%;
        width: 100%;
        padding: .75rem 1rem;
        background: var(--white, #FFF);
        box-shadow: 0px 4px 24px 0px rgba(130, 163, 170, 0.10);
        display: none;
        z-index: 2;
    }

    .hemonc2__callback-item {
        color: var(--h, #0F2531);
        font-family: 'Gerbera', sans-serif;
        opacity: .24;
        font-size: 1rem;
        font-style: normal;
        font-weight: 300;
        line-height: normal;
        margin-bottom: .63rem;
    }

    .hemonc2__callback-item:last-child {
        margin-bottom: 0;
    }

    .hemonc2__callback-btn {
        background-color: #007088;
        border-radius: 0.625rem;
        max-width: 12.5rem;
        text-align: center;
        width: 100%;
        margin-top: 1.5rem;
    }

    .hemonc2__callback-sub {
        margin-top: 1rem;
        color: var(--h, #0F2531);
        font-family: 'Gerbera', sans-serif;
        opacity: .5;
        font-size: 0.75rem;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .hemonc2__callback-sub a {
        text-decoration: underline;
        color: var(--h, #0F2531);
        font-family: 'Gerbera', sans-serif;
        font-size: 0.75rem;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .hemonc2__callback-wrap {
        width: 100%;
        position: relative;
        padding-bottom: 65.63467492260062%;
    }

    .hemonc2__callback-wrap img {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        object-fit: cover;
        object-position: center;
        border-radius: 1rem;
    }

    .valid {
        border: 2px dotted #cbe9e9 !important;
    }

    .invalid {
        border: 2px dashed #ed5c59 !important;
    }
</style>

<section class="hemonc2__callback">
    <div class="center-wrap">
        <div class="hemonc2__callback-grid">
            <div class="hemonc2__callback-content">
                <div class="hemonc2__callback-title">Не откладывайте - <br> запишитесь сейчас</div>
                <form class="hemonc2__callback-form">
                    <div class="hemonc2__callback-wrapper">
                        <input data-input="name" name="name" type="text" placeholder="* Ваше имя">
                    </div>

                    <div class="hemonc2__callback-wrapper">
                        <input data-input="phone" name="phone" type="tel" placeholder="* Ваш телефон">
                    </div>

                    <div class="hemonc2__callback-wrapper">
                        <input type="hidden" name="type" value="">
                        <div class="hemonc2__callback-type">* Тип обращения</div>
                        <div class="hemonc2__callback-select">
                            <div class="hemonc2__callback-item">Тип</div>
                            <div class="hemonc2__callback-item">Тип 2</div>
                            <div class="hemonc2__callback-item">Тип 3</div>
                        </div>
                    </div>
                    <button type="submit" class="hemonc2__callback-btn btn">Запись на прием</button>
                    <div class="hemonc2__callback-sub">Нажимая на кнопку, вы даете согласие на <a href="#">обработку своих персональных данных</a> и соглашаетесь с <a href="#">Политикой обработки персональных данных</a>.</div>
                </form>
            </div>
            <div class="hemonc2__callback-wrap">
                <img src="<?=SITE_TEMPLATE_PATH?>/images/cta-form/service-callback.png" alt="">
            </div>
        </div>
    </div>
</section>

<script>
    $('.hemonc2__callback-type').click(function(e) {
        $(this).parent().children('.hemonc2__callback-select').slideToggle()
        e.stopPropagation()
    })
    
    $('.hemonc2__callback-item').click(function() {
        $(this).parent().parent().children('input').val($(this).text())
        $(this).parent().parent().children('.hemonc2__callback-type').text($(this).text())
        $(this).parent().slideUp()
    })

    $('body').click(function() {
        $('.hemonc2__callback-select').slideUp()
    })

    $('.hemonc2__callback-form').submit(function (e) {
        e.preventDefault();

        var pass = true;

        document.querySelectorAll("[data-input]").forEach((input) => {
            if (input.getAttribute("data-input_valid") !== 'true') {
                $('html, body').animate({
                    scrollTop: $('[data-input]').offset().top - 150
                }, 500);

                pass = false;
            }
        });

        if (pass) {
            var data = $(".hemonc2__callback-form").serializeArray();

            var phone;
            var name;
            let ctSessionId = window.ct == undefined || window.ct('calltracking_params', '9500f011') === undefined ?
            '111122223333' : window.ct('calltracking_params', '9500f011').sessionId;

            for (var item in data) {
                if (data[item].name == "phone") {
                    phone = data[item].value;
                }

                if (data[item].name == "name") {
                    name = data[item].value;
                }
            }

            $.ajax({
                type: "POST",
                url: "/ajax/",
                data: {
                    action: 'hemonc2__callback-form',
                    phone: phone,
                    name: name,
                    sessionId: ctSessionId,
                    requestUrl: location.href,
                },
                beforeSend: function () {
                    $(".hemonc2__callback-content").html('<div class="floatingBarsG floatingBarsG-modal-default">' +
                        '<div class="blockG rotateG_01"></div>' +
                        '<div class="blockG rotateG_02"></div>' +
                        '<div class="blockG rotateG_03"></div>' +
                        '<div class="blockG rotateG_04"></div>' +
                        '<div class="blockG rotateG_05"></div>' +
                        '<div class="blockG rotateG_06"></div>' +
                        '<div class="blockG rotateG_07"></div>' +
                        '<div class="blockG rotateG_08"></div>' +
                        '</div>'
                    );
                },
                success: function (data) {
                    $(".hemonc2__callback-content").html('<div class="success-form"><h2 style="font-size:16px;">Заявка отправлена!<br/>Администратор свяжется с вами, в ближайшее время.</h2></div>');
                },
                error: function (data) {
                    alert("error");
                }
            });
        }
    });

    document.querySelectorAll("[data-input]").forEach((input) => {
        input.addEventListener("keyup", () => {
            if (
                input.value === undefined
                || input.value === null
                || input.value === ""
            ) {
                input.setAttribute("data-input_valid", false);
                input.classList.remove("valid");
                input.classList.add("invalid");
            } else {
                input.setAttribute("data-input_valid", true);
                input.classList.remove("invalid");
                input.classList.add("valid");
            }

            if (
                input.getAttribute("data-input") === "phone"
                && (
                    input.value.length <= 10
                    || input.value.length > 11
                )
            ) {
                input.setAttribute("data-input_valid", false);
                input.classList.remove("valid");
                input.classList.add("invalid");
            }

            if (
                input.getAttribute("data-input") === "email"
                && !input.value.match(
                    /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                )
            ) {
                input.setAttribute("data-input_valid", false);
                input.classList.remove("valid");
                input.classList.add("invalid");
            }
        });
    });
    
    if ($.fn.mask != undefined) {
        $('#fPhone').mask('+7 (999) 999-99-99');
    }
</script>