<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"/www/wwwroot/yusuzhou.youacloud.com/application/forum/view/detail/index.html";i:1517802872;}*/ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
        <title><?php echo $thread['title']; ?></title>
        <script type="text/javascript">
        	(function (){
    		    var Doc = document.documentElement;
    		    Doc.style.fontSize = Doc.clientWidth/10+'px';
    		})();
        </script>
        <link rel="stylesheet" href="__STATIC__/home/css/base.css" type="text/css" />
        <style type="text/css">
            .thread-head{
                display: box;
                padding: 15px;
                display: -webkit-box;
                border-bottom: 1px solid rgba(239,239,239,0.5);
            }
            .thread-head .user-author{
                width: 1.3rem;
            }
            .thread-head .user-author img{
                border-radius: 1.3rem;
            }
            .thread-head .user-intro{
                margin-left: 10px;
            }
            .thread-head .user-intro .name{
                font-size: 18px;
            }
            .thread-head .user-intro .time_view{
                margin-top: 4px;
                color: #d9d9d9;
            }
            .thread-cont{
                padding: 15px;
            }
            .thread-title{
                font-size: 20px;
                font-weight: bold;
                padding-bottom: 15px;
            }
            .thread-images img{
                margin-bottom: 20px;
            }
            .thread-text{
                color: #666;
                font-size: 18px;
            }
            .thread-share ul{
                display: box;
                padding: 0 60px 30px;
                text-align: center;
                box-pack: justify;
                display: -webkit-box;
                -webkit-box-pack: justify;
            }
            .thread-share-title{
                width: 160px;
                height: 1px;
                display: box;
                box-pack: center;
                margin: 30px auto;
                background: #ededed;
                display: -webkit-box;
                -webkit-box-pack: center;
            }
            .thread-share-title:after{
                content: "分享到";
                display: block;
                background: #fff;
                height:14px;
                width:80px;
                color:#888;
                text-align: center;
                transform: translateY(-50%);
            }
            .thread-share li{
                width: 50px;
            }
            .thread-share img{
                width: 40px;
            }
            .thread-share .text{
                color: #999;
                margin-top: 6px;
                font-size: 8px;
            }
            .common-title{
                color: #999;
                line-height: 40px;
                font-size: 10px;
                margin-bottom: 10px;
                border-bottom: 1px solid rgba(239,239,239,0.5);
            }
            .thread-comment{
                padding: 0 15px;
            }
            .comment-list li+li{
                margin-top: 10px;
            }
            .comment-list li:last-of-type .comment-text{
                border: 0;
            }
            .comment-list .user-head{
                display: box;
                display: -webkit-box;
                box-align: center;
                -webkit-box-align: center;
            }
            .comment-list .user-author{
                width: 1rem;
            }
            .comment-list .user-author img{
                border-radius: 1rem;
            }
            .comment-list .user-intro{
                box-flex: 1;
                padding:0 10px;
                -webkit-box-flex: 1;
            }
            .comment-list .user-intro .user-name{
                font-size: 0.4rem;
                color: #888;
                margin: 4px 0;
            }
            .comment-list .user-intro .add-time{
                color: #c6c6c6;
            }
            .comment-list .comment-intro{
                display: box;
                color: #888;
                display: -webkit-box;
            }
            .comment-list .comment-intro .zan{
                height: 14px;
                padding-left: 18px;
                margin-right: 20px;
                background: url(__STATIC__/home/img/dianzan.png) no-repeat left center/14px;
            }
            .comment-list .comment-intro .zan.active{
                background: url(__STATIC__/home/img/dianzan_active.png) no-repeat left center/14px;
            }
            .comment-list .comment-intro .com{
                height: 14px;
                padding-left: 18px;
                background: url(__STATIC__/home/img/pinglun.png) no-repeat left center/14px;
            }
            .comment-list .comment-text{
                padding: 10px 20px 10px 0;
                margin-left: 60px;
                font-size: 16px;
                color: #393939;
                border-bottom: 1px solid rgba(239,239,239,0.5);
            }
            .comment-list .comment-images{
                display: box;
                display: -webkit-box;
                height: 2rem;
                overflow: hidden;
                margin-left: 60px;
                margin-bottom: 10px;
            }
            .comment-list .comment-images .image{
                box-flex: 1;
                width: 1px;
                -webkit-box-flex: 1;
            }
            .comment-list .comment-images .image+.image{
                margin-left:2px;
            }
            .thread-recom{
                padding: 0 10px;
            }
            .recom-list li+li{
                padding-top: 10px;
                border-top: 1px solid rgba(239,239,239,0.5);
            }
            .recom-list .recom-title{
                line-height: 20px;
                margin-bottom: 10px;
            }
            .recom-list .recom-images{
                display: box;
                display: -webkit-box;
                height: 2.2rem;
                overflow: hidden;
            }
            .recom-list .recom-images .image{
                box-flex: 1;
                width: 1px;
                -webkit-box-flex: 1;
            }
            .recom-list .recom-images .image+.image{
                margin-left:2px;
            }
            .recom-list .recom-num{
                display: box;
                margin: 10px 0;
                display: -webkit-box;
            }
            .recom-list .recom-num div{
                height: 20px;
                font-size: 12px;
                line-height: 22px;
                padding-left: 24px;
                color: #c6c6c6;
            }
            .recom-list .recom-num .zan{
                margin-right: 10px;
                background: url(__STATIC__/home/img/dianzan_gray.png) no-repeat left center/20px;
            }
            .recom-list .recom-num .com{
                background: url(__STATIC__/home/img/pinglun_gray.png) no-repeat left center/16px;
            }
            .footer{
                left: 0;
                right: 0;
                bottom: 0;
                display: box;
                height: 1.5rem;
                position: fixed;
                background: #fff;
                box-align: center;
                display: -webkit-box;
                -webkit-box-align: center;
                border-top: 1px solid rgba(239,239,239,0.5);
            }
            .footer .comment{
                box-flex: 1;
                color: #c6c6c6;
                height: 1rem;
                line-height: 1rem;
                margin: 0 0.3rem;
                padding-left: 0.8rem;
                -webkit-box-flex: 1;
                border-radius: .8rem;
                background: #efefef url(__STATIC__/home/img/edit.png) no-repeat 0.3rem center/0.4rem;
            }
            .footer .button-list{
                display: box;
                margin-right: 0.3rem;
                font-size: 0.2rem;
                text-align: center;
                display: -webkit-box;
            }
            .footer .button-list .icon{
                height: 0.5rem;
            }
            .footer .button-list .text{
                margin-top: 0.1rem;
            }
            .footer .button-list .com{
                background: url(__STATIC__/home/img/pinglun.png) no-repeat center/0.45rem;
            }
            .footer .button-list .zan{
                background: url(__STATIC__/home/img/dianzan.png) no-repeat center/0.5rem;
            }
            .footer .button-list li{
                width: 1.5rem;
            }
        </style>
    </head>
    
    <body class="page_main">
        <div class="thread-head">
            <div class="user-author">
                <img src="<?php echo $thread['headimg']; ?>" />
            </div>
            <div class="user-intro">
                <div class="name"><?php echo $thread['name']; ?></div>
                <div class="time_view">
                    <?php echo date("m-d H:i",$thread['add_time']); ?> | <?php echo $thread['view_num']; ?>人浏览
                </div>
            </div>
        </div>
        <div class="thread-cont">
            <div class="thread-title">
                <?php echo $thread['title']; ?>
            </div>
            <div class="thread-images">
                <?php if(is_array($thread['images']) || $thread['images'] instanceof \think\Collection || $thread['images'] instanceof \think\Paginator): $i = 0; $__LIST__ = $thread['images'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$image): $mod = ($i % 2 );++$i;?>
                <img data-original="<?php echo $image; ?>" class="lazy" >
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <div class="thread-text">
                <?php echo $thread['content']; ?>
            </div>
        </div>
        <div class="thread-share">
            <div class="thread-share-title"></div>
            <ul>
                <li data-type="wxFriend">
                    <div class="icon"><img src="__STATIC__/home/img/weixin.png" /></div>
                    <div class="text">微信好友</div>
                </li>
                <li data-type="wxCircle">
                    <div class="icon"><img src="__STATIC__/home/img/pengyouquan.png" /></div>
                    <div class="text">朋友圈</div>
                </li>
                <li data-type="qqFriend">
                    <div class="icon"><img src="__STATIC__/home/img/qq.png" /></div>
                    <div class="text">QQ</div>
                </li>
                <li data-type="xinLang">
                    <div class="icon"><img src="__STATIC__/home/img/weibo.png" /></div>
                    <div class="text">微博</div>
                </li>
            </ul>
        </div>
        <div class="block-line"></div>
        <div class="thread-comment">
            <div class="common-title">评论</div>
            <ul class="comment-list">
                <?php if(is_array($comment) || $comment instanceof \think\Collection || $comment instanceof \think\Paginator): $i = 0; $__LIST__ = $comment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$com): $mod = ($i % 2 );++$i;?>
                <li data-id="<?php echo $com['id']; ?>">
                    <div class="user-head">
                        <div class="user-author">
                            <img src="<?php echo $com['headimg']; ?>" />
                        </div>
                        <div class="user-intro">
                            <div class="user-name"><?php echo $com['name']; ?></div>
                            <div class="add-time"><?php echo date("Y-m-d",$com['add_time']); ?></div>
                        </div>
                        <div class="comment-intro">
                            <div class="zan"><?php echo $com['zan_num']; ?></div>
                        </div>
                    </div>
                    <div class="comment-text"><?php echo $com['content']; ?></div>
                    <?php $com['images'] = array_filter(explode(',',$com['images'])); if($com['images']): ?>
                    <div class="comment-images">
                        <?php $__FOR_START_1960940441__=0;$__FOR_END_1960940441__=3;for($i=$__FOR_START_1960940441__;$i < $__FOR_END_1960940441__;$i+=1){ ?>
                        <div class="image">
                            <?php if(isset($com['images'][$i])): ?>
                            <img data-original="<?php echo $com['images'][$i]; ?>" class="lazy">
                            <?php endif; ?>
                        </div>
                        <?php } ?>
                    </div>
                    <?php endif; ?>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <div class="block-line"></div>
        <div class="thread-recom">
            <div class="common-title">相关推荐</div>
            <ul class="recom-list">
                <?php if(is_array($recom) || $recom instanceof \think\Collection || $recom instanceof \think\Paginator): $i = 0; $__LIST__ = $recom;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$res): $mod = ($i % 2 );++$i;?>
                <li data-id="<?php echo $res['id']; ?>">
                    <div class="recom-title"><?php echo $res['title']; ?></div>
                    <?php $res['images'] = array_filter(explode(',',$res['images'])); if($res['images']): ?>
                    <div class="recom-images">
                        <?php $__FOR_START_213273273__=0;$__FOR_END_213273273__=3;for($i=$__FOR_START_213273273__;$i < $__FOR_END_213273273__;$i+=1){ ?>
                        <div class="image">
                            <?php if(isset($res['images'][$i])): ?>
                            <img data-original="<?php echo $res['images'][$i]; ?>" class="lazy">
                            <?php endif; ?>
                        </div>
                        <?php } ?>
                    </div>
                    <?php endif; ?>
                    <div class="recom-num">
                        <div class="zan"><?php echo $res['zan_num']; ?></div>
                        <div class="com"><?php echo $res['com_num']; ?></div>
                    </div>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <div class="block-line"></div>
        <div class="footer">
            <div class="comment">写评论...</div>
            <ul class="button-list">
                <li>
                    <div class="icon com"></div>
                    <div class="text"><?php echo $thread['com_num']; ?></div>
                </li>
                <li>
                    <div class="icon zan"></div>
                    <div class="text"><?php echo $thread['zan_num']; ?></div>
                </li>
            </ul>
        </div>
        <div style="height:1.5625rem;"></div>
        <script type="text/javascript" src="__STATIC__/home/js/api.js?4"></script>
        <script type="text/javascript" src="__STATIC__/home/js/jquery-2.1.3.min.js"></script>
        <script type="text/javascript" src="__STATIC__/home/js/jquery.lazyload.min.js"></script>
        <script>
            var user = decodeURIComponent($api.getCookie('userLogin'));
            user = user ? JSON.parse(user) : {};
            $("img.lazy").lazyload({
				effect: "fadeIn",
				container: $(".page_main")
			});
            apiready = function () {
                var inShare = api.require('inShare');
                $('.thread-share li').on('click',function (){
                    var type = $(this).attr('data-type');
                    var host = window.location.protocol + '//' + window.location.hostname;
                    var logo = host+'/public/static/home/image/logo.png';
                    var img = $('.thread-images img').eq(0).attr('src');
                    /*
                    inShare.shareImgsTo({
                        imgPaths: img ? host + img : logo ,
                        sendPattern:'ONLY',
                        description:'<?php echo $thread['title']; ?>',
                        app: type,               
                    },function(ret,err){
                        if(ret.status){
                            alert(JSON.stringify(ret));
                        }else{
                            alert(ret.errorMessage);
                        }
                    });
                    */
                    inShare.shareImgsTo({
    imgPaths:logo,
    sendPattern:'ONLY',
    description:'这是分享的测试图片描述',
    app:'wxFriend',               
},function(ret,err){
    if(ret.status){
        alert(JSON.stringify(ret));
    }else{
        alert(ret.errorMessage);
    }
});
                })

                $('.user-author').on('click',function (){
                    $api.openUcenter(<?php echo $thread['uid']; ?>);
                });
                $('.thread-images').on('click','img',function (){
                    var img = [];
                    $.each($('.thread-images img'),function (i,e){
                        img.push( site_url + $(e).attr('src') );
                    });
                    var activeIndex = $(this).index();
                    var photoBrowser = api.require('photoBrowser');
                    photoBrowser.open({
                        images: img,
                        activeIndex,
                        placeholderImg: 'widget://res/img/apicloud.png',
                        bgColor: '#000'
                    });
                })
                $('.comment-images').on('click','.image',function (){
                    var img = [];
                    $.each($('.comment-images img'),function (i,e){
                        img.push( site_url + $(e).attr('src') );
                    });
                    var activeIndex = $(this).index();
                    var photoBrowser = api.require('photoBrowser');
                    photoBrowser.open({
                        images: img,
                        activeIndex,
                        placeholderImg: 'widget://res/img/apicloud.png',
                        bgColor: '#000'
                    });
                })
                $('.recom-list').on('click','.recom-title,.recom-images',function (){
                    var id = $(this).parents('li').attr('data-id');
                    api.openWin({
					    name: 'thread_detail_'+id,
					    url: 'widget://html/thread/thread_detail.html',
					    pageParam: {
					        id
					    }
					});
                });
                $('.footer .comment,.button-list li:first').on('click',function (){
                    if( user.id ){
                        api.openWin({
    					    name: 'thread_comment',
    					    url: 'widget://html/thread/thread_comment.html',
    					    pageParam: {
    					        id: <?php echo $thread['id']; ?>
    					    }
    					});
                    }else{
                      	$api.openLogin()
                    }
                });
                $('.comment-list').on('click','.comment-intro div',function (){
                    if( $(this).hasClass('zan') ){
                        setInc($(this),'comment',$(this).parents('li').attr('data-id'));
                    }
                });
                $('.recom-list').on('click','.recom-num div',function (){
                    if( $(this).hasClass('zan') ){
                        setInc($(this),'thread',$(this).parents('li').attr('data-id'));
                    }else if( $(this).hasClass('com') ){
                        if( user.id ){
            	            api.openWin({
        					    name: 'thread_comment',
        					    url: 'widget://html/thread/thread_comment.html',
        					    pageParam: {
        					        id: $(this).parents('li').attr('data-id')
        					    }
    					    });
                        }else{
                          	$api.openLogin()
                        }
                    }
                    event.stopPropagation();
                });
                $('.button-list li').eq(1).on('click',function (){
                    setInc($(this).find('.text'),'thread',<?php echo $thread['id']; ?>);
                });
            }
            function setInc(el,table,id){
                if( !user.id ){
                    return $api.openLogin();
                }
                $.ajax({
                    type: 'post',
                    url: site_url + '/index.php/forum/detail/setNumerInc.html',
                    data: {
                        id,
                        table
                    },
                    dataType: 'json',
                    success: function ( data ){
                        if( data.data ){
                            var num = parseInt(el.html());
                            num++;
                            el.html(num);
                        }
                    }
                });
            }
        </script>
    </body>
</html>
