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

namespace app\collect\home;

use app\collect\model\Orders as OrdersModel;
use think\Db;
use think\Cookie;
// use util\Express;
use util\Snoopy;
/**
* 快递物流
*/
class Expressage extends Common
{
   public function gong(){
      $id = input('post.id');
      $data = Db::name('collect_order')->alias('o')
              ->join('order_delivery d','o.express=d.code')
              ->join('collect_good g','o.goods_id=g.id')
              ->where(['o.id'=>$id])
              ->field('o.express_no,d.name,g.images')
              ->find();
      $imgs = explode(",", $data['images']);
      $data['pic'] = $imgs[0];   
      show_api($data);
      
   }
   public function index(){
      $typeCom = input('express');//快递公司
      $typeNu = input('express_no');  //快递单号
      $AppKey='29833628d495d7a5';//申请到的KEY
      // $AppKey = 'WkfoqBPU5853';
      // $customer = 'F64D5529830D778DEE87852FAB1671B9';
      $url ='http://api.kuaidi100.com/api?id='.$AppKey.'&com='.$typeCom.'&nu='.$typeNu.'&muti=1&order=dasc';
// return json_encode($url);die;
      //请勿删除变量$powered 的信息，否者本站将不再为你提供快递接口服务。
      $powered = '查询数据由：<a href="http://kuaidi100.com" target="_blank">KuaiDi100.Com （快递100）</a> 网站提供 ';
      //优先使用curl模式发送数据
      if (function_exists('curl_init') == 1){
        $curl = curl_init();
        curl_setopt ($curl, CURLOPT_URL, $url);
        curl_setopt ($curl, CURLOPT_HEADER,0);
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
        curl_setopt ($curl, CURLOPT_TIMEOUT,5);
        $get_content = curl_exec($curl);
        curl_close ($curl);
      }else{
        // include("snoopy.php");
        $snoopy = new snoopy();
        $snoopy->referer = 'http://www.google.com/';//伪装来源
        $snoopy->fetch($url);
        $get_content = $snoopy->results;
      }
      print_r($get_content);
      exit();
   }
}