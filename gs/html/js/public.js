var ImgUrl = 'http://192.168.1.136/source/js/',
        dataURL = "http://192.168.1.136/";
// var ImgUrl = 'http://gscs.sem98.com/source/js/',
//    dataURL="http://gscs.sem98.com/";

// var dataToken="5523cbad2881cc1ea54a6b55083547c6a932eef2";
var dataToken = getCookie('token');
if (dataToken == undefined || dataToken == null || !dataToken) {
    location.href=dataURL+'/main/logout';
}
function getCookie(cname)
{
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++)
    {
        var c = ca[i].trim();
        if (c.indexOf(name) == 0)
            return c.substring(name.length, c.length);
    }
    return "";
}
$(function () {
    $(document).on('click', '.download', function () {
        var id = $(this).attr('itemid');
        var title = $(this).text();
        // parent.window.newHtml('/main/yulan?id=' + id, title)
        window.location.href = '/main/download?id=' + id;
    });
    /*
     * 回到顶部
     * */
    $(window).scroll(function () {
        var scrollTop = $(window).scrollTop();
        if (scrollTop > 200) {
            if (!$('.GoTop')[0]) {
                $('.ContentBox').append('<img class="GoTop" src="' + ImgUrl + '../images/top.png" alt="" />')
            }
        } else {
            $('.GoTop').remove()
        }
    })

    $(document).on('click', '.GoTop', function () {
        $('html,body').animate({'scrollTop': '0px'}, 300)
    })
    /*
     * 顶部用户菜单按钮
     * */
    $(document).on('click', '.NavMenuItem.User', function (e) {
        e.stopPropagation()
        $('.NavMenuItem.User').toggleClass('active')
    })
    $(document).on('click', function (e) {
        if (e.target != $('.NavMenuItem.User')[0] && $('.NavMenuItem.User').eq(0).hasClass('active')) {
            $('.NavMenuItem.User').eq(0).removeClass('active')
        } else if (!$('.NavMenuItem.User')[0]) {
            // console.log(0);
        } else {
            parent.window.menuClos();
        }
    })
    /*
     * 左部菜单导航
     * */
    saveWidth()
    leftM()
    $(document).on('click', '.ContentTitlNavItem', function (e) {
        e.stopPropagation()
        var that = $(this)
        $('.ContentTitlNavItem').removeClass('active')
        $('iframe.html').removeClass('active')
        that.addClass('active')
        $('iframe.html.' + that.attr('data-clas')).addClass('active');
//		$('.ContentTitl').scrollLeft($('.ContentTitlNavItem.active').offset().left-230)
    })
    $(document).on('click', '.ContentTitlClose', function (e) {
        e.stopPropagation()
        var that = $(this).parent().parent()
        $('iframe.html.' + that.attr('data-clas')).remove()
        $('.ContentTitlNavItem').removeClass('active');
        $('iframe.html').removeClass('active')
        $('.ContentTitlNavItem').eq(that.index() - 1).addClass('active');
        $('iframe.html.' + $('.ContentTitlNavItem').eq(that.index() - 1).attr('data-clas')).addClass('active')
        $('.LeftMenu .' + that.attr('data-clas')).removeClass('on')
        that.remove();
    })
    LeftMenu();
    function LeftMenu() {
        var h = 0
        $('.GroupSecondMenu.active').children('.GroupSecondBox').children().each(function (k, v) {
            h += $(v)[0].offsetHeight
        })
        $('.GroupSecondMenu.active').children('.GroupSecondBox').height(h)
        var h1 = 0
        $('.MenuGroup.active').children('.GroupFirstBox').children().each(function (k, v) {
            h1 += $(v)[0].offsetHeight
        })
        $('.MenuGroup.active').children('.GroupFirstBox').height(h1 + h)
    }
    $(document).on('click', '.GroupFirst', function (e) {
        e.stopPropagation()
        var that = $(this);
        $('.MenuGroup').each(function (k, v) {
            if ($(v)[0] == that.parent()[0]) {
            } else {
                $(v).removeClass('active')
            }
        });
        $('.GroupFirstBox').height(0);
        if (that.parent().hasClass('active')) {

            that.parent().removeClass('active');
            that.parent().children('.GroupFirstBox').height(0)
            that.parent().children('.GroupFirstBox').children('.GroupSecondMenu').removeClass('active');
            that.parent().children('.GroupFirstBox').children('.GroupSecondMenu').children('.GroupSecondBox ').height(0)
        } else {
            that.parent().addClass('active');
            var h = 0;
            that.parent().children('.GroupFirstBox').children().each(function (k, v) {
                h += $(v)[0].offsetHeight
            })
            that.parent().children('.GroupFirstBox').height(h);
        }
    });
    $(document).on('click', '.LeftMenuBox .NewHtml', function () {
        $('.LeftMenuBox .NewHtml').removeClass('active');
        $(this).addClass('active');
        var that = $(this);
        if (!that.parent().parent().hasClass('MenuGroup')) {
            $('.GroupFirstBox').height(0);
            $('.MenuGroup').removeClass('active')
        }
        // 可以让鼠标移到附近时弹出左方导航菜单
        // $(".Content").css({
        //     'margin-left':'0'
        // });
        // $(".LeftMenu").hide();
    })
    /*
     * 页面弹窗
     * */
    $(document).on('click', '.NewPop', function (e) {
        e.stopPropagation()
        var that = $(this);
        //判断是否父级页面
        if ($('.ContentCont')[0]) {
            newHtml(that.attr('data-url'), that.attr('data-title'))
        } else {
            parent.window.newHtml(that.attr('data-url'), that.attr('data-title'));
        }
    })

    /*
     * 弹窗页面关闭
     * */
    $(document).on('click', '.Close', function (e) {
        e.stopPropagation()
        parent.window.closHtml()
    })
    /*
     * 新建页面
     * */
    $(document).on('click', '.NewHtml', function (e) {
        e.stopPropagation()
        var that = $(this);
        //判断是否父级页面
        if ($('.ContentCont')[0]) {
            AddHtml(that)
        } else {
            parent.window.AddHtml(that)
        }
    })
    /*
     * 头部导航滑动
     * */
    $('.ContentTitl').mousedown(function (e) {
        var that = this;
        var w1 = e.screenX;
        var lef = $('.ContentTitl').scrollLeft();
        document.onmousemove = function (e1) {
            var w2 = e1.screenX;
            $('.ContentTitl').scrollLeft(lef - (w2 - w1))
        }
    })
    $('.ContentTitl').mouseup(function (e) {
        document.onmousemove = function (e1) {
        }
    })
    $('.ContentTitl').mouseleave(function (e) {
        document.onmousemove = function (e1) {
        }
    })
    /*
     * 内部页面弹窗
     * */
    $(document).on('click', '.InPop', function (e) {
        e.stopPropagation()
        var that = $(this);
        $('.Tan#' + that.attr('data-BoxId')).show()
        $('.Tan#' + that.attr('data-BoxId') + ' .TanBox').animate({'top': $(window).height() * 0.15}, 300)
    })
    $(document).on('click', '.OtPop', function (e) {
        e.stopPropagation()
        var that = $(this)
        $('.Tan#' + that.attr('data-BoxId') + ' .TanBox').animate({'top': '-900px'}, 300, function () {
            $('.Tan#' + that.attr('data-BoxId')).hide()
        })

    })
    /*
     * 输入框边框
     * */

    InputBorder('.FrameGroupInput')
    InputBorder('.FrameDatGroup')
    InputBorder('.ChousSerchItem')
    InputBorder('.smallInp')
    function InputBorder(clas) {
        $(document).on('focus', clas, function () {
            $(clas).removeClass('active');
            $(this).addClass('active')
        })
        $(document).on('focusout', clas, function () {
            $(clas).removeClass('active');
        })
    }
    ;
    /*
     * 上传文件删除
     * */
    $(document).on('click', '.DelFile', function () {
        var that = $(this);
        Confirm('确定删除？', function (e) {
            if (e) {
                $(that).parent().remove()
            }
        })
    })
    /*
     * 弹窗数据选择
     * */
    $(document).on('click', '.PersonListName', function (e) {
        e.stopPropagation()
        var that = $(this);
        if (that.hasClass('active')) {

            that.removeClass('active');
            that.parent().children('.PersonListBox').height(0)
        } else {
            that.addClass('active');
            var h = 0;
            that.parent().children('.PersonListBox').children().each(function (k, v) {
                h += $(v)[0].offsetHeight
            })
            that.parent().children('.PersonListBox').height(h);
        }
    });
    $(document).on('click', '.PersonListItem', function (e) {
        e.stopPropagation()
        $(this).toggleClass('active')
        $(this).parent().parent().children('.PersonListName').children('label').children('.checkbox').removeClass('active')
    })
    $(document).on('click', '.one .PersonListItem', function (e) {
        e.stopPropagation()
        var that = $(this)
        $('.one .PersonListItem').each(function (k, v) {
            $(v)[0] == that[0] ? '' : $(v).removeClass('active')
        })
    })
    $(document).on('click', '.PersonListName .checkbox', function (e) {
        e.stopPropagation()
        var that = $(this);
        if (that.hasClass('active')) {
            that.parent().parent().next().children('.PersonListItem').removeClass('active')
        } else {
            that.parent().parent().next().children('.PersonListItem').addClass('active')
        }
    })
    $(document).on('click', '.one .PersonListName .checkbox', function (e) {
        e.stopPropagation()
        var that = $(this);
        $('.one .PersonListName .checkbox').each(function (k, v) {
            $(v)[0] == that[0] ? '' : $(v).removeClass('active')
        })
        $('.one .PersonListItem').removeClass('active');
        that.parent().parent().next().children('.PersonListItem').addClass('active')
    })
    $(document).on('click', '.PersonSerchBtn', function (e) {
        e.stopPropagation()
        var that = $(this);
        var val = that.prev().val();
        if (val != '') {
            $('.PersonListName').each(function (k, v) {
                if ($(v).children('label').children('.checkbox').text().indexOf(val) != -1) {
                    $(v).parent().show()
                    $(v).next().children('.PersonListItem').show();
                } else {
                    var boo = false;
                    var h = 0;
                    $(v).next().children('.PersonListItem').each(function (k1, v1) {
                        if ($(v1).children('span').text().indexOf(val) != -1) {
                            $(v1).show();
                            boo = true;
                            h += 44
                        } else {
                            $(v1).hide();
                        }
                    })
                    if (boo) {
                        $(v).parent().show()
                        $(v).next().height(h)
                    } else {
                        $(v).parent().hide()
                    }
                }
            })
        } else {
            PersonInit()
        }
    });
    $(document).on('keydown', '.PersonSerchVal', e => {
        console.log(e);
    });
    $(document).on('click', '.Person .Close', function (e) {
        e.stopPropagation()
        $('.PersonBox').animate({'top': -$('.PersonBox')[0].offsetHeight}, 200, function () {
            $('.Person').remove()
        })
    })
    /*
     *下拉菜单
     * */
    $(document).click(function (e) {
        if (e.target.className.indexOf('list-menu') != -1) {
            var that = $(e.target);
            var w = 0;
            var h = 0;
            if (that.hasClass('menu-active')) {
                that.removeClass('menu-active');
            } else {
                $('.list-menu').removeClass('menu-active');
                that.addClass('menu-active');
            }

            if (($('.menu').width() + that.offset().left) > $(window).width()) {
                w = that.offset().left - ($('.menu').width() - that[0].offsetWidth + 2);
            } else {
                w = that.offset().left;
            }
            ;

            if (($('.menu').height() + that.offset().top + that[0].offsetHeight - $(window).scrollTop()) > $(window).height()) {
                h = that.offset().top - ($('.menu').height() + 2) - $(window).scrollTop();
            } else {
                h = that.offset().top + that[0].offsetHeight - $(window).scrollTop();
            }

            that.children('.menu').css({left: w, top: h})
        } else {
            $('.list-menu').removeClass('menu-active')
        }
    })
    $(window).scroll(function () {
        $('.list-menu').removeClass('menu-active')
    })
    $('.MenuCont').width($('.MenuCont').parent().width() - 430)
})
/*
 * 头部菜单关闭
 * */
function menuClos() {
    $('.NavMenuItem.User').eq(0).removeClass('active')
}
/*
 * 新页面添加
 * */
function AddHtml(that) {

    var clas = that.attr('data-clas');
    var urls = that.attr('data-url');
    var name = that.attr('data-name');

    $('iframe.html').removeClass('active');
    $('.ContentTitlNavItem').removeClass('active');

    //判断是否存在页面
    if ($('iframe.' + clas)[0]) {
        $('iframe.' + clas).addClass('active');
        $('.ContentTitlNavItem.' + clas).addClass('active');
        if ($('iframe.' + clas).attr('src') != urls) {
            $('iframe.' + clas)[0].src = urls
        }
    } else {
        $('.ContentCont').append('<iframe src="' + urls + '" class="html active ' + clas + '"name="' + clas + '" ></iframe>')
        $('.ContentTitlNav').append(
                '<li class="ContentTitlNavItem active ' + clas + '" data-clas="' + clas + '"><a>'
                + '<span class="ContentTitlNavItemText">' + name + '</span><img class="ContentTitlClose" src="' + ImgUrl + 'images/shouye_22.png"/></a></li>'
                )
        $('.ContentTitlNav').width() > $('.ContentTitl').width() ? $('.ContentTitl').css({'overflow-x': 'scroll'}) : $('.ContentTitl').css({'overflow': 'hidden'})
    }
}

/*
 * 模块宽度设置
 * */
function saveWidth() {
    $('.row').each(function (k, v) {
        $(v).children('.col6').each(function (k1, v1) {
            $(v1).width(parseInt($(v).width() / 2) - 20)
            if (k1 % 2 == 0) {
                $(v1).css({'margin-right': '20px'})
            }
        })
    })
    $('.ModuleScroll').each(function (k, v) {
        if ($(v)[0].offsetWidth > $(v).parent()[0].offsetWidth) {
            $(v).parent().css({'overflow-x': 'scroll'})
        } else {
            $(v).parent().css({'overflow-x': 'hidden'})
        }
    })
}
;
/*
 * 左导航
 * */
function leftM() {
    $('.LeftMenuBox').height($(window).height() - 50 - 61 - 72)
    $('.ContentCont').height($(window).height() - 50 - 36)
}

/*
 * 监听窗口变化
 * */
window.onresize = function () {
    saveWidth()
    if ($('.ContentCont')[0]) {
        changHeight()
        leftM()
    } else {
        changHeight();
        leftM();
    }
    $('.MenuCont').width($('.MenuCont').parent().width() - 430)
}
function changHeight() {
    $('iframe.Call').css({'height': $(window).height() * 0.8})
}
;
/*
 * 页面引用
 * */
function newHtml(url, title) {
    var mk = document.createElement('div');
    mk.className = 'Mark'
    $('body').append(mk)
    $(mk).append('<div class="CallHead">' + title + '<span class="Close"></span></div>');
    $(mk).append('<iframe class="Call" name="Call" src="' + url + '"></iframe>');
    changHeight();
    if (url.indexOf('Item') != -1) {
        $(mk).children('iframe.Call').animate({'top': $(window).height() * 0.15}, 300)
        $(mk).children('.CallHead').animate({'top': $(window).height() * 0.15}, 300)
    } else {
        $(mk).children('iframe.Call').animate({'top': $(window).height() * 0.15}, 300)
        $(mk).children('.CallHead').animate({'top': $(window).height() * 0.15}, 300)
    }
}
;
/*
 * 页面关闭
 * */
function closHtml() {
    $('.CallHead').animate({'top': '-999px'}, 300)
    $('iframe.Call').animate({'top': '-999px'}, 300, function () {
        $('.Mark').remove()
    })
}
/*
 * 提示选择框
 * Confirm('问题',function(e){ 回调 })
 * */
function Confirm(quest, callback, boo) {
    if (!boo) {
        if ($('.ContentCont')) {
            parent.window.Confirm(quest, callback, true)
            return;
        }
    }
    var Confirm = document.createElement('div');
    Confirm.className = 'Confirm';
    $(Confirm).append(
            '<div class="ConfirmBox"><div class="ConfirmTitl">系统提示<span class="close"></span></div>'
            + '<div class="ConfirmCont"><div class="ConfirmQuset">' + quest + '</div></div><div class="ConfirmBtn">'
            + '<span class="Btn Big Btn-green">确认</span><span class="Btn Big Btn-blue">取消</span></div></div>'
            );
    $('body').append(Confirm)
    $('.ConfirmBox').animate({'top': parseInt($(window).height() / 3) - parseInt($('.ConfirmBox').height() / 2)}, 300);
    $(Confirm).click(function (e) {

        if (e.target == $('.Confirm .close')[0]) {
            Remove()
            callback ? callback(false) : '';
        } else if (e.target == $('.Confirm .Btn')[0]) {
            Remove()
            callback ? callback(true) : '';
        } else if (e.target == $('.Confirm .Btn')[1]) {
            Remove()
            callback ? callback(false) : '';
        } else {
            return;
        }
    })
    function Remove() {
        $('.ConfirmBox').animate({'top': '-500px'}, 300, function () {
            $(Confirm).remove()
        })
    }
}
;
/*
 * 数据加载
 * */
function loading(str, boo) {
    if (!boo) {
        if (!$('.ContentCont')[0]) {
            parent.window.loading(str, true)
            return;
        }
    }
    $('.Mark.Loading').remove()
    if (str == 'none') {
        $('.Mark.Loading').remove()
    } else {
        $('body').append('<div class="Mark Loading h-center"><div class="Load"><img src="' + ImgUrl + 'images/loading.gif"/></div></div>')
    }
}
/*
 * 提示框
 * Alert('问题',function(e){ 回调 })
 * */
function Alert(quest, callback, boo) {
    if (!boo) {
        if (!$('.ContentCont')[0]) {
            parent.window.Alert(quest, callback, true)
            return;
        }
    }
    var Alert = document.createElement('div');
    Alert.className = 'Alert';
    $(Alert).append(
            '<div class="AlertBox"><div class="AlertTitl">系统提示<span class="close"></span></div>'
            + '<div class="AlertCont"><div class="AlertQuset">' + quest + '</div></div><div class="AlertBtn">'
            + '<span class="Succ">确认</span></div></div>'
            );
    $('body').append(Alert);
    $('.AlertBox').animate({'top': parseInt($(window).height() / 3) - parseInt($('.AlertBox').height() / 2)}, 300);
    $(Alert).click(function (e) {

        if (e.target == $('.Alert .close')[0]) {
            Remove()
            callback ? callback(true) : '';
        } else if (e.target == $('.Alert .Succ')[0]) {
            Remove()
            callback ? callback(true) : '';
        } else {
            return;
        }
    })
    function Remove() {
        $('.AlertBox').animate({'top': '-500px'}, 300, function () {
            $('.Alert').remove()
        })
    }
}
;
/*
 * 选择人员
 * */
function ChousPerson(res, type, clastex, clasval, dom, callback) {

//	if(res.status == 0){ return;}
    var ids = null, boo;
    if (type == 'one') {
        ids = [$(dom).parent().children(clasval).val()];
        boo = true;
    } else {
        ids = $(dom).parent().children(clasval).val().split(',');
        boo = false;
    }
    var Tan = document.createElement('div'),
            str = '';
    Tan.className = 'Tan Person ' + (type == 'one' ? 'one' : '');
    str += '<div class="TanBox PersonBox">'
            + '<div class="PersonTit">请选择<span class="close"></span></div>'
            + '<div class="PersonCont"><div class="PersonSerch"><div class="PersonSerchGroup">'
            + '<input class="PersonSerchVal" type="text" name="" id="" value="" placeholder="部门/姓名"/>'
            + '<span class="PersonSerchBtn noChoice">搜索</span></div></div><div class="PersonScroll">'

    if (res.code != 0) {
        $.each(res.results, function (k, v) {
            str += '<div class="PersonList"><div class="PersonListName"><label>'
                    + '<span data-id="' + v.id + '" data-name="' + v.name + '" class="checkbox whit ' + (Find(ids, v.id) ? "active" : "") + '" >' + v.name + '</span></label></div></div>'
        });

    } else if (res.code == 0) {
        $.each(res.results, function (k, v) {

            if (type == 'one') {

                str += '<div class="PersonList"><div class="PersonListName ' + (find(v.children) ? "active" : "") + '">' + v.name
                        + '</div><ul class="PersonListBox">'
            } else {

                str += '<div class="PersonList"><div class="PersonListName ' + (find(v.children) ? "active" : "") + '"><label>'
                        + '<span data-id="' + v.id + '" data-name="' + v.name + '" class="checkbox whit ' + (find(v.children) == 1 ? "active" : "") + '" >' + v.name + '</span></label></div><ul class="PersonListBox">'
            }
            $.each(v.children || [], function (k1, v1) {

                var positionname = v1.positionname ? v1.positionname : '无';
                str += '<li class="PersonListItem ' + (Find(ids, v1.id) ? "active" : "") + '"data-id="' + v1.id + '" data-name="' + v1.name + '"><img src="' + ImgUrl + 'images/shouoye_36.png"/><span>' + v1.name + '（' + positionname + '）</span></li>'
            });
            str += '</ul></div>'
        });
    }
    str += '</div></div><div class="PersonFoot"><span class="Succ">确认</span></div></div>'

    $(Tan).append(str)
    $('body').append(Tan)
    $(Tan).show()
    $(Tan).children('.TanBox').animate({'top': $(window).height() * 0.15}, 300)

    $('.PersonListName.active').each(function (k, v) {
        var h = 0;
        $(v).parent().children('.PersonListBox').children().each(function (k, v) {
            h += $(v)[0].offsetHeight
        })
        $(v).parent().children('.PersonListBox').height(h);
    })

    function find(arr) {
        var num = 0;
        var num1 = 0;
        if (arr == null)
            arr = [];
        $.each(arr, function (k, v) {
            num1++
            if (Find(ids, v.id)) {
                num++
            }
        })
        if (num == 0) {
            return 0
        } else if (num == num1) {
            return 1
        } else {
            return 2
        }
    }
    $(Tan).click(function (e) {
        if (e.target.className == 'close') {
            $(Tan).children('.TanBox').animate({'top': '-500px'}, 300, function () {
                $(Tan).remove()
            })
        } else if (e.target.className == 'Succ') {
            var list = $(Tan).children('.TanBox').children('.PersonCont').children('.PersonScroll').children('.PersonList')
            var valTex = '',
                    valVal = '';
            if (res.status == 1) {
                list.each(function (k, v) {
                    var check = $(v).children('.PersonListName').children('label').children('.checkbox')
                    if (check.hasClass('active')) {
                        if (type == 'one') {
                            valTex = check.attr('data-name');
                            valVal = check.attr('data-id');
                            return
                        } else {
                            valTex += check.attr('data-name') + ', ';
                            valVal += check.attr('data-id') + ',';
                        }
                    }
                })
            } else if (res.code == 0) {
                list.each(function (k, v) {
                    var check = $(v).children('.PersonListBox').children('.PersonListItem');
                    check.each(function (k1, v1) {

                        if ($(v1).hasClass('active')) {
                            if (type == 'one') {
                                valTex = $(v1).attr('data-name');
                                valVal = $(v1).attr('data-id');
                                return
                            } else {
                                valTex += $(v1).attr('data-name') + ', ';
                                valVal += $(v1).attr('data-id') + ',';
                            }
                        }
                    })
                })
            }
            $(Tan).children('.TanBox').animate({'top': '-500px'}, 300, function () {
                $(Tan).remove()
                $(dom).parent().children(clastex).val(valTex)
                $(dom).parent().children(clasval).val(valVal)
                if (callback) {
                    callback(valVal)
                }
            })
        }
    })
}
/*
 * 人员选择初始化
 * */
function PersonInit() {
    $('.PersonListItem').show();
    $('.PersonList').show();
    $('.PersonSerchVal').val('')
    $('.Person .checkItem').removeClass('active')
    $('.PersonListName').removeClass('active')
    $('.PersonListItem').removeClass('active')
    $('.PersonListBox').height(0)
}
/*
 * 页面刷新
 * */
function Refresh(boo) {
    if (boo) {
        window[$('.html.active').attr('name')].location.reload()
    } else if ($('.html.active').attr('name')) {
        window[$('.html.active').attr('name')].location.reload()
    } else {
        parent.window.Refresh(true)
    }
}
/*
 * 页面打印
 * */
function printdiv(printpage) {
    var headstr = "<html><head><title></title></head><body>";
    var footstr = "</body>";
    var newstr = document.all.item(printpage).innerHTML;
    var oldstr = document.body.innerHTML;
    document.body.innerHTML = headstr + newstr + footstr;
//	var a = ( 1024 * 1.4 - $('body').height() ) / ( $('body tr').length * 2 )
//	$('body td').css({'padding': a+'px 0'})
//	$('body th').css({'padding': a+'px 0'})
    window.print();
    document.body.innerHTML = oldstr;
    return false;
}
/*
 * id查找
 * */
function Find(arr, k) {
    if (arr == null)
        return false;
    for (var i = 0; i < arr.length; i++) {
        if (arr[i] - 0 == k - 0) {
            return true
        }
    }
    return false
}
// 进度条
function getProgress() {
    $(".progress").each(function (i, item) {
        var a = parseInt($(item).children(".rate").attr("w"));
        if (a > 100)
            a = 100;
        var newFont = 0;
        $(item.children[0]).animate({
            width: a + "%"
        }, 1000);
        function newTimer() {
            if (newFont < a) {
                newFont++;
            } else {
                clearInterval(timer);
                return;
            }
            $(item).children(".rate-font").html(newFont + '%');
        }
        var timer = setInterval(newTimer, 1000 / a);
    });
}
getProgress();
// form表单解码
function getSubData(formId) {
    var SubStr = $("#" + formId).serialize();
    SubStr = SubStr.split("+").join(" ").split("&").join(",").split("=").join(",").split(",");
    for (var i = 0, SubData = {}; i < SubStr.length; i++) {
        if (i % 2 == 0) {
            SubData[SubStr[i]] = 0;
        } else {
            SubData[SubStr[i - 1]] = decodeURIComponent(SubStr[i]);
        }
    }
    return SubData;
}
// 销售名加载
function showSaleName(dom) {
    $(dom).each(function (i, e) {
        var that = $(e);
        var name = that.attr('name');
        var id = that.attr('id');
        var html = `<input class=" nameClass getUsers FrameGroupInput" type="text" name="${name}" placeholder="点击选择部门人员" readonly="readonly"/>
        <input class="idClass" type="hidden" name="${id}" />
        <span class="btn btn-success btn-sm getUsers">选择</span>`;
        that.parent().html(html);
        showCommonList('app.php/main/getUsersWeb', function (data) {
            $('.getUsers').click(function () {
                ChousPerson(data, 'one', '.nameClass', '.idClass', this);
            });
        });
    });
}
//客户类别-列表
function showCustName(dom) {
    $(dom).each(function (i, e) {
        var that = $(e);
        var name = that.attr('name');
        var id = that.attr('id');
        var html = `<input class=" custnameClass getCUsers FrameGroupInput" type="text" name="${name}" placeholder="点击选择客户" readonly="readonly"/>
        <input class="custidClass" type="hidden" name="${id}" />
        <span class="btn btn-success btn-sm getUsers">选择</span>`;
        that.parent().html(html);
        showCommonList('app.php/service/mycust', function (data) {
            $('.getCUsers').click(function () {
                ChousPerson(data, 'one', '.custnameClass', '.custidClass', this);
            });
        });
    });
}
//商品类别-列表
function showInvoiceName(dom) {
    $(dom).each(function (i, e) {
        var that = $(e);
        var name = that.data('name');
        var id = that.data('id');
        var html = `<input class=" nameClass getIUsers FrameGroupInput" type="text" data-name="${name}" placeholder="点击选择商品" title="点击选择商品" readonly="readonly"/>
        <input class="idClass listName" type="hidden" data-name="${id}" />
        <span class="btn btn-success btn-sm getUsers">选择</span>`;
        that.parent().html(html);
        showCommonList('app.php/goods/cateForGoods', function (data) {
            $('.getIUsers').click(function () {
                ChousPerson(data, 'one', '.nameClass', '.idClass', this);
            });
        });
    });
}
showInvoiceName('.invoiceNameList');
showCustName('.custNameLst');
// // 商品名加载
// function showInvoiceName(dom){
//     $(dom).each(function(i,e){
//         var that=$(e);
//         var name=that.attr('name');
//         var id=that.attr('id');
//         var html=`<input class=" nameClass getUsers FrameGroupInput" type="text" name="${name}" placeholder="点击选择部门人员" readonly="readonly"/>
//         <input class="idClass" type="hidden" name="${id}" />
//         <span class="btn btn-success btn-sm getUsers">选择</span>`;
//         that.parent().html(html);
//         showCommonList('app.php/goods/index',function(data){
//             $('.getUsers').click(function(){
//                 ChousPerson(data, 'one', '.nameClass', '.idClass', this);
//             });
//         });
//     });
// }
showSaleName(".saleNameList");
// showInvoiceName(".invoiceNameList");
function getUsers(dom, childName) {
    $(dom).each(function (i, e) {
        var that = $(e);
        showGetUser(function (data) {
            var d_html = '';
            for (var {id, name} of data.results) {
                d_html += `<option value="${id}">${name}</option>`;
            }
            that.html(d_html);
            showGetUser(function (data) {
                var u_html = ``;
                for (var {id, children} of data.results) {
                    if (that.val() == id) {
                        if (children) {
                            for (var item of children) {
                                u_html += `<option value="${item.id}">${item.name}</option>`;
                            }
                            that.after(`<select name="${childName}" class="FrameGroupInput">${u_html}</select>`);
                        }
                    }
                }
            });
        });
    });
    $(dom).change(function () {
        var that = $(this);
        that.next('.FrameGroupInput').remove();
        showGetUser(function (data) {
            var u_html = ``;
            for (var {id, children} of data.results) {
                if (that.val() == id) {
                    if (children) {
                        for (var item of children) {
                            u_html += `<option value="${item.id}">${item.name}</option>`;
                        }
                        that.after(`<select name="${childName}" class="FrameGroupInput">${u_html}</select>`);
                    }
                }
            }
        });
    });
}
function showGetUser(success) {
    $.ajax({
        type: 'get',
        url: dataURL + '/app.php/main/getUsersWeb',
        data: {token: dataToken},
        dataType: 'json',
        success(data) {
            console.log(data);
        },
        error() {
            console.error("网络错误");
        }
    }).then(success);
}
// getUsers(".saleNameList",'saleid');

// 维修单加载
$(".equipLst").each(function (i, e) {
    var that = $(e);
    showCommonList("/app.php/service/equipLst", function (data) {
        if (data.code == 0) {
            var res = data.results, html;
            for (var {id, name} of res) {
                html += `<option value="${id}">${name}</option>`;
            }
            that.html(html);
        } else {
            console.error("网络错误！");
        }
    });
});
// 客户名加载
// $(".custNameList").each(function(i,e){
//     var that=$(e);
//     showCommonList("app.php/allcust/chooseUser",function(data){
//         if(data.code!=0){
//             alert(data.msg);
//             return false;
//         }
//         var res=data.results,html;
//         for(var {id,cust_name} of res){
//             html+=`<option   value="${id}">${cust_name}</option>`;
//         }
//         that.html(html);
//     });
// });
// 部门名称加载
$(".departmentList").each(function (i, e) {
    var that = $(e);
    showCommonList("app.php/main/departmentLst", function (data) {
        if (data.code == 0) {
            var res = data.results, html;
            for (var {id, name} of res) {
                html += `<option   value="${id}">${name}</option>`;
            }
            that.html(html);
        } else {
            console.error("网络错误！");
        }
    });
});
// 设备客户名称加载
// $(".custNameLst").each(function(i,e){
//     var that=$(e);
//     showCommonList("/app.php/keep/myCust",function(data){
//         if(data.code==0){
//             var res=data.results,html;
//             for(var {id,name} of res){
//                 html+=`<option   value="${id}">${name}</option>`;
//             }
//             that.html(html);
//         }else{
//             console.error("网络错误！");
//         }
//     });
// });
// 客户分类加载
$(".custJob").each(function (i, e) {
    var that = $(e);
    showCommonList("app.php/custcate/index", function (data) {
        if (data.code == 0) {
            var res = data.results, html = '';
            for (var {id, catename} of res) {
                html += `<option   value="${id}">${catename}</option>`;
            }
            that.html(html);
        } else {
            console.error("网络错误！");
        }
    });
});
// 合同表
$(".contractList").each(function (i, e) {
    var that = $(e);
    showCommonList("app.php/custmang/contractLst", function (data) {
        if (data.code == 0) {
            var res = data.results, html = '';
            for (var {id, name} of res) {
                html += `<option   value="${id}">${name}</option>`;
            }
            that.html(html);
        } else {
            console.error("网络错误！");
        }
    });
});
// 商品名称
// $(".invoiceNameList").each(function(i,e){
//     var that=$(e);
//     showCommonList("app.php/goods/index",function(data){
//         if(data.code==0){
//             var res=data.results,html='';
//             for(var {id,order_name} of res){
//                 html+=`<option   value="${id}">${order_name}</option>`;
//             }
//             that.html(html);
//         }else{
//             console.error("网络错误！");
//         }
//     });
// });
// 供应商公司
$(".buldcomList").each(function (i, e) {
    var that = $(e);
    showCommonList("app.php/supplier/index", function (data) {
        if (data.code == 0) {
            var res = data.results, html = '';
            for (var {id, company} of res) {
                html += `<option   value="${id}">${company}</option>`;
            }
            that.html(html);
        } else {
            console.error("网络错误！");
        }
    });
});
// 采购单列表
// $(".buldcomList").each(function(i,e){
//     var that=$(e);
//     showCommonList("app.php/invoice/invoiceApply",function(data){
//         console.log(data);
//         if(data.code==0){
//             var res=data.results,html='';
//             for(var {id,company} of res){
//                 html+=`<option   value="${id}">${company}</option>`;
//             }
//             that.html(html);
//         }else{
//             console.error("网络错误！");
//         }
//     });
// });
// 固资设备列表
$(".deviceNameList").each(function (i, e) {
    var that = $(e);
    showCommonList("app.php/device/index", function (data) {
        if (data.code == 0) {
            var res = data.results, html = '';
            for (var {id, device_name} of res) {
                html += `<option   value="${id}">${device_name}</option>`;
            }
            that.html(html);
        } else {
            console.error("网络错误！");
        }
    });
});
// 固资设备类别
$(".cateNameList_d").each(function (i, e) {
    var that = $(e);
    showCommonList("app.php/devicecate/index", function (data) {
        if (data.code == 0) {
            var res = data.results, html = '';
            for (var {id, catename} of res) {
                html += `<option   value="${id}">${catename}</option>`;
            }
            that.html(html);
        } else {
            console.error("网络错误！");
        }
    });
});
// 商品类别
$(".cateNameList").each(function (i, e) {
    var that = $(e);
    showCommonList("app.php/goodsordercate/index", function (data) {
        if (data.code == 0) {
            var res = data.results, html = '';
            for (var {id, catename} of res) {
                html += `<option   value="${id}">${catename}</option>`;
            }
            that.html(html);
        } else {
            console.error("网络错误！");
        }
    });
});
// 用款类别
$(".paycNameList").each(function (i, e) {
    var that = $(e);
    showCommonList("app.php/paycate/index", function (data) {
        if (data.code == 0) {
            var res = data.results, html = '';
            for (var {id, catename} of res) {
                html += `<option   value="${id}">${catename}</option>`;
            }
            that.html(html);
        } else {
            console.error("网络错误！");
        }
    });
});
// 库房名称
$(".stockNameList").each(function (i, e) {
    var that = $(e);
    showCommonList("app.php/stockroom/index", function (data) {
        if (data.code == 0) {
            var res = data.results, html = '';
            for (var {id, room_name} of res) {
                html += `<option   value="${id}">${room_name}</option>`;
            }
            that.html(html);
        } else {
            console.error("网络错误！");
        }
    });
});
// 汇报表名称
$(".deviceDescList").each(function (i, e) {
    var that = $(e);
    showCommonList("app.php/devicedesc/index", function (data) {
        if (data.code == 0) {
            var res = data.results, html = '';
            for (var {id, descname} of res) {
                html += `<option   value="${id}">${descname}</option>`;
            }
            that.html(html);
        } else {
            console.error("网络错误！");
        }
    });
});
//加载名称
function getTypeLst(typeLst, type) {
    $(typeLst).each(function (i, e) {
        var that = $(e);
        $.ajax({
            type: 'get',
            url: dataURL + '/app.php/main/data',
            dataType: 'json',
            data: {type},
            success(data) {
                var res = data.data, html = '';
                for (var {id, name} of res) {
                    html += `<option value="${id}">${name}</option>`;
                }
                that.html(html);
            },
            error() {
                alert("类型接口错误");
            }
        });
    });
}
// 印章名称
getTypeLst(".sealNameList", 'SEAL_TYPE');
getTypeLst(".payTypeList", 'PAY_TYPE');
getTypeLst(".custLyLst", 'CUST_LAIYUAN');
// 分页制作
function getPagesBox( {nowUrl, page, distance, addList}){
    if (!page) {
        page = 1;
    }
    let searchname = $(".searchname").val();
    let cateid = $(".liveCateLst").val();
    let start=$('[name="start"]').val();
    let end=$('[name="end"]').val();
    let that = $('.PagesBox');
    $("#dataList").html('');
    $(".noMsg").html(`<div class='l_loading'></div>`).show();
    let data= {token: dataToken, page};
    if(start){
        data.start=start;
    }
    if(end){
        data.end=end;
    }
    if(searchname){
        data.searchname=searchname;
    }
    if(cateid){
        data.cateid=cateid;
    }
    if(distance){
        data.distance=distance;
    }
    $.ajax({
        type: "get",
        url: dataURL + nowUrl,
        data,
        dataType: "json",
        success(data) {
            $(".noMsg").hide();
            $(".l_loading").hide();
            if (data.code != 0) {
                alert(data.msg);
                return false;
            }
            let pageres = data.pager, pagehtml = '';
            if (pageres == null) {
                $("#dataList").html("");
                that.hide();
                $(".noMsg").show();
                return false;
            }
            let firstPage = pageres.first_page,
                    lastPage = pageres.last_page,
                    prevPage = pageres.prev_page,
                    nextPage = pageres.next_page;
            pagehtml += `<li class="PagesItem firstPage"><a>&lt;&lt;&nbsp;首页</a></li>
            <li class="PagesItem prevPage"><a>&lt;</a></li>`;
            for (let item of pageres.all_pages) {
                pagehtml += `<li class="PagesItem ${item == pageres.current_page ? "active" : ""}"><a>${item}</a></li>`;
            }
            pagehtml += `<li class="PagesItem nextPage"><a>&gt;</a></li>
            <li class="PagesItem lastPage"><a>末页&nbsp;&gt;&gt;</a></li>`;
            that.html(pagehtml);
            $(".PagesItem").click(function () {
                let that = $(this);
                if (that.hasClass("firstPage")) {
                    getPagesBox({nowUrl, page: firstPage, addList});
                } else if (that.hasClass("lastPage")) {
                    getPagesBox({nowUrl, page: lastPage, addList});
                } else if (that.hasClass("prevPage")) {
                    getPagesBox({nowUrl, page: prevPage, addList});
                } else if (that.hasClass("nextPage")) {
                    getPagesBox({nowUrl, page: nextPage, addList});
                } else {
                    getPagesBox({nowUrl, page: parseInt(that.children().html()), addList});
                }
            });
        },
        error() {
            $(".noMsg").show();
            // alert("列表数据有误！");
        }
    }).then(addList).then(() => {
        $(document).on('keydown',".searchname",e => {
            if (e.keyCode == 13) {
                getPagesBox({nowUrl, addList});
            }
        });
        $(document).on('click', '.TablesHeadNav .TablesHeadItem', function () {
            let that = $(this);
            let distance = that.data("id");
            $(".TablesHeadItem").removeClass("active");
            that.addClass("active");
            getPagesBox({nowUrl, distance, addList});
            return false;
            //未处理bug：延时
        });
        $(document).on('click',"#searchNameId",() => {
            $(".noMsg").html(`<div class='l_loading'></div>`).show();
            getPagesBox({nowUrl, addList});
            return false;
        });
        $(document).on('change','.liveCateLst',()=>{
            $(".noMsg").html(`<div class='l_loading'></div>`).show();
            getPagesBox({nowUrl, addList});
            return false;
        });
    });
}
// 是否删除
function isDelTr(delUrl) {
    $('.delTr').on('click', function () {
        var that = $(this);
        Confirm('确定删除？', function (e) {
            if (e) {
                that.closest("tr").remove();
                // Total();
                if (delUrl) {
                    var id = that.data("cid");
                    $.ajax({
                        type: "post",
                        url: dataURL + delUrl,
                        dataType: "json",
                        data: {id, token: dataToken},
                        success: function (data) {
                            if (data.code == 0) {
                                // location.reload();
                                console.log("删除成功，此界面仅限于操作人员");
                            }
                        },
                        error() {
                            alert("删除失败！");
                            console.error(that.val());
                        }
                    });
                }
            }
        }, false);
    });
}
// id过滤器
function getStatu(arr, list, i) {
    return arr[list[i]];
}
// 查看详情
function showDataList(url, success) {
    $("#dataItem").html("<div class='l_loading'></div>");
    var id = getRequest().id;
    $.ajax({
        type: "get",
        url: dataURL + url,
        data: {id, token: dataToken},
        dataType: "json",
        success,
        error() {
            alert("详情接口网络错误！");
        }
    });
}
// 点击刷新
$(".l_refresh").click(function () {
    location.reload();
});
// 新增方法
function addDataList(url) {
    $(document).on('click','#addDataSub',function () {
        var that = $(this);
        that.hide().parent().append("<i class='l_loading'></i>");
        var addData = getSubData('addData');
        if (addData) {
            if(addData.files){
                var files=[];
                files.push(addData.files);
                addData.files=files;
            }
            if (addData.invoice_id)
                addData.invoice_name = filtDataId(addData.invoice_id, 'invoice_id');
            if (addData.buldid)
                addData.buldcom = filtDataId(addData.buldid, 'buldid');
            if (addData.recomid)
                addData.recompany = filtDataId(addData.recomid, 'recomid');
            if (addData.addid)
                addData.addname = filtDataId(addData.addid, 'addid');
            if (addData.apply_id)
                addData.apply_name = filtDataId(addData.apply_id, 'apply_id');
            if (addData.salesid)
                addData.salesname = filtDataId(addData.salesid, 'salesid');
            if (addData.custumid)
                addData.custname = filtDataId(addData.custumid, 'custumid');
            if (addData.stock_id)
                addData.stock_name = filtDataId(addData.stock_id, 'stock_id');
            if (addData.goods_id)
                addData.goods_name = filtDataId(addData.goods_id, 'goods_id');
            if (addData.inven_house_id)
                addData.inven_house_name = filtDataId(addData.inven_house_id, 'inven_house_id');
            if (addData.inven_num)
                addData.inven_name = filtDataId(addData.inven_num, 'inven_num');
            if (addData.device_cateid)
                addData.device_catename = filtDataId(addData.device_cateid, 'device_cateid');
            if (addData.deviceid)
                addData.devicename = filtDataId(addData.deviceid, 'deviceid');
            if (addData.devicecateid)
                addData.devicecatename = filtDataId(addData.devicecateid, 'devicecateid');
            if (addData.checkid)
                addData.checkname = filtDataId(addData.checkid, 'checkid');
            if (addData.paytypeid)
                addData.paytype = filtDataId(addData.paytypeid, 'paytypeid');
            if (addData.paydid)
                addData.paydname = filtDataId(addData.paydid, 'paydid');
            if (addData.did)
                addData.dname = filtDataId(addData.did, 'did');
            if (addData.depid)
                addData.depname = filtDataId(addData.depid, 'depid');
            if (addData.sealid)
                addData.sealname = filtDataId(addData.sealid, 'sealid');
            if (addData.cateid)
                addData.catename = filtDataId(addData.cateid, 'cateid');
        }
        addData.token = dataToken;
        $.ajax({
            type: "post",
            url: dataURL + url,
            data: addData,
            dataType: "json",
            success(data) {
                if (data.code != 0) {
                    alert(data.msg);
                    that.show().next().remove();
                    return false;
                }
                parent.window.closHtml();
                location.reload();
                alert(data.msg + ",请再次刷新。");
            },
            error() {
                console.error("新增接口断开！");
            }
        });
    });
}
//***********加载公共数据********
function showCommonList(url, success) {
    $.ajax({
        type: "get",
        url: dataURL + url,
        data: {token: dataToken},
        dataType: "json",
        success(data) {
            if(data.code != 0){
                Alert(data.msg);
                return false;
            }
        },
        error() {
            console.error("网络错误")
        }
    }).then(success);
}
// 关闭input自动缓存
$("input").each(function (i, e) {
    var that = $(e);
    that.attr({"autocomplete": "off"});
});
// 获取地址栏参数
function getRequest() {
    var url = window.location.search; //获取url中"?"符后的字串
    var theRequest = new Object();
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        strs = str.split("&");
        for (var i = 0; i < strs.length; i++) {
            theRequest[strs[i].split("=")[0]] = decodeURI(strs[i].split("=")[1]);
        }
    }
    return theRequest;
}
// 新增记录
function addCustRecord(url) {
    $("#addCustSub").click(function () {
        var that = $(this);
        var id = getRequest().id;
        that.hide().parent().append("<i class='l_loading'></i>");
        var addSubData = getSubData("addCustRecord");
        if (addSubData.paytypeid)
            addSubData.paytype = filtDataId(addSubData.paytypeid, 'paytypeid');
        if (addSubData.contractid)
            addSubData.contractid = $(".contractname").attr("id");
        if (addSubData.contractname)
            addSubData.contractname = $(".contractname").html();
        if (addSubData.paycname)
            addSubData.paycname = $(".paycname").html();
        addSubData.custumid = id;
        addSubData.token = dataToken;
        $.ajax({
            type: "post",
            url: dataURL + url,
            data: addSubData,
            dataType: "json",
            success(data) {
                if (data.code != 0) {
                    alert(data.msg);
                    that.show().next().remove();
                    return false;
                }
                Alert("跟进成功，请刷新页面！");
                parent.window.closHtml();
            },
            error() {
                console.error("网络错误！");
            }
        });
    });
}
//过滤id，name
function filtDataId(id, name) {
    $('[name="' + name + '"]>[value="' + id + '"]').html();
    return $('[name="' + name + '"]>[value="' + id + '"]').html();
}
// 异步插name
function showDataName(url, id, success) {
    $.ajax({
        type: 'get',
        url: dataURL + url,
        data: {token: dataToken, id},
        dataType: 'json',
        success(data) {
            console.log(data);
        },
        error() {
            console.error("网络错误！");
        }
    }).then(success);
}

//删除cookie
function deleteCookie(name) {
    var expdate = new Date();
    expdate.setTime(expdate.getTime() - (86400 * 1000 * 1));
    setCookie(name, "", expdate);
}

//保存cookie
function setCookie(name, value) {
    var argv = setCookie.arguments;
    var argc = setCookie.arguments.length;
    var expires = (argc > 2) ? argv[2] : null;
    if (expires != null) {
        var LargeExpDate = new Date();
        LargeExpDate.setTime(LargeExpDate.getTime() + (expires * 1000 * 3600 * 24));
    }
    document.cookie = name + "=" + escape(value) + ((expires == null) ? "" : ("; expires=" + LargeExpDate.toGMTString()));
}