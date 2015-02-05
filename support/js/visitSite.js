// JavaScript Document
/*var simpleEncoding = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

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
*/

$(function(){
	/*var api ="http://chart.apis.google.com/chart?cht=lc&chs=758x200&chxt=x,y"
			+"&chf=bg,s,eeeeee&chls=3,1,0&chg="+(100 / (siteByDay.length - 1))+",50";

	var siteMax = 0;
	var chxl = [];
	
	for(var i = 0, len = siteByDay.length; i < len; i++){
		siteByDay[i] = parseInt(siteByDay[i]);
		siteMax = Math.max(siteMax, siteByDay[i]);
		chxl[i] = i + 1;
	}
	
	siteMax1 = Math.ceil(siteMax * 1.2);
	
	var siteChd = simpleEncode(siteByDay, siteMax1);
	var siteChxl = '0:|';
	siteChxl += chxl.join('|');
	siteChxl += "|1:||" + Math.round(siteMax/2) + '|' + siteMax1;
	
	var siteSource = api + '&chxl=' + siteChxl + '&chd=' + siteChd;
	$('#site').prop('src', siteSource);
	
	
	//填充比例
	$('#siteDetail tbody tr').each(function(){
		var value = $(this).find('td:eq(1)').text();
		value = parseInt(value);
		var proportion = Math.max(0.5, value / siteMax * 100);
		$(this).find('.proportion').css('width', proportion+'%');
	});*/

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
			var terminal = $('#terminal').val();
			var url = 'newvisitSite.php';
			o = o.split('-');
			url += '?year=' + o[0];
			url += '&month=' + o[1];
			url += '&terminal=' + terminal;
			console.log(url);
			window.location.href = url;
		}
	});
	//终端选择事件
	$('#terminal').bind('change',function(){
		var ter = $(this).val();
		var url = 'newvisitSite.php';
		url += '?year=' + year;
		url += '&month=' + month;
		url += '&terminal=' + ter;
		window.location.href = url;
	});
});
