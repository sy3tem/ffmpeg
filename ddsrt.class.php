<?php
class ddsrt{
	public static function Down($file)
	{
		$token = 'Yw071qO6bYBmlDSFn3uL1oFzgnVt3UN1';
$api = 'http://api.assrt.net/v1/sub/search?token='.$token.'&q='.$file;//.$name;
$rsp = json_decode(file_get_contents($api),true);
print_r($rsp);exit;
	if(!$rsp)
	{
		die('接口错误');
	}
$id = $rsp['sub']['subs'][0]['id'];
if($id>0)
{
	$more = json_decode(file_get_contents('http://api.assrt.net/v1/sub/detail?token='.$token.'&id='.$id),true);

	if($more['status']==0)
	{
		$zmrar = $more['sub']['subs'][0]['filename'];
		$url = $more['sub']['subs'][0]['url'];
		file_put_contents($file,file_get_contents($url));
		exec('unrar e '.$zmrar.';ls *srt|sed -r \'s#(.*).srt#mv &  \1.srt#\'|bash;cat *.srt > out/'.$file.'.srt');
		unlink($zmrar);
	}else{
		exit('字幕下载出错！');
	}
	//print_r($more);
	self::do($file);
}
	}
	public static function do($file){
		if(!$file)
		{
			exit('No File.');
		}
$srt = file_get_contents('out/'.$file.'.srt');
//print_r($srt);exit;
if(!file_exists)
{
	exit('字幕文件错误。');
}
preg_match_all('/(\d+)\r\n(\d{2}:\d{2}:\d{2},\d{3}) --> (\d{2}:\d{2}:\d{2},\d{3})\r\n([^\r\n]+)/',$srt,$str);
//print_r($str[1]);exit;
$line = $str[1];
array_shift($line);
//print_r($line);exit;
//echo count($str[2]);exit;
$tmp['count'] = count($str[2]);
$tmp['sub'] = array();
foreach($str[2] as $key=>$val)
{
	$out = str_replace(' ',',',trim($str[4][$key]));
	$olen = strlen($out);
	if($olen<40)
	{
		continue;
	}
	//echo $out.'###'.$olen."\r\n";
	if(!empty($line[$key])&&$line[$key]==2)
	{
		$tmp['sub'][]= $key;
		$tmp['line'][] = check($str[2][$key-1]);
		$tmp['line'][] = $str[2][$key-1];
	}
	$start = gmdate('H:i:s',check($val));
	$len = mt_rand(6,10)+check($str[3][$key])-check($val);
	//var_dump($len);exit;
	$data[$key] = array('start'=>$start,'len'=>$len,'out'=>$out);
	//$arr[] = array('old'=>$val,'new'=>gmdate('H:i:s',$time));
}

if(!$tmp['sub'])
{
	exit;
}
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
foreach($n as $k2=>$v2)
{
	$time = retime($tmp['line'][0],check($v2));
	$start = gmdate('H:i:s',$time);
	$len = mt_rand(6,10)+check($str[3][$k2])-check($v2);
	//var_dump($len);exit;
	$out = $str[4][$k2];
	$data[$key] = array('start'=>$start,'len'=>$len,'out'=>$out);
}
//echo count($data);
//print_r($data);
return $data;
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
}