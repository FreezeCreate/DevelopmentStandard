<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title>车辆预定申请</title>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/jedate/jedate.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/jquery-1.9.0.js"></script>
        <script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=3ok9BVGSrFMz1bb4xZ5zGu9N"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.js"></script>
        <style>
            .BMap_Marker{background: url(<?php echo SOURCE_PATH; ?>/images/mapicon.png) no-repeat!important;}
            .tabimg { border: 1px solid #fff;}
            .tabimg:hover { border: 1px solid #ccc;}
        </style>
    </head>
    <body>
        <div class="Frame">
			<div class="FrameTit"><span class="FrameTitName">车辆预定</span><span class="Close"></span></div>
			<div class="FrameBox">
				<div class="FrameCont">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    	<div class="FrameTableTitl">车辆预定</div>
						<table class="FrameTableCont">
                        <tbody>
                            <tr>
                                <td class="FrameGroupName">编号：</td>
                                <td><?php echo $result['number'] ?></td>
                                <td class="FrameGroupName">申请时间：</td>
                                <td><?php echo $result['applydt'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">申请人：</td>
                                <td><?php echo $result['uname'] ?></td>
                                <td class="FrameGroupName">部门：</td>
                                <td><?php echo $result['udeptname'] ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">预定车辆：</td>
                                <td><?php echo $result['gname'] ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">开始时间：</td>
                                <td><?php echo $result['start'] ?></td>
                                <td class="FrameGroupName">截止时间：</td>
                                <td><?php echo $result['end']; ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">目的地：</td>
                                <td><?php echo $result['mudi'] ?></td>
                                <td class="FrameGroupName">路线：</td>
                                <td><?php echo $result['luxian']; ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">取车时间：</td>
                                <td><?php echo $result['takedt'] ?></td>
                                <td class="FrameGroupName">归还时间：</td>
                                <td><?php echo $result['redt']; ?></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"> 说明：</td>
                                <td colspan="3"><?php echo $result['explain'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <?php if ($address) { ?>
                    <div class="title01">到达目的地(<?php echo $address['dt'] ?>)</div>
                    <div id='m-map' style="width: 100%; height: 200px;"></div>
                    <script>
                        getAddress(<?php echo $address['lng'] . ',' . $address['lat'] . ',"' . $address['address'] . '"' ?>);
                        function getAddress(lng, lat, address) {
                            markerArr = [{title: "我在这里", content: address, point: lng + '|' + lat, isOpen: 0, icon: {w: 21, h: 21, l: 0, t: 0, x: 6, lb: 5}}
                            ];
                            createMap(lng, lat);//创建地图
                            setMapEvent();//设置地图事件
                            addMapControl();//向地图添加控件
                            addMarker();//向地图中添加marker
                        }

                        //创建地图函数：
                        function createMap(lng, lat) {
                            var map = new BMap.Map("m-map");//在百度地图容器中创建一个地图
                            var point = new BMap.Point(lng, lat);//定义一个中心点坐标
                            map.centerAndZoom(point, 17);//设定地图的中心点和坐标并将地图显示在地图容器中
                            window.map = map;//将map变量存储在全局
                        }

                        //地图事件设置函数：
                        function setMapEvent() {
                            map.enableDragging();//启用地图拖拽事件，默认启用(可不写)
                            map.enableScrollWheelZoom();//启用地图滚轮放大缩小
                            map.enableDoubleClickZoom();//启用鼠标双击放大，默认启用(可不写)
                            map.enableKeyboard();//启用键盘上下左右键移动地图
                        }

                        //地图控件添加函数：
                        function addMapControl() {
                            //向地图中添加缩放控件
                            var ctrl_nav = new BMap.NavigationControl({anchor: BMAP_ANCHOR_TOP_LEFT, type: BMAP_NAVIGATION_CONTROL_LARGE});
                            map.addControl(ctrl_nav);
                            //向地图中添加缩略图控件
                            var ctrl_ove = new BMap.OverviewMapControl({anchor: BMAP_ANCHOR_BOTTOM_RIGHT, isOpen: 1});
                            map.addControl(ctrl_ove);
                            //向地图中添加比例尺控件
                            var ctrl_sca = new BMap.ScaleControl({anchor: BMAP_ANCHOR_BOTTOM_LEFT});
                            map.addControl(ctrl_sca);
                        }

                        //标注点数组
                        var markerArr = [{title: "我在这里", content: "中国成都西体路中地锦尚12楼", point: "104.062528|30.685242", isOpen: 0, icon: {w: 21, h: 21, l: 0, t: 0, x: 6, lb: 5}}
                        ];
                        //创建marker
                        function addMarker() {
                            for (var i = 0; i < markerArr.length; i++) {
                                var json = markerArr[i];
                                var p0 = json.point.split("|")[0];
                                var p1 = json.point.split("|")[1];
                                var point = new BMap.Point(p0, p1);
                                var iconImg = createIcon(json.icon);
                                var marker = new BMap.Marker(point, {icon: iconImg});
                                var iw = createInfoWindow(i);
                                var label = new BMap.Label(json.title, {"offset": new BMap.Size(json.icon.lb - json.icon.x + 10, -20)});
                                marker.setLabel(label);
                                map.addOverlay(marker);
                                label.setStyle({
                                    borderColor: "#808080",
                                    color: "#333",
                                    cursor: "pointer"
                                });

                                (function() {
                                    var index = i;
                                    var _iw = createInfoWindow(i);
                                    var _marker = marker;
                                    _marker.addEventListener("click", function() {
                                        this.openInfoWindow(_iw);
                                    });
                                    _iw.addEventListener("open", function() {
                                        _marker.getLabel().hide();
                                    });
                                    _iw.addEventListener("close", function() {
                                        _marker.getLabel().show();
                                    });
                                    label.addEventListener("click", function() {
                                        _marker.openInfoWindow(_iw);
                                    });
                                    if (!!json.isOpen) {
                                        label.hide();
                                        _marker.openInfoWindow(_iw);
                                    }
                                })();
                            }
                        }
                        //创建InfoWindow
                        function createInfoWindow(i) {
                            var json = markerArr[i];
                            var iw = new BMap.InfoWindow("<b class='iw_poi_title' title='" + json.title + "'>" + json.title + "</b><div class='iw_poi_content'>" + json.content + "</div>");
                            return iw;
                        }
                        //创建一个Icon
                        function createIcon(json) {
                            var icon = new BMap.Icon("http://app.baidu.com/map/images/us_mk_icon.png", new BMap.Size(json.w, json.h), {imageOffset: new BMap.Size(-json.l, -json.t), infoWindowOffset: new BMap.Size(json.lb + 5, 1), offset: new BMap.Size(json.x, json.h)})
                            return icon;
                        }
                    </script>
                    <?php } ?>
 						<p class="FrameListTableTit">处理记录</p>	
                    <table class="table02 FrameListTableItem">
					<thead>		
                        
                            <tr>
                                <td class="FrameGroupName">序号</td>
                                <td class="FrameGroupName">处理人</td>
                                <td class="FrameGroupName">处理状态</td>
                                <td class="FrameGroupName">说明</td>
                                <td class="FrameGroupName">时间</td>
                            </tr>
					</thead>
					<tbody>
                            <tr>
                                <td>1</td>
                                <td><?php echo $bill['uname'] ?></td>
                                <td>提交</td>
                                <td></td>
                                <td><?php echo $bill['applydt'] ?></td>
                            </tr>
                            <?php foreach ($log as $k => $v) { ?>
                                <tr>
                                    <td><?php echo $k + 2; ?></td>
                                    <td><?php echo $v['checkname']; ?></td>
                                    <td><?php echo $v['statusname']; ?></td>
                                    <td><?php echo $v['explain']; ?></td>
                                    <td><?php echo $v['optdt']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php if (in_array($admin['id'], $bill['nowcheckid'])) { ?>
                       <p class="FrameListTableTit">审核处理</p>	
                        <form id="check_form">
                            <input type="hidden" name="id" value="<?php echo $bill['id'] ?>"/>
                            <table class="table01 FrameListTableItem">
								<thead>
                                    <tr>
                                        <td class="FrameGroupName">状态：</td>
                                        <td class="FrameGroupName">待<?php echo $bill['nowcheckname'] ?>处理</td>
                                    </tr>
								</thead>
									<tbody>
                                    <tr>
                                        <td>处理流程：</td>
                                        <td><?php echo $course['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><span style="color:red;">*</span> 处理人：</td>
                                        <td><?php echo $admin['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><span style="color:red;">*</span> 处理动作：</td>
                                        <td>
                                            <?php foreach ($course['courseact'] as $v) { ?>
                                                <label class="color-<?php echo $v[2] ?>"><input type="radio" name="status" value="<?php echo $v[1] ?>"/> <?php echo $v[0] ?></label>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php if ($result['status'] == 4) { ?>
                                        <tr>
                                            <td><span style="color:red;">*</span> 位置：</td>
                                            <td>
                                                <div id='l-map' style="height: 150px;"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span style="color:red;">*</span> 地址：</td>
                                            <td><div class="mui-input-row">
                                                    <input type="hidden" id="map-lng" name="lng" value=""/>
                                                    <input type="hidden" id="map-lat" name="lat" value=""/>
                                                    <input type="text" class="form-control" style="width:90%;" readonly="true" id="map-address" name="address" value=""/>
                                                </div>
                                            </td>
                                        </tr>
                                    <script type="text/javascript">
                                        // 百度地图API功能
                                        var map = new BMap.Map("l-map");
                                        var point = new BMap.Point(116.331398, 39.897445);
                                        map.centerAndZoom(point, 12);

                                        var geolocation = new BMap.Geolocation();
                                        geolocation.getCurrentPosition(function(r) {
                                            if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                                                var mk = new BMap.Marker(r.point);
                                                map.addOverlay(mk);
                                                map.panTo(r.point);
                                                //Alert('您的位置：' + r.point.lng + ',' + r.point.lat);
                                                var mPoint = new BMap.Point(r.point.lng, r.point.lat);

                                                $("#map-lng").val(r.point.lng);
                                                $("#map-lat").val(r.point.lat);
                                                var myGeo = new BMap.Geocoder();
                                                // 根据坐标得到地址描述 
                                                myGeo.getLocation(mPoint, function(result) {
                                                    if (result) {
                                                        $("#map-address").val(result.address);
                                                        var marker = new BMap.Marker(mPoint);
                                                        map.addOverlay(marker);
                                                        marker.setLabel(new BMap.Label('我在这里', {offset: new BMap.Size(20, -10)}));
                                                    }
                                                });
                                            } else {
                                                mui.Alert('failed' + this.getStatus());
                                            }
                                        }, {enableHighAccuracy: true})

                                    </script>
                                <?php } ?>
                                <tr>
                                    <td>说明：</td>
                                    <td><textarea class="form-control" name="checksm"></textarea></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><a class="but but-primary" onclick="do_subcheck()">提交处理</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                    <?php } ?>
            </div>
        </div>
		</div>
    </body>

</html>


<script>
    function do_subcheck() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveCarmsapl"); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                loading('none');
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    loading('none');
                    window.close();
                    parent.location.replace(parent.location.href);
                } else {
                    Alert(data.msg);
                    loading('none');
                }

            }
        });
    }
</script>