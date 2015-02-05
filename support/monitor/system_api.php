<?php
			$arr=$_GET['apiuri'];
			//$arr=array("system/server", "system/cpu", "system/harddisk", "system/loadavg");
			
			/**
			* ===== [M] GET 获取服务器参数 V1.1 =====
			* @link    GET system/server
			* @return  JSON    {
			*                      "status"    : bool,
			*                      "ip"        : string,       // IP
			*                      "webport"   : int,          // Web端口
			*                      "wsport"    : int,          // Websockets端口
			*                      "sysid"     : string,       // 服务器标识
			*                      "oscore"    : string,       // 操作系统内核
			*                      "webserver" : string,       // Web服务器
			*                      "update"    : float         // 运行时间原始秒数
			*                  }
			*/
			$sysid = php_uname();
			$os = explode(" ", $sysid);

			$update = explode(" ", implode("", file("/proc/uptime")));
			$update = trim($update[0]);

			$data = array(
				"status"    => true,
				"ip"        => $_SERVER['SERVER_NAME'],
				"webport"   => $_SERVER['SERVER_PORT'],
				"wsport"    => 8889,
				"sysid"     => $sysid,
				"oscore"    => isset($os[2]) ? $os[2] : "unknown",
				"webserver" => $_SERVER['SERVER_SOFTWARE'],
				"update"    => $update
			);
			//$data = array("status"=>false);
			
			//$data=json_encode($data, JSON_NUMERIC_CHECK);	
			$arr["system/server"]=$data;
			//print_r($arr);exit;


			/**
			* ===== [M] GET 获取CPU参数 V1.1 =====
			* @link    GET system/cpu
			* @return  JSON    {
			*                      "status"    : bool,
			*                      "brand"     : string,       // CPU型号
			*                      "num"       : int,          // CPU内核数
			*                      "freq"      : int,          // CPU频率
			*                      "cache"     : string,       // CPU缓存
			*                      "timestamp" : int           // 服务器时间戳
			*                  }
			*/
			$str = implode("", file("/proc/cpuinfo"));
			@preg_match_all("/model\s+name\s{0,}\:+\s{0,}([\w\s\)\(\@.-]+)([\r\n]+)/s", $str, $model);
			@preg_match_all("/cpu\s+MHz\s{0,}\:+\s{0,}([\d\.]+)[\r\n]+/", $str, $mhz);
			@preg_match_all("/cache\s+size\s{0,}\:+\s{0,}([\d\.]+\s{0,}[A-Z]+)/", $str, $cache);

			$datacpu = array(
				"status"    => true,
				"brand"     => $model[1][0],
				"num"       => sizeof($model[1]),
				"freq"      => $mhz[1][0],
				"cache"     => $cache[1][0],
				"timestamp" => time()*1000
			);
			//print_r($datacpu);
			//$datacpu=json_encode($datacpu, JSON_NUMERIC_CHECK);	
			$arr["system/cpu"]=$datacpu;
			//print_r($arr);

			
			/**
			* ===== [M] GET 获取硬盘使用情况 V1.1 =====
			* @link    GET system/harddisk
			* @return  JSON    {
			*                      "status"    : bool,
			*                      "unit"      : string,   // 数据的单位（G）
			*                      "total"     : float,    // 总容量
			*                      "available" : float,    // 可用容量
			*                      "used"      : float,    // 已用容量
			*                      "percent"   : string    // 已用空间占比
			*                  }
			*/
			$dt = round(@disk_total_space(".") / (1024 * 1024 * 1024), 3); //总
			$df = round(@disk_free_space(".") / (1024 * 1024 * 1024), 3); //可用
			$du = $dt - $df; //已用
			$hdPercent = (floatval($dt) != 0) ? round($du / $dt * 100, 2) : 0;

			$datadisk = array(
				"status"    => true,
				"unit"      => 'G',
				"total"     => $dt,
				"available" => $df,
				"used"      => $du,
				"percent"   => $hdPercent . "%"
			);
			//print_r($datadisk);
			//$datadisk=json_encode($datadisk, JSON_NUMERIC_CHECK);	
			$arr["system/harddisk"]=$datadisk;
			
			/**
			* ===== [M] GET 获取系统平均负载 V1.0 =====
			* @link    GET system/loadavg
			* @return  JSON    {
			*                      "status"    : bool,
			*                      "proc1"     : float,        // 1分钟内的平均进程数
			*                      "proc5"     : float,        // 5分钟内的平均进程数
			*                      "proc15"    : float,        // 15分钟内的平均进程数
			*                      "curproc"   : string        // 分子是正在运行的进程数，分母是进程总数
			*                  }
			*/
			$str = explode(" ", implode("", file("/proc/loadavg")));
			$dataload = array(
				"status"    => true,
				"proc1"     => $str[0],
				"proc5"     => $str[1],
				"proc15"    => $str[2],
				"curproc"   => $str[3]
			);
			//print_r($dataload);
			//$dataload=json_encode($dataload, JSON_NUMERIC_CHECK);	
			$arr["system/loadavg"]=$dataload;

			$arr=json_encode($arr);			
			print_r($arr);


			
			
?>
