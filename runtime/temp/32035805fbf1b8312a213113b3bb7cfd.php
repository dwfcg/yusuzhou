<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:67:"D:\phpStudy\WWW\yusuzhou/application/auction\view\index\detail.html";i:1535002087;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html;charset=UTF-8" http-equiv="Content-Type"/>
        <meta content="no-cache,must-revalidate" http-equiv="Cache-Control"/>
        <meta content="no-cache" http-equiv="pragma"/>
        <meta content="0" http-equiv="expires"/>
        <meta content="telephone=no, address=no" name="format-detection"/>
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
        <title><?php echo $info['title']; ?></title>
        <link rel="stylesheet" href="__STATIC__/live/css/swiper.min.css" />
        <link rel="stylesheet" href="__STATIC__/auction/css/detail.css" />
        <style>
		    
        </style>
        <script src="__STATIC__/live/js/jquery.js"></script>
        <script src="__STATIC__/live/js/swiper.min.js"></script>
    </head>
    <body>

        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php if(is_array($info['imgs']) || $info['imgs'] instanceof \think\Collection || $info['imgs'] instanceof \think\Paginator): $i = 0; $__LIST__ = $info['imgs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <div class="swiper-slide"><img src="<?php echo $v; ?>" /></div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
              <div class="swiper-pagination"></div>
        </div>
        <div class="pm_time <?php if($info['pm_status'] == 2): ?>pm_wkp<?php elseif($info['pm_status'] == 3): ?> yjs<?php endif; ?>">
            <div>
                <p><span class="pm_status"><?php if($info['pm_status'] == 1): ?>拍卖中<?php elseif($info['pm_status'] == 2): ?>预展中<?php elseif($info['pm_status'] == 3): ?>已结束<?php endif; ?></span> <?php if($info['pm_status'] == 1): ?>距结束<?php elseif($info['pm_status'] == 2): ?>距开始<?php endif; ?> 
                <span id="t_d">00天</span>
    <span id="t_h">00时</span>
    <span id="t_m">00分</span>
    <span id="t_s">00秒</span>
      <?php if($info['pm_status'] == 3): ?> 结束<?php endif; ?></p>
            </div>
        </div>
        <div class="info">
            <div class="title">
                <?php echo $info['title']; ?>
            </div>
            <div class="tags clear">
                <span class="tag_right"><?php echo $info['partake']; ?>人围观</span>
                <?php if(is_array($info['tags']) || $info['tags'] instanceof \think\Collection || $info['tags'] instanceof \think\Paginator): $i = 0; $__LIST__ = $info['tags'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                    <span class="tag"><?php echo $v; ?></span>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <div class="money">
                <div class="dq_money">
                    <p>当前价</p>
                    <span class="dangqian">￥<?php echo $info['start_price']; ?></span>
                </div>
                <div class="qp_money">
                    <p>起拍价</p>
                    <span>￥<?php echo $info['start_price']; ?></span>
                </div>
                <div class="range">
                    <p>加价幅度</p>
                    <span>￥<?php echo $info['price_range']; ?></span>
                </div>
            </div>
            <div class="h2"></div>
            <div class="record">
                <div class="record_title clear"> <span class="right"><?php echo $count; ?>次出价 > </span>出价记录 </div>
                <div class="record_lists">
                    <?php if(is_array($records) || $records instanceof \think\Collection || $records instanceof \think\Paginator): $i = 0; $__LIST__ = $records;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                        <div class="record_list clear <?php if($key == 0): ?>first<?php endif; ?>">
                            <div class="l-left"><img src="<?php echo $v['headimg']; ?>" /> <?php if($v['anon']):  echo substr($v['name'],0,1)."**".substr($v['name'],-1,1); else: ?><?php echo $v['name']; endif; ?><span><?php  echo date('m-d H:i:s',$v['addtime']) ?></span> </div><div class="l-right"><span class="r-money">￥<?php echo $v['money']; ?></span><span class="r-status"><?php if($key == 0): ?>领先<?php else: ?>出局<?php endif; ?></span></div>
                        </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <div class="refesh_cj">点击刷新出价</div>
            </div>
            <!-- <?php if($info['attrs']): ?> -->
            <div class="h2"></div>
            <div class="attr">
                <div class="attr_title">商品属性</div>
                <div class="attrs clear">
<!--                     <?php if(is_array($info['attrs']) || $info['attrs'] instanceof \think\Collection || $info['attrs'] instanceof \think\Paginator): $i = 0; $__LIST__ = $info['attrs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                    <div class="attr_item"><span><?php echo $v[0]; ?></span><?php echo $v[1]; ?></div>
                    <?php endforeach; endif; else: echo "" ;endif; ?> -->
                    <div class="attr_item"><?php echo $info['attrs']; ?></div>
                </div>
            </div>
            <!-- <?php endif; ?> -->
            <div class="h2"></div>
            <div class="content">
                <?php echo $info['content']; ?>
            </div>
        </div>
        <div class="footer <?php if($info['pm_status'] == 2): ?>pmwks<?php elseif($info['pm_status'] == 3): ?> pmwks<?php endif; ?>">
            <div class="chujia" <?php if($info['pm_status'] == 1): ?>onClick="chujia();"<?php endif; ?>><?php if($info['pm_status'] == 1): ?>出价<?php elseif($info['pm_status'] == 2): ?>拍卖尚未开始<?php elseif($info['pm_status'] == 3): ?>已结拍<?php endif; ?></div>
        </div>
        <div class="cj_box hide">
            <div class="cj_bg"></div>
            <div class="cj_bottom">
                <div class="cj_jiajia"> <span class="cj_right"><input type="radio" id="anon" value="1" />匿名出价</span>当前价<span class="dangqian dq_price">￥2000</span>加价幅度￥<?php echo $info['price_range']; ?> </div>
                <div class="cj_money">
                    <div class="cj_jian ">-</div>
                    <div class="cj_price">￥0000</div>
                    <div class="cj_jia">+</div>
                </div>
                <div class="is_button">确认出价</div>
            </div>
        </div>
        <input type="hidden" id="price" />
        <script type="text/javascript" src="__STATIC__/home/js/api.js?113"></script>
        <script type="text/javascript">
            apiready = function() { 
            }
           var mySwiper = new Swiper('.swiper-container', {
            	autoplay: 5000,//可选选项，自动滑动
            	loop: true,
    
                // 如果需要分页器
                pagination: {
                  el: '.swiper-pagination',
                },
           })
           var price = "<?php echo $info['price']; ?>";
           var range = "<?php echo $info['price_range']; ?>";
           function GetRTime(){
                var EndTime= new Date("<?php echo $info['end_time']; ?>");
                var NowTime = new Date();
                var t =EndTime.getTime() - NowTime.getTime();
                var d=0;
                var h=0;
                var m=0;
                var s=0;
                if(t>=0){
                  d=Math.floor(t/1000/60/60/24);
                  h=Math.floor(t/1000/60/60%24);
                  m=Math.floor(t/1000/60%60);
                  s=Math.floor(t/1000%60);
                }
                document.getElementById("t_d").innerHTML = d + "天";
                document.getElementById("t_h").innerHTML = h + "时";
                document.getElementById("t_m").innerHTML = m + "分";
                document.getElementById("t_s").innerHTML = s + "秒";
              }
              <?php if($info['pm_status'] == 1): ?>
                setInterval(GetRTime,0);
              <?php endif; ?>
              
              function chujia(){
                   $api.openLogin();
                  $.ajax({
                        type:'post',
                        url:"<?php echo url('index/ajax_chujia'); ?>",
                        data:{'gid':"<?php echo $info['id']; ?>"},
                        success:function ( data ){
                            data = JSON.parse(data);
                            price = data.price;
                            if(data.type == 1){
                                $(".dangqian").html("￥"+price);
                                yprice = parseFloat(price) + parseFloat(range);
                                $(".cj_price").html("￥"+yprice);
                                $("#price").val(yprice);
                            }else{
                                $(".dangqian").html("￥"+price);
                                $(".cj_price").html("￥"+price); 
                                $("#price").val(price);
                            }
                            $(".cj_box").removeClass('hide');
                        }
                    });
              }
              
              window.setInterval(check,10000); 
              function check(){
                   $.ajax({
                        type:'post',
                        url:"<?php echo url('index/ajax_check'); ?>",
                        data:{'gid':"<?php echo $info['id']; ?>"},
                        success:function ( data ){
                            data = JSON.parse(data);
                            price = data.price;
                            $(".dangqian").html("￥"+price);
                        }
                    });
              }
              $(".cj_bg").click(function(){
                   $(".cj_box").addClass('hide');
              });
              
              
              $(".cj_jia").click(function(){
                  var price1 = $("#price").val();
                  var money = parseFloat(price1)+parseFloat(range);
                  $(".cj_price").html("￥"+money);
                  $("#price").val(money);
                  $(".cj_jian").addClass('cj_red');
              });
              $(".cj_jian").click(function(){
                  var price1 = $("#price").val();
                  var money = parseFloat(price1)-parseFloat(range);
                  var sum = parseFloat(price)+parseFloat(range);
                  if(money <= sum){
                      money = parseFloat(price)+parseFloat(range);
                      $(".cj_price").html("￥"+money);
                      $("#price").val(money); 
                      $(".cj_jian").removeClass('cj_red');
                      return false;
                  }
                  $(".cj_price").html("￥"+money);
                  $("#price").val(money);
              });
              //出价
              $(".is_button").click(function(){
                  
                  var anon = $("#anon").val();
                  var money = $("#price").val();
                  $.ajax({
                        type:'post',
                        url:"<?php echo url('index/ajax_chujia'); ?>",
                        data:{'gid':"<?php echo $info['id']; ?>",'money':money,'anon':anon},
                        success:function ( data ){
                           console.log(data);
                           if(data.code == 1){
                               alert(data.msg);
                           }else{
                               alert(data.msg);
                           }
                        }
                    });
              });
        </script>
    </body>
</html>