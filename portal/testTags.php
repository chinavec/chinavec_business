<?php 
//Connect the database 
include('lib/connect.php'); 
/** 
* CountTag() - Statistics labels appear the number,and the data to be stored in the two array 
* 
* GetTag() - Access the Tag's Labels from the database 
*/ 
function CountTag($String){ 
	$TagString = $String; 
	//echo $TagString." "; 
	$Tags = explode(";",$TagString); 
	$n = 1; 
	$i = 0; 
	$Continue = TRUE; 
	//echo $Tags[1]." "; 
	//in case no-label's article while($Tags[$n] OR $Tags[++$n] OR $Tags[++$n] ){ 
		$EachTag = $Tags[$n++]; 
		//echo $EachTag." "; 
		$Continue = TRUE; 
		for($i=0;$Continue;$i++){ 
			if( $EachTagStr[$i][0] ) { 
				if( $EachTagStr[$i][0] == $EachTag ){ 
					$EachTagStr[$i][1]++; 
					$Continue = FALSE; 
				} 
				else { 
					if( $EachTagStr[$i+1][0] ) $Continue = TRUE; 
					else { 
						$EachTagStr[$i+1][0] = $EachTag; 
						$EachTagStr[$i+1][1] = 1; 
						$Continue = FALSE; 
					} 
				} 
			} 
			else { //initialize the array $EachTagStr[][] 
				$EachTagStr[$i][0] = $EachTag; 
				$EachTagStr[$i][1] = 1; 
				$Continue = FALSE; 
			} 
		}  
		return $EachTagStr; 
} 


function ShowTag($Row,$ablink){ 
	$i = 0; 
	while($Row[$i][0]){ 
		$EachTag = $Row[$i][0]; 
		$EachCount = $Row[$i][1]; 
		$Size = SetSize($EachCount); 
		echo " <a style='color:BLUE ; font-size:".$Size." ' onMouseOver=this.style.color='#900000' onMouseOut=this.style.color='BLUE' href='".$ablink."tag?tag=".$EachTag."' target='_self' > ".$EachTag."(".$EachCount.")"." "; 
		$i++; 
	} 
} 


function GetTag(){ 
	$QuerySet = mysql_query("select * from video"); 
	while($Row = mysql_fetch_array($QuerySet)){ 
		$Tag = $Row['tags']; 
		$TagString = $TagString.",".$Tag; 
	} 
	return $TagString; 
} 

function SetSize($Size){ 
	$Size += 10; 
	if($Size > 30) 
		$Size = 30; 
	return $Size; 
} 
//Go 
	echo " "; 
	echo "标签云"; 
	$String = GetTag(); 
	$Row = CountTag($String); 
	ShowTag($Row,$ablink); 
	echo " "; 
?> 
