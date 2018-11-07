
var ImgUrl = '/source/';

$(function() {
    $(document).on('click', '.download', function() {
        var id = $(this).attr('itemid')?$(this).attr('itemid'):$(this).children('.download-a').attr('itemid');
        var title = $(this).text();
        parent.window.newHtml('/main/yulan?id=' + id, title)
        //window.location.href = '/main/download?id=' + id;
    });
    /*
     * 回到顶部
     * */
    $(window).scroll(function() {
        var scrollTop = $(window).scrollTop();
        if (scrollTop > 200) {
            if (!$('.GoTop')[0]) {
                $('.ContentBox').append('<img class="GoTop" src="' + ImgUrl + 'images/top.png" alt="" />')
            }
        } else {
            $('.GoTop').remove()
        }
    })

    $(document).on('click', '.GoTop', function() {
        $('html,body').animate({'scrollTop': '0px'}, 300)
    })
    /*
     * 顶部用户菜单按钮
     * */
    $(document).on('click', '.NavMenuItem.User', function(e) {
        e.stopPropagation()
        $('.NavMenuItem.User').toggleClass('active')
    })
    $(document).on('click', function(e) {
        if (e.target != $('.NavMenuItem.User')[0] && $('.NavMenuItem.User').eq(0).hasClass('active')) {
            $('.NavMenuItem.User').eq(0).removeClass('active')
        } else if (!$('.NavMenuItem.User')[0]) {
        }
        {
            parent.window.menuClos()
        }
    })
    /*
     * 左部菜单导航
     * */
    saveWidth()
    leftM()
    $(document).on('click', '.ContentTitlNavItem', function(e) {
        e.stopPropagation()
        var that = $(this)
        $('.ContentTitlNavItem').removeClass('active')
        $('iframe.html').removeClass('active')
        that.addClass('active')
        $('iframe.html.' + that.attr('data-clas')).addClass('active');
//		$('.ContentTitl').scrollLeft($('.ContentTitlNavItem.active').offset().left-230)
    })
    $(document).on('click', '.ContentTitlClose', function(e) {
        e.stopPropagation()
        var that = $(this).parent().parent()
        $('iframe.html.' + that.attr('data-clas')).remove()
        $('.ContentTitlNavItem').removeClass('active');
        $('iframe.html').removeClass('active')
        $('.ContentTitlNavItem').eq(that.index() - 1).addClass('active');
        $('iframe.html.' + $('.ContentTitlNavItem').eq(that.index() - 1).attr('data-clas')).addClass('active')
        $('.LeftMenu .' + that.attr('data-clas')).removeClass('on')
        that.remove();
        $('.ContentTitlNavItem').eq(that.index()-1).attr('data-clas').window.saveWidth();
    })
    LeftMenu();
    function LeftMenu() {
        var h = 0
        $('.GroupSecondMenu.active').children('.GroupSecondBox').children().each(function(k, v) {
            h += $(v)[0].offsetHeight
        })
        $('.GroupSecondMenu.active').children('.GroupSecondBox').height(h)
        var h1 = 0
        $('.MenuGroup.active').children('.GroupFirstBox').children().each(function(k, v) {
            h1 += $(v)[0].offsetHeight
        })
        $('.MenuGroup.active').children('.GroupFirstBox').height(h1 + h)
    }
    $(document).on('click', '.GroupFirst', function(e) {
        e.stopPropagation()
        var that = $(this);
        $('.MenuGroup').each(function(k, v) {
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
            that.parent().children('.GroupFirstBox').children().each(function(k, v) {
                h += $(v)[0].offsetHeight
            })
            that.parent().children('.GroupFirstBox').height(h);
        }
    });
    $(document).on('click', '.LeftMenuBox a', function() {
        $('.LeftMenuBox a').removeClass('active');
        $(this).addClass('active');
        var that = $(this);
        if (that.parent().parent()[0].className.indexOf('MenuGroup') == -1) {
            $('.GroupFirstBox').height(0);
            $('.MenuGroup').removeClass('active')
        }
    })
    /*
     * 页面弹窗
     * */
    $(document).on('click', '.NewPop', function(e) {
        e.stopPropagation()
        var that = $(this);
        //判断是否父级页面
        if ($('.ContentCont')[0]) {
            newHtml(that.attr('data-url'), that.attr('data-title'))
        } else {
            parent.window.newHtml(that.attr('data-url'), that.attr('data-title'))
        }
    })

    /*
     * 弹窗页面关闭
     * */
    $(document).on('click', '.Close', function(e) {
        e.stopPropagation()
        var that = $(this);
		closHtml(that)
    })
    /*
     * 新建页面
     * */
    $(document).on('click', '.NewHtml', function(e) {
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
    $('.ContentTitl').mousedown(function(e) {
        var that = this;
        var w1 = e.screenX;
        var lef = $('.ContentTitl').scrollLeft();
        document.onmousemove = function(e1) {
            var w2 = e1.screenX;
            $('.ContentTitl').scrollLeft(lef - (w2 - w1))
        }
    })
    $('.ContentTitl').mouseup(function(e) {
        document.onmousemove = function(e1) {
        }
    })
    $('.ContentTitl').mouseleave(function(e) {
        document.onmousemove = function(e1) {
        }
    })
    /*
     * 内部页面弹窗
     * */
    $(document).on('click', '.InPop', function(e) {
        e.stopPropagation()
        var that = $(this);
        $('.Tan#' + that.attr('data-BoxId')).show()
        $('.Tan#' + that.attr('data-BoxId') + ' .TanBox').animate({'top': $(window).height() * 0.15}, 300)
    })
    $(document).on('click', '.OtPop', function(e) {
        e.stopPropagation()
        var that = $(this)
        $('.Tan#' + that.attr('data-BoxId') + ' .TanBox').animate({'top': '-900px'}, 300, function() {
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
        $(document).on('focus', clas, function() {
            $(clas).removeClass('active');
            $(this).addClass('active')
        })
        $(document).on('focusout', clas, function() {
            $(clas).removeClass('active');
        })
    }
    ;
    /*
     * 上传文件删除
     * */
    $(document).on('click', '.DelFile', function() {
        var that = $(this);
        Confirm('确定删除？', function(e) {
            if (e) {
                $(that).parent().remove()
            }
        })
    })
    /*
     * 弹窗数据选择
     * */
    $(document).on('click', '.PersonListName', function(e) {
        e.stopPropagation()
        var that = $(this);
        if (that.hasClass('active')) {

            that.removeClass('active');
            that.parent().children('.PersonListBox').height(0)
        } else {
            that.addClass('active');
            var h = 0;
            that.parent().children('.PersonListBox').children().each(function(k, v) {
                h += $(v)[0].offsetHeight
            })
            that.parent().children('.PersonListBox').height(h);
        }
    });
    $(document).on('click', '.PersonListItem', function(e) {
        e.stopPropagation()
        $(this).toggleClass('active')
        $(this).parent().parent().children('.PersonListName').children('label').children('.checkbox').removeClass('active')
    })
    $(document).on('click', '.one .PersonListItem', function(e) {
        e.stopPropagation()
        var that = $(this)
        $('.one .PersonListItem').each(function(k, v) {
            $(v)[0] == that[0] ? '' : $(v).removeClass('active')
        })
    })
    $(document).on('click', '.PersonListName .checkbox', function(e) {
        e.stopPropagation()
        var that = $(this);
        if (that.hasClass('active')) {
            that.parent().parent().next().children('.PersonListItem').removeClass('active')
        } else {
            that.parent().parent().next().children('.PersonListItem').addClass('active')
        }
    })
    $(document).on('click', '.one .PersonListName .checkbox', function(e) {
        e.stopPropagation()
        var that = $(this);
        $('.one .PersonListName .checkbox').each(function(k, v) {
            $(v)[0] == that[0] ? '' : $(v).removeClass('active')
        })
        $('.one .PersonListItem').removeClass('active');
        that.parent().parent().next().children('.PersonListItem').addClass('active')
    })
    $(document).on('click', '.PersonSerchBtn', function(e) {
        e.stopPropagation()
        var that = $(this);
        var val = that.prev().val();
        if (val != '') {
            $('.PersonListName').each(function(k, v) {
                if ($(v).children('label').children('.checkbox').text().indexOf(val) != -1) {
                    $(v).parent().show()
                    $(v).next().children('.PersonListItem').show();
                } else {
                    var boo = false;
                    var h = 0;
                    $(v).next().children('.PersonListItem').each(function(k1, v1) {
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
    })
    $(document).on('click', '.Person .Close', function(e) {
        e.stopPropagation()
        $('.PersonBox').animate({'top': -$('.PersonBox')[0].offsetHeight}, 200, function() {
            $('.Person').remove()
        })
    })
    /*
     *下拉菜单
     * */
    $(document).click(function(e) {
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
    $(window).scroll(function() {
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
function AddHtml(that){
	
	var clas = that.attr('data-clas');
	var urls = that.attr('data-url');
	var name = that.attr('data-name');
	
	$('iframe.html').removeClass('active');
	$('.ContentTitlNavItem').removeClass('active');
	
	//判断是否存在页面
	if( $('iframe.'+clas)[0] ){
		$('iframe.'+clas).addClass('active');
		$('.ContentTitlNavItem.'+clas).addClass('active');
		if( $('iframe.'+clas).attr('src') != urls ){
			$('iframe.'+clas )[0].src = urls
		}
	}else{
		$('.ContentCont').append('<iframe src="'+urls+'" class="html active '+clas+'"name="'+clas+'" ></iframe>')
		$('.ContentTitlNav').append(
			'<li class="ContentTitlNavItem active '+clas+'" data-clas="'+clas+'"><a><img class="ContentTitlNavItemImg" src="'+ImgUrl+'images/mr_n.png"/>'
			+'<span class="ContentTitlNavItemText">'+name+'</span><img class="ContentTitlClose" src="'+ImgUrl+'images/shouye_22.png"/></a></li>'
		)
		$('.ContentTitlNav').width()>$('.ContentTitl').width()?$('.ContentTitl').css({'overflow-x': 'scroll'}):$('.ContentTitl').css({'overflow': 'hidden'})
	}
}

/*
 * 模块宽度设置
 * */
function saveWidth(){
	$('.row').each(function(k,v){
		$(v).children('.col6').each(function(k1,v1){
			$(v1).width( parseInt($(v).width()/2)-20 )
			if( k1 % 2 == 0 ){
				$(v1).css({'margin-right': '20px'})
			}
		})
	})
	$('.ModuleScroll').each(function(k,v){
		if( $(v)[0].offsetWidth > $(v).parent()[0].offsetWidth ){
			 $(v).parent().css({'overflow-x': 'scroll'})
		}else{
			$(v).parent().css({'overflow-x': 'hidden'})
		}
	})
};
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
window.onresize = function() {
    saveWidth()
    if ($('.ContentCont')[0]) {
        changHeight()
        leftM()
    } else {
        parent.window.changHeight()
        parent.window.leftM()
    }
    $('.MenuCont').width($('.MenuCont').parent().width() - 430)
}
function changHeight(){
	$('iframe.Call').css({'height': $(window).height()*0.8})
};
/*
 * 页面引用
 * */
function newHtml(url, title){
	var mk = document.createElement('div');
	mk.className = 'Mark'
	$('body').append(mk)
	$(mk).append('<div class="CallHead">'+title+'<span class="Close"></span></div>');
	$(mk).append('<iframe class="Call" name="Call" src="'+url+'"></iframe>');
	changHeight();
	if(url.indexOf('/main/yulan') != -1){
		$(mk).children('iframe.Call').animate({'top': $(window).height()*0.15+22},300)
		$(mk).children('.CallHead').animate({'top': $(window).height()*0.15-22},300)
	}else{
		$(mk).children('iframe.Call').animate({'top': $(window).height()*0.15},300)
		$(mk).children('.CallHead').animate({'top': $(window).height()*0.15},300)
	}
};
/*
 * 页面关闭
 * */
function closHtml(that) {
	that.parent().animate({'top': '-999px'}, 300)
	that.parent().next().animate({'top': '-999px'}, 300, function() {
		that.parent().parent().remove()
	})
}
/*
 * 提示选择框
 * Confirm('问题',function(e){ 回调 })
 * */
function Confirm(quest,callback,boo){
	if(!boo){
		if(!$('.ContentCont')[0]){
			parent.window.Confirm(quest,callback,true)
			return;
		}
	}
	var Confirm = document.createElement('div');
	Confirm.className = 'Confirm';
	$(Confirm).append(
		'<div class="ConfirmBox"><div class="ConfirmTitl">系统提示<span class="close"></span></div>'
		+'<div class="ConfirmCont"><div class="ConfirmQuset">'+quest+'</div></div><div class="ConfirmBtn">'
		+'<span class="Btn Big Btn-green">确认</span><span class="Btn Big Btn-blue">取消</span></div></div>'
	);
	$('body').append(Confirm)
	$('.ConfirmBox').animate({'top': parseInt($(window).height()/3)-parseInt($('.ConfirmBox').height()/2)},300);
	$(Confirm).click(function(e){
		
		if( e.target == $('.Confirm .close')[0] ){
			Remove()
			callback?callback(false):'';
		}else if( e.target == $('.Confirm .Btn')[0] ){
			Remove()
			callback?callback(true):'';
		}else if( e.target == $('.Confirm .Btn')[1] ){
			Remove()
			callback?callback(false):'';
		}else{
			return;
		}
	})
	function Remove(){
		$('.ConfirmBox').animate({'top': '-500px'},300,function(){
			$(Confirm).remove()
		})
	}
};
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
function Alert(quest,callback,boo){
	if(!boo){
		if(!$('.ContentCont')[0]){
			parent.window.Alert(quest,callback,true)
			return;
		}
	}
	var Alert = document.createElement('div');
	Alert.className = 'Alert';
	$(Alert).append(
		'<div class="AlertBox"><div class="AlertTitl">系统提示<span class="close"></span></div>'
		+'<div class="AlertCont"><div class="AlertQuset">'+quest+'</div></div><div class="AlertBtn">'
		+'<span class="Succ">确认</span></div></div>'
	);
	$('body').append(Alert);
	$('.AlertBox').animate({'top': parseInt($(window).height()/3)-parseInt($('.AlertBox').height()/2)},300);
	$(Alert).click(function(e){
		
		if( e.target == $('.Alert .close')[0] ){
			Remove()
			callback?callback(true):'';
		}else if( e.target == $('.Alert .Succ')[0] ){
			Remove()
			callback?callback(true):'';
		}else{
			return;
		}
	})
	function Remove(){
		$('.AlertBox').animate({'top': '-500px'},300,function(){
			$('.Alert').remove()
		})
	}
};
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

    if (res.status == 1) {
        $.each(res.data, function(k, v) {
            str += '<div class="PersonList"><div class="PersonListName one" ><label>'
                    + '<span data-id="' + v.id + '" data-name="' + v.name + '" class="checkbox ' + (Find(ids, v.id) ? "active" : "") + '" >' + v.name + '</span></label></div></div>'
        });

    } else if (res.status == 2) {

        $.each(res.data, function(k, v) {

            if (type == 'one') {

                str += '<div class="PersonList"><div class="PersonListName ' + (find(v.children) ? "active" : "") + '">' + v.name
                        + '</div><ul class="PersonListBox">'
            } else {

                str += '<div class="PersonList"><div class="PersonListName ' + (find(v.children) ? "active" : "") + '"><label>'
                        + '<span data-id="' + v.id + '" data-name="' + v.name + '" class="checkbox ' + (find(v.children) == 1 ? "active" : "") + '" >' + v.name + '</span></label></div><ul class="PersonListBox">'
            }
            $.each(v.children, function(k1, v1) {

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

    $('.PersonListName.active').each(function(k, v) {
        var h = 0;
        $(v).parent().children('.PersonListBox').children().each(function(k, v) {
            h += $(v)[0].offsetHeight
        })
        $(v).parent().children('.PersonListBox').height(h);
    })

    function find(arr) {
        var num = 0;
        var num1 = 0;
        $.each(arr, function(k, v) {
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
    $(Tan).click(function(e) {
        if (e.target.className == 'close') {
            $(Tan).children('.TanBox').animate({'top': '-500px'}, 300, function() {
                $(Tan).remove()
            })
        } else if (e.target.className == 'Succ') {
            var list = $(Tan).children('.TanBox').children('.PersonCont').children('.PersonScroll').children('.PersonList')
            var valTex = '',
                    valVal = '';
            if (res.status == 1) {
                list.each(function(k, v) {
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
            } else if (res.status == 2) {
                list.each(function(k, v) {
                    var check = $(v).children('.PersonListBox').children('.PersonListItem');
                    check.each(function(k1, v1) {

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
            $(Tan).children('.TanBox').animate({'top': '-500px'}, 300, function() {
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
    // alert('成功请刷新');
	$('.CallHead').animate({'top': '-999px'}, 300)
	$('iframe.Call').animate({'top': '-999px'}, 300, function() {
		$('.Mark').remove()
	})
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
    for (var i = 0; i < arr.length; i++) {
        if (arr[i] - 0 == k - 0) {
            return true
        }
    }
    return false
}

//保存cookie
function setCookie(name, value) {
	var argv = setCookie.arguments;
	var argc = setCookie.arguments.length;
	var expires = (argc > 2) ? argv[2] : null;
	if(expires != null) {
		var LargeExpDate = new Date();
		LargeExpDate.setTime(LargeExpDate.getTime() + (expires * 1000 * 3600 * 24));
	}
	document.cookie = name + "=" + escape(value) + ((expires == null) ? "" : ("; expires=" + LargeExpDate.toGMTString()));
}

//获取cookie
function getCookie(Name) {
	var search = Name + "="
	if(document.cookie.length > 0) {
		offset = document.cookie.indexOf(search)
		if(offset != -1) {
			offset += search.length
			end = document.cookie.indexOf(";", offset)
			if(end == -1) end = document.cookie.length
			return unescape(document.cookie.substring(offset, end))
		} else return ""
	}
}

//删除cookie
function deleteCookie(name) {
	var expdate = new Date();
	expdate.setTime(expdate.getTime() - (86400 * 1000 * 1));
	setCookie(name, "", expdate);
}