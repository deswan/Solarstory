<?php
function dateConvert($type,$timeStamp){
    switch ($type) {
        case 'month':$format = 'M';break;
        
        case 'day':$format = 'd';break;

        case 'date':$format = 'n月d日  H:i';break;
        default:break;
    }
    return date($format,$timeStamp);
}
function sortTime($x,$y){
    if(intval($x['time'])>intval($y['time'])){
        return -1;
    }
    else{
        return 1;
    };
}
?>