// JavaScript Document
var simpleEncoding = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

function simpleEncode(values,maxValue) {

  var chartData = ['s:'];
  for (var i = 0; i < values.length; i++) {
    var currentValue = values[i];
    if (!isNaN(currentValue) && currentValue >= 0) {
      chartData.push(simpleEncoding.charAt(Math.round((simpleEncoding.length-1) * currentValue / maxValue)));
    }
    else {
      chartData.push('_');
    }
  }
  return chartData.join('');
}

$(function(){
	var api ="http://chart.apis.google.com/chart?cht=lc&chs=758x200&chxt=x,y"
			+"&chf=bg,s,eeeeee&chls=3,1,0&chg=9.090909,50";
	var orderMax = 0;
	var incomeMax = 0;
	var chxl = [];
	
	for(var i = 0, len = orderByMonth.length; i < len; i++){
		orderByMonth[i] = parseInt(orderByMonth[i]);
		orderMax = Math.max(orderMax, orderByMonth[i]);
		chxl[i] = i + 1;
	}
	for(var i = 0, len = incomeByMonth.length; i < len; i++){
		incomeByMonth[i] = parseInt(incomeByMonth[i]);
		incomeMax = Math.max(incomeMax, incomeByMonth[i]);
	}
	
	orderMax1 = Math.ceil(orderMax * 1.2);
	incomeMax1 = Math.ceil(incomeMax * 1.2);
	
	var orderChd = simpleEncode(orderByMonth, orderMax1);
	var orderChxl = '0:|';
	orderChxl += chxl.join('|');
	orderChxl += "|1:||" + Math.round(orderMax/2) + '|' + orderMax1;
	
	var orderSource = api + '&chxl=' + orderChxl + '&chd=' + orderChd;
	$('#order').prop('src', orderSource);
	
	var incomeChd = simpleEncode(incomeByMonth, incomeMax1);
	var incomeChxl = '0:|';
	incomeChxl += chxl.join('|');
	incomeChxl += "|1:||" + Math.round(incomeMax/2) + '|' + incomeMax1;
	
	var incomeSource = api + '&chxl=' + incomeChxl + '&chd=' + incomeChd;
	$('#income').prop('src', incomeSource);
	
	//填充比例
	$('#orderDetail tbody tr').each(function(){
		var value = $(this).find('td:eq(1)').text();
		value = parseInt(value);
		var proportion = Math.max(0.3, value / orderMax * 100);
		$(this).find('.proportion').css('width', proportion+'%');
	});
	
	$('#incomeDetail tbody tr').each(function(){
		var value = $(this).find('td:eq(1)').text();
		value = parseInt(value);
		var proportion = Math.max(0.3, value / incomeMax * 100);
		$(this).find('.proportion').css('width', proportion+'%');
	});
	
	$('.detailButton').toggle(function(){
		$(this).text('隐藏详细信息').next().show();
		return false;
	}, function(){
		$(this).text('显示详细信息').next().hide();
		return false;
	});
	
	//填充年份选择控制
	var d = new Date();
	var y = d.getFullYear();
	
	var option = '<option value="">--请选择--</option>';
	for(var i = y; i >= startYear; i--){
		option += '<option value='+i+'>'+i+'</option>';
	}
	$('#selectYear').append($(option));
	$('#selectYear').bind('change', function(){
		if($(this).val() != ""){
			var o = $(this).val();
			var url = 'statisticsByMonth.php'
			url += '?year=' + $(this).val();
			
			url += '&bid=' + (businessId == 0 ? '' : businessId);
			//alert(url);
			window.location.href = url;
		}
	});
});