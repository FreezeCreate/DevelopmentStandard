$(function(){
    var ua = navigator.userAgent.toLowerCase();
    var isWeixin = ua.indexOf('micromessenger') != -1;
    var isAndroid = ua.indexOf('android') != -1;
    var isIos = (ua.indexOf('iphone') != -1) || (ua.indexOf('ipad') != -1);
	if(isAndroid||isIos||isWeixin) {
        top.location='h5/index.html';
	}else{
        // top.location='index.html';
    }
});