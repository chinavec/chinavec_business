jQuery(document).ready(function($){
	var type = 0,
		dur = 0,
		year = 0;
	
	
	$("#select1 dd").click(function () {
		$(this).addClass("selected").siblings().removeClass("selected");
		if ($(this).hasClass("select-all")) {
			$("#selectA").remove();
		} else {
			var copyThisA = $(this).clone();
			if ($("#selectA").length > 0) {
				$("#selectA span").html($(this).text());
			} else {
				$(".select-result dl").append(copyThisA.attr("id", "selectA"));
			}
		}
	});
	
	$("#select2 dd").click(function () {
		$(this).addClass("selected").siblings().removeClass("selected");
		if ($(this).hasClass("select-all")) {
			$("#selectB").remove();
		} else {
			var copyThisB = $(this).clone();
			if ($("#selectB").length > 0) {
				$("#selectB span").html($(this).text());
			} else {
				$(".select-result dl").append(copyThisB.attr("id", "selectB"));
			}
		}
	});
	
	$("#select3 dd").click(function () {
		$(this).addClass("selected").siblings().removeClass("selected");
		if ($(this).hasClass("select-all")) {
			$("#selectC").remove();
		} else {
			var copyThisC = $(this).clone();
			if ($("#selectC").length > 0) {
				$("#selectC span").html($(this).text());
			} else {
				$(".select-result dl").append(copyThisC.attr("id", "selectC"));
			}
		}
	});
	
	$("#selectA").live("click", function () {
		$(this).remove();
		$("#select1 .select-all").addClass("selected").siblings().removeClass("selected");
		$("#type").val(0);
	});
	
	$("#selectB").live("click", function () {
		$(this).remove();
		$("#select2 .select-all").addClass("selected").siblings().removeClass("selected");
		$("#dur").val(0);
	});
	
	$("#selectC").live("click", function () {
		$(this).remove();
		$("#select3 .select-all").addClass("selected").siblings().removeClass("selected");
		$("#year").val(0);
	});
	
	$(".select dd").live("click", function () {
		if ($(".select-result dd").length > 0) {
			$(".select-no").hide();
		} else {
			$(".select-no").show();
		}
	});
	
	//视频类型
	$("#select1").find("span").click(function () {
		$("#type").val($(this).attr("tag"));
		// type = $(this).attr("tag");
	});
	//视频时长
	$("#select2").find("span").click(function () {
		// dur = $(this).attr("tag");
		$("#dur").val($(this).attr("tag"));
	});
	
	//年份
	$("#select3").find("span").click(function () {
		// year = $(this).attr("tag");
		$("#year").val($(this).attr("tag"));
	});
	
});