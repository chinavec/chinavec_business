<?php
/*
 *服务器监控信息获取
 *肖亚翠
 *V1.0
 *2013-4-3
 */
//require('../../../lib/interfaceAccess.php');

/*function getServerInfo($host, $community, $objectid) {//$objectid是SNMP对象标识符(OID)
    $a = snmpget($host, $community, $objectid);
    $tmp = explode(":", $a);
    if (count($tmp) > 1) {
    	$a = trim($tmp[1]);
    }
    return $a;
}
$host="localhost";
$community="public155";
$serverInfo = array();

//获取$host服务器的内存使用率

//空闲内存
$memoryAvail = getServerInfo($host,$community,".1.3.6.1.4.1.2021.4.6.0"); 
$memoryAvail = substr($memoryAvail, 0, (strlen($memoryAvail) -2))/1024;


//总内存
$memoryTotal = getServerInfo($host,$community,".1.3.6.1.4.1.2021.4.5.0"); 
$memoryTotal = substr($memoryTotal, 0, (strlen($memoryTotal) -2))/1024;

//内存使用率
$serverInfo['memoryUsage'] = 100 - number_format($memoryAvail / $memoryTotal * 100, 2);


//获取$host服务器的CPU使用率
$idleCPU = getServerInfo($host,$community,".1.3.6.1.4.1.2021.11.11.0"); 
$serverInfo['cpuUsage'] = 100 - $idleCPU;

//线程数
$serverInfo['thread']=exec('ps ax | grep httpd -c');
*/

//测试数据
$serverInfo['memoryUsage'] = 20;
$serverInfo['cpuUsage'] = 30;
$serverInfo['thread'] = 300;

echo json_encode($serverInfo);

?>


