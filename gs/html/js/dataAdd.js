// 弹窗导航条 
$('.FrameBox').height($(window).height() - $('.FrameTit').get(0).offsetHeight - $('.FrameTableFoot').get(0).offsetHeight)
$('body').height($(window).height() - $('.FrameTit').get(0).offsetHeight - $('.FrameTableFoot').get(0).offsetHeight)
window.onresize = function() {
    $('.FrameBox').height($(window).height() - $('.FrameTit').get(0).offsetHeight - $('.FrameTableFoot').get(0).offsetHeight)
    $('body').height($(window).height() - $('.FrameTit').get(0).offsetHeight - $('.FrameTableFoot').get(0).offsetHeight)
}
jeDate({
    dateCell:".FrameDatGroup",
    format:"YYYY-MM-DD",
    // isinitVal:false,
    minDate:"1990-01-01",
    okfun:function(val){alert(val)}
})