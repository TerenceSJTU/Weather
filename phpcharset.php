<?php  
function phpcharset($data, $to)  
{  
    if (is_array($data)) {  
        foreach ($data as $key => $val) {  
            $data[$key] = phpcharset($val, $to);  
        }  
    } else {  
        $encode_array = array(  
            'ASCII',  
            'UTF-8',  
            'GBK',  
            'GB2312',  
            'BIG5'  
        );  
        $encoded      = mb_detect_encoding($data, $encode_array);  
        $to           = strtoupper($to);  
        if ($encoded != $to) {  
            $data = mb_convert_encoding($data, $to, $encoded);  
        }  
    }  
    return $data;  
}  
  
function toUTF8($data)  
{  
    return phpcharset($data, 'UTF-8');  
}  
  
function toGBK($data)  
{  
    return phpcharset($data, 'GBK');  
}  
  
function toASCII($data)  
{  
    return phpcharset($data, 'ASCII');  
}  
  
function toGB2312($data)  
{  
    return phpcharset($data, 'GB2312');  
}  
  
function toBIG5($data)  
{  
    return phpcharset($data, 'BIG5');  
}  
?>  