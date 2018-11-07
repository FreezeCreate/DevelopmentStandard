$(function(){
    var ua = navigator.userAgent.toLowerCase();
    var isWeixin = ua.indexOf('micromessenger') != -1;
    var isAndroid = ua.indexOf('android') != -1;
    var isIos = (ua.indexOf('iphone') != -1) || (ua.indexOf('ipad') != -1);
    var isIE=ua.indexOf('msie')!=-1;
	if(isAndroid||isIos||isWeixin) {
        top.location='index.html';
	}else if(isIE){
        document.write("浏览器版本太低");
    }
});