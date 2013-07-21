<?php  
require_once('phpcharset.php');

class get_guest_info  
{  
    ////获得访客浏览器类型  
    function GetBrowser()  
    {  
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {  
            $br = $_SERVER['HTTP_USER_AGENT'];  
            if (preg_match('/MSIE/i', $br)) {  
                $br = 'MSIE';  
            } elseif (preg_match('/Firefox/i', $br)) {  
                $br = 'Firefox';  
            } elseif (preg_match('/Chrome/i', $br)) {  
                $br = 'Chrome';  
            } elseif (preg_match('/Safari/i', $br)) {  
                $br = 'Safari';  
            } elseif (preg_match('/Opera/i', $br)) {  
                $br = 'Opera';  
            } else {  
                $br = 'Other';  
            }  
            return $br;  
        } else {  
            return "获取浏览器信息失败！";  
        }  
    }  
      
    ////获得访客浏览器语言  
    function GetLang()  
    {  
        if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {  
            $lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];  
            $lang = substr($lang, 0, 5);  
            if (preg_match("/zh-cn/i", $lang)) {  
                $lang = "简体中文";  
            } elseif (preg_match("/zh/i", $lang)) {  
                $lang = "繁体中文";  
            } else {  
                $lang = "English";  
            }  
            return $lang;  
              
        } else {  
            return "获取浏览器语言失败！";  
        }  
    }  
      
    ////获取访客操作系统  
    function GetOs()  
    {  
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {  
            $OS = $_SERVER['HTTP_USER_AGENT'];  
            if (preg_match('/win/i', $OS)) {  
                $OS = 'Windows';  
            } elseif (preg_match('/mac/i', $OS)) {  
                $OS = 'MAC';  
            } elseif (preg_match('/linux/i', $OS)) {  
                $OS = 'Linux';  
            } elseif (preg_match('/unix/i', $OS)) {  
                $OS = 'Unix';  
            } elseif (preg_match('/bsd/i', $OS)) {  
                $OS = 'BSD';  
            } else {  
                $OS = 'Other';  
            }  
            return $OS;  
        } else {  
            return "获取访客操作系统信息失败！";  
        }  
    }  
      
    ////获得访客真实ip  
    function Getip()  
    {  
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {  
            $ip = $_SERVER["HTTP_CLIENT_IP"];  
        }  
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { //获取代理ip  
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);  
        }  
        if ($ip) {  
            $ips = array_unshift($ips, $ip);  
        }  
          
        $count = count($ips);  
        for ($i = 0; $i < $count; $i++) {  
            if (!preg_match("/^(10|172\.16|192\.168)\./i", $ips[$i])) { //排除局域网ip  
                $ip = $ips[$i];  
                break;  
            }  
        }  
        $tip = empty($_SERVER['REMOTE_ADDR']) ? $ip : $_SERVER['REMOTE_ADDR'];  
        if ($tip == "127.0.0.1") { //获得本地真实IP  
            return $this->get_onlineip();  
        } else {  
            return $tip;  
        }  
    }  
      
    ////获得本地真实IP  
    function get_onlineip()  
    {  
        $mip = file_get_contents("http://iframe.ip138.com/ic.asp");  
        if ($mip) {  
            preg_match("/\[.*\]/", $mip, $sip);  
            $p = array(  
                "/\[/",  
                "/\]/"  
            );  
            return preg_replace($p, "", $sip[0]);  
        } else {  
            return toUTF8("获取本地IP失败！");  
        }  
    }  
      
    ////根据ip获得访客所在地地名：基于纯真数据库  
    function Getaddress_1($ip = '')  
    {  
        if (empty($ip)) {  
            $ip = $this->Getip();  
        }  
          
        require('qqwrt_parser.php');  
        $QQWry              = new QQWry;  
        $ifErr              = $QQWry->QQWry($ip);  
        $address            = array();  
        $address['country'] = toUTF8($QQWry->Country);  
        $address['local']   = toUTF8($QQWry->Local);  
        return $address;  
    }  
      
    ////根据ip获得访客所在地地名：从ip138获取  
    function Getaddress_2($ip = '')  
    {  
        //来自：XX省XX市 电信  
        if (empty($ip)) {  
            $ip = $this->Getip();  
        }  
        $get_url = sprintf('http://wap.ip138.com/ip_search.asp?ip=%s', $ip);  
        $mip     = file_get_contents($get_url);  
        if ($mip) {  
            preg_match("/查询结果：(\S+)\s+(\S+)/", $mip, $sip);  
            $address            = array();  
            $address['country'] = toUTF8($sip[1]);  
            $address['local']   = toUTF8($sip[2]);  
            return $address;  
        } else {  
            return toUTF8("获取本地IP失败！");  
        }  
    }  
}  
  
?>  