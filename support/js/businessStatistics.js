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
			+"&chf=bg,s,eeeeee&chls=3,1,0&chg="+(100 / (orderByDay.length - 1))+",50";

	var orderMax = 0;
	var incomeMax = 0;
	var chxl = [];
	
	for(var i = 0, len = orderByDay.length; i < len; i++){
		orderByDay[i] = parseInt(orderByDay[i]);
		orderMax = Math.max(orderMax, orderByDay[i]);
		chxl[i] = i + 1;
	}
	for(var i = 0, len = incomeByDay.length; i < len; i++){
		incomeByDay[i] = parseInt(incomeByDay[i]);
		incomeMax = Math.max(incomeMax, incomeByDay[i]);
	}
	
	orderMax1 = Math.ceil(orderMax * 1.2);
	incomeMax1 = Math.ceil(incomeMax * 1.2);
	
	var orderChd = simpleEncode(orderByDay, orderMax1);
	var orderChxl = '0:|';
	orderChxl += chxl.join('|');
	orderChxl += "|1:||" + Math.round(orderMax/2) + '|' + orderMax1;
	
	var orderSource = api + '&chxl=' + orderChxl + '&chd=' + orderChd;
	$('#order').prop('src', orderSource);
	
	var incomeChd = simpleEncode(incomeByDay, incomeMax1);
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
	
	//填充月份选择控制
	var d = new Date();
	var y = d.getFullYear();
	var m = d.getMonth() + 1;
	
	var option = '<option value="">--请选择--</option>';
	if(startYear < y){
		for(var i = m; i >= 1; i--){
			option += '<option value='+y+'-'+i+'>'+y+'-'+i+'</option>';
		}
		if((startYear+1) < y){
			for(var i = 12; i >= 1; i--){
				option += '<option value='+(startYear+1)+'-'+i+'>'+(startYear+1)+'-'+i+'</option>';
			}
		}
		for(var i = 12; i >= startMonth; i--){
			option += '<option value='+startYear+'-'+i+'>'+startYear+'-'+i+'</option>';
		}
	}else{
		for(var i = m; i >= startMonth; i--){
			option += '<option value='+y+'-'+i+'>'+y+'-'+i+'</option>';
		}
	}
	$('#selectMonth').append($(option));
	$('#selectMonth').bind('change', function(){
		if($(this).val() != ""){
			var o = $(this).val();
			var url = 'businessStatistics.php'
			o = o.split('-');
			url += '?year=' + o[0];
			url += '&month=' + o[1];
			//alert(url);
			window.location.href = url;
		}
	});
});