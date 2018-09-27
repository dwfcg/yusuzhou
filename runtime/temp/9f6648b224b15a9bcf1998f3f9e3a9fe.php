<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:65:"D:\phpStudy\WWW\yusuzhou/application/forum\view\detail\index.html";i:1536300640;}*/ ?>
<!DOCTYPE html>
<html>
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
                /*border-radius: 1.3rem;*/
               width: 1.3rem;
               height: 1.3rem;
               border-radius: 50%;
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
                color: #000;
                line-height: 40px;
                font-size: 15px;
                margin-bottom: 10px;
                border-bottom: 1px solid rgba(239,239,239,0.5);
                font-weight: bold;
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
            	width: 1rem;
            	height: 1rem;
                border-radius: 50%;
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
            .comment-box{
            	display: box;
            	display: -webkit-box;
            	-webkit-box-pack: end;
            	padding-bottom: 15px;
            }
            .comment-list .comment-intro{
                display: box;
                color: #888;
                display: -webkit-box;
            }
            .comment-list .comment-intro .zan{
                height: 14px;
                padding-left: 18px;
                line-height: 14px;
                /*margin-right: 20px;*/
                background: url(__STATIC__/home/img/dianzan.png) no-repeat left center/14px;
            }
            .p_active{
            	color: #000;
            	height: 14px;
                padding-left: 18px;
                line-height: 14px;
                /*margin-right: 20px;*/
                background: url(__STATIC__/home/img/dianzan_active.png) no-repeat left center/14px;
            }
            .comment-list .comment-intro .com{
                height: 14px;
                padding-left: 18px;
                margin-right: 10px;
                line-height: 14px;
                background: url(__STATIC__/home/img/pinglun.png) no-repeat left center/14px;
            }
            .comment-list .comment-text{
                padding: 10px 20px 10px 10px;
                margin-left: 1rem;
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
                padding: 0 15px;
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
            .w_active{
            	background: url(__STATIC__/home/img/dianzan_active.png) no-repeat center/0.5rem;
            }
            .footer .button-list li{
                width: 1.5rem;
            }
            .thread-head .user-intro{
            	width: calc(70% - 30px)
            }
            .user-info-follow{
            	width: calc(30% - 1.3rem);
            	font-size: 16px;
            	margin-top: 1px;
            	text-align: center;
            	padding-left: 10px;
            	padding-right: 10px;
            	border-radius: 2rem;
            	height: 24px;
            	visibility: hidden;
            }
            .usernofollow{
            	background: #ff0000;
		     	color: #fff;
		    }
		    .userfollow{
		     	background: rgba(0,0,0,0.1);
		    	color: #888;
		    }
		    /*相关推荐样式*/
		   /*一张图*/
		   .tui-one-img{
		   		padding-top: .3125rem;
		   		display: -webkit-box;
		   		display: -webkit-flex;
		   		display: flex;
		   }
		   .tui-title{
		   		font-size: .4375rem;
		   		-webkit-box-flex: 1;
		   		-webkit-flex: 1;
		   		flex: 1;
		   }
		   .recom-list .tui-one-images{
		   		display: box;
		   		display: -webkit-box;
		   		width: 3.125rem;
		   		height: 2.5rem;
		   		padding: 0 0.3125rem;
		   		overflow: hidden;
		   }
		   .recom-list .recom-images .img{
		   		position: relative;
		   		background: black;
		   }
		   .recom-list .recom-images .img img{
		   		position: absolute;
		   		top: 50%;
		   		transform: translateY(-50%);
		   		-webkit-transform: translateY(-50%);
    			-ms-transform: translateY(-50%);
    			-moz-transform: translateY(-50%);
    			-o-transform: translateY(-50%);
		   }
		   /*-----------------------------返回顶部----------------------------------------------*/
		    #totop {position: fixed; z-index: 99999; bottom: 1.55rem;right: 2%;cursor: pointer; display: none; background: #fff; -moz-border-radius: 50%;
		     -webkit-border-radius: 50%; border-radius: 50%;cursor: pointer;}
		    #totop a {display: block; background-size:100%; width: 40px; height: 40px;cursor: pointer;background-image: url(__STATIC__/home/image/icon_return.png); background-repeat: no-repeat;
		     background-position: center;}
		   /*视频*/
		    .video-box{
		       position: relative;
		    }
		    .videoPlay{
		       width: 50px;
		       height: 50px;
		       position: absolute;
		       left: 50%;
		       top: 50%;
		       margin-left: -25px;
		       margin-top: -25px;
		    }
		    .videoPlay img{
		       width: 100%;
		    }
		    video::-webkit-media-controls-enclosure {
		       /*禁用播放器控制栏的样式*/
		       display: none !important;
		    }
		    /*回复*/
		    .reply-box{
		   		background: #f0f0f0;
		   		padding: 10px;
		   		margin-left: 1rem;
		   		margin-bottom: 10px;
		    }
		    .reply-list{
		    	font-size: 0.4rem;
		    }
		    .reply-list span{
		    	font-size: 0.4rem;
		    }
		    .font-color{
		    	color: #616db7!important;
		    	font-size: 0.4rem;
		    }
		    .reply-all{
		    	margin-top: 5px;
		    	font-size: 0.4rem;
		    	color: #afafb1;
		    }
        </style>
    </head>
    
    <body class="page_main">
    	<!--<a style="font-size: 20px; text-align: center; width: 100%;" href="yusuzhou://">测试打开应用</a>-->
    	<!--<a style="font-size: 20px; text-align: center; width: 100%;" class="ceshi" href="">测试</a>-->
        <div class="thread-head">
            <div class="user-author user-author-click">
                <img src="<?php echo $thread['headimg']; ?>" />
            </div>
            <div class="user-intro">
                <div class="name"><?php echo $thread['name']; ?></div>
                <div class="time_view">
                    <?php echo date("m-d H:i",$thread['add_time']); ?> | <?php echo $thread['view_num']; ?>人浏览
                </div>
            </div>
            <?php if($guan == 0): ?>
              	<div class="username user-info-follow usernofollow">关注</div>
          	<?php elseif($guan == 1): ?>
              	<div class="username user-info-follow userfollow">已关注</div>
          	<?php endif; ?>
        </div>
        <div class="thread-cont">
            <div class="thread-title">
                <?php echo $thread['title']; ?>
            </div>
            <div class="thread-images">
                <?php if(is_array($thread['images']) || $thread['images'] instanceof \think\Collection || $thread['images'] instanceof \think\Paginator): $i = 0; $__LIST__ = $thread['images'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$image): $mod = ($i % 2 );++$i;?>
                <img src="<?php echo $image; ?>" class="lazy" >
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
                <li data-id="<?php echo $com['cid']; ?>" data-uid ="<?php echo $com['uid']; ?>">
                    <div class="user-head">
                        <!--<div class="user-author">
                            <img src="<?php echo $com['headimg']; ?>" />
                        </div>-->
                        <div class="user-author">
                            <img src="<?php echo $com['headimg']; ?>" />
                        </div>
                        <div class="user-intro">
                            <div class="user-name font-color"><?php echo $com['uname']; ?></div>
                            <div class="add-time"><?php echo date("Y-m-d",$com['add_time']); ?></div>
                        </div>
                    </div>
                    <div class="comment-text"><?php echo $com['content']; ?></div>
                    <?php $com['images'] = array_filter(explode(',',$com['images'])); if($com['images']): ?>
                    <div class="comment-images">
                        <?php $__FOR_START_2478__=0;$__FOR_END_2478__=3;for($i=$__FOR_START_2478__;$i < $__FOR_END_2478__;$i+=1){ ?>
                        <div class="image">
                            <?php if(isset($com['images'][$i])): ?>
                            <img src="<?php echo $com['images'][$i]; ?>" class="lazy">
                            <?php endif; ?>
                        </div>
                        <?php } ?>
                    </div>
                    <?php endif; ?>
                    <div class="comment-box">
                    	<div class="comment-intro huifu" onclick="openInput()">
                    		<div class="com">回复</div>
	                    </div>
	                    <div class="comment-intro dianzan">
	                    	<!--文章评论没有赞的状态-->
	                    	<?php if($com['stat'] == 1): ?>
	                        	<div class="zan"><?php echo $com['zan_num']; ?></div>
	                        <?php elseif($com['stat'] == 0): ?>
	                        <!--文章评论赞的状态-->
	                        	<div class="p_active"><?php echo $com['zan_num']; ?></div>
	                        <?php endif; ?>
	                    </div>
                    </div>
                    <div class="reply-box">
                    <!-- 当前用户回复根评论 -->
                    <?php if($com['mos']): if(is_array($com['mos']) || $com['mos'] instanceof \think\Collection || $com['mos'] instanceof \think\Paginator): $k = 0; $__LIST__ = $com['mos'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$asd): $mod = ($k % 2 );++$k;if($asd['reply_status'] == 0): ?>
                       
                    	<div class="reply-list"><span class="font-color"><?php echo $asd['toname']; ?></span>：<span><?php echo $asd['acontent']; ?></span></div>
                            <?php elseif($asd['reply_status'] == 1): ?>
                    <!-- 当前用户回复回复的评论 -->
                        <div class="reply-list"><span class="font-color"><?php echo $com['uname']; ?></span>回复<span class="font-color"><?php echo $asd['toname']; ?></span>：<span><?php echo $asd['acontent']; ?></span></div>
                        <div class="reply-list"><span class="font-color"><?php echo $asd['fname']; ?></span>回复<span class="font-color"><?php echo $asd['toname']; ?></span>：<span><?php echo $asd['acontent']; ?></span></div>
                        <?php endif; endforeach; endif; else: echo "" ;endif; if($com['hui_num'] > 3): ?>
                        <div class="reply-all" onclick="seeReply()">查看全部<?php echo $com['hui_num']; ?>条回复</div>
                    <?php endif; endif; ?>
                    </div>
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
                    <?php $res['conimage'] = array_filter(explode(',',$res['conimage'])); ?>
                    <!--没有图的时候-->
                    <?php if(count($res['conimage']) == 0): ?>
                    <div style="display: none;" class="tui-one-img">
                    	<div class="recom-title tui-title"><?php echo $res['title']; ?></div>
	                    <div class="recom-images tui-one-images">
	                        <?php $__FOR_START_17354__=0;$__FOR_END_17354__=1;for($i=$__FOR_START_17354__;$i < $__FOR_END_17354__;$i+=1){ ?>
	                        <div class="image img">
	                            <?php if(isset($res['conimage'][$i])): ?>
	                            <img src="<?php echo $res['conimage'][$i]; ?>" class="lazy">
	                            <?php endif; ?>
	                        </div>
	                        <?php } ?>
	                    </div>
	                    <div class="recom-num">
	                        <div class="zan"><?php echo $res['zan_num']; ?></div>
	                        <div class="com"><?php echo $res['com_num']; ?></div>
	                    </div>
                    </div>
                    <?php endif; ?>
                    <!--一张图的时候-->
                    <?php if(count($res['conimage']) == 1): ?>
                    <div class="tui-one-img">
                    	<div class="recom-title tui-title"><?php echo $res['title']; ?></div>
	                    <div class="recom-images tui-one-images">
	                        <?php $__FOR_START_11562__=0;$__FOR_END_11562__=1;for($i=$__FOR_START_11562__;$i < $__FOR_END_11562__;$i+=1){ ?>
	                        <div class="image img">
	                            <?php if(isset($res['conimage'][$i])): ?>
	                            <img src="<?php echo $res['conimage'][$i]; ?>" class="lazy">
	                            <?php endif; ?>
	                        </div>
	                        <?php } ?>
	                    </div>
                    </div>
                    <div class="recom-num">
                        <div class="zan"><?php echo $res['zan_num']; ?></div>
                        <div class="com"><?php echo $res['com_num']; ?></div>
                    </div>
                    <?php endif; if(count($res['conimage']) == 2): ?>
                    <div class="tui-two-img">
                    	<div class="recom-title tui-title"><?php echo $res['title']; ?></div>
	                    <div class="recom-images">
	                        <?php $__FOR_START_12051__=0;$__FOR_END_12051__=2;for($i=$__FOR_START_12051__;$i < $__FOR_END_12051__;$i+=1){ ?>
	                        <div class="image img">
	                            <?php if(isset($res['conimage'][$i])): ?>
	                            <img src="<?php echo $res['conimage'][$i]; ?>" class="lazy">
	                            <?php endif; ?>
	                        </div>
	                        <?php } ?>
	                    </div>
                    </div>
                    <div class="recom-num">
                        <div class="zan"><?php echo $res['zan_num']; ?></div>
                        <div class="com"><?php echo $res['com_num']; ?></div>
                    </div>
                    <?php endif; if(count($res['conimage']) > 2): ?>
                    <div class="tui-three-img">
                    	<div class="recom-title tui-title"><?php echo $res['title']; ?></div>
	                    <div class="recom-images">
	                        <?php $__FOR_START_19617__=0;$__FOR_END_19617__=3;for($i=$__FOR_START_19617__;$i < $__FOR_END_19617__;$i+=1){ ?>
	                        <div class="image img">
	                            <?php if(isset($res['conimage'][$i])): ?>
	                            <img src="<?php echo $res['conimage'][$i]; ?>" class="lazy">
	                            <?php endif; ?>
	                        </div>
	                        <?php } ?>
	                    </div>
                    </div>
                    <div class="recom-num">
                        <div class="zan"><?php echo $res['zan_num']; ?></div>
                        <div class="com"><?php echo $res['com_num']; ?></div>
                    </div>
                    <?php endif; ?>
                    <!--<div class="recom-images">
                        <?php $__FOR_START_6642__=0;$__FOR_END_6642__=3;for($i=$__FOR_START_6642__;$i < $__FOR_END_6642__;$i+=1){ ?>
                        <div class="image">
                            <?php if(isset($res['conimage'][$i])): ?>
                            <img data-original="<?php echo $res['conimage'][$i]; ?>" class="lazy">
                            <?php endif; ?>
                        </div>
                        <?php } ?>
                    </div>-->
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <div class="block-line"></div>
        <div class="footer">
            <div class="comment">回答/写评论...</div>
            <ul class="button-list">
                <li onclick="reply_all()">
                    <div class="icon com"></div>
                    <div class="text"><?php echo $thread['com_num']; ?></div>
                </li>
                <li>
                	<!--没有文章赞的状态-->
                    <?php if($zan == 0): ?>
                       <div class="btn-icon icon zan"></div>
                    <?php elseif($zan == 1): ?>
                    <!--文章被赞的状态-->
                    	<div class="btn-icon icon w_active"></div>
                    <?php endif; ?>
                    <div class="btn-icon-num text"><?php echo $thread['zan_num']; ?></div>
                </li>
            </ul>
        </div>
        <div style="height:1.5625rem;"></div>
        <script type="text/javascript" src="__STATIC__/home/js/api.js?4"></script>
        <script type="text/javascript" src="__STATIC__/home/js/jquery-2.1.3.min.js"></script>
		<script type="text/javascript" src="__STATIC__/home/js/runend.js"></script>
        <script type="text/javascript" src="__STATIC__/home/js/jquery.lazyload.js"></script>
        <script>
        	$(document).ready(function() {
	            $("img.lazy").lazyload({
					effect : "fadeIn"
				});
	        });
//          var user = decodeURIComponent($api.getCookie('userLogin'));
            var zShare = {};
			$(".ceshi").on('click',function(){
				open_or_download_app()
	   		});
			function open_or_download_app() {
			    if (navigator.userAgent.match(/(iPhone|iPod|iPad);?/i)) {
			    	alert('苹果')
			        // 判断useragent，当前设备为ios设备
			        $(".ceshi").attr('href',"yusuzhou://"); // Android端URL Schema
			        //var loadDateTime = new Date(); // 设置时间阈值，在规定时间里面没有打开对应App的话，直接去App store进行下载。
			        window.setTimeout(function() {
			            window.location = "https://itunes.apple.com/cn/app/hu-lu/id627370076?mt=8";
			        },  5000);
			    } else if (navigator.userAgent.match(/android/i)) {
		    		// 判断useragent，当前设备为android设备
		    		$(".ceshi").attr('href',"yusuzhou://")
//		        	window.location = "yusuzhou://"; // Android端URL Schema
		        	window.setTimeout(function() {
			            window.location = "http://downloadpkg.apicloud.com/app/download?path=http://7z1zfx.com1.z0.glb.clouddn.com/3aefd57658938fc0e499ac5674275028_d";
			        },  5000);
			    }
			}
			//点击视频
			$(".video-box").on('click',function(){
				var index = $(".video-box").index(this);
				if ($(".videos").eq(index).get(0).paused) {
		            $(".videos").eq(index).get(0).play();
		            $(".videoPlay").eq(index).css("display", "none");
		            $('.videos').eq(index).bind('error ended', function() {
		                $(".videoPlay").eq(index).css("display", "block");
		            });
		        } else {
		            $(".videos").eq(index).get(0).pause();
		            $(".videoPlay").eq(index).css("display", "block");
		        }
			})
			//分享
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
			// 判断是否是iphoneX
			function isIPhoneX(){
			    var u = navigator.userAgent;
			    var isIOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
			    if (isIOS) {
			        if (screen.height == 812 && screen.width == 375){
			            //是iphoneX
			            $(".footer").css('padding-bottom','15px');
			            $('#totop').css('bottom','2rem');
			        }else{
			            //不是iphoneX
			            $(".footer").css('padding-bottom','0');
			        }
			    }else{
			        $(".footer").css('padding-bottom','0');
			    }
			}
            apiready = function () {
            	isIPhoneX();
//          	$('img').addClass('lazy');
//          	alert('AndroidApp');
//          	api.appInstalled({
//				    appBundle: 'yusuzhou'
//				}, function(ret, err) {
//					alert(JSON.stringify(ret))
//				    if (ret.installed) {
//				        //应用已安装
//				        alert("应用已安装")
//				    } else {
//				        //应用未安装
//				        alert("应用未安装")
//				    }
//				});
            	//服务器的登录信息只能以这种方式得到，安卓和ios都可以。
            	//不加var的时候是全局变量
            	//ios莫名其妙多了个str-
            	user = api.getPrefs({sync: true,key: 'userLogin'});
            	var u = navigator.userAgent, app = navigator.appVersion;
			    var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //g
			    var isIOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
			    if (isAndroid) {
			        user = JSON.parse(user);
			    }
			    if (isIOS) {
			    	if(user.indexOf('str-') === 0){
			    		user = user.slice(4);
			    	}
			        user = JSON.parse(user);
			    }
			    //是否是自己的帖子
			    var lid = user.data.id;
			    var uid = <?php echo $thread['uid']; ?>;
			    if(lid == uid){
			    	$(".user-info-follow").css('visibility','hidden');
			    }else{
			    	$(".user-info-follow").css('visibility','visible');
			    }
				// 关注
	          	$(".user-info-follow").on('click',function(){
	          		if( user.code != 1 ){
		  				return $api.openLogin();
		  			}
	          		var uid = user.data.id;//当前登录用户id
	            	var tid = <?php echo $thread['uid']; ?>;//个人中心用户id
		            if($(this).hasClass('userfollow')){
		              // 取消关注
		              	$.ajax({
			              	type: 'post',
			              	dataType: 'json',
			              	url: 'http://yusuzhou.youacloud.com/index.php/forum/detail/quxiao',
			              	data: {
			              		uid: uid,
			              		tid: tid,
			              		status: 1
			              	},
			              	success: function(data){
			                  	$(".user-info-follow").text('关注');
			                  	$(".user-info-follow").removeClass('userfollow').addClass('usernofollow');
			                  	api.sendEvent({
						        	name: 'updata'
						        })
			      			},
			      			error: function(){
			      				alert('错误')
			      			}
		               	})
		            }else{
		              // 关注
		                $.ajax({
			              	type: 'post',
			              	dataType: 'json',
			              	url: 'http://yusuzhou.youacloud.com/index.php/forum/detail/guan',
			              	data: {
			                  uid: uid,
			              		tid: tid,
			              		status: 0
			              	},
			              	success: function(data){
			                  $(".user-info-follow").text('已关注');
			                  $(".user-info-follow").removeClass('usernofollow').addClass('userfollow');
			                  api.sendEvent({
						        	name: 'updata'
						      })
			      			},
			      			error: function(){
			      				alert('错误')
			      			}
		                })
		            }
	          	})
				//分享
				var test = window.location.href;
                $('.thread-share li').on('click',function (){
                	var index = $(this).index();
                	if(index == 0){
                		zShare.wxNews('session','<?php echo $thread['name']; ?>','<?php echo $thread['title']; ?>',''+test,'<?php echo $thread['headimg']; ?>');
                	}else if(index == 1){
                		zShare.wxNews('timeline','<?php echo $thread['name']; ?>','<?php echo $thread['title']; ?>',''+test,'<?php echo $thread['headimg']; ?>');
                	}else if(index == 2){
                		zShare.qqNews('QFriend','<?php echo $thread['name']; ?>','<?php echo $thread['title']; ?>',''+test,'<?php echo $thread['headimg']; ?>');
                	}else{
                		zShare.weiboNews('sinaWb','<?php echo $thread['name']; ?>','<?php echo $thread['title']; ?>',''+test,'<?php echo $thread['headimg']; ?>');
                	}
//                  var type = $(this).attr('data-type');
//                  var host = window.location.protocol + '//' + window.location.hostname;
//                  var logo = host+'/public/static/home/image/logo.png';
//                  var img = $('.thread-images img').eq(0).attr('src');
//                  inShare.shareImgsTo({
//                      imgPaths: img ? host + img : logo ,
//                      sendPattern:'ONLY',
//                      description:'<?php echo $thread['title']; ?>',
//                      app: type,               
//                  },function(ret,err){
//                      if(ret.status){
//                          alert(JSON.stringify(ret));
//                      }else{
//                          alert(ret.errorMessage);
//                      }
//                  });
//                  inShare.shareImgsTo({
//					    imgPaths: img ? host + img : logo,
//					    sendPattern:'ONLY',
//					    description:'<?php echo $thread['title']; ?>',
//					    app: type,               
//					},function(ret,err){
//					    if(ret.status){
//					        alert(JSON.stringify(ret));
//					    }else{
//					        alert(ret.errorMessage);
//					    }
//					});
                })
				//点击文章头像，进入个人中心
                $('.user-author-click').on('click',function (){
                    $api.openUcenter(<?php echo $thread['uid']; ?>);
                });
                //点击文章图片，进入全屏浏览模式
                $('.thread-images').on('click','img',function (){
                    var img = [];
                    $.each($('.thread-images img'),function (i,e){
                        img.push($(e).attr('src'));
                    });
                    var activeIndex = $(this).index();
                    var photoBrowser = api.require('photoBrowser');
                    photoBrowser.open({
                        images: img,
                        activeIndex,
                        placeholderImg: 'widget://res/img/apicloud.png',
                        bgColor: '#000'
                    },function(ret,err){
                    	//单击，关闭全屏浏览
						if(ret.eventType == 'click'){
							photoBrowser.close();
						}
                    });
                })
                //点击评论图片，进入全屏浏览模式
                $('.comment-images').on('click','.image',function (){
                    var img = [];
                    $.each($('.comment-images img'),function (i,e){
                        img.push($(e).attr('src'));
                    });
                    var activeIndex = $(this).index();
                    var photoBrowser = api.require('photoBrowser');
                    photoBrowser.open({
                        images: img,
                        activeIndex,
                        placeholderImg: 'widget://res/img/apicloud.png',
                        bgColor: '#000'
                    },function(ret,err){
                    	//单击，关闭全屏浏览
						if(ret.eventType == 'click'){
							photoBrowser.close();
						}
                    });
                });
                //文章相关推荐，点击进入文章详情
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
                //打开文章评论页面
                $('.footer .comment').on('click',function (){
                	if( user.code != 1 ){
		  				return $api.openLogin();
		  			}else{
		  				api.openWin({
    					    name: 'thread_comment',
    					    url: 'widget://html/thread/thread_comment.html',
    					    pageParam: {
    					        id: <?php echo $thread['id']; ?>
    					    }
    					});
		  			}
//                  if( user.id ){
//                      api.openWin({
//  					    name: 'thread_comment',
//  					    url: 'widget://html/thread/thread_comment.html',
//  					    pageParam: {
//  					        id: <?php echo $thread['id']; ?>
//  					    }
//  					});
//                  }else{
//                    	$api.openLogin()
//                  }
                });
                //文章评论的赞
                $('.comment-list').on('click','.dianzan div',function (){
                	if( user.code != 1 ){
		  				return $api.openLogin();
		  			}
                	var index = $(this).parents('li').index();
//              	alert(index);
					var pinid = $(this).parents('li').attr('data-id');
					var pingid = $(this).parents('li').attr('data-uid');
//					alert(pinid);
//					alert(pingid);
                    if( $(this).hasClass('zan') ){
                    	self = this;
////                      setInc($(this),'comment',$(this).parents('li').attr('data-id'));
//						// 点赞
			          	$.ajax({
				          	type: 'post',
				          	dataType: 'json',
				          	url: 'http://yusuzhou.youacloud.com/index.php/forum/detail/dianping',
				          	data: {
				          		userid: user.data.id,
				          		pinid: pinid,
				              	threadid: <?php echo $thread['id']; ?>,
				              	pingid:pingid,
				          		status: 0
				          	},
				          	success: function(data){
//				          		alert(JSON.stringify(data))
				              	$(self).text(data.data.zan_num);
				          		$(self).removeClass('zan').addClass('p_active');
				          		api.sendEvent({
						        	name: 'updata'
						      	})
				  			},
				            error:function(){
				              alert('错误')
				            }
			         	})
                    }else{
                    	$.ajax({
				          	type: 'post',
				          	dataType: 'json',
				          	url: 'http://yusuzhou.youacloud.com/index.php/forum/detail/qudian',
				          	data: {
				             	userid: user.data.id,
				          		pinid: pinid,
				              	threadid: <?php echo $thread['id']; ?>,
				              	pingid:pingid,
				          		status: 1
				          	},
				          	success: function(data){
//				              	alert(JSON.stringify(data));
				              	$(self).text(data.data.zan_num);
				          		$(self).removeClass('p_active').addClass('zan');
				          		api.sendEvent({
					        		name: 'updata'
					      		})
				  			},
				  			error:function(){
				              alert('错误')
				            }
				        })	
                    }
                });
//              $('.recom-list').on('click','.recom-num div',function (){
//                  if( $(this).hasClass('zan') ){
//                      setInc($(this),'thread',$(this).parents('li').attr('data-id'));
//                  }else if( $(this).hasClass('com') ){
//                      if( user.id ){
//          	            api.openWin({
//      					    name: 'thread_comment',
//      					    url: 'widget://html/thread/thread_comment.html',
//      					    pageParam: {
//      					        id: $(this).parents('li').attr('data-id')
//      					    }
//  					    });
//                      }else{
//                        	$api.openLogin()
//                      }
//                  }
//                  event.stopPropagation();
//              });
				//文章的赞
                $('.button-list li').eq(1).on('click',function (){
                	if( user.code != 1 ){
		  				return $api.openLogin();
		  			}
					if($('.button-list li .btn-icon').hasClass('zan')){
						//赞
						$.ajax({
				        	type: 'post',
				        	dataType: 'json',
				        	url: 'http://yusuzhou.youacloud.com/index.php/forum/detail/dianzan',
				        	data: {
				        		userid: user.data.id,
				        		threadid: <?php echo $thread['id']; ?>,
				        		status: 0
				        	},
				        	success: function(data){
//				        		alert(JSON.stringify(data));
				        		$('.button-list li .btn-icon-num').html(data.data.zan_num);
				        		$('.button-list li .btn-icon').removeClass('zan').addClass('w_active');
				        		api.sendEvent({
					        		name: 'updata'
					      		})
							},
							error: function(){
								alert('错误')
							}
				        })
//						$('.button-list li .btn-icon').removeClass('zan').addClass('w_active');
					}else{
						$.ajax({
				        	type: 'post',
				        	dataType: 'json',
				        	url: 'http://yusuzhou.youacloud.com/index.php/forum/detail/quzan',
				        	data: {
				        		userid: user.data.id,
				        		threadid: <?php echo $thread['id']; ?>,
				        		status: 1
				        	},
				        	success: function(data){
//				        		alert(JSON.stringify(data));
				        		$('.button-list li .btn-icon-num').html(data.data.zan_num);
				        		$('.button-list li .btn-icon').removeClass('w_active').addClass('zan');
				        		api.sendEvent({
					        		name: 'updata'
					      		})
							},
				        	error: function(){
								alert('错误')
							}
				       	})
						//取消赞
//						$('.button-list li .btn-icon').removeClass('w_active').addClass('zan');
					}
                });
                //监听到发布评论事件
                api.addEventListener({
                	name: 'text_comment'
                },function(ret,err){
                	if(ret){
                		window.location.reload();
                		api.toast({
                		    msg: '评论成功！',
                		    location: 'bottom',
                		    duration: 2000,
                		});
                	}
                });
            }
            //评论回复
            function openInput(){
		      	var UIChatBox = api.require('UIChatBox');
				UIChatBox.open({
				    placeholder: '',
			        maxRows: 4,
			        emotionPath: 'widget://res/emotion',
			        autoFocus: true,
			        isClose: true,
			        texts: {
			            recordBtn : {
			  						normalTitle : '按住  说话',
			  						activeTitle : '松开  结束'
			  					},
			            sendBtn: {
			                title: '发送'
			            }
			        },
			        styles: {
			            inputBar: {
			                borderColor: '#d9d9d9',
			                bgColor: '#f2f2f2'
			            },
			            inputBox: {
			                borderColor: '#B3B3B3',
			                bgColor: '#FFFFFF'
			            },
			            emotionBtn: {
			                normalImg: 'widget://res/img/chatBox_face1.png'
			            },
//			            extrasBtn: {
//			            	normalImg: 'widget://res/emotion/add.png'
//			            },
//			            speechBtn : {
//	  						normalImg : 'widget://res/emotion/rec.png'
//	  					},
			            indicator: {
			                target: 'both',
			                color: '#c4c4c4',
			                activeColor: '#9e9e9e'
			            },
			            sendBtn: {
			                titleColor: '#fff',
			                bg: '#12ad13',
			                activeBg: '#46a91e',
			                titleSize: 14
			            },
			            recordBtn: {
			                normalBg: '#F5F5F5',
			                activeBg: '#E2E2E2',
			                color: '#797979',
			                size: 14
			            },
			        },
//			        extras: {
//			            titleSize: 10,
//			            titleColor: '#a3a3a3',
//			            btns: [{
//			                title: '图片',
//			                normalImg: 'widget://res/emotion/1.png',
//			                activeImg: 'widget://res/emotion/1.png'
//			            }, {
//			                title: '拍照',
//			                normalImg: 'widget://res/emotion/2.png',
//			                activeImg: 'widget://res/emotion/2.png'
//			            },{
//			                title: '视频',
//			                normalImg: 'widget://res/emotion/3.png',
//			                activeImg: 'widget://res/emotion/3.png'
//			            },{
//			                title: '收藏',
//			                normalImg: 'widget://res/emotion/4.png',
//			                activeImg: 'widget://res/emotion/4.png'
//			            },{
//			                title: '贴子',
//			                normalImg: 'widget://res/emotion/5.png',
//			                activeImg: 'widget://res/emotion/5.png'
//			            },{
//			                title: '商品',
//			                normalImg: 'widget://res/emotion/6.png',
//			                activeImg: 'widget://res/emotion/6.png'
//			            }]
//			        }
				}, function(ret, err) {
				    if (ret) {
						if(ret.eventType == "send"){
		 					var replyContent = ret.msg;//回复内容
		 					console.log(user.data.id);
		 				    UIChatBox.closeKeyboard();
		 				    UIChatBox.close();
		 				    console.log(replyContent);
			 		    }
				    } else {
				        alert(JSON.stringify(err));
				    }
				});
		    }
            //查看评论
            function reply_all(){
            	$api.openPage({
                    title: '查看评论',
                    name: 'replay',
                    url: 'widget://html/reply_all.html'
                })
            }
            function seeReply(){
			    $api.openPage({
			        title: '查看回复',
			        name: 'replay',
			        url: 'widget://html/reply_content.html'
			    })
		    }
//          function setInc(el,table,id){
//              if( !user.id ){
//                  return $api.openLogin();
//              }
//              $.ajax({
//                  type: 'post',
//                  url: site_url + '/index.php/forum/detail/setNumerInc.html',
//                  data: {
//                      id,
//                      table
//                  },
//                  dataType: 'json',
//                  success: function ( data ){
//                      if( data.data ){
//                          var num = parseInt(el.html());
//                          num++;
//                          el.html(num);
//                      }
//                  }
//              });
//          }
        </script>
    </body>
</html>
