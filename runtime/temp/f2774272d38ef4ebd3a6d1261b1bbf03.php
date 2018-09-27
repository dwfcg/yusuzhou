<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"/www/wwwroot/yusuzhou.youacloud.com/application/shop/view/goods/flow.html";i:1517971500;}*/ ?>
<!DOCTYPE html>
<html class="" lang="zh-cmn-Hans">
    <head>
        <meta charset="utf-8">
        <title>订单提交</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <style>
            a, body {
                color: #333
            }
            a, abbr, acronym, address, applet, article, aside, audio, b, big, blockquote, body, canvas, caption, center, cite, code, dd, del, details, dfn, div, dl, dt, em, embed, fieldset, figcaption, figure, footer, form, h1, h2, h3, h4, h5, h6, header, hgroup, html, i, iframe, img, ins, kbd, label, legend, li, mark, menu, nav, object, ol, output, p, pre, q, ruby, s, samp, section, small, span, strike, strong, sub, summary, sup, table, tbody, td, tfoot, th, thead, time, tr, tt, u, ul, var, video {
                margin: 0;
                padding: 0;
                border: 0;
                font: inherit;
                font-size: 100%;
                vertical-align: baseline
            }
            html {
                line-height: 1;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
                font-family: Helvetica, "STHeiti STXihei", "Microsoft YaHei", Tohoma, Arial
            }
            ol, ul {
                list-style: none
            }
            table {
                border-collapse: collapse;
                border-spacing: 0
            }
            caption, td, th {
                font-weight: 400;
                vertical-align: middle
            }
            blockquote, q {
                quotes: none
            }
            blockquote:after, blockquote:before, q:after, q:before {
                content: "";
                content: none
            }
            .arrow-right::after, .clearfix:after, .container .content:after {
                content: ''
            }
            a img {
                border: none
            }
            article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section, summary {
                display: block
            }
            body {
                background-color:#f8f8f8;
                -webkit-backface-visibility: hidden
            }
            body.body-fixed-bottom {
                padding-bottom: 50px
            }
            .container {
                background-color: #f8f8f8
            }
            strong {
                font-weight: 700
            }
            a {
                background: 0 0;
                text-decoration: none;
                -webkit-tap-highlight-color: transparent
            }
            h1 {
                font-size: 2em;
                margin: .67em 0
            }
            h2 {
                font-size: 18px;
                line-height: 22px
            }
            h3 {
                font-size: 15px;
                line-height: 18px
            }
            button, input[type=number], input[type=text], input[type=password], input[type=email], input[type=search], select, textarea {
                font-family: inherit;
                font-size: 100%;
                margin: 0;
                -webkit-tap-highlight-color: transparent;
                -webkit-appearance: none;
                -moz-appearance: none
            }
            .c-orange {
                color: #f60!important
            }
            .c-orange-dark {
                color: #f15a0c!important
            }
            .c-green {
                color: #06bf04!important
            }
            .c-wx-green {
                color: #4b0!important
            }
            .c-red {
                color: #ed5050!important
            }
            .c-pink {
                color: #ee614b!important
            }
            .c-white {
                color: #fff!important
            }
            .c-gray-light {
                color: #e5e5e5!important
            }
            .c-gray {
                color: #c9c9c9!important
            }
            .c-gray-dark {
                color: #999!important
            }
            .c-gray-darker {
                color: #666!important
            }
            .c-black {
                color: #333!important
            }
            .c-yellow {
                color: #f09000!important
            }
            .c-light-yellow {
                color: #fcff00!important
            }
            .c-blue {
                color: #38f!important
            }
            @media only screen and (-webkit-min-device-pixel-ratio:1.5), only screen and (min--moz-device-pixel-ratio:1.5), only screen and (min-device-pixel-ratio:1.5) {
                hr {
                    border-top-width: 1px
                }
            }
            hr.margin-0 {
                margin: 0
            }
            hr.left-10 {
                margin-left: 10px
            }
            .relative {
                position: relative
            }
            .font-size-12 {
                font-size: 12px!important
            }
            .font-size-14 {
                font-size: 14px!important
            }
            .font-size-16 {
                font-size: 16px!important
            }
            .font-size-18 {
                font-size: 18px!important
            }
            .font-size-20 {
                font-size: 20px!important
            }
            .font-size-22 {
                font-size: 22px!important
            }
            .font-size-24 {
                font-size: 24px!important
            }
            .font-size-26 {
                font-size: 26px!important
            }
            .font-size-28 {
                font-size: 28px!important
            }
            .ellipsis {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis
            }
            .border-bottom-none {
                border-bottom: 0!important
            }
            .border-top-none {
                border-top: 0!important
            }
            .link, .link:active, .link:hover, .link:link, .link:visited {
                color: #07d
            }
            .clearfix:after {
                display: table;
                clear: both
            }
            .pull-left {
                float: left
            }
            .pull-right {
                float: right
            }
            .show {
                display:block!important;
            }
            .hide {
                display:none!important;
            }
            .motify {
                position: fixed;
                top: 35%;
                left: 50%;
                width: 220px;
                padding: 0;
                margin: 0 0 0 -110px;
                z-index: 9999;
                background: rgba(0,0,0,.8);
                color: #fff;
                display:none;
                line-height: 1.5em;
                border-radius: 6px;
                -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
                box-shadow: 0 1px 2px rgba(0,0,0,.2);
            }
            .motify-inner{
                padding:10px;
                text-align:center;
            }
            .js-goods-list{
                border-bottom: 1px solid #eee;
            }
        </style>
        <link rel="stylesheet" href="__STATIC__/home/css/trade.css">
        <link rel="stylesheet" href="__STATIC__/home/css/index.css">
    </head>
    <body class=" body-fixed-bottom default-theme" style="overflow: hidden; height: 100%; margin-bottom: 0px; padding: 0px;">
        <div class="container">
            <div class="content confirm-container">
                <div class="app app-order">
                    <div class="app-inner inner-order" id="js-page-content">
                        <div class="order-top-info-block block block-list border-top-0"> 
                            <div class="block-item express border-0" id="js-logistics-container" style="margin-top: -1px;">
                                <div class="js-logistics-content logistics-content js-express">
                                    <div class="">
                                        <div class="js-order-address express-panel express-panel-edit">
                                            <ul class="express-detail">
                                                <li class="clearfix"><span class="h-real_name name">收货人：<?php echo $first_address['consignee']; ?></span><span class="tel h-mobile"><?php echo $first_address['mobile']; ?></span></li>
                                                <li class="address-detail">收货地址：<span class="h-address address"><?php echo $first_address['sheng']; ?>.<?php echo $first_address['shi']; ?>.<?php echo $first_address['xian']; ?>.<?php echo $first_address['address']; ?></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="js-logistics-content logistics-content js-self-fetch hide"></div>
                                <div class="js-logistics-tips logistics-tips font-size-12 c-orange hide">很抱歉，该地区暂不支持配送。</div>
                            </div>
                        </div>
                        <div class="js-goods-list-container block block-list block-order ">
                            <div class="js-header header" style="display:none;"></div>
                            <?php if(is_array($goods_list) || $goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator): $i = 0; $__LIST__ = $goods_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($i % 2 );++$i;?>
                            <div class="js-goods-list" data-id="<?php echo $goods['id']; ?>">
                                <div class="js-goods-item order-goods-item clearfix block-list">
                                    <div class="name-card name-card-goods clearfix block-item"> <a href="javascript:;" class="thumb"> <img class="js-view-image" src="<?php echo $goods['images']; ?>"> </a>
                                        <div class="detail">
                                            <div class="clearfix detail-row">
                                                <div class="right-col text-right">
                                                    <div class="price">￥<span><?php echo $goods['price']; ?></span></div>
                                                </div>
                                                <div class="left-col"> <a href="javascript:;">
                                                        <h3 class="l2-ellipsis"><?php echo $goods['title']; ?></h3>
                                                    </a> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                            <div class="js-presale-delivery presale-delivery-panel hide"></div>
                            <div class="js-shop-ump info-panel block-item hide"><span class="left-part">店铺活动</span>
                                <div class="ump-info arrow js-shop-ump-info">
                                    <p class="ellipsis"></p>
                                </div>
                            </div>
                            <div class="js-hotel-info hotel-block-list block block-list border-top-0 hide"></div>
                            <div class="js-express-block block-item info-panel"><span class="left-part">配送方式</span>
                                <div class="js-express-info right-part c-gray-darker ">
                                    <p> 顺丰快递 </p>
                                </div>
                            </div>
                            <div class="js-express-block block-item info-panel">
                            <span class="left-part">支付方式</span>
                                <div class="js-express-info right-part c-gray-darker ">
                                    <p class="font-size-12"> 在线支付 </p>
                                </div>
                            </div>
                            <div class="hide block-item js-localdelivery-block  info-panel "></div>
                            <div class="hide block-item js-localdelivery-block-info"></div>
                             <div class="js-total block-item order-message border-none"><span>商品金额</span>
                                <div id="" class=" hprice js-sum-price input-wrapper c-orange theme-price-color pull-right"> ￥<?php echo $goods['price']; ?> </div>
                            </div>
                        </div>
                        <div class="js-invalid-goods invalid-goods hide"> </div>
                        <div class="js-order-total-pay order-total-pay bottom-fix">
                            <div class="pay-container clearfix">
                                <div class="pull-right pull-margin-up"> <span class="c-gray-darker font-size-16">合计：</span> <span id='' class=" hprice js-price c-red-f44 font-size-16 theme-price-color">￥<?php echo $goods_price; ?></span>
                                                                        <button class="js-confirm btn btn-red-f44 commit-bill-btn">提交订单</button>
                                                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="W6swAlhL8R" style="display:none;height: 100%; position: fixed; top: 0px; left: 0px; right: 0px; background-color: rgba(0, 0, 0, 0.701961); z-index: 1000; transition: none 0.2s ease; opacity: 1;"></div>
        <div id="I0QkHSnfQ2" class="popup" style="display:none;overflow: hidden; position: absolute; z-index: 1000; left: 0px; right: 0px; bottom: 0px; background: white; visibility: visible; transform: translate3d(0px, 0px, 0px); transition: all 300ms ease; opacity: 1;">
            <div class="js-scene-address-list">
                <div class="address-ui address-list">
                    <h4 class="address-title">选择收货地址</h4>
                    <div class="cancel-img js-cancel"></div>
                                        <?php if(is_array($address) || $address instanceof \think\Collection || $address instanceof \think\Paginator): $i = 0; $__LIST__ = $address;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$add): $mod = ($i % 2 );++$i;?>
                    <div class="js-address-container address-container<?php echo $add['address_id']; ?> address-container block block-list border-top-0" data-id="<?php echo $add['address_id']; ?>" data-username="<?php echo $add['consignee']; ?>" data-mobile="<?php echo $add['mobile']; ?>" data-pre="<?php echo $add['sheng']; ?>.<?php echo $add['shi']; ?>.<?php echo $add['xian']; ?>." data-address="<?php echo $add['address']; ?>" data-province="<?php echo $add['province']; ?>" data-city="<?php echo $add['city']; ?>" data-district="<?php echo $add['district']; ?>" data-postalcode="<?php echo $add['zipcode']; ?>">
                        <div id="js-address-item-53646979" class="js-address-item block-item ">
                            <div>
                                <div class="icon-check <?php if($add['address_id'] == $first_address['address_id']): ?>icon-checked<?php endif; ?>"></div>
                                            <p> <span class="address-name" style="margin-right: 5px;"><?php echo $add['consignee']; ?></span>, <span class="address-tel"><?php echo $add['mobile']; ?></span> </p>
                                            <span class="address-str address-str-sf">收货地址：<?php echo $add['sheng']; ?>.<?php echo $add['shi']; ?>.<?php echo $add['xian']; ?>.<?php echo $add['address']; ?></span>
                                            <div class="address-opt  js-edit-address "> <i class="icon-circle-info"></i> </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                                <div class="add-address js-add-address"> <span class="icon-add"></span> <a class="" href="javascript:;">新增地址</a> <span class="icon-arrow-right"></span> </div>
                    </div>
                </div>
            </div>
            <div id="UPdfDA0zmA" style="display:none;height: 100%; position: fixed; top: 0px; left: 0px; right: 0px; background-color: rgba(0, 0, 0, 0.701961); z-index: 1000; transition: none 0.2s ease; opacity: 1;"></div>
            <div id="4Xfr0JmrMv" class="popup" style="display:none;overflow: hidden; position: absolute; z-index: 1000; left: 0px; right: 0px; bottom: 0px; background: white; visibility: visible; transform: translate3d(0px, 0px, 0px); transition: all 300ms ease; opacity: 1;">
                <form class="js-address-fm address-ui address-fm">
                    <h4 class="address-fm-title"> 编辑收货地址 </h4>
                    <div class="js-address-cancel cancel-img"></div>
                    <div class="block form" style="margin:0;">
                        <input type="hidden" id="address_id" value="<?php echo $first_address['address_id']; ?>">
                        <div class="block-item no-top-border">
                            <label>收货人</label>
                            <input type="text" id="user_name" value="" placeholder="收货人姓名">
                        </div>
                        <div class="block-item">
                            <label>联系电话</label>
                            <input type="tel" id="mobile" value="" placeholder="收货人电话">
                        </div>
                        <div class="block-item">
                            <label>选择地区</label>
                            <div class="js-area-select area-layout"> <span>
                                    <select class="js-province address-province" id="province">
                                        <option value="0">选择省份</option>
                                        <option value="2">北京</option>
                                        <option value="3">安徽省</option>
                                        <option value="4">福建省</option>
                                        <option value="5">甘肃省</option>
                                        <option value="6">广东省</option>
                                        <option value="7">广西省</option>
                                        <option value="8">贵州省</option>
                                        <option value="9">海南省</option>
                                        <option value="10">河北省</option>
                                        <option value="11">河南省</option>
                                        <option value="12">黑龙江省</option>
                                        <option value="13">湖北省</option>
                                        <option value="14">湖南省</option>
                                        <option value="15">吉林省</option>
                                        <option value="16">江苏省</option>
                                        <option value="17">江西省</option>
                                        <option value="18">辽宁省</option>
                                        <option value="19">内蒙古</option>
                                        <option value="20">宁夏省</option>
                                        <option value="21">青海省</option>
                                        <option value="22">山东省</option>
                                        <option value="23">山西省</option>
                                        <option value="24">陕西省</option>
                                        <option value="25">上海</option>
                                        <option value="26">四川省</option>
                                        <option value="27">天津省</option>
                                        <option value="28">西藏</option>
                                        <option value="29">新疆</option>
                                        <option value="30">云南省</option>
                                        <option value="31">浙江省</option>
                                        <option value="32">重庆省</option>
                                        <option value="33">香港</option>
                                        <option value="34">澳门</option>
                                        <option value="35">台湾</option>
                                    </select>
                                </span> <span>
                                    <select class="js-city address-city" id="city">
                                        <option value="0">选择城市</option>
                                    </select>
                                </span> <span>
                                    <select class="js-county address-county" id="district">
                                        <option value="0">选择地区</option>
                                    </select>
                                </span> </div>
                        </div>
                        <div class="block-item">
                            <label>详细地址</label>
                            <div class="address-detail-wrap ">
                                <textarea type="text" class="js-address-detail address-detail" id="address" placeholder="如街道，楼层，门牌号等" rows="1" style="height:28px;"></textarea>
                                <i class="cancel-input-icon js-cancel-input hide"></i> <i class="cancel-input-icon-trigger js-cancel-input hide"></i>
                                <div class="address-prompt js-address-prompt"></div>
                            </div>
                        </div>
                        <div class="block-item">
                            <label>邮政编码</label>
                            <input type="tel" maxlength="6" id="postal_code" value="" placeholder="邮政编码(选填)">
                        </div>
                    </div>
                    <div class="action-container"> <a class="js-address-save btn btn-block btn-green">保存</a> <a class="js-address-delete btn btn-block btn-white">删除收货地址</a> </div>
                </form>
            </div>
            <div class="motify"><div class="motify-inner"></div></div>
            <script src="http://img.weibaoke.com.cn//static/lingshu/js/jquery-2.1.3.min.js"></script>
            <script>

                        $('.js-order-address').click(function (){
                $('#W6swAlhL8R,#I0QkHSnfQ2').show();
                });
                        $('.js-cancel,#W6swAlhL8R').click(function (){
                $('#W6swAlhL8R,#I0QkHSnfQ2').hide();
                });
                        $('.add-address').click(function (){
                $('#address_id').val('');
                        $('#UPdfDA0zmA,#4Xfr0JmrMv').show();
                        $('.js-address-delete').addClass('hide');
                });
                        $('.js-address-cancel,#UPdfDA0zmA').click(function (){
                $('#4Xfr0JmrMv,#UPdfDA0zmA').hide();
                });
                        $(document).on('touchend', '.js-address-container', function (){
                $('.js-address-container .icon-check').removeClass('icon-checked');
                        $(this).find('.icon-check').addClass('icon-checked');
                        var AddressContainer = $(this);
                        $('.h-mobile').html(AddressContainer.attr('data-mobile'));
                        $('.h-real_name').html('收货人：' + AddressContainer.attr('data-username'));
                        $('.h-address').html(AddressContainer.attr('data-pre') + AddressContainer.attr('data-address'));
                        $('#address_id').val(AddressContainer.attr('data-id'));
                        setTimeout(function (){
                        $('#W6swAlhL8R,#I0QkHSnfQ2').hide();
                        }, 500);
                })
                        var city_data = {};
                        $('#province').change(function (){
                var change_val = $(this).val();
                        create_region(change_val, null, city_data, '#city', '选择城市');
                });
                        $(document).on('touchend', '.js-edit-address', function (){
                setTimeout(function (){
                $('#UPdfDA0zmA,#4Xfr0JmrMv').show();
                }, 500);
                        $('.js-address-delete').removeClass('hide');
                        var parent = $(this).parents('.js-address-container');
                        $('#address_id').val(parent.attr('data-id'));
                        $('#user_name').val(parent.attr('data-username'));
                        $('#mobile').val(parent.attr('data-mobile'));
                        $('#address').val(parent.attr('data-address'));
                        $('#province').val(parent.attr('data-province'));
                        $('#postal_code').val(parent.attr('data-postalcode'));
                        create_region(parent.attr('data-province'), parent.attr('data-city'), city_data, '#city', '选择城市', function (){
                        create_region(parent.attr('data-city'), parent.attr('data-district'), city_data, '#district', '选择城市');
                        });
                });
                        $(document).on('click', '.js-address-delete', function (){
                $.ajax({
                type:'post',
                        url:'<?php echo url('del_address'); ?>',
                        dataType:'json',
                        data:{
                        address_id:$('#address_id').val()
                        },
                        success:function (){
                        notice('删除成功');
                                $('.js-address-cancel,#UPdfDA0zmA').click();
                                $('.address-container' + $('#address_id').val()).remove();
                                $('#user_name,#mobile,#province,#city,#district,#address,#postal_code,#address_id').val('');
                        }
                });
                });
                        var district_data = {};
                        $('#city').change(function (){
                var change_val = $(this).val();
                        create_region(change_val, null, district_data, '#district', '选择地区');
                });
                        var submit_onoff = true;
                        $('.js-address-save').on('click', function (){
                var msg = '';
                        var onOff = false;
                        var post_data = {
                        address_id:$('#address_id').val(),
                                user_name:$('#user_name').val(),
                                mobile:$('#mobile').val(),
                                province:$('#province').val(),
                                city:$('#city').val(),
                                district:$('#district').val(),
                                address:$('#address').val(),
                                postal_code:$('#postal_code').val(),
                                sheng:$('#province').find("option:selected").text(),
                                shi:$('#city').find("option:selected").text(),
                                xian:$('#district').find("option:selected").text()
                        }

                if (post_data.user_name == ''){
                    onOff = true;
                    msg = '请填写收货人姓名';
                } else if (post_data.mobile == ''){
                    onOff = true;
                    msg = '请填写收货人电话';
                } else if(!(/^1[34578]\d{9}$/.test(post_data.mobile))){ 
                    onOff = true;
                    msg = '请填写正确的收货人电话';
                } else if (post_data.province == 0 || post_data.city == 0 || post_data.district == 0){
                    onOff = true;
                    msg = '请选择收货人地区';
                } else if (post_data.address == ''){
                    onOff = true;
                    msg = '请填写收货人详细地址';
                }
                if (onOff){
                notice(msg);
                        return false;
                }
                if (!submit_onoff){
                return false;
                }
                submit_onoff = false;
                        $.ajax({
                        type:'post',
                                url:'<?php echo url('add_address'); ?>',
                                dataType:'json',
                                data:post_data,
                                success:function (data){
                                notice('保存成功');
                                        submit_onoff = true;
                                        post_data.address_id = data.code;
                                        var express_detail = $('.express-detail');
                                        $('.js-address-cancel,#UPdfDA0zmA').click();
                                        express_detail.find('.tel').html(post_data.mobile);
                                        express_detail.find('.name').html(post_data.user_name);
                                        express_detail.find('.address').html(post_data.sheng + '.' + post_data.shi + '.' + post_data.xian + '.' + post_data.address);
                                        if (post_data.address_id){
                                $('#address_id').val(post_data.address_id);
                                        $('.js-add-address').before(
                                        '<div class="js-address-container address-container' + post_data.address_id + ' address-container block block-list border-top-0" data-id="' + post_data.address_id + '" data-username="' + post_data.user_name + '" data-mobile="' + post_data.mobile + '" data-address="' + post_data.address + '" data-province="' + post_data.province + '" data-city="' + post_data.city + '" data-district="' + post_data.district + '" data-pre="' + post_data.sheng + '.' + post_data.shi + '.' + post_data.xian + '" data-postalcode="' + post_data.postal_code + '">' +
                                        '<div id="js-address-item-53646979" class="js-address-item block-item ">' +
                                        '<div>' +
                                        '<div class="icon-check "></div>' +
                                        '<p> <span class="address-name" style="margin-right: 5px;">收货人：' + post_data.user_name + '</span>, <span class="address-tel">' + post_data.mobile + '</span> </p>' +
                                        '<span class="address-str address-str-sf">收货地址：' + post_data.sheng + '.' + post_data.shi + '.' + post_data.xian + '.' + post_data.address + '</span>' +
                                        '<div class="address-opt  js-edit-address"> <i class="icon-circle-info"></i> </div>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>'
                                        );
                                        $('.js-address-container .icon-check').removeClass('icon-checked');
                                        $('.address-container' + post_data.address_id).find('.icon-check').addClass('icon-checked');
                                        return false;
                                }

                                if ($('#address_id').val()){
                                var address = $('.address-container' + $('#address_id').val());
                                        address.attr({
                                        'data-username':post_data.user_name,
                                                'data-mobile':post_data.mobile,
                                                'data-address':post_data.address,
                                                'data-province':post_data.province,
                                                'data-city':post_data.city,
                                                'data-district':post_data.district
                                        });
                                        address.find('.address-name').html(post_data.user_name);
                                        address.find('.address-tel').html(post_data.mobile);
                                        address.find('.address-str').html(post_data.sheng + '.' + post_data.shi + '.' + post_data.xian + '.' + post_data.address);
                                }
                                }
                        });
                });
                var confirm_onoff = true;
                $('.js-confirm').click(function (){
                    if ($('#address_id').val() == ''){
                        notice('请选择一个收货地址!');return false;
                    }
                    if (!confirm_onoff){
                    return false;
                    }
                    confirm_onoff = false;
                    var goods_id = [];
                    $.each($('.js-goods-list'),function (i,t){
                        goods_id.push($(t).attr('data-id'));
                    });
                        $.ajax({
                        type:'post',
                                url:'<?php echo url('create_order'); ?>',
                                dataType:'json',
                                data:{
                                    goods_id: goods_id.join(','),
                                    address_id:$('#address_id').val(),
                                    note:$('#note').val(),
                                },
                                success:function (data){
                                    if (data.code == 'address'){
                                        confirm_onoff = true;
                                        notice('收货地址不准确，请完善收货地址!');
                                    }else if (data.code == 2){
                                        confirm_onoff = true;
                                        notice('下单异常，请重新下单!');
                                    } else{
                                        notice('下单成功，正在打开支付...');
                                        window.location.href = '/index.php/shop/pay/pay.html?order_id='+data.data;
                                    }
                                }
                        });
                });
                        function create_region(change_val, selected, region_data, target, region_name, callback){
                        if (change_val != 0 && !region_data[change_val]){
                        $.ajax({
                        type:'post',
                                url:'<?php echo url('get_region'); ?>',
                                dataType:'json',
                                data:{
                                parent_id:change_val
                                },
                                success:function (data){
                                region_data[change_val] = data.data;
                                        create_option(region_data[change_val], selected, target, '<option value="0">' + region_name + '</option>');
                                        callback && callback();
                                }
                        });
                        } else{
                        callback && callback();
                                region_data[change_val] && create_option(region_data[change_val], selected, target, '<option value="0">' + region_name + '</option>');
                        }
                        }
                function create_option(data, selected, main, html){
                var option = html || '';
                        var length = data.length;
                        for (var i = 0; i < length; i++){
                var region = data[i];
                        option += '<option value="' + region.region_id + '">' + region.region_name + '</option>';
                }
                $(main).html(option);
                        selected && $(main).val(selected);
                }
                function notice(msg, time){
                $('.motify-inner').html(msg);
                        $('.motify').show(500);
                        setTimeout(function (){
                        $('.motify').hide(500);
                        }, time || 2000);
                }
            </script>
        </body>
    </html>