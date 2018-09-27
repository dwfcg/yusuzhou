<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:66:"D:\phpStudy\WWW\yusuzhou/application/auction\view\order\index.html";i:1524102213;}*/ ?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/html">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
        <meta content="yes" name="apple-mobile-web-app-capable">
        <meta content="black" name="apple-mobile-web-app-status-bar-style">
        <meta content="telephone=no" name="format-detection">
        <script language="javascript" src="__STATIC__/home/js/jquery.js"></script>
        <title>我的拍卖</title>
        <style>
            a, a:visited {
                text-decoration: none;    cursor: auto; }
            #container{
                margin-bottom:50px;
            }
        </style>
    </head>
    <body style="">
        <style type="text/css">
            body {margin:0px;background:#efefef; -moz-appearance:none; -webkit-appearance: none;}
            .order_topbar {height:44px; width:100%; background:#fff; border-bottom:1px solid #e3e3e3;}
            .order_topbar .nav {height:44px; width:33.33%; line-height:44px; text-align:center; font-size:14px; float:left; color:#666;}
            .order_topbar .on {height:42px; color:#ff771b; border-bottom:2px solid #ff771b;}
            .order_noinfo {height:20px; width:150px; background:url(img/order_img1.png) top center no-repeat; margin:50px auto 0px; padding-top:100px; line-height:20px; font-size:14px; text-align:center; color:#c9c9c9;}
            .order_main {height:auto; width:94%; background:#fff; padding:0px 3%; margin-top:16px; border-bottom:1px solid #e2e2e2; border-top:1px solid #e2e2e2;}
            .order_main .title {height:42px; width:100%; border-bottom:1px solid #e2e2e2; font-size:14px; line-height:42px; color:#666;}
            .order_main .title span {height:42px; width:auto; float:right; color:#ff771b;}


            .order_main .good {height:50px; width:100%; padding:10px 0px; border-bottom:1px solid #eaeaea;}
            .order_main .good .img {height:50px; width:50px; float:left;}
            .order_main .good  .img img {height:100%; width:100%;}
            .order_main .good  .info {width:100%;float:left; margin-left:-50px;margin-right:-60px;}
            .order_main .good .info .inner { margin-left:60px;margin-right:60px; }
            .order_main .good .info .inner .name {height:32px; width:100%; float:left; font-size:12px; color:#555;overflow:hidden;}
            .order_main .good .info .inner .option {height:18px; width:100%; float:left; font-size:12px; color:#888;overflow:hidden;word-break: break-all}
            .order_main .good span { color:#666;}
            .order_main .good  .price { float:right;width:60px;;height:54px;margin-left:-60px;;}
            .order_main .good  .price .pnum { height:20px;width:100%;text-align:right;font-size:14px; }
            .order_main .good  .price .num { height:20px;width:100%;text-align:right;}
            .order_main .info1 {height:42px; width:100%; border-bottom:1px solid #e2e2e2; font-size:14px; color:#999; line-height:42px; text-align:right;}
            .order_main .info1 span {color:#666;}

            .order_main .sub {height:50px; width:100%;}
            .order_main .sub1 {height:30px; width:auto; padding:0px 10px; border:1px solid #ff771b; float:right; border-radius:5px; line-height:30px; font-size:14px; margin:10px 5px 10px 0px; color:#fff; background:#ff771b;}
            .order_main .sub2 {height:30px; width:auto; padding:0px 10px; border:1px solid #5f6e8b; float:right; border-radius:5px; line-height:30px; font-size:14px; margin:10px 5px 10px 0px; color:#5f6e8b;}
            select { width:80px;height:30px;position:absolute;left:0; filter:alpha(Opacity=0); opacity: 0;-webkit-appearance: none;background:#fff; -webkit-tap-highlight-color: transparent };
            .order_no {height:40px; width:100%;  padding-top:180px; margin:50px 0px;}

            .order_no {height:100px; width:100%; margin:50px 0px 60px; color:#ccc; font-size:12px; text-align:center;}
            .order_no_menu {height:40px; width:100%; text-align:center;}
            .order_no_nav {height:38px;padding:10px; width:100px; background:#eee; border:1px solid #d4d4d4; border-radius:5px; text-align:center; line-height:38px; color:#666;}
            #order_loading { width:94%;padding:10px;color:#666;text-align: center;}
            .login{
                width: 80%;
                margin: 200px auto;
                height: 45px;
                line-height: 45px;
                border-radius: 5px;
                background: #ef5555;
                color: #fff;
                text-align: center;
            }
        </style>
        <div id='container' >
            <div class="order_topbar">
                <div class="nav <?php if($status == ''): ?>on <?php endif; ?>" data-status=""  onclick="location.href = '<?php echo url('order/index'); ?>'">竞拍中</div>
                <div class="nav <?php if($status == 1): ?>on <?php endif; ?>" data-status="0" onclick="location.href = '<?php echo url('order/index',array('status'=>1)); ?>'">竞拍成功</div>
                <div class="nav <?php if($status == -1): ?>on <?php endif; ?>"  data-status="1" onclick="location.href = '<?php echo url('order/index',array('status'=>-1)); ?>'">竞拍失败</div>
            </div>
            <div id='order_container' >
            <div class="login" style="display:none">
                点击登录
            </div>
            <?php if(!isset($orders)): ?>
            <div class="order_no"><i class="fa fa-file-text-o" style="font-size:100px;"></i><br><span style="line-height:18px; font-size:16px;" </span>您还没有拍品<br>随便逛逛</div>
            <?php else: if(is_array($orders) || $orders instanceof \think\Collection || $orders instanceof \think\Paginator): $i = 0; $__LIST__ = $orders;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <div class="order_main" data-orderid="111">
                <div class="title">订单ID：<?php echo $v['id']; ?><span><?php echo $order_status[$v['status']]; ?></span></div>
                <div class="good">
                    <div class="img"  onclick="location.href = ''"><img src="<?php echo $v['pic']; ?>"/></div>
                    <div class='info' onclick="location.href = '<?php echo url('index/detail',array('gid'=>$v['gid'])); ?>'">
                        <div class='inner'>
                            <div class="name"><?php echo $v['title']; ?></div>     
                            <div class='option'></div>
                        </div>
                    </div>
                    <div class="price">
                        <div class='pnum'><span class='marketprice'>￥<?php echo $v['money']; ?></span></div>
                        <div class='pnum'><span class='total'>×1</span></div>
                    </div>
                </div>
                <div class="info1">&nbsp;实付：<span>￥<?php echo $v['money']; ?></span></div>
                <?php if($v['status'] >= 1): ?>
                <div class="sub">
                    <div class="sub1" onclick="location.href = '<?php echo url("pay/pay",array('id'=>$v['id'])); ?>'">付款</div>  
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; endif; else: echo "" ;endif; endif; ?>
        </div>
        </div>
        <script type="text/javascript" src="__STATIC__/home/js/api.js?12222"></script>
        <script>
                apiready = function () {
                   var user = decodeURIComponent($api.getCookie('userLogin'));
                    user = user ? JSON.parse(user) : {};
                    if( !user.id ){
                        $(".login").show();
                        $(".order_no").hide();
                    }
                    $(".login").click(function(){
                        $api.openLogin();
                    });
            	}
               
                $(".ajax_btn").click(function(){
                      var oid = $(this).attr('data-id');
                      var status = $(this).attr('data-status');
                       $.ajax({
                            url: "<?php echo url('order/save_status'); ?>",
                            type: "get",
                            data: {"oid":oid,"status":status},
                            datatype:'json',
                            success: function (res) {
                                res = $.parseJSON(res);
                                if(res.status == 1){
                                    alert('操作成功');
                                    location.reload();
                                }else{
                                    alert('网络错误');
                                }
                            }
                        });
                  });
                  var page_count = <?php echo $page; ?>;
                  load_data('#order_container',page_count,{page_count},'<?php echo url('order/ajax_orders'); ?>',{body_main:'#order_container',doc_main:'#container'},
                    function (){
                        //$('.loading').css({display:'-webkit-box'});
                        //$('.loading_main').css({WebkitAnimation:'loading 1s infinite linear'});
                    },
                    function (){
                           // $('.loading').css({display:'none'});
                  });
                 function load_data( item_main,iMaxPage,datas,data_url,doc_main,before,after ){
                        var page_main = doc_main || {doc_main:document,body_main:document};
                        var view_height = $(window).height();
                        var iNowPage = 1;
                        var onOff = true;
                        var time = null;
                        var loading_item = null;

                        $(document).bind('touchmove',move);
                        $(window).bind('resize',function (){
                            view_height = $(window).height();
                        });

                        function move(ev){
                            var ev = ev || window.event;
                            var aTouch = ev.changedTouches;
                            var scr_top = $(page_main.doc_main).scrollTop();

                            if( onOff && iNowPage < iMaxPage && scr_top + view_height > $(page_main.body_main).height() - 50){
                                ajax_post();
                                onOff = false;
                                before && before();
                            }else{
                                var prevScrollTop = scr_top;
                                clearInterval(time);
                                time = setInterval(function (){
                                    var thisScrollTop = $(page_main.doc_main).scrollTop();
                                    if(thisScrollTop==prevScrollTop){
                                        clearInterval(time);
                                    }
                                    prevScrollTop = $(page_main.doc_main).scrollTop();
                                },200);
                            }
                        }

                        function ajax_post(){
                            if(!data_url)return;
                            loading_item = layer.open({
                                content:'\u6b63\u5728\u52a0\u8f7d\u002e\u002e\u002e',
                                skin: 'msg',
                            });
                            $.ajax({
                                type:'post',
                                url:data_url,
                                data:$.extend(datas,{start:iNowPage*10}),
                                success:function ( data ){
                                    layer.close(loading_item);
                                    if( !data ){
                                        onOff = false;
                                    }else{
                                        iNowPage++;
                                        onOff = true;
                                        after && after();
                                        $(item_main).append(data);
                                    }
                                }
                            });
                        }
                    }
        </script>
    </body>
</html>