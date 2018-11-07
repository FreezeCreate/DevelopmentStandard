var dataURL='http://gscs.sem98.com/';
var token='5523cbad2881cc1ea54a6b55083547c6a932eef2';

$(document).on('click','.checkbox', function(e) {
    e.stopPropagation();
    var that = $(e.target);
    if(!that.hasClass('active')) {
        that.parent().parent().find('.active').removeClass('active').next().removeAttr('checked');
        that.addClass('active').next().attr("checked",'true').click();
    }
})
function getRequest() {// 获取地址栏参数
    var url = window.location.search; //获取url中"?"符后的字串
    var theRequest = new Object();
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        strs = str.split("&");
        for(var i = 0; i < strs.length; i ++) {            
            theRequest[strs[i].split("=")[0]]=decodeURI(strs[i].split("=")[1]);            
        }
    }
    return theRequest;
}
function Toast(msg,duration){
    duration=isNaN(duration)?3000:duration;
    var m = document.createElement('div');
    m.innerHTML = msg;
    m.style.cssText="width: 60%;min-width: 150px;opacity: 0.77;height: 30px;color: rgb(255, 255, 255);line-height: 30px;text-align: center;border-radius: 5px;position: fixed;bottom: 10%;left: 20%;z-index: 9999;background: rgb(0, 0, 0);font-size: 12px;";
    document.body.appendChild(m);
    setTimeout(function() {
        var d = 0.5;
        m.style.webkitTransition = '-webkit-transform ' + d + 's ease-in, opacity ' + d + 's ease-in';
        m.style.opacity = '0';
        setTimeout(function() { document.body.removeChild(m) }, d * 1000);
    }, duration);
}