<?php
$srt = file_get_contents('out/all.srt');
//print_r($srt);exit;
preg_match_all('/(\d+)\r\n(\d{2}:\d{2}:\d{2},\d{3}) --> (\d{2}:\d{2}:\d{2},\d{3})\r\n([^\r\n]+)/',$srt,$str);
//print_r($str[1]);exit;
$line = $str[1];
array_shift($line);
//print_r($line);exit;
//echo count($str[2]);exit;
$tmp['count'] = count($str[2]);
$subs = array();
foreach($str[2] as $key=>$val)
{
	if(!empty($line[$key])&&$line[$key]==2)
	{
		$tmp['sub'][]= $key;
		
	}
	//$time[$key] = check(str_replace(',','.',$val));
	
	//$arr[] = array('old'=>$val,'new'=>date('H:i:s',$time));
}
//print_r($tmp);
foreach($tmp['sub'] as $k=>$t)
{
	if($t == reset($tmp['sub']))
	{
		//echo 111;
		$s1 = $tmp['count'] - $t;
		$s2 = $tmp['sub'][$k+1] - $t;
		//echo $t."###\n".$tmp['sub'][$k+1]."###\n".$s1."\n".$s2;
		$n[$k] = array_slice($str[2],$s1,$s2);
	}
	elseif($t==end($tmp['sub'])){
		//echo 222;
	}
	else{
		//echo 333;
	}
}
print_r($n);
//$newsrt = array_slice($str[2],0,end($tmp['sub']));
//print_r($newsrt);
//print_r($time);
//print_r($str[1]);
function check($time)
{
if(!$time){
$ret = 0;
}else{
    $parsed = date_parse($time);
    $ret = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second'];
}
return $ret;
}
function retime($time1,$time2){
	return $time1 + $time2;
}