<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 河源市卓锐科技有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

// 为方便系统核心升级，二次开发中需要用到的公共函数请写在这个文件，不要去修改common.php文件

    /**
     * json打印
     * @author Lieber
     */

    function show_api($data=array(), $info='', $code=1){
        $json['data'] = $data;
        $json['info'] = $info;
        $json['code'] = $code;
        echo json_encode($json,JSON_UNESCAPED_UNICODE);exit;
    }
    
    function formatTime($time){     
    	$rtime = date("m-d H:i",$time);     
    	$htime = date("H:i",$time);           
    	$time = time() - $time;       
    	if ($time < 60){         
    		$str = '刚刚';     
    	}elseif($time < 60 * 60){         
    		$min = floor($time/60);         
    		$str = $min.'分钟前';     
    	}elseif($time < 60 * 60 * 24){         
    		$h = floor($time/(60*60));         
    		$str = $h.'小时前 ';     
    	}elseif($time < 60 * 60 * 24 * 3){         
    		$d = floor($time/(60*60*24));         
    		if($d==1){
    			$str = '昨天 '.$rtime;
    		}else{
    			$str = '前天 '.$rtime;     
    		}
    	}else{         
    		$str = $rtime;     
    	}     
    	return $str; 
    }


 
