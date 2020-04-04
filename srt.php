<?php
$token = '4wmQsDjmIK4t7vpAateaI8byw3OydfCa';
$api = 'http://api.assrt.net/v1/sub/search?token='.$token.'&q=赌神2';//.$name;
$rsp = json_decode(file_get_contents($api),true);
$id = $rsp['sub']['subs'][0]['id'];
if($id>0)
{
	$more = json_decode(file_get_contents('http://api.assrt.net/v1/sub/detail?token='.$token.'&id='.$id),true);
	if($more['status']==0)
	{
		$file = $more['sub']['subs'][0]['filename'];
		$url = $more['sub']['subs'][0]['url'];
		file_put_contents($file,file_get_contents($url));
		exec('unrar e '.$file.';ls *srt|sed -r \'s#(.*).srt#mv &  \1.srt#\'|bash;');
		unlink($file);
	}
	print_r($more);
}
//print_r($rsp);