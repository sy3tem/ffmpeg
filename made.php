<?php
$dir = __DIR__.'/Media/';
$file = $dir.$argv[1];
//echo 'ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 \'/mnt/d/下载/'.$file.'\'';
//exit;
if(empty($file)||!file_exists($file))
{
	die('未输入文件名，或者文件不存在！');
}
$avg = exec('ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 '.$file);
$avg = round($avg);
exec('mkdir -p '.$dir.'out/');
for($i=318;$i<=$avg-500;$i+=mt_rand(318,888))
{
	$start = gmdate('H:i:s',$i);
	$len = mt_rand(68,318);
	$cmd = 'ffmpeg -y -i '.$file.' -ss '.$start.' -t '.$len.' -vcodec copy -acodec copy '.$dir.'out/'.$i.'.mp4';
	echo $cmd;
	exec($cmd);//exit;
	//$item[] = array('start'=>$start,'len'=>$len);
}
print_r($item);