$(()=>{
    "use strice"
    showIndex(0);
    
    //head头信息动态加载
    $(()=>{
        showDataList("/app.php/basic/headBasic",function(data){
            if(data.code!=0){
                console.error(data.msg);
                return false;
            }
            var res=data.results;
            $("#headerLogo .HeaderLogoImg").attr('src',dataURL+res.logo).show();
            $("#headerLogo .HeaderLogoName").html(res.name);
            $('.Header').css({//.LeftMenu
                'background':res.color
            });
        });
    });
    //头部点击事件
    $('.HeaderTitle .NavMenuItem').click(function(){
        var that=$(this);
        if(!that.hasClass('active')){
            that.parent().children('.active').removeClass("active");
            that.addClass('active');
        }
    });
    $('.xzwj').click(function() {
        $('.upfile').click()
    });
    $('#upcoming').attr({'data-url':dataURL+'/person/upcoming'});
    var newDate=new Date();
    var dayArr=['一','二','三','四','五','六','七'],y=0,m=0,d=0;
    y=newDate.getFullYear();
    m=newDate.getMonth()+1;
    d=newDate.getDate();
    $('#newDate').html(y+'-'+m+'-'+d+' 星期'+dayArr[newDate.getDay()-1]);
    $('#exit').click(function(){
        //deleteCookie('token');
        location.href=dataURL+'main/logout';
        // $.ajax({
        //     type:'get',
        //     url:dataURL+'app.php/main/logout',
        //     dataType:'json',
        //     error(){
        //         console.error('网络错误');
        //     },
        //     success(data){
        //         console.log(data.msg);
        //     }
        // });
    });
    function showIndex(oid){
//    	var route_path = '';
//    	if(oid == 0){
//    		route_path = 'app.php/';
//    	}else{
//    		route_path = 'app.php/';
//    	}
        var html=`<li>
            <a class="MenuItem active on NewHtml a_01"data-url="home.html"data-clas="a_01"data-img="images/shouye_39.png"data-name="首页"data-url="home.html">
                <i class="firstImg home_1"></i>
                <span class="firstText">首页</span>
            </a>
        </li><li class='l_loading'></li>`;
        $("#LeftMenuBox").html(html);
        $.ajax({
            type:"get",
            data:{oid,token:dataToken},
            url:dataURL+"app.php/main/menuLst",
            dataType:"json",
            success:function(data){
                if(data.code!=0){
                    console.log("加载失败！");
                    return false;
                }
                var html=`<li>
                    <a class="MenuItem active on NewHtml a_01"data-url="home.html"data-clas="a_01"data-img="images/shouye_39.png"data-name="首页"data-url="home.html">
                        <i class="firstImg home_1"></i>
                        <span class="firstText">首页</span>
                    </a>
                </li>`;
                var res=data.results,url='';
                if(!res)return false;
                for(var {id,title,control,way,children,img} of res){
                    if(id==366)continue;
                    var childHtml='',len=children.length;
                    url=len>0?control:(control+'/'+way);
                    if(len>0){
                        for(var i=0;i<len;i++){
							if(oid==0){
								childHtml+=`<a class="Second NewHtml" data-url="${dataURL+children[i].control+'/'+children[i].way}" data-clas="a_${children[i].id}" data-name="${children[i].title}">
                                <i class="firstImg home_01"></i>
                                <span class="firstText">${children[i].title}</span>
                            </a>`;
							}else{
                            childHtml+=`<a class="Second NewHtml" data-url="${children[i].control+'/'+children[i].way}.html" data-clas="a_${children[i].id}" data-name="${children[i].title}">
                                <i class="firstImg home_01"></i>
                                <span class="firstText">${children[i].title}</span>
                            </a>`;
							}
                        }
                        html+=`<li class="MenuGroup">
                                <div class="GroupFirst">
                                    <i class="firstImg home_${img}"></i>
                                    <span class="firstText">${title}</span>
                                </div>
                                <div class="GroupFirstBox">${childHtml}</div>
                            </li>`;
                    }else{						
                        html+=`<li>
                            <a class="MenuItem NewHtml" data-url="${url}.html" data-clas="a_${id}" data-name="${title}">
                                <i class="firstImg home_${img}"></i>
                                <span class="firstText">${title}</span>
                            </a>
                        </li>`;
                    }
                }
                $("#LeftMenuBox").html(html);
            },
            //error(){alert("导航接口问题");}
        });
    }
    $(".HeaderTitle li").click(function(e){
        e.preventDefault();
        var that=$(this);
        var oid=that.data("oid");
        showIndex(oid);
    });
    showCommonList('/app.php/main/todoNotice',data=>$('#note').html(data.num));
    showCommonList('/app.php/main/userInfo',data=>{
        var res=data.results;
        var html='';
        /*	{ "id": "id", "username": "登录账号", "pname": "职位", "dname": "部门", "number": "编号", "name": "姓名 ", "head": "头像", "birthday": "生日", "idCard": "身份证号", "phone": "手机号", "trumpet": "短号", "email": "邮箱", "QQ": "QQ号码", "dir": "员工状态1、试用期2、正式3、实习生4、兼职5、合同工6、离职", "workdate": "入职日期", "positivedt": "转正日期", }*/ 
        if(res){
            $('.username').html(res.name);
            var isadmin='';
            dataToken?isadmin='管理员':isadmin='用户';
            $('.isadmin').html(isadmin);
            var dir=res.dir;
            switch(dir){
                case '1':dir='试用期';break
                case '2':dir='正式';break
                case '3':dir='实习生';break
                case '4':dir='兼职';break
                case '5':dir='合同中';break
                case '6':dir='离职';break
            }
            html=`<tr>
                    <td class="FrameGroupName">姓名 ：</td>
                    <td>${res.name}</td>
                    <td class="FrameGroupName" rowspan="2">头像 ：</td>
                    <td rowspan="2">
                        <img class="userImg userhead" src="${dataURL+res.head}">
                        <input class="None upfile" type="file" name="fileToUploadHead" id="fileToUploadHead" value="">
                    </td>
                </tr>
                <tr>
                    <td class="FrameGroupName">登录账号 ：</td>
                    <td>${res.username}</td>
                </tr>
                <tr>
                    <td class="FrameGroupName">编号 ：</td>
                    <td>${res.number}</td>
                    <td class="FrameGroupName">部门 ：</td>
                    <td>${res.dname}</td>
                </tr>
                <tr>
                    <td class="FrameGroupName">职务 ：</td>
                    <td>${res.pname}</td>
                    <td class="FrameGroupName">员工状态 ：</td>
                    <td>${dir}</td>
                </tr>
                <tr>
                    <td class="FrameGroupName"><span class="colorRed">*</span> 入职日期 ：</td>
                    <td>${res.workdate}</td>
                    <td class="FrameGroupName">转正日期 ：</td>
                    <td>${res.positivedt}</td>
                </tr>
                <tr>
                    <td class="FrameGroupName">手机号码 ：</td>
                    <td><input class="FrameGroupInput" type="text" name="phone" id="" value="${res.phone}" /></td>
                    <td class="FrameGroupName">短号 ：</td>
                    <td><input class="FrameGroupInput" type="text" name="trumpet" id="" value="${res.trumpet}" /></td>
                </tr>
                <tr>
                    <td class="FrameGroupName">省份证号 ：</td>
                    <td><input class="FrameGroupInput" type="text" name="idCard" id="" value="${res.idCard}" /></td>
                    <td class="FrameGroupName">生日 ：</td>
                    <td><input class="FrameGroupInput" type="text" name="birthday" id="birth" value="${res.birthday}" /></td>
                </tr>
                <tr>
                    <td class="FrameGroupName">邮箱 ：</td>
                    <td><input class="FrameGroupInput" type="text" name="email" id="" value="${res.email}" /></td>
                    <td class="FrameGroupName">QQ ：</td>
                    <td><input class="FrameGroupInput" type="text" name="QQ" id="" value="${res.QQ}" /></td>
                </tr>`;
            $("#addData table").html(html);
            $('.userhead').attr('src',dataURL+res.head).show();
        }
        addDataList('/app.php/main/editUserInfo');
        $("#addData .userImg").click(function(){
            $('#fileToUploadHead').click();
        })
        $(document).on('change','.upfile',ajaxFileUpload);
        $('#updPwdSub').click(function(){
            var data=new Object();
            $("#updPwd input").each(function(i,e){
                var that=$(e);
                data[that.attr('name')]=that.val();
            });
            data.token=dataToken;
            $.ajax({
                type:'post',
                url:dataURL+'/app.php/main/updatePwd',
                data,
                dataType:'json',
                success(data){
                    alert(data.msg);
                    location.reload();
                },
                error(){
                    console.error("修改接口错误！");
                }
            });
        });
    });

    function ajaxFileUpload() {
        $.ajaxFileUpload({
            url: dataURL+'/uplaodimage/uploadhead',
            secureuri: false,
            fileElementId: 'fileToUploadHead',
            dataType: 'json',
            data: {name: 'fileToUploadHead', id: 'fileToUploadHead'},
            success: function(data, status) {
                if (data.code != 1) {
                    $('.userhead').attr('src', data.src);
                } else {
                    Alert(data.msg);
                }
            },
            error: function(data, status, e) {
                Alert(e);
            }
        });
        return false;
    }
});