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
	var api ="http://chart.apis.google.com/chart?cht=lc&chco=0000ff&chs=758x200&chxt=x,y"
			+"&chf=bg,s,ffffff&chls=3,1,0&chg="+(100 / (userByDay.length - 1))+",50";

	var userMax = 0;
	var chxl = [];
	
	for(var i = 0, len = userByDay.length; i < len; i++){
		userByDay[i] = parseInt(userByDay[i]);
		userMax = Math.max(userMax, userByDay[i]);
		chxl[i] = i + 1;
	}
	
	userMax1 = Math.ceil(userMax * 1.2);
	
	var userChd = simpleEncode(userByDay, userMax1);
	var userChxl = '0:|';
	userChxl += chxl.join('|');
	userChxl += "|1:||" + Math.round(userMax/2) + '|' + userMax1;
	
	var userSource = api + '&chxl=' + userChxl + '&chd=' + userChd;
	$('#user').prop('src', userSource);
	
	
	//填充比例
	$('#userDetail tbody tr').each(function(){
		var value = $(this).find('td:eq(1)').text();
		value = parseInt(value);
		var proportion = Math.max(0.5, value / userMax * 100);
		$(this).find('.proportion').css('width', proportion+'%');
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
			var url = 'userActive.php'
			o = o.split('-');
			url += '?year=' + o[0];
			url += '&month=' + o[1];
			
			window.location.href = url;
		}
	});
});
