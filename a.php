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
		$tmp['line'][] = check($str[2][$key-1]);
		$tmp['line'][] = $str[2][$key-1];
	}
	$time = check($val);
	$arr[] = array('old'=>$val,'new'=>gmdate('H:i:s',$time));
}
//var_dump(gmdate('H:i:s',check($tmp['line'][0])));
//var_dump($tmp['line'][0]);
//exit;//print_r($tmp);exit;
$next = $tmp['sub'];
array_shift($next);
array_push($next,$tmp['count']);
//print_r($next);exit;
$n = array();
foreach($tmp['sub'] as $k=>$t)
{
	$len = $next[$k] - $t;
	$n+= array_slice($str[2],$t,$len,true);//array('start'=>$t,'len'=>$len); 
	
}
//print_r($asd);
foreach($n as $k2=>$v2)
{
	$time = retime($tmp['line'][0],check($v2));
	$arr[$k2] = array('old'=>$v2,'new'=>gmdate('H:i:s',$time));
}
print_r($arr);
//$newsrt = array_slice($str[2],0,end($tmp['sub']));
//print_r($newsrt);
//print_r($time);
//print_r($str[1]);
function addtime($t1,$t2)
{
	
}
function check($time)
{
if(!$time){
$ret = 0;
}else{
	$time = str_replace(',','.',$time);
    $parsed = date_parse($time);
    $ret = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second'];
}
return $ret;
}
function retime($time1,$time2){
	return $time1 + $time2;
}