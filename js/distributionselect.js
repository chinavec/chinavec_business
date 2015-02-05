
	 $(document).ready(function(){
		$("#btn").click(function(){
			$("p input[name='distribution']").each(function(){
			     //alert($(this).attr("checked"));
				 if($(this).attr("checked") != true){
				  // alert("aaa");
				 $(this).parent().remove();
				 }
			});
		});
		
		$("#allbtn").click(function(){
			//·µ»Øindex.php
			window.location.href="contentdistribution.php";
		});
	});
	