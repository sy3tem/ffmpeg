<?php
$file = $argv[1];
//echo 'ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 \'/mnt/d/下载/'.$file.'\'';
//exit;
$avg = exec('ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 \'/mnt/d/下载/'.$file.'\'');
$avg = round($avg);
for($i=300;$i<=$avg-500;$i+=mt_rand(60,300))
{
	$start = gmdate('H:i:s',$i);
	$len = mt_rand(60,300);
	$cmd = 'ffmpeg -y -i  \'/mnt/d/下载/'.$file.'\' -ss '.$start.' -t '.$len.' -vcodec copy -acodec copy '.$i.'.mp4';
	echo $cmd;
	exec($cmd);//exit;
	//$item[] = array('start'=>$start,'len'=>$len);
}
print_r($item);