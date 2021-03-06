<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:63:"D:\phpStudy\WWW\yusuzhou/application/shop\view\goods\index.html";i:1529915919;}*/ ?>
<!DOCTYPE html>
<html class="" lang="zh-cmn-Hans">
<head>
    <meta charset="utf-8">
    <meta name="description" content=""/>
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="cleartype" content="on">
    <meta name="referrer" content="always">
    <title><?php echo $good['title']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="__STATIC__/home/css/base1.css" onerror="_cdnFallback(this)"
          media="screen">
    <link rel="stylesheet" href="__STATIC__/home/css/show.css"
          onerror="_cdnFallback(this)" media="screen">
    <link rel="stylesheet" href="__STATIC__/home/css/goods.css" onerror="_cdnFallback(this)"
          media="screen">
    <style type="text/css">
        .comment_list li {
            padding: 0.3125rem;
        }

        .user_intro {
            display: box;
            display: -webkit-box;
            position: relative;
        }

        .user_icon {
            width: 1rem;
        }

        .user_icon img {
            width: 100%;
            border-radius: 50%;
        }

        .user_name {
            padding: 0 0.3125rem;
            line-height: 1rem;
            font-size: 0.5rem;
        }

        .publish_time {
            color: #999;
            font-size: 0.3125rem;
            padding-top: 0.3125rem;
            position: absolute;
            right: 0;
        }

        .comment_cont {
            color: #333;
            font-size: 0.4rem;
            padding: 0.3125rem 0;
        }

        .comment_pics {
            overflow: hidden;
        }

        .comment_pics li {
            float: left;
            width: 2.8rem;
            height: 2.8rem;
            padding: 0;
            margin-right: 0.2rem;
            overflow: hidden;
        }

        .comment_pics img {
            width: 100%;
            height: 100%;
        }

        .comment_star {
        }

        .comment_star.s1 {
            width: 0.5rem;
            background: url(http://img.weibaoke.com.cn//static/shop/images/star_active.png) repeat-x left center/0.5rem;
        }

        .comment_star.s2 {
            width: 1rem;
            background: url(http://img.weibaoke.com.cn//static/shop/images/star_active.png) repeat-x left center/0.5rem;
        }

        .comment_star.s3 {
            width: 1.5rem;
            background: url(http://img.weibaoke.com.cn//static/shop/images/star_active.png) repeat-x left center/0.5rem;
        }

        .comment_star.s4 {
            width: 2rem;
            background: url(http://img.weibaoke.com.cn//static/shop/images/star_active.png) repeat-x left center/0.5rem;
        }

        .comment_star.s5 {
            width: 2.5rem;
            background: url(http://img.weibaoke.com.cn//static/shop/images/star_active.png) repeat-x left center/0.5rem;
        }

        .empty_comment {
            text-align: center;
            padding-top: 0.1rem;
        }

        .empty_comment img {
            width: 3rem;
        }

        .empty_text {
            margin-top: 0.2rem;
            margin-bottom: 0.3rem;
            font-size: 0.4rem;
            color: #666;
        }
    </style>
    <style type="text/css">
        @charset "UTF-8";
        .default-theme .main-btn::after, .default-theme .vice-btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 200%;
            height: 200%;
            -webkit-perspective: 1000;
            -webkit-backface-visibility: hidden;
            pointer-events: none;
            border-top: 1px solid rgba(0, 0, 0, .1)
        }

        .default-theme .main-btn {
            background-color: #F44;
            color: #fff
        }

        .default-theme .main-btn::after {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            -webkit-transform: scale(.5);
            -moz-transform: scale(.5);
            -ms-transform: scale(.5);
            transform: scale(.5);
            -webkit-transform-origin: left top;
            -moz-transform-origin: left top;
            -ms-transform-origin: left top;
            transform-origin: left top
        }

        .default-theme .main-btn:active {
            background: #ff1b1b
        }

        .default-theme .vice-btn {
            background-color: #F85;
            color: #fff
        }

        .default-theme .vice-btn::after {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            -webkit-transform: scale(.5);
            -moz-transform: scale(.5);
            -ms-transform: scale(.5);
            transform: scale(.5);
            -webkit-transform-origin: left top;
            -moz-transform-origin: left top;
            -ms-transform-origin: left top;
            transform-origin: left top
        }

        .default-theme .vice-btn:active {
            background: #ff6b2c
        }

        .default-theme .current-price, .default-theme .price-sub {
            color: #F44 !important
        }

        .default-theme .goods-detail .tabber {
            color: #F44;
            border-bottom: 1px solid #F44
        }

        .default-theme .goods-detail .tabber .item button.active {
            color: #fff
        }

        .default-theme .goods-detail .tabber button.active {
            color: #F44;
            border-bottom: 1px solid #F44
        }

        .default-theme .commit-bill-btn, .default-theme .pay-bill-btn, .default-theme .sku-layout .sku-list-container .active {
            background-color: #F44;
            border-color: #F44
        }

        .default-theme .trade-review-list .review-rate-tabber button.active {
            background-color: #F44
        }

        .default-theme .sku-layout .current-price .price-name, .default-theme .sku-layout .current-price i {
            color: #F44 !important
        }

        .default-theme .sku-layout .other-info .quota {
            color: #F44
        }

        .default-theme .theme-price-color {
            color: #F44 !important
        }

        .default-theme .sc-goods-list .info p.goods-price > em, .default-theme .service .icon-service {
            color: #F44
        }

        .js-detail-container img, .js-detail-container p img {
            width: 100%;
        }

        #banner_box {
            overflow: hidden;
            position: relative;
        }

        #banner_box ul {
            overflow: hidden;
            position: relative;
        }

        #banner_box ul > li {
            float: left;
            width: 100%;
            position: relative;
        }

        .box_swipe ul li {
            display: none;
        }

        .box_swipe ul li:first-child {
            display: block;
        }

        .content img {
            width: 100%;
        }

        .link_button {
            width: 100%;
            height: 50px;
            display: -webkit-box;
            display: box;
            background: #fff;
        }

        .link_button div.shopactive {
            border-bottom: 2px solid #F44;
        }

        .link_button div:nth-of-type(1):after {
            content: '';
            position: absolute;
            right: 0;
            top: 10px;
            bottom: 10px;
            width: 1px;
            background: #eee;
        }

        .link_button a {
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            left: 0;
        }

        .link_button div {
            width: 50%;
            font-size: 14px;
            display: -webkit-box;
            display: box;
            -webkit-box-align: center;
            box-align: center;
            -webkit-box-pack: center;
            box-pack: center;
            -webkit-box-flex: 1;
            position: relative;
            box-sizing: border-box;
        }
        /*.to-cart{

            left: 0;

            top: 0;

            color: #999;

            width: 50px;

            font-size: 10px;

            padding-top: 34px;

            position: absolute;

            background: url(__STATIC__/home/image/cart.png) no-repeat center 8px/20px;

        }
        .to-sc{
        	left: 50px;
        }*/		
        .to-other{			
        	width: 40%;			
        	overflow: hidden;			
        	margin-bottom: -50px;		
        }		
        .to-other .to-cart,.to-other .to-shoucang{			
        	width: 50%;			
        	font-size: 10px;			
        	color: #999;			
        	padding-top: 34px;	
        	padding-bottom: 5px;	
        }		
        .to-other .to-cart{			
        	float: left;			
        	background: url(__STATIC__/home/images/phone1.png) no-repeat center 8px/20px;		
        }		
        .to-other .to-sc{
        	float: right;
        	background: url(__STATIC__/home/image/shoucang.png) no-repeat center 8px/20px;		
        }
        .to-other .to-sc-ed{
        	float: right;
        	background: url(__STATIC__/home/image/shoucang_ed.png) no-repeat center 8px/20px;		
        }
        .add-cart{
            background: #f1ab47;
        }
        .big-btn-2-1 .big-btn{
            width: 60%;
            color: #fff;
            float: right;
        }        
        /*推荐*/       
        .common-title{       		
        	color: #999;       		
        	line-height: 40px;       		
        	font-size: 14px;       		
        	border-bottom: 1px solid rgba(239,239,239,0.5);              		
        	padding-left: 20px; 
        	background: url(__STATIC__/home/image/shu.png) no-repeat 10px 10px;
        	background-size: 4px 20px;
        	background-color: white;
        }       
        /*商品列表*/      	
        .flex-wrap{ 
        	display: -webkit-box;	
        	display: -webkit-flex;	
        	display: flex; 
        }      	
        .flex-align{
        	-webkit-align-items: center;
        	align-items: center;
        }    	
        .goods-list{    		
        	width: 100%;    		
        	list-style: none;    		
        	overflow: hidden;    	
        }    	
        .goods-list li{    		
        	float: left;    		
        	width: 48%;    		
        	margin-top: 10px;    		
        	background: white;    		
        	padding: 10px 10px 0 10px;    		
        	box-sizing: border-box;    	
        }    	
        .goods-list li:nth-child(2n+1){
        	margin-left: 1%;    		
        	margin-right: 1%;    	
        }    	
        .goods-intro{
        	width: 100%;    		
        	font-size: 12px;			
        	overflow: hidden;			
        	white-space: nowrap;			
        	text-overflow: ellipsis;    	
        }    	
        .goods-img{    		
        	width: 100%;    		
        	margin-top: 10px;    	
        }    	
        .goods-img img{    		
        	width: 100%;    	
        }    	
        .goods-outer {		    
        	height: .9375rem;		    
        	-webkit-box-pack: justify;		    
        	-ms-flex-pack: justify;		    
        	justify-content: space-between		
        }				
        .goods-outer .sign {		    
        	color: #b2b2b2;		    
        	font-size: .25rem		
        }				
        .goods-outer .sign div {		    
        	padding: .0625rem .125rem;		    
        	margin-right: .125rem;		    
        	border: 1px solid #e3e3e3		
        }				
        .goods-outer .price {		    
        	color: #e61717;		    
        	font-size: 0.375rem;		
        }				
        .goods-outer .price span {		    
        	font-size: .375rem;
        }
    </style>
    <style type="text/css">
        .sl-overlay {
            position: fixed;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background: rgba(0,0,0,0.3);
            display: none;
            z-index: 1000;
        }
        .video-play{
        	width: 100%;
        	position: absolute;
        	top: 0;
        	left: 0;
        }
        .videoPlay{
        	width: 80px!important;
        	height: 80px;
        	position: absolute;
        	top: 50%;
        	left: 50%;
        	transform: translate(-50%,-50%);
			-webkit-transform: translate(-50%,-50%);
			-ms-transform: translate(-50%,-50%);
			-moz-transform: translate(-50%,-50%);
			-o-transform: translate(-50%,-50%);
			z-index:0;
        }
        #video_good{
        	background-color: black;
        }
        /*新增店铺信息*/
       .shop-goods-info{
       		background: #fff;
       	}
       .shop-goods-info,.sgi-left,.sgi-right,.shop-info-tags{
       		display: flex;
  			display: -webkit-flex;
  			justify-content: space-between;
  			align-items: center;
        }
        .shop-goods-attribute{
        	display: flex;
  			display: -webkit-flex;
  			justify-content: space-between;
        }
        .sgi-left{
        	font-size: 0.5rem;
        }
        .sgi-left img{
        	width: 2rem;
        }
        .sgir-one{
        	font-size: 0.375rem;
        	margin-right: 20px;
        }
        .go-buy-show{
        	height: 40px;
        	line-height: 40px;
        	background: white;
        	color: black;
        	text-align: center;
        	font-size: 0.4rem;
        	margin-bottom: 10px;
        	border-top: 1px #f0f0f0 solid;
        }
        .goods-header{
        	margin-bottom: 0;
        	position: initial;
        }
        .shop-info-tags{
        	background: #fff;
        	margin-bottom: 10px;
        	padding-left: 10px;
        	padding-right: 10px;
        }
        .sit_inner{
        	font-size: 0.375rem;
        	color: #999977;
        	line-height: 30px;
        }
        .shop-goods-attribute{
        	background: #fff;
        	margin-bottom: 10px;
        	padding-top: 10px;
        	padding-bottom: 10px;
        }
        .sga-left p,.sga-right p{
        	font-size: 0.3125rem;
        	color: #888;
        }
        .sga-left p span,.sga-right p span{
        	color: black;
        }
        .sga-left{
        	width: 50%;
        	padding-left: 10px;
        	line-height: 1rem;
        }
        .sga-right{
        	width: 50%;
        	line-height: 1rem;
        }
        .go-shop-attr{
        	font-size: 0.3125rem;
        	color: #888;
        	padding-left: 10px;
        	line-height: 40px;
        	background: #fff;
        	border-bottom: 1px #f0f0f0 solid;
        }
        /*分享图标*/
       .goods-header .wish-add:before {

			content: '';
		
			position: absolute;
		
			top: 5px;
		
			left: 4px;
		
			width: 12px;
		
			height: 10px;
		
			background: url(__STATIC__/home/image/share_goods.png) no-repeat;
		
			background-size: 12px 10px;
		
		}
		.good-back{
			width: 40px;
			height: 40px;
			background: rgba(0,0,0,0.6);
			position: absolute;
			left: 10px;
			top: 10px;
			border-radius: 50%;
			z-index: 100;
		}
		.good-back img{
			width: 20px;
			height: 20px;
			position: absolute;
			left: 10px;
			top: 10px;
		}
    </style>
    <script type="text/javascript">
        (function () {
            var Doc = document.documentElement;
            Doc.style.fontSize = Doc.clientWidth / 10 + 'px';
        })();
    </script>
    <script type="text/javascript" src="__STATIC__/home/js/jquery.js"></script>
    <script type="text/javascript" src="__STATIC__/home/js/swipe.js"></script>
</head>
<body class=" body-fixed-bottom  default-theme">

<div class="container wap-goods internal-purchase" id="content">
    <div class="content no-sidebar">
    	<div onclick="api.closeWin()" class="good-back">
    		<img src="__STATIC__/home/images/back.png" alt="" />
    	</div>
        <div id="banner_box" class="box_swipe">

            <ul>
            	<?php if(is_array($good['video']) || $good['video'] instanceof \think\Collection || $good['video'] instanceof \think\Paginator): $i = 0; $__LIST__ = $good['video'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$video): $mod = ($i % 2 );++$i;if(is_array($good['images']) || $good['images'] instanceof \think\Collection || $good['images'] instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($good['images']) ? array_slice($good['images'],0,1, true) : $good['images']->slice(0,1, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$img): $mod = ($i % 2 );++$i;?>
						<li>
							<video id="video_good" data-vid="视频id" width="100%" poster="<?php echo $img; ?>"  src="<?php echo $video; ?>" x-webkit-airplay="true" webkit-playsinline="true" playsinline="true" type='video/mp4'>
					        	您的手机不支持html5标签
					    	</video>
					    	<div class="video-play"><img class="videoPlay" src="__STATIC__/home/images/videoPlays.png"/></div>
						</li>
					<?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; if(is_array($good['images']) || $good['images'] instanceof \think\Collection || $good['images'] instanceof \think\Paginator): $i = 0; $__LIST__ = $good['images'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$img): $mod = ($i % 2 );++$i;?>
                	<li><img class="imgHeight" src="<?php echo $img; ?>"></li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>

            <ol>
                <li class="on"></li>

            </ol>

        </div>
        <div class="content-body">
            <div class="goods-header">
                <h2 class="title"><?php echo $good['title']; ?></h2>
                <span id="share_goods" class="js-add-wish js-wish-animate wish-add  font-size-12 tag tag-redf30 pull-right">分享 </span>
                <div class="goods-price ">
                    <div class="current-price"><span>￥</span><i class="js-goods-price price"><?php echo $good['price']; ?></i></div>
                </div>
                <!--<hr class="with-margin-l"/>-->
            </div>
            <div class="shop-info-tags">
            	<div class="sit_inner">顺丰包邮</div>
            	<div class="sit_inner">月销<span><?php echo $good['goods_num']; ?></span>笔</div>
            	<div class="sit_inner">库存：<span><?php echo $good['sku']; ?></span></div>
            </div>
            <!--店铺信息-->
            <div class="shop-goods-info">
            	<div class="sgi-left">
            		<img src="__STATIC__/home/image/logo.png" />
            		<p>玉蘇周</p>
            	</div>
            	<div class="sgi-right">
            		<div class="sgir-one">
            			<p style="text-align: center;"><?php echo $count; ?></p>
            			<p style="margin-top: 5px; font-size: 0.3rem;">在售</p>
            		</div>
            	</div>
            </div>
            <!--进入买家秀-->
            <div class="go-buy-show" onclick="$api.openSection(8, '买家秀')">进入买家秀</div>
            <!--服务-->
            <div style="margin-bottom: 10px;" class="go-shop-attr">服务：<span style="color: black; margin-left: 10px;">七天无理由退货</span></div>
            <!--商品属性-->
            <div class="go-shop-attr">商品属性</div>
            <div class="shop-goods-attribute">
            	<div class="sga-left">
            		<p>重量:<span><?php echo $good['weight']; ?></span></p>
            		<p>产状：<span><?php echo $rock['name']; ?></span></p>
            		<p>种类：<span><?php echo $kind['name']; ?></span></p>
            		<p>产地：<span><?php echo $origin['name']; ?></span></p>
            	</div>
            	<div class="sga-right">
            		<p>分类：<span><?php echo $cation['name']; ?></span></p>
            		<p>尺寸：<span><?php echo $good['size']; ?></span></p>
            		<p>皮色：<span><?php echo $though['name']; ?></span></p>
                    <p>题材：<span><?php echo $theme['name']; ?></span></p>
            	</div>
            </div>
            <div class="link_button" style="clear:both;">
                <div class="shopmessage shopactive" style="text-align:left;">商品详情</div>
                <!--<div class="shopmessage">商品评论 <span>( 0条评论 )</span></div>-->
            </div>
            <!--<a class="js-package-buy-block hide"></a>-->

            <div class="js-detail-container" style="margin-top: 10px;">
                <div class="js-tabber-container goods-detail"><?php echo $good['content']; ?></div>
                <!--<div class="js-tabber-container goods-detail" style="display: none;">
                    <div class="page_main">
                                                <div class="empty_comment">
                            <img src="http://img.weibaoke.com.cn//static/shop/images/empty_comment.png?123123"/ >

                            <div class="empty_text">暂时没有评论哦!</div>
                        </div>
                                            </div>
                </div>-->
            </div>
        </div>		
        <div class="common-title">相关推荐</div>		
        	<ul class="goods-list">
        		<li v-for="tui in tuijian" :data-id="tui.id">                
	      			<div class="goods-intro">{{tui.title}}</div>                
	      			<div class="goods-image flex-wrap">                    
	      				<div class="goods-img">                        
	      					<img :src="tui.images" />                    
	      				</div>                
	      			</div>                
	      			<div class="goods-outer flex-wrap flex-align">                    
	      				<div class="sign flex-wrap">                        
	      					<div v-for="tag in tui.tags">{{tag}}</div>
	      				</div>                    
	      				<div class="price"><span>&yen;</span>{{tui.price}}</div>                
	      			</div>            
      			</li>
        	</ul>
        		<div class="js-bottom-opts js-footer-auto-ele bottom-fix">
            <div class="responsive-wrapper">
                <div class="big-btn-2-1">
                	<?php if($good['status'] == 1): ?>
                	<div class="to-other">						
                		<div class="to-cart">联系电话</div>
                		<?php if($shou == 0): ?>
                		<div class="to-shoucang to-sc">收藏</div>	
                		<?php elseif($shou == 1): ?>
                		<div class="to-shoucang to-sc-ed">已收藏</div>	
                		<?php endif; ?>
                	</div>
                    <div class="big-btn red-btn main-btn liji-buy">立即购买</div>
                    <!--<div class="add-cart big-btn">
                        	加入购物车
                    </div>-->
                    <?php endif; if($good['status'] == 0): ?>
                    <a class="big-btn red-btn main-btn" style="width:100%;background:#666;">已结缘</a>
                    <!--
                    <a class="big-btn red-btn main-btn" style="width:100%;background:#666;">已下架</a>-->
                    <?php endif; ?>
                </div>
            
        </div>
    </div>
    <div id="shop-nav"></div>
</div>
</div>
<script type="text/javascript" src="__STATIC__/home/js/api.js?3"></script>
<script type="text/javascript" src="__STATIC__/home/js/vue.min.js"></script>
<script type="text/javascript" src="__STATIC__/home/js/jquery-2.1.3.min.js"></script>
<script>
		apiready = function(){
			user = api.getPrefs({sync: true,key: 'userLogin'});
			user = JSON.parse(user);
			// 登录时接收事件，刷新本页面
		    api.addEventListener({
		        name: 'refreshes'
		    }, function(ret, err){
		        if(ret){
		          location.reload();
		        }
		    });
			//头部滑动
//			var content = $api.byId("content");
//			api.openFrame({
//	            name: 'shopdetail',
//	            url: 'widget://html/shopdetail_win.html',
//	            bounces: false,
//	            vScrollBarEnabled: false,
//	            hScrollBarEnabled: false,
//	            bgColor: 'rgb(0,0,0,1)',
//	            rect: {
//	                x: 0,
//	                y: 0,
//	                w: 'auto',
//	                h: api.winWidth/10*1.5625,
//	            }
//	     	});
//	        window.onscroll = function(e) {
//	            var scrollTop = document.body.scrollTop;
//	            if (scrollTop > 300) {
//	                scrollTop = 300;
//	            }
//          	api.setFrameAttr({
//	                name: 'shopdetail',
//	                bgColor: 'rgba(255,255,255,' + scrollTop / 300 + ')',
//	            });
//	            if(scrollTop / 300 == 0){
//	            	api.sendEvent({
//		            	name: 'colordel'
//		            })
//	            }else{
//	            	api.sendEvent({
//		            	name: 'color'
//		            })
//	            }
//	            
//	        };
			//点击立即购买
		    $(".liji-buy").on('click',function(){
		        if( user.code != 1 ){
		          	$api.openLogin()
		          	return false;
		        }
		        $api.openPage({
		           title: '商品购买',
		           name: 'GoodsDetailbuy',
		           url: site_url + '/index.php/shop/goods/flow/id/'+<?php echo $good['id']; ?>+'/uid/'+user.data.id+'.html',
		       	})
			//window.location.href = 'http://yusuzhou.youacloud.com/index.php/shop/goods/flow/id/'+<?php echo $good['id']; ?>+'/uid/'+user.data.id+'.html';
    		});
    		//点击收藏
		    $('.to-shoucang').on('click',function(){
		    	if( user.code != 1 ){
		          	$api.openLogin()
		          	return false;
		        }
		    	if($(this).hasClass('to-sc')){
		    		$.ajax({
		    			type: 'post',
		    			dataType: 'JSON',
		    			url: 'http://yusuzhou.youacloud.com/index.php/shop/goods/shoucang',
		    			data: {
		    				userid: user.data.id,
		    				goodid: <?php echo $good['id']; ?>,
		    				status: 0
		    			},
		    			success: function(data){
		    				$('.to-shoucang').removeClass('to-sc').addClass('to-sc-ed');
		    				$('.to-shoucang').html('已收藏');
		    				$('.to-shoucang').css('color','#ff0000');
		    			},
		    			error: function(){
		    				alert('错误')
		    			}
		    		})
		//  		$(this).removeClass('to-sc').addClass('to-sc-ed');
		//  		$(this).css('color','#ff0000');
		    	}else{
		    		$.ajax({
		    			type: 'post',
		    			dataType: 'JSON',
		    			url: 'http://yusuzhou.youacloud.com/index.php/shop/goods/qushou',
		    			data: {
		    				userid: user.data.id,
		    				goodid: <?php echo $good['id']; ?>,
		    			},
		    			success: function(data){
		    				$('.to-shoucang').removeClass('to-sc-ed').addClass('to-sc');
		    				$('.to-shoucang').html('收藏');
		    				$('.to-shoucang').css('color','#999');
		    			},
		    			error: function(msg){
		    				alert(JSON.stringify(msg))
		    			}
		    		})
		//  		$(this).removeClass('to-sc-ed').addClass('to-sc');
		//  		$(this).css('color','#999');
		    	}
		    });
		    //相关推荐功能
		    $('.goods-list').on('click','.goods-intro,.goods-image',function (){
		    	if( user.code != 1 ){
		          	$api.openLogin()
		          	return false;
		        }
		        var id = $(this).parents('li').attr('data-id');
		//      api.openWin({
		//		    name: 'goods_detail_'+id,
		//		    url: 'http://yusuzhou.youacloud.com/index.php/shop/goods/index/id/' + id + '.html',
		//		    pageParam: {
		//		        id
		//		    }
		//		});
		//		alert(user.data.id)
				api.openWin({
			        name: 'GoodsDetail',
			        url: site_url + '/index.php/shop/goods/index/id/' + id + '/uid/'+user.data.id+'.html',
			        rect: {
				        x:0,
				        y:0,
				        w:'auto',
				        h:'auto'
			        },
		          	useWKWebView: true, //设置在 ios 平台使用 wkWebview 显示页面
		          	//slidBackEnabled: false//关闭ios的左滑返回效果
		        });
		//		$api.openPage({
		//	    	title: '商品详情',
		//	    	name: 'goods_detail_'+id,
		//	    	url: 'http://yusuzhou.youacloud.com/index.php/shop/goods/index/id/' + id + '.html',
		////			url: 'widget://html/goodDetailImage.html',
		////			id: id,
		//		});
		    });
		}
		//相关推荐
		var tui = new Vue({
  			el: '.goods-list',
  			data: {
  				tuijian: [],
  				tags: [],
  			}
	  	});
	  	function hq(){
	  		var str = window.location + '';
	  		var arr = str.split('/');
			var arr1 = arr[8];
			var id = arr1.split('.')[0];
			return id;
	  	}
	  	var id = hq();
		$.ajax({
		    type: 'post',
		    url: 'http://yusuzhou.youacloud.com/index.php/shop/goods/tuijian',
		    data:{
		    	id: id,
		    },
		    dataType: 'json',
		    success: function (data) {
		    	tui.tuijian = data.data;
		    }
		});
    var other_flag = $("#banner_box ol li").length == 2 ? true : false;
    new Swipe(document.getElementById('banner_box'), {
        speed: 1000,
        auto: false,
        continuous: true,
        disableScroll: false,
        stopPropagation: false,
        callback: function (index) {
            var lis = $("#banner_box ol").children();
            lis.removeClass("on").eq(index).addClass("on");
            if (other_flag) {
                if (index > 1) {
                    lis.removeClass("on").eq(index - 2).addClass("on");
                }
            }
        }
    });
    $('.box_swipe ul li').show();
    $(function(){
    	var height = $("#banner_box ul li .imgHeight").height();
    	$("#video_good").height(height);
    	$(".video-play").height(height);
    	$(".video-play").on('click',function(){
			if($("#video_good").get(0).paused){
				$("#video_good").get(0).play();
				$(".videoPlay").css("display","none");
			}else{
				$("#video_good").get(0).pause();
				$(".videoPlay").css("display","block");
			}
    		
    	})
    	$('#video_good').bind('error ended', function(){  
	        $(".videoPlay").css("display","block");
	        $('#video_good').load();
	    })  
    })
    //切换商品评论和商品详情
//  $(".shopmessage").click(function () {
//      $(this).addClass("shopactive").siblings().removeClass("shopactive");
//      $(".goods-detail").eq($(this).index()).css("display", "block").siblings().css("display", "none");
//  });
//  $('.big-btn').on('click',function (){
//      var user = $api.checkLogin();
//      if( !user.id ){
//        	$api.openLogin()
//        	return false;
//      }
//  });
    
    
    //点击购物车
//  $('.to-cart').click(function (){
////      window.location.href = '<?php echo url('flow',array('id'=>$good['id'])); ?>';
////		window.location.href = '<?php echo url('order/ajax_orders'); ?>';
//		$api.openPage({
//	    	title: '购物车',
//	    	name: 'shopcart',
//			url: 'widget://html/shopcart/index.html',
////			url: 'widget://html/shopcar.html',
//		});
//  });
    //点击拨打电话
    $(".to-cart").on('click',function(){
    	api.call({
		    type: 'tel_prompt',
		    number: '18260428780'
		});
    })
    //点击加入购物车
//  $('.add-cart').click(function (){
//      if( !user.data.id ){
//        	$api.openLogin()
//        	return false;
//      }else{
//          $.ajax({
//              type: 'post',
//              dataType: 'json',
//              url: '<?php echo url('add_cart'); ?>',
//              data: {goods_id: <?php echo $good['id']; ?>},
//              success: function ( data ){
//                  if( data.code == 1 ){
//                      alert('加入成功');
//                  }else if( data.code == -1 ){
//                      alert('商品已结缘或已下架');
//                  }
//              }
//          });
//      }
//  });
    
    //分享
    var zShare = {};
  	$("#share_goods").on('click',function(){
  		var MNActionButton = api.require('MNActionButton');
        MNActionButton.open({
            layout: {
                row: 1,
                col: 4,
                rowSpacing: 10,
                colSpacing: 10,
                offset: 0
            },
            animation: true,
            autoHide: true,
            styles: {
                maskBg: 'rgba(0,0,0,0)',
                bg: '#fff',
                cancelButton: {
                    size: 44,
                    bg: '#fff',
                    icon: 'widget://image/cancel.png'
                },
                item: {
                    titleColor: '#888',
                    titleHighlight: 'dd2727',
                    titleSize: 12
                },
                indicator: {
                    color: '#c4c4c4',
                    highlight: '#9e9e9e'
                }
            },
            items: [{
                icon: 'widget://image/weixin.png',
                title: '微信好友'
            }, {
                icon: 'widget://image/pengyouquan.png',
                title: '朋友圈'
            }, {
                icon: 'widget://image/qq.png',
                title: 'QQ'
            }, {
                icon: 'widget://image/weibo.png',
                title: '微博'
            }]
        }, function(ret) {
            if (ret) {
            var test = window.location.href;
	      		if(ret.index == 0){
	      			zShare.wxNews('session','玉蘇州','<?php echo $good['title']; ?>',''+test,'<?php echo $img; ?>');
	      		}
            }
       });
    });
	//微信  朋友圈
	zShare.wxNews = function(tar, title, text, url, img) {
    filename = (new Date()).valueOf() + '.' + zShare.ext(img);
    api.download({
        url: img,
        savePath: 'fs://' + filename,
        report: false,
        cache: true,
        allowResume: true
    }, function(ret, err) {
        var wx = api.require('wx');
        wx.isInstalled(function(ret) {
            if (ret.installed) {
                api.toast({
                    msg: '分享中，请稍候',
                    duration: 2000,
                    location: "middle"
                });
            } else {
                api.toast({
                    msg: '没有安装微信，无法进行分享',
                    duration: 2000,
                    location: "middle"
                });
            }
        });
        wx.shareWebpage({
            apiKey: '',
            scene: tar,
            title: title,
            description: text,
            thumb: 'fs://' + filename,
            contentUrl: url
        }, function(ret, err) {
            if (ret.status) {
                api.toast({
                    msg: '分享成功',
                    duration: 2000,
                    location: "middle"
                });
            }
        });
    });
    }
	//QQ好友
	zShare.qqNews = function(tar,title,text,url,img){
    var qq = api.require('qq');
    qq.installed(function(ret){
        if(ret.status) {
            api.toast({msg:'分享中，请稍候',duration:2000,location:"middle"});
        } else {
            api.toast({msg:'没有安装QQ，无法进行分享',duration:2000,location:"middle"});
        }
    });
    qq.shareNews({
        url: url,
        title: title,
        description: text,
        imgUrl: img,
        type: tar
    },function(ret,err){
        if (ret.status){
            api.toast({msg: '分享成功',duration:2000, location: "botoom"});
        }
    });
	}
	//微博
	zShare.weiboNews = function(tar,title,text,url,img){
    filename = (new Date()).valueOf()+'.'+zShare.ext(img);
    api.download({
        url: img,
        savePath: 'fs://'+filename,
        report: false,
        cache: true,
        allowResume: true
    }, function(ret, err) {
        var weibo = api.require('weibo');
        weibo.shareImage({
            text: title+text+url,
            imageUrl: 'fs://'+filename
        }, function(ret, err) {
            if (ret.status) {
                api.toast({msg:'分享成功',duration:2000,location:"middle"});
            }
        });
    });
	}
	zShare.ext = function(fileName) {
  		return fileName.substring(fileName.lastIndexOf('.') + 1);
	}
</script>
</body>
</html>