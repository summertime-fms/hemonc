<!-- Bitrix code -->
    <script>
        (function(w,d,u){
                var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
                var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://cdn-ru.bitrix24.ru/b27438580/crm/site_button/loader_4_7ohmbw.js');
    </script>
    <script>
        window.addEventListener('onBitrixLiveChat', function (event) {
            var widget = event.detail.widget;
            // Обработка событий
            widget.subscribe({
                type: BX.LiveChatWidget.SubscriptionType.userMessage,
                callback: function (data) {
                    // любая команда
                    if (typeof (dataLayer) == 'undefined') {
                        dataLayer = [];
                    }
                    dataLayer.push({
                        "ecommerce": {
                            "purchase": {
                                "actionField": {
                                    "id": "userwritechatonk",
                                    "goal_id": "298844230"
                                },
                                "products": [{}]
                            }
                        }
                    });
                }
            });
        });
    </script>
<!-- /Bitrix code -->
<script>
    var _ctreq_b24 = function (data) {            
        SendCalltouchRequestByGet(data.phoneNumber, 'Запрос на обратный звонок с формы из контента hemonc.ru', '');
    };
    window.addEventListener('b24:form:submit', function (e) {
        var form = event.detail.object;
        if (form.validated) {
            var fio = ''; var phone = ''; var email = ''; var comment = '';
            form.getFields().forEach(function (el) {
                if (el.name == 'LEAD_NAME' || el.name == 'CONTACT_NAME') { fio = el.value(); }
                if (el.name == 'LEAD_PHONE' || el.name == 'CONTACT_PHONE') { phone = el.value(); }
                if (el.name == 'LEAD_EMAIL' || el.name == 'CONTACT_EMAIL') { email = el.value(); }
                if (el.name == 'LEAD_COMMENTS' || el.name == 'DEAL_COMMENTS ' || el.name == 'CONTACT_COMMENTS') { comment = el.value(); }
            });
            var sub = 'Заявка с формы Bitrix24 ' + location.hostname;
            var ct_data = { fio: fio, phoneNumber: phone, email: email, comment: comment, subject: sub, requestUrl: location.href, sessionId: window.ct('calltracking_params', '9500f011').sessionId };
            console.log(ct_data);
            if (!!phone || !!email) _ctreq_b24(ct_data);
        }
    });
</script>