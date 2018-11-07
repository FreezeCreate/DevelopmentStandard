window.onload = function() {
	/*
	 *多选框
	 * */
	$(document).on('click', '.checkbox', function(e) {
		e.stopPropagation();
		$(this).toggleClass('active')
	})
	/*
	 *单选框
	 * */
	$(document).on('click', '.radio', function(e) {
		e.stopPropagation();
		var arr = document.getElementsByName($(this).next().attr('name'));
		$.each(arr, function(k,v){
			$(v).prev().removeClass('active')
		})
		$(this).addClass('active')
	})
	/*
	 *二选框
	 * */
	$(document).on('click', '.checkT', function(e) {
		e.stopPropagation();
		var that = $(this);
		if(that.hasClass('true')) {

			that.removeClass('true');
			that.addClass('false');
			that.next().val(2)
		} else if(that.hasClass('false')) {

			that.removeClass('false');
			that[0].className = 'checkT';
			that.next().val('')
		} else {
			that.addClass('true');
			that.next().val(1)
		}
	})
	/*
	 *三选框
	 * */
	$(document).on('click', '.check', function(e) {
		e.stopPropagation();
		var that = $(this);
		if(that.hasClass('true')) {

			that.removeClass('true');
			that.addClass('false');
			that.next().val(2)
		} else if(that.hasClass('false')) {

			that.removeClass('false');
			that.addClass('squar');
			that.next().val(3)
		} else if(that.hasClass('squar')) {

			that.removeClass('squar');
			that[0].className = 'check';
			that.next().val('')
		} else {
			that.addClass('true');
			that.next().val(1)
		}
	})
	/*
	 *重置
	 * */
	$('.TablesSerchReset').click(function(){
		$('input').val('')
		$(".FrameGroupInput option:first").prop("selected", 'selected')
		$('.MoreSelectItem').removeClass('active')
	})
	/*
	 *行数据合计 加
	 * */
	$(document).on('change', '.colAdd input', function(){
		$('.colAdd tr').each(function(k,v){
			var num1 = 0, num2 = 0;
			$(v).children('.num1').each(function(k1,v1){
				var a = $(v1).children('input').val() - 0;
				if(!isNaN(a)){
					num1 += a;
				}
			})
			$(v).children('.num2').each(function(k1,v1){
				var a = $(v1).children('input').val() - 0;
				if(!isNaN(a)){
					num2 += a;
				}
			})
			$(v).children('.num1all').children('input').val(num1)
			$(v).children('.num2all').children('input').val(num2)
		})
		var allNum1 = 0, allNum2 = 0;
		$('.num1all').each(function(k,v){
			var a = $(v).children('input').val() - 0;
			if(!isNaN(a)){
				allNum1 += a;
			}
		})
		$('.totalAllNum1').text(allNum1)
		$('.num2all').each(function(k,v){
			var a = $(v).children('input').val() - 0;
			if(!isNaN(a)){
				allNum2 += a;
			}
		})
		$('.totalAllNum2').text(allNum2)
	})
	/*
	 *列数据合计
	 * */
	$(document).on('change', '.totalVal input', function(e) {
		e.stopPropagation();
		var index = $(this).parent().index();
		var num = 0;
		$('.TabInp tr').each(function(k, v) {
			var num1 = $(v).children('td').eq(index).children('input').val() - 0;
			if(!isNaN(num1)) {
				num += num1
			}
		})
		$('.totalMneu td').eq(index).text(num)
	})
	
	/*
	 *行数据合计 乘
	 * */
	$(document).on('change', '.total input', function() {
		Total()
	})
};
/*
 *金额转大写
 * */
function changeMoneyToChinese(money) {
	var cnNums = new Array("零", "壹", "贰", "叁", "肆", "伍", "陆", "柒", "捌", "玖"); //汉字的数字  
	var cnIntRadice = new Array("", "拾", "佰", "仟"); //基本单位  
	var cnIntUnits = new Array("", "万", "亿", "兆"); //对应整数部分扩展单位  
	var cnDecUnits = new Array("角", "分", "毫", "厘"); //对应小数部分单位  
	//var cnInteger = "整"; //整数金额时后面跟的字符  
	var cnIntLast = "元"; //整型完以后的单位  
	var maxNum = 999999999999999.9999; //最大处理的数字  

	var IntegerNum; //金额整数部分  
	var DecimalNum; //金额小数部分  
	var ChineseStr = ""; //输出的中文金额字符串  
	var parts; //分离金额后用的数组，预定义  
	if(money == "") {
		return "";
	}
	money = parseFloat(money);
	if(money >= maxNum) {
		$.alert('超出最大处理数字');
		return "";
	}
	if(money == 0) {
		//ChineseStr = cnNums[0]+cnIntLast+cnInteger;  
		ChineseStr = cnNums[0] + cnIntLast
		//document.getElementById("show").value=ChineseStr;  
		return ChineseStr;
	}
	money = money.toString(); //转换为字符串  
	if(money.indexOf(".") == -1) {
		IntegerNum = money;
		DecimalNum = '';
	} else {
		parts = money.split(".");
		IntegerNum = parts[0];
		DecimalNum = parts[1].substr(0, 4);
	}
	if(parseInt(IntegerNum, 10) > 0) { //获取整型部分转换  
		zeroCount = 0;
		IntLen = IntegerNum.length;
		for(i = 0; i < IntLen; i++) {
			n = IntegerNum.substr(i, 1);
			p = IntLen - i - 1;
			q = p / 4;
			m = p % 4;
			if(n == "0") {
				zeroCount++;
			} else {
				if(zeroCount > 0) {
					ChineseStr += cnNums[0];
				}
				zeroCount = 0; //归零  
				ChineseStr += cnNums[parseInt(n)] + cnIntRadice[m];
			}
			if(m == 0 && zeroCount < 4) {
				ChineseStr += cnIntUnits[q];
			}
		}
		ChineseStr += cnIntLast;
		//整型部分处理完毕  
	}
	if(DecimalNum != '') { //小数部分  
		decLen = DecimalNum.length;
		for(i = 0; i < decLen; i++) {
			n = DecimalNum.substr(i, 1);
			if(n != '0') {
				ChineseStr += cnNums[Number(n)] + cnDecUnits[i];
			}
		}
	}
	if(ChineseStr == '') {
		//ChineseStr += cnNums[0]+cnIntLast+cnInteger;  
		ChineseStr += cnNums[0] + cnIntLast;
	}
	/* else if( DecimalNum == '' ){ 
	                ChineseStr += cnInteger; 
	                ChineseStr += cnInteger; 
	            } */
	return ChineseStr;
}
function Total(){
		$('.totalItem tr').each(function(k, v) {
			var num = $(v).children('.total.num').children('input').val()
			var price = $(v).children('.total.price').children('input').val()
			$(v).children('.total.val').children('input').val((num * price).toFixed(2))
		})
		$('.totalItem .totalMneu td.total').text(0)
		$('.totalItem tr').each(function(k, v) {
			$(v).children('.total').each(function(k1, v1) {
				var index = $(v1).index()
				var num = $(v1).children('input').val() - 0
				if(!isNaN(num)) {
					var td = $('.totalItem .totalMneu td').eq(index);
					if(td.hasClass('total')) {

						td.text((td.text() - 0 + num))
					}
				}
			})
		})
		$('.total.all').text(($('.total.all').text() - 0).toFixed(2))
		$('.hjdx').text(changeMoneyToChinese($('.total.all').text() - 0))
	}