<?php  

  
function get_city_code($city_name = '北京')  
{  
    $remote_server = 'http://search.weather.com.cn/wap/search.php';  
    $post_data     = array(  
        'city' => $city_name,  
        'submit' => 'submit'  
    );  
      
    $ch = curl_init();  
    curl_setopt($ch, CURLOPT_URL, $remote_server);  
    curl_setopt($ch, CURLOPT_POST, true);  
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
    $data = curl_exec($ch);  
    curl_close($ch);  
    //Post的返回结果如下：  
    //<script>window.location="http://wap.weather.com.cn/wap/weather/101010100.shtml";</script>  
    $data = explode("/", $data); //$data[5]='101010100.shtml";<';  
    $data = explode('.', $data[5]);  
    return $data[0];  
}  
  
function get_weather_by_name($city_name = '北京')  
{  
    $city_code    = get_city_code($city_name);  
    $weatherurl   = "http://m.weather.com.cn/data/" . $city_code . ".html";  
    $weatherjson  = file_get_contents($weatherurl); 
    $weatherarray = json_decode($weatherjson, true);  
   $weatherinfo  = $weatherarray['weatherinfo'];  
    return $weatherinfo;  
}  
  
function get_weather_by_code($city_code = '101010100')  
{  
    $weatherurl   = "http://m.weather.com.cn/data/" . $city_code . ".html";  
    $weatherjson  = file_get_contents($weatherurl);  
    $weatherarray = json_decode($weatherjson, true);  
    $weatherinfo  = $weatherarray['weatherinfo'];  
    return $weatherinfo;  
}  
  

  
function get_week($day, $short = false)  
{  
    $week_short = array(  
        '周日',  
        '周一',  
        '周二',  
        '周三',  
        '周四',  
        '周五',  
        '周六'  
    );  
    $week       = array(  
        '星期日',  
        '星期一',  
        '星期二',  
        '星期三',  
        '星期四',  
        '星期五',  
        '星期六'  
    );  
    $w          = date('w', $day);  
    if ($short)  
        return $week_short[$w];  
    else  
        return $week[$w];  
}  


  
?>  