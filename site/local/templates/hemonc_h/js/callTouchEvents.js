function GetCalltouchSessionId() {

    try {
        let sessionId = window.ct == undefined || window.ct('calltracking_params', '9500f011') === undefined ?
            '111122223333' : window.ct('calltracking_params', '9500f011').sessionId;
        return sessionId;
    } catch (e) {
        return '';
    }    
}

function SendCalltouchRequest(phone, subject, comment) {

    var sessionId = GetCalltouchSessionId();  

    var ct_data = {
        phoneNumber: phone,
        subject: subject, // 'Запись на прием с сайта КДЛ',
        comment: comment,
        requestUrl: location.href,
        sessionId: sessionId // window.ct('calltracking_params', '9500f011').sessionId
    };

    console.log(' -> Post calltouch : ' + phone + ' sub : "' + subject + '" comm : "' + comment + '"');

    jQuery.ajax({
        url: 'https://api.calltouch.ru/calls-service/RestAPI/requests/8083/register/',
        dataType: 'json',
        type: 'POST',
        data: ct_data
    });
}

function SendCalltouchRequestByGet(phone, subject, comment) {

    var sessionId = GetCalltouchSessionId();

    //var ct_data = {
    //    phoneNumber: phone,
    //    subject: subject, // 'Запись на прием с сайта КДЛ',
    //    comment: comment,
    //    requestUrl: location.href,
    //    sessionId: sId // window.ct('calltracking_params', '9500f011').sessionId
    //};

    console.log(' -> Post calltouch : ' + phone + ' sub : "' + subject + '" comm : "' + comment + '"');

    let url = 'https://api.calltouch.ru/calls-service/RestAPI/requests/8083/register/';
    url += '?phoneNumber=' + phone;
    url += '&sessionId=' + sessionId;
    url += '&requestUrl=' + location.href;
    url += '&subject=' + subject;
    url += '&comment=' + comment;

    jQuery.ajax({
        url: url,
        type: 'GET'
    });
}