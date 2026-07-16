$(document).ready(function() {
    window.setTimeout(function () {
        var htop = 0; 
        var children = $('#right-clmn > p').children();
        for (var idx = 0; idx < children.length; idx++) {
            htop += $(children[idx]).height();
        }
        var h = $('#right-clmn').height() - htop - 20;
        if (h > 200) {
            var sc = Math.floor(h / 48);
            var h2 = sc * 48;
            $('#blog-list').css('top', (htop + 20) + 'px');
            $('#blog-list').css('height', h2 + 'px');
        }
    },200);
});