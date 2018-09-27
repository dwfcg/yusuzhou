<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"/www/wwwroot/yusuzhou.youacloud.com/application/shop/view/goods/index.html";i:1513151738;}*/ ?>
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
    <title><?php echo $goods['title']; ?></title>
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
            margin-top: 0.1rem;
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
        .to-cart{
            left: 0;
            top: 0;
            color: #999;
            width: 50px;
            font-size: 10px;
            padding-top: 34px;
            position: absolute;
            background: url(__STATIC__/home/image/cart.png) no-repeat center 8px/20px;
        }
        .add-cart{
            background: #f1ab47;
        }
        .big-btn-2-1 .big-btn{
            width: 30%;
            color: #fff;
            float: right;
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

<div class="container wap-goods internal-purchase">
    <div class="content no-sidebar">
        <div id="banner_box" class="box_swipe">

            <ul>
                <?php if(is_array($goods['images']) || $goods['images'] instanceof \think\Collection || $goods['images'] instanceof \think\Paginator): $i = 0; $__LIST__ = $goods['images'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$img): $mod = ($i % 2 );++$i;?>
                                 <li> <img src="<?php echo $img; ?>"></li>
                                 <?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>

            <ol>
                <li class="on"></li>

            </ol>

        </div>
        <div class="content-body">
            <div class="goods-header">
                <h2 class="title"><?php echo $goods['title']; ?></h2>
                <span class="hide js-add-wish js-wish-animate wish-add  font-size-12 tag tag-redf30 pull-right"> 喜欢 </span>

                <div class="goods-price ">
                    <div class="current-price"><span>￥</span><i class="js-goods-price price"><?php echo $goods['price']; ?></i></div><br>
                </div><br>
                <hr class="with-margin-l"/>
            </div>
            <div class="link_button" style="clear:both;">
                <div class="shopmessage shopactive" style="text-align:left;">商品详情</div>
                <div class="shopmessage" style="display:none;">商品评论 <span>( 0条评论 )</span></div>
            </div>
            <a class="js-package-buy-block hide"></a>

            <div class="js-detail-container" style="margin-top: 10px;">
                <div class="js-tabber-container goods-detail"><?php echo $goods['content']; ?></div>
                <div class="js-tabber-container goods-detail" style="display: none;">
                    <div class="page_main">
                                                <div class="empty_comment">
                            <img src="http://img.weibaoke.com.cn//static/shop/images/empty_comment.png?123123"/ >

                            <div class="empty_text">暂时没有评论哦!</div>
                        </div>
                                            </div>
                </div>
            </div>
        </div>
        <div class="js-bottom-opts js-footer-auto-ele bottom-fix">
            <div class="responsive-wrapper">
                <div class="big-btn-2-1">
                    <div class="to-cart">购物车</div>
                    <?php if($goods['status'] == 1): ?>
                    <a href="<?php echo url('flow',array('id'=>$goods['id'])); ?>" class="big-btn red-btn main-btn">立即购买</a>
                    <div class="add-cart big-btn">
                        加入购物车
                    </div>
                    <?php elseif($goods['status'] == 2): ?>
                    <a class="big-btn red-btn main-btn" style="width:100%;background:#666;">已结缘</a>
                    <?php elseif($goods['status'] == 0): ?>
                    <a class="big-btn red-btn main-btn" style="width:100%;background:#666;">已下架</a>
                    <?php endif; ?>
                </div>
            
        </div>
    </div>
    <div id="shop-nav"></div>
</div>
<script type="text/javascript" src="__STATIC__/home/js/api.js?3"></script>
<script>
    var other_flag = $("#banner_box ol li").length == 2 ? true : false;
    new Swipe(document.getElementById('banner_box'), {
        speed: 500,
        auto: 3000,
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
    //切换商品评论和商品详情
    $(".shopmessage").click(function () {
        $(this).addClass("shopactive").siblings().removeClass("shopactive");
        $(".goods-detail").eq($(this).index()).css("display", "block").siblings().css("display", "none");
    });
    $('.big-btn').on('click',function (){
        var user = $api.checkLogin();
        if( !user.id ){
          	$api.openLogin()
          	return false;
        }
    })
    $('.to-cart').click(function (){
        window.location.href = '<?php echo url('flow'); ?>';
    })
    $('.add-cart').click(function (){
        var user = $api.checkLogin();
        if( !user.id ){
          	$api.openLogin()
          	return false;
        }else{
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '<?php echo url('add_cart'); ?>',
                data: {goods_id: <?php echo $goods['id']; ?>},
                success: function ( data ){
                    if( data.code == 1 ){
                        alert('加入成功');
                    }else if( data.code == -1 ){
                        alert('商品已结缘或已下架');
                    }
                }
            });
        }
    })
</script>
</body>
</html>