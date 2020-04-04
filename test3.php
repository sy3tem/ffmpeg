<?php
set_time_limit(0);

$conetnt = file_get_contents('all.srt');

$arr = explode(PHP_EOL,$conetnt);
echo '<pre>';
$arr = array_filter($arr);
$arr = array_values($arr);

$i=0;
$num_arr = array();
foreach ($arr as $k=>$v){
    $i++;
    if ($v==1){
        $num_arr[] = $i-1;
    }
}

if (empty($num_arr)){
    //只有一块，不处理
    die('只有一个块');
}
$now = 0;
//将内容分割成多个块
$new_arr = array();
foreach ($num_arr as $v){
    $new_arr [] = array_slice($arr,$now,$v-$now);
    $now = $v;
}
$new_arr [] = array_slice($arr,$now);
//var_dump($new_arr);

$last_time = 0;
$my_arr = array();
foreach ($new_arr as $nk=>$arr){
    //区域的最后一个时间节点
    $max_string = $arr[count($arr)-2];
    if (strpos($max_string,' --> ')===false){
       echo ($max_string); continue;
    }
    //每一块的时间区域
    $sts = explode(' --> ',$max_string);
    if ($nk!=0){
        foreach ($arr as $k=>$v){
            if ($k%3==1){
                $nsts = explode(' --> ',$v);
                var_dump($nsts);
                var_dump($last_time);
                $s1= addtime($last_time,$nsts[0]);
                $s2= addtime($last_time,$nsts[1]);
                $s = $s1.' --> '.$s2;

                $arr[$k]=$s;
            }
        }
    }
    $my_arr = array_merge($my_arr,$arr);
    $last_time = addtime($last_time,$sts[1]);
    var_dump($last_time);
}

$str = implode("\r\n", $my_arr);

file_put_contents("new_all.srt", $str);

function addtime($stime1,$stime2){

    $arr1 = explode(',',$stime1);
    $arr2 = explode(',',$stime2);

    $t1 = strtotime($arr1[0])- strtotime('today')+strtotime($arr2[0])- strtotime('today');

    $t2 = @$arr1[1]+$arr2[1];
    if ($t2>=1000){
        $t2=$t2-1000;
        $t1=$t1+1;
    }

    return date('H:i:s',$t1).','.$t2;
}