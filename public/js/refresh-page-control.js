$('body').each(function() {
    var _body_times = $(this).attr('time-stamps') == 'undefined' ? '0' : $(this).attr('time-stamps');
    if (sessionStorage.getItem('myPageTimes') != null && parseInt(sessionStorage.getItem('myPageTimes')) >= parseInt(_body_times)) {
        window.location.reload();
    } else if (sessionStorage.getItem('myPageTimes') == null) {
        sessionStorage.setItem('myPageTimes', _body_times);
        window.location.reload();
    } else {
        sessionStorage.setItem('myPageTimes', _body_times);
    }


})