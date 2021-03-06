<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:62:"D:\phpStudy\WWW\yusuzhou/application/live\view\index\live.html";i:1524102223;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html;charset=UTF-8" http-equiv="Content-Type"/>
        <!-- Mobile Devices Support @begin -->
        <meta content="no-cache,must-revalidate" http-equiv="Cache-Control"/>
        <meta content="no-cache" http-equiv="pragma"/>
        <meta content="0" http-equiv="expires"/>
        <meta content="telephone=no, address=no" name="format-detection"/>
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
        <!-- Mobile Devices Support @end -->
        <title><?php echo $live['title']; ?></title>
        <link rel="stylesheet" href="__STATIC__/live/css/sm.css">
        <link rel="stylesheet" href="__STATIC__/live/css/style.css" />
        <script type="text/javascript" src="__STATIC__/live/js/zepto.min.js"></script>
        <script type="text/javascript" src="__STATIC__/live/js/swipeSlide.min.js"></script>
        <script type="text/javascript" src="__STATIC__/live/js/fastclick.min.js"></script>
        <script type="text/javascript" src="__STATIC__/live/js/sq-2.3.js"></script>
        <style>
        	.topbox{
        	//	position: fixed;
        		top: 0;
        		left: 0;
        		z-index: 111;
        	}
        	.inputStyle{
        		-webkit-appearance: none;
			    appearance: none;
			    border: none;
			    resize: none;
			    outline: none;
			    background: none;	
        	}
        	    
        	[class*=floatBox]{position:fixed; left: 0; top: 0; right: 0; bottom: 0;}
        	.mid{ position: absolute; left: 50%; top: 50%; -webkit-transform: translate(-50%,-50%);transform: translate(-50%,-50%);}
			.popupPay{ background: rgba(0,0,0,0.8); z-index: 9999;}
			.popupPay .box{ background: #fff; padding: 20px; text-align: center; width:280px; border-radius: 5px;}
			.popupPay .close{ background: none; position: absolute; top: 0; right: 0; -webkit-transform: scale(0.8);transform: scale(0.8);}
			.popupPay .info span{ padding: 15px 0; display: block; line-height: 100%; font-size: 36px;}
			.popupPay ul.select{ border-top: 1px solid #eee;}
			.popupPay li{ height: 54px; padding: 15px 10px; border-bottom: 1px solid #eee;}
			.popupPay li.active{ background: #fafafa;}
			.popupPay li span{ padding-left: 36px; display: block;}
			.popupPay li input[type=radio]{ -webkit-appearance: none; -moz-appearance: none;appearance: none; border: 1px solid #ccc; border-radius:50%; width:24px; height:24px; position: relative; float: left; -webkit-transition: all ease 0.25s; background: #fff;}
			.popupPay li input[type=radio]:checked{ border: none; background: #3ea71e;}
			.popupPay li input[type=radio]:after{ content:""; display: block; border:2px solid; border-color: transparent transparent #fff #fff; width:8px; height:4px; position: absolute; left: 50%; top: 50%; -webkit-transform: translate(-75%,-60%) rotate(-45deg);transform: translate(-75%,-60%) rotate(-45deg); -webkit-transform-origin: center top;transform-origin: center top; border-radius: 2px;}
			.popupPay button{ background: #09BB07; color: #fff; border-radius: 3px; line-height:46px; margin-top: 20px; width: 100%;}
			.popupPay .recharge input{ background: rgba(0,0,0,0.05); height: 60px; padding: 0 20px; font-size:36px; line-height:60px; color: #09BB07; text-align: center; width: 100%;}
			.popupPay .recharge input:focus{ background:rgba(9,187,7,0.1);}
			.popupPay .recharge{ position: relative;}
				
						
			.close{ width: 46px; height: 46px; -webkit-transform: scale(0.6);transform: scale(0.6); position: relative; background: #eee; border-radius: 50%;}
			.close:after,.close:before{ content: ""; display: block; width: 2px; height:26px; background: #aaa; border-radius: 3px; position: absolute; left: 50%; top: 50%; -webkit-transform-origin: center center;transform-origin: center center;-webkit-transform:translate(-50%,-50%) rotate(-45deg);transform:translate(-50%,-50%) rotate(-45deg);}
			.close:before{-webkit-transform:translate(-50%,-50%) rotate(45deg);translate(-50%,-50%) rotate(45deg);}
			.f18{
				    -webkit-appearance: none;
				    appearance: none;
				    border: none;
				    resize: none;
				    outline: none;
			}
			
			.dashang{
				width:50px;
				height: 50px;
				background-image: url(__STATIC__/live/images/shang.png);
				background-position: center;
				background-repeat: no-repeat;
				background-size: 50px;
				position: fixed;
				bottom: 5rem;
				right: 0.625rem;
				z-index: 8888;
			
			}
			.bar-footer{
			    z-index: 9999;
			}
		    .dropload-noData{
		        text-align: center;
		        padding:80px 0;
		    }
		    .content .content-block{
		        position: relative;
		    }
		    /*.video_text{*/
		    /*    position: fixed;*/
		    /*    top: 0;*/
		    /*    z-index: 99999;*/
		    /*}*/
        </style>
    </head>
    <body>
       
        <div id="video_container" class="parent_container">
            <div class="mask"></div>
            <div class="video_reply_container">
                <div class="vrc_title justify_fix">
                    <p onclick="closeNMB(this)">取消</p>
                    <p>回复</p>
                    <p onclick="sendrl(this)">发送</p>
                </div>
                <div class="reply_container">
                    <div class="reply_hoster">回复&nbsp;<span id="theReplier"></span>:</div>
                </div>
                <div class="reply_contents">
                    <textarea name="" id="" cols="30" rows="10"></textarea>
                </div>
                <?php if($live['niming'] == 1): ?> 
                <div class="plr10" style="padding-bottom:.1rem;" id="is_anonymous">
                    <div class="select-js grey-circle choose_anonymous" id="user_1">
                        <p class="text">匿名</p>
                        <input type="hidden" name="reply_ways" class="reply_ways" value="0">
                    </div>
                </div>
                <?php endif; ?>
                <input type="hidden" name="parent_id" value=""/>
                <input type="hidden" name="parent_uid" value=""/>
                <input type="hidden" name="parent_username" value=""/>
            </div>
        </div>

        <div class="page-group">
            <div class="page page-current">
                <!--内容-->
                <div class="content index-live" id="cnmb">
                  
                    <header class="video_text">
                        <div class="video-live" style="z-index:0;">
                        
                          <?php if($live['video']): ?>
                            <?php echo $live['video']; else: ?>
                            
                            <img src="<?php echo $live['img']; ?>"  />
                           <?php endif; ?>
                        </div>      
                    </header>
                  
                    <!--<div class="slide" id="slide2">
                        <ul>
                            <li class="">
                                <div class="live-detail-box right_con" style="width: 100%;z-index: 999999;">
                                    <a href="#" class="live-detail"><span>{lang qidou_video_live:details}</span></a>
                                    <a class="live-num"><span>{lang qidou_video_live:cany}<b style="font-weight:normal;" id="partake"><?php echo $live['partake']; ?></b></span></a>
                                    <p class="x-line"></p>
                                </div>
                            </li>
                           
                            <li onclick="javascript:window.location.href = ''"  >
                                <div class="" style="width: 100%;">
                                    <img src=" />
                                </div>
                            </li>
                           
                        </ul>
                    </div>-->

                    <script>
                                $(function () {
                                $('#slide2').swipeSlide({
                                autoSwipe: true,
                                        continuousScroll: true,
                                        lazyLoad: true,
                                        speed: 5000
                                });
                                });</script>

                    <!--可能轮播\广告位-->
                    <!--                    <div class="ban-img">
                                             <img src="/public/wap/images/img-test.png" />
                                         </div>-->
                    <div class="buttons-tab">
                       
                        <a href="javascript:void(0)" class="tab-link button active">评论席</a></a>
                        <a href="javascript:void(0)" class="tab-link button ">简介</a>
                    </div>
                    <div class="content-block" id="content-block">
                        <div class="tabs">
                            <!--直播厅-->
                         
                            <!--pinglun-->
                            <div id="tab1" class="tab active">
                                <!--新消息-->
                                <div class="new-info" id="newinfo">
                                    <p class="new-info-text">顶部有新消息</p>
                                </div>
                                <div class="content-block" id="replies_list">
                                    <ul>
                                        <input type="hidden" name="page" value="1">
                                      
                                        <?php if(is_array($comments) || $comments instanceof \think\Collection || $comments instanceof \think\Paginator): $i = 0; $__LIST__ = $comments;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>   
                                        <li class="li-b" data-time="<?php echo $v['addtime']; ?>" id="replyid<?php echo $v['id']; ?>">
                                            <div class="main">
                                                <div class="clearfix leave_bg">
                                                    <?php if($v['reply_ways'] == 1): ?>
                                                     <img src="__STATIC__/live/images/anonymous_head.png" alt="" class="user_img"/>
                                                    <?php else: ?>
                                                     <img src="<?php echo $v['headimg']; ?>" alt="" class="user_img"/>
                                                    <?php endif; ?>
                                                    <div class="right_con">
                                                        <div class="line clearfix">
                                                            <p class="name flooer_name"><?php echo $v['username']; ?></p>
                                                            <p class="time"><?php echo $v['addtime1']; ?></p>
                                                        </div>
                                                        <div class="detail"><?php echo $v['contents']; ?></div>
                                                       <?php echo $v['contents_t']; ?>
                                                        <div class="tools clearfix">
                                                            <div class="fr clearfix">
                                                                <span class="zan tnzan <?php echo $v['my_zan']; ?>" onclick="ilikeid(this, 'reply')" likeid="<?php echo $v['id']; ?>"><?php echo $v['zan']; ?></span>
                                                                <span class="comment" onclick="addReply(this,'<?php echo $v['id']; ?>')" parent_id="<?php echo $v['id']; ?>" parent_uid="<?php echo $v['uid']; ?>" parent_username="<?php echo $v['username']; ?>">回复</span>
                                                             
                                                            </div>
                                                          
                                                            <!--<div class="manager_btn fl" onclick="manager_this_post(this)" tid="<?php echo $v['id']; ?>" sign='reply' place ="" >                                                                -->
                                                            <!--</div>-->
                                                            
                                                        </div>
                                                         <div class="comment_list">
                                                             <?php if($v['coms']): if(is_array($v['coms']) || $v['coms'] instanceof \think\Collection || $v['coms'] instanceof \think\Paginator): $kk = 0; $__LIST__ = $v['coms'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($kk % 2 );++$kk;?>
                                                            <div class="clearfix li" onclick="addReply(this, '<?php echo $vv["id"]; ?>')" parent_uid="<?php echo $vv['uid']; ?>" parent_id="<?php echo $vv['id']; ?>" parent_username="<?php echo $vv['username']; ?>">
                                                                <span class="name"><?php echo $vv['username']; ?></span>
                                                                <?php if($vv['pid'] && $vv['username'] != $vv['parent_name']): ?>
                                                                <span class="content-say">回复</span>
                                                                <span class="name"><?php echo $vv['parent_name']; ?></span>
                                                                <?php endif; ?>
                                                                <span class="content-say">:<?php echo $vv['contents']; ?></span>
                                                            </div>
                                                             <?php endforeach; endif; else: echo "" ;endif; endif; if($v['coms_num']): ?>
                                                                <a href="plugin.php?id=qidou_video_live&act=commentall&lid=<?php echo $live['id']; ?>&rid=<?php echo $v['id']; ?>" data-no-cache="true" class="comment-btnmore external">{lang qidou_video_live:chakqy}<span class="rest_size"><?php echo $v['coms_num']; ?></span>条回复</a>
                                                             <?php endif; ?>
                                                            <!--展开btn-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                      
                                    </ul>
                                </div>
                            </div>
                         
                            <div id="tab2" class="tab">
                        
                         
                                <div class="content-block">
                                    <!--jianjie-->
                                    <div style="padding: 20px;">
                                    	<?php echo $live['details']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!--编辑-->
                <div class="popup popup-about popup-about-3">
                    <div class="content-block">
                        <div class="dialog-relay-box" id="bj_container" style="">
                            <div class="dialog-relay">
                                <div class="relay-topbar">
                                    <p class="relay-close">&nbsp;&nbsp;&nbsp;取消</p>
                                    <p style="float:right;" onclick="sendBj(this)">确认提交&nbsp;&nbsp;&nbsp;</p>
                                </div>
                                <textarea name="bj_content" id="bj_content"></textarea>
                                <div class="input_container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="bar bar-standard bar-footer main-bottom">
                <p class="bottom-head">
                    <img src="__STATIC__/live/images/no_login.png" alt="" id="user" />
                </p>
                <!--我也要说-->
         		<!--<input id="comtext" style=" width: 58%;" type="text" class="pub-say" placeholder="我也想要说..." />-->
                <a href="javascript:void(0)" class="pub-say" id="commonAddReply" onclick="addComment(this,0)">我也想要说...</a>
    <!--           <div class="btn-fabu" style="  position: absolute;-->
				<!--right: 50px;-->
				<!--top: 0;-->
				<!--width: 50px;-->
				<!--height: 1.8rem;-->
				<!--line-height: 1.8rem;-->
				<!--margin: 0.3rem 0 0 0;-->
				<!--color: #fff;-->
				<!--background: #15bfff;-->
				<!--border-radius: 5px;-->
				<!--text-align: center;">-->
				<!--				发送-->
				<!--			</div>-->
             
                <div class="btn-love" onclick="manyclicks(this)">
                    <p class="no-touch zan-click"></p>
                    <p style="width:100%;text-align: center;margin-top:10px;color: #f97474;position: absolute;top:0;" id="xzan"><?php echo $live['zan']; ?></p>
                </div>
              

            </div>

            
            <div class="other-events-box">
                <div class="other-events">
                    <ul id="manage_action">
                        <li onclick="editor_msg(this)" id="editor_msg">编辑</li>
                        <li class="elite" isElite="1" onclick="elite_action(this)">{lang qidou_video_live:jingh}</li>
                        <li onclick="hide_this_post(this)" class="hideOrDelete">{lang qidou_video_live:yinc}</li>
                        <li onclick="cancel_manage_container()">取消</li>
                    </ul>
                </div>
            </div>
            <!--打赏-->
            <?php if($live['is_tip']): ?>
 			<div class="dashang">
            	
            </div>
            <?php endif; ?>
      
            <!--滑动到底部功能-->
            <div id="gotop" class="gotop">
                <a href="javascript:void(0);" class="w_top"></a>
            </div>
        </div>
		 <div id="send_pl_container" class="parent_container dialog-relay-box" style="z-index:999999999;  " >
            <div class="mask"></div>
            <div class="video_reply_container" style="    margin: 20% auto 0 auto;">
                <div class="vrc_title justify_fix">
                    <p onclick="closeNMB(this)">取消</p>
                    <p>我也想要说</p>
                    <p onclick="sendpl(this)">发送</p>
                </div>
                <div class="reply_contents">
                    <textarea name="" id="" cols="30" rows="10"></textarea>
                </div>
                <!--<?php if($live['niming'] == 1): ?>-->
                <div class="plr10" style="padding-bottom:.1rem;" id="is_anonymous">
                    <div class="select-js grey-circle choose_anonymous" id="user_1">
                        <p class="text">匿名</p>
                        <input type="hidden" name="reply_ways" class="reply_ways" value="0">
                    </div>
                </div>
                <!--<?php endif; ?>-->
                <input type="hidden" name="topic_id" value="0"/>
            </div>
        </div>
        <script src="__STATIC__/live/js/dropload.js"></script>
        <!--<script type="text/javascript" src="--><!--/public/wap/js/sm.min.js"></script>-->
        <script type="text/javascript" src="__STATIC__/live/js/deepshare_v2.4.min.js"></script>
      	<script type="text/javascript" src="__STATIC__/home/js/api.js?113"></script>
        <script type="text/javascript">
       
        apiready = function() { 
            $("#user").click(function(){
               // alert($api.getCookie('userLogin'));
                $api.openLogin();
            });
            
        }
         var user = decodeURIComponent($api.getCookie('userLogin'));
         user = user ? JSON.parse(user) : {};
   
        if(user){
           if(user.data){
                $("#user").attr("src",user.data.headimg);
                var uid = user.data.id;
            } 
        }
        // var user = {
        //     data: {
        //         id: 1,
        //         sex: 1,
        //         name: "Lieber",
        //         openid: "ouMsu0TvmZUJxF0DpLfKR3U8kDKQ",
        //         headimg: "http://wx.qlogo.cn/mmopen/vi_32/4oEZ9R2iapvOFwcTgvIYCGr0TjrzIB6Xb1Nv7SIQnr9b6jP7XhW6TbmOv6vUc9WibMCTnWhzUaRicgV3H6CtzSpWA/0",
        //         mobile: null,
        //         guanzhu: 1,
        //         fensi: 2,
        //         zan: 3,
        //         shoucang: 4,
        //         token: "34e971028c2985ec1edc009b57d1b373",
        //         add_time: 1511754993
        //     },
        //     info: "获取成功",
        //     code: 1
        // };
        
        
        $(function(){								
			    var wd = $(window),
		        img = $('.ljzimg'),
		        imgTop,          //图片距离顶部高度
		        scTop,             //滚动条高度
		        wH;           //窗口高度
			    wH = wd.height();    //获得可视浏览器的高度
		  	    img.each(function(){
		  	    scTop = wd.scrollTop(); 
	            imgTop =  $(this).offset().top;	
	           
		            if(imgTop - wH < scTop &&     //图片必须出现在窗口底部上面
		                //imgTop - wH > 0 &&        //排除首页图片
		                  $(this).attr('src') != $(this).attr('_src')){  
		                	 //排除已经加载过的图片
		                   $(this).attr('src', $(this).attr('_src'));
		              }
	            });
			    wd.scroll( function() {
			        scTop = wd.scrollTop();  //获取滚动条到顶部的垂直高度			     
			        img.each(function(){
			            imgTop =  $(this).offset().top;
			         
			            if(imgTop - wH < scTop &&     //图片必须出现在窗口底部上面
			                imgTop - wH > 0 &&        //排除首页图片
			                $(this).attr('src') != $(this).attr('_src')){  
			                	 //排除已经加载过的图片
			                   $(this).attr('src', $(this).attr('_src'));
			            }
			        });
			    });
			$(document).on('click','.open_page',function(){
			  open_page_url( $(this).attr('href') );
			  return false;
			});
		})	
        var th = $(".topbox").height();
        
        $(".page-group").css({'margin-top':th+'px'});
        
        
        $(".close").click(function(){
        	$(this).parents('div').parents('div').hide();
        	//document.location.href = 'plugin.php?id=qidou_video_live';
        	//history.go(-1);
        });
        $(".dashang").click(function(){
        	$(".reward_wrap").show();
        });
        
        function gokey(){
        	var key = $("#keyspan").val();
        	 $.ajax({
	            url: 'plugin.php?id=qidou_video_live:live_ajax',
	            type: 'post',
	            data: {'ajax':'code',lid:'<?php echo $live["id"]; ?>','code':key,formhash: '{FORMHASH}'},
	            dataType: 'json',
	            success: function (res) {
	          		if(res.status == 1){
	          			alert(res.msg);
	          			$(".video-live").html(res.video);
	          			$(".code").hide();
	          		}else{
	          			alert(res.msg);
	          		}
	            }
            });
        }
        function gopay(){
        	 uid = "<?php echo $uid; ?>";
        	 if(!uid){
        	 	document.location.href = "登录地址";
        	 	return false;
        	 }
        	 $.ajax({
	            url: 'plugin.php?id=qidou_video_live:live_ajax',
	            type: 'post',
	            data: {'ajax':'pay',lid:'<?php echo $live["id"]; ?>',formhash: '{FORMHASH}'},
	            dataType: 'json',
	            success: function (res) {
	          		if(res.status == 1){
	          			alert(res.msg);
	          			$(".video-live").html(res.video);
	          			$(".pay").hide();
	          		}else{
	          			alert(res.msg);
	          		}
	            }
            });
        }
        
               
         //脱离sm.js
        var tab = $('#content-block .tabs .tab');
        $('.buttons-tab .button').each(function(){
            var this1 = $(this);
            var index = this1.index();
            this1.on('click',function(){
                this1.addClass('active').siblings('.button').removeClass('active');
                tab.eq(index).addClass('active').siblings('.tab').removeClass('active');
            });
        });

        //直播详情弹出框

        $(document).on('click','.live-detail', function () {
            var strs = '<p><?php echo $live["details"]; ?></p>';
            modal = {
            build:function(){
                var html = '<div id="modal_container" class="modal">' +
                    '<div class="modal-inner">' +
                    '<div class="modal-title"><p class="item-title"></p><p></p></div>' +
                    '<div class="modal-text">' +
                    '</div>' +
                    '</div>' +
                    '<div class="modal-buttons"><span class="modal-button"></span></div>' +
                    '</div>'+
                    '<div class="modal-overlay" id="modal-overlay-visible"></div>';
                $('body').append(html);
            },
            show:function(title,content){
                var modal_overlay_visible = $('#modal-overlay-visible');
                var modal_container = $('#modal_container');
                modal_overlay_visible.addClass('modal-overlay-visible');
                modal_container.show(800);
                setTimeout(function(){
                    modal_container.addClass('modal-in');
                },50);
                var item_title = modal_container.find('.item-title');
                item_title.html(title);
                var modal_text = modal_container.find('.modal-text');
                modal_text.html(content);
                var modal_buttons = modal_container.find('.modal-buttons');
                modal_buttons.on('click',function(){
                    modal.close();
                });
            },
            close:function(modal_mask,dialog_container){
                var modal_container = $('#modal_container');
                var modal_overlay_visible = $('#modal-overlay-visible');
                modal_container.removeClass('modal-in');
                modal_container.hide(800);
                modal_overlay_visible.removeClass('modal-overlay-visible');
            }
        };
            
            modal.build();
            modal.show('{lang qidou_video_live:details}',strs);
        });
      </script>
    <script>
        var theInterval;
        var theInterval1;
        var lastsTime = 5000;
        $(function () {
        /**
         * 返回顶部处理
         */
        var _objscroll = {
                win: $("#cnmb"),
                newinfo: $('#newinfo')
        };

            _objscroll.win.scroll(function () {
           
            //新消息出现条件
            var height = $('#slide2').height() + $('header').height() + $('.buttons-tab').height();
                    var share_top = $('#share_top');
                    if (_objscroll.win.scrollTop() > height) {
            if (share_top.size() == 1 && share_top.css('display') == 'block') {
            _objscroll.newinfo.css({
            'position': 'fixed',
                    'top': '2.84rem'
            });
            } else {
            _objscroll.newinfo.css({
            'position': 'fixed',
                    'top': '4px'
            });
            }
            } else {
            _objscroll.newinfo.css({
            'position': 'absolute',
                    'top': '4px'
            });
            }

            });
       
            //新消息返回顶部
            _objscroll.newinfo.click(function () {
                    getNewReplies();
                    _objscroll.win.scrollTop(0);
                    $(this).hide();
                    return false;
            });
    });
    $(document).on('click', '.relay-close', function () {
    $.closeModal('.popup.modal-in');
    });
    $('.choose_anonymous').on('click', function () {
    //  var $this = $(this);
    if ($(this).hasClass('bule-circle')) {
    $(this).removeClass('bule-circle');
    $(this).find('input[name=reply_ways]').val('0');
    } else {
    $(this).addClass('bule-circle');
    $(this).find('input[name=reply_ways]').val('1');
    }
    });
    function getTopics() {
    var page1 = $('input[name=page]');
            var page = parseInt(page1.val()) + 1;
            $.ajax({
            url: window.location.href,
                    type: 'post',
                    data: {page: page},
                    dataType: 'html',
                    success: function (html) {
                    if (html == '') {
                    //                    $this.fadeOut(100);
                    } else {
                    //                    $this.before(html);
                    page1.val(page);
                    }
                    }
            });
    }
    //回复
    var video_container = $('#video_container');
    function addReply(obj, reply_container_id) {
             var html = '';
                     var this1 = $(obj);
                     var parent_id = this1.attr('parent_id');
                     var parent_uid = this1.attr('parent_uid');
                     var parent_username = this1.attr('parent_username');
                     var reply_parent = $('#reply_parent');
                     reply_parent.text(parent_username);
                     var hf_container = $('#hf_container');
                     var input_container = hf_container.find('.input_container');
                     if (!parent_id) {
             alert('网络错误');
                     return false;
             }
                     video_container.show(100);
                     video_container.find('textarea').focus();
                     $('#theReplier').text(parent_username);
                     video_container.find('input[name="parent_id"]').val(parent_id);
                     video_container.find('input[name="parent_username"]').val(parent_username);
                     video_container.find('input[name="parent_uid"]').val(parent_uid);
                     video_container.attr('data-container-id', reply_container_id);
                     //        window.location.href = "///default/replyhost/?parent_id="+parent_id+"&parent_username="+ parent_username+"&parent_uid="+parent_uid+"&aid=//";
 }


        var send_pl_container = $('#send_pl_container');
                //{lang qidou_video_live:pingl}
        function addComment(obj, sign) {
                var html = '';
                var pl_container = $('#pl_container');
                var input_container = pl_container.find('.input_container');


                var this1 = $(obj);
                var topic_id = 0;
                //sign 1有topicid 0没有topic
                if (sign == 1) {
                   topic_id = this1.attr('topic_id');
                }
                //console.log(topic_id);
                //        window.location.href = "///default/reply/?sign="+sign+"&topic_id="+topic_id+"&aid=//";
                send_pl_container.show(100);
				 $('.video-live').remove();
                send_pl_container.find('textarea').val('').focus();
                send_pl_container.find('input[name="topic_id"]').val(topic_id);
         }



    function index_add_reply(parentobj, obj, parent_uid, parent_id, parent_username, content, reply_username, username) {
                   comment_list = $(obj);
                   parentobj = $(parentobj);

                   var li_size = comment_list.find('.li').size();
                   var rest_size = 0;
                   var html = '';
                   var clearfix_li = $('<li class="clearfix li" onclick="addReply(this)" parent_uid="' + parent_uid + '" parent_id="' + parent_id + '" parent_username="' + parent_username + '"></li>');
                   html += '<span class="name">' + parent_username + '</span>';
                   if (reply_username != parent_username) {
                    html += '<span class="content-say"> 回复 </span>';
                            html += '<span class="name">' + reply_username + '</span>';
                    }
                    html += '<span class="content-say"> :' + content + '</span>';
                            clearfix_li.append(html);
                   if (li_size == 4) {
                        if (comment_list.find('.rest_size').size() == 0) {
                                 rest_size = 1;
                                comment_list.append('<a href="plugin.php?id=qidou_video_live&act=commentall&lid=<?php echo $live["id"]; ?>&rid=' + parent_id + '" data-no-cache="true" class="comment-btnmore external">{lang qidou_video_live:chakqy}<span class="rest_size">' + rest_size + '</span>条回复</a>');
                        } else {
                                rest_size = parseInt(comment_list.find('.rest_size').text()) + 1;
                                comment_list.find('.rest_size').text(rest_size);
                        }
                    } else if (li_size == 0) {
                            var cnm_html = $('<div class="comment_list"></div>').append(clearfix_li);
                            parentobj.find('.right_con').append(cnm_html);
                    } else {
                        comment_list.append(clearfix_li);
                    }
           }
        //编辑
        function editor_msg(obj) {
        var html = '';
                var bj_container = $('#bj_container');
                var input_container = bj_container.find('.input_container');
                var bj_content = $('#bj_content');
                var this1 = $(obj);
                var tid = this1.attr('tid');
                var sign = this1.attr('sign');
                bj_content.val(this1.attr('text'));
                //跳转编辑页面
                window.location.href = 'plugin.php?id=qidou_video_live:publive&tid=' + tid + '&sign=' + sign;
        }
    //编辑
    function localhost_page_jump(zindex) {
    var button = $('.buttons-tab .button');
            var tab_page = $('.tabs .tab');
            if (zindex == 0) {
            getMoreRepies();
            } 
             button.removeClass('active').eq(zindex).addClass('active');
            tab_page.removeClass('active').eq(zindex).addClass('active');
    }

    $('.tab-link.button').on('click', function () {
             var this1 = $(this);
            var zindex = this1.index();
            if (zindex == 0) {
		 	    getMoreRepies();
		    } 
    });
    var topic_list = $('#topic_list');
    var tpage = topic_list.find('input[name=page]');
    var thepage = parseInt(tpage.val());
  


var phblist = $('.phb');
   	 phbp = 0; 
  
 function getphbs() {
    phblist.dropload({
    scrollArea: window,
            loadDownFn: function (me) {
            	
                $.ajax({
                'url': 'plugin.php?id=qidou_video_live:live_ajax',
                'type': 'POST',
                'data': {'ajax':'phb','page': phbp, 'lid':"<?php echo $live['id']; ?>", formhash: '{FORMHASH}'},
                'dataType': 'html',
                'success': function (data) {
                	
                   	if(data){
                   		$(".phb").append(data);
                   		$(".dropload-down").hide();
                   		phbp++;
                   	}else{
                       		// 锁定
                        me.lock();
                        // 无数据
                        me.noData();
                   	}
                   	me.resetload();
                },
	            'error': function () {
	                alert('网络错误');
	                // 即使加载出错，也得重置
	                me.resetload();
	            }
            });
            }
});
}
var replies_list = $('#replies_list');
var rpage = replies_list.find('input[name=page]');
var rthepage = parseInt(rpage.val());
getMoreRepies();
function getMoreRepies() {
replies_list.dropload({
		scrollArea: window,
        loadDownFn: function (me) {
                        $.ajax({
                            'url': '<?php echo url("index/morerepies"); ?>',
                            'type': 'POST',
                            'data': {'page': rthepage, 'lid':"<?php echo $live['id']; ?>"},
                            'dataType': 'json',
                            'success': function (data) {
                           
                                if (rthepage <= <?php echo $pagec; ?>) {
                                    rpage.val(parseInt(rpage.val()) + 1);
                                    if (data.html) {
                                        var html = '';
                                        for (var i = 0; i < data.html.length; i++) {
                                           
                                            var head = '';
                                            var coms = '';
                                            if(data.html[i].reply_ways == 1){
                                              head  = '<img src="__STATIC__/live/images/anonymous_head.png" alt="" class="user_img"/>';
                                            }else{
                                              head = '<img src="'+data.html[i].headimg+'" alt="" class="user_img"/>';
                                            }
                                             for(var c = 0; c<data.html[i].coms.length; c++){
                                                coms += '<div class="clearfix li" onclick="addReply(this,"'+data.html[i].coms[c].id+'")" parent_uid="'+data.html[i].coms[c].uid+'" parent_id="'+data.html[i].coms[c].id+'" parent_username="'+data.html[i].coms[c].username+'">'+
                                                    ' <span class="name">'+data.html[i].coms[c].username+'</span>';
                                                    if(data.html[i].coms[c].pid && data.html[i].coms[c].uid != data.html[i].coms[c].parent_id){
                                                        coms += '<span class="content-say">回复</span>'+
                                                     '<span class="name">'+data.html[i].coms[c].parent_name+'</span>';
                                                    } 
                                                coms +=  '<span class="content-say">:'+data.html[i].coms[c].contents+'</span>'+
                                                ' </div>';
                                             }     
                                            html += '<li class="li-b" data-time="'+data.html[i].addtime+'" id="replyid'+data.html[i].id+'">'+
                                                '<div class="main">'+
                                                   '<div class="clearfix leave_bg">'+ head +                                              
                                                        '<div class="right_con">'+
                                                           ' <div class="line clearfix">'+
                                                               ' <p class="name flooer_name">'+data.html[i].username+'</p>'+
                                                               ' <p class="time">'+data.html[i].addtime1+'</p>'+
                                                            '</div>'+
                                                           ' <div class="detail">'+data.html[i].contents+'</div>';
                                               if(data.html[i].contents_t && data.html[i].contents_t != 'null'){
                                                    html += data.html[i].contents_t;
                                                }              
                                                 html +=     '<div class="tools clearfix">'+
                                                                '<div class="fr clearfix">'+
                                                                    '<span class="zan tnzan '+data.html[i].my_zan+'" onclick="ilikeid(this, \'reply\')" likeid="'+data.html[i].id+'">'+data.html[i].zan+'</span>'+
                                                                    '<span class="comment" onclick="addReply(this,\''+data.html[i].id+'\')" parent_id="'+data.html[i].id+'" parent_uid="'+data.html[i].uid+'" parent_username="'+data.html[i].username+'">回复</span>'+
                                                               ' </div>';
                                                if (data.fabu) { 
                                                    html +=  '<div class="manager_btn fl" onclick="manager_this_post(this)" tid="'+data.html[i].id+'" sign="reply" place ="'+data.html[i].place+'" >   '+                                                       
                                                       ' </div>';
                                                }
                                                html +=   '</div><div class="comment_list">'+ coms;
                                                if(data.html[i].coms_num){
                                                    html +=   ' <a href="plugin.php?id=qidou_video_live&act=commentall&lid='+data.html[i].lid+'&rid='+data.html[i].id+'" data-no-cache="true" class="comment-btnmore external">{lang qidou_video_live:chakqy}<span class="rest_size">'+data.html[i].coms_num+'</span>条回复</a>';
                                                }         
                                                html +=  '</div></div></div> </div> </li>';
                                           }
                                        rthepage = rthepage + 1;
                                        rpage.val(rthepage); 
                                        replies_list.find('ul').append(html);
                                    } else {
                                        rthepage = rthepage;
                                        rpage.val(rthepage);
                                        // 锁定
                                        me.lock();
                                        // 无数据
                                        me.noData();
                                    }
                                } else {
                                    // 锁定
                                    me.lock();
                                    // 无数据
                                    me.noData();
                                }
                                
                                me.resetload();
                            },
                            'error': function () {
                                //alert('网络错误');
                                // 即使加载出错，也得重置
                               // me.resetload();
                            }
                        });
                    }
            });
            }

    function ilikeid(obj, sign) {
        var this1 = $(obj);
        var the_action = '';
        var lid = this1.attr('likeid');
        var text = parseInt(this1.text());
         if (lid > 0) {
             $api.openLogin();
            $.ajax({
                    type: "POST",
                    url: "<?php echo url('index/ajax_zan'); ?>",
                    dataType: "json",
                    data: {uid:uid, sign:sign, lid: lid},
                    beforeSend: function () {
                    },
                    success: function (data) {
                    if (data.status == 0) {
                         this1.removeClass('thzan');
                            alert(data.msg);
                    } else if (data.status == 1) {
                        if (this1.hasClass('thzan')) {
                        this1.removeClass('thzan');
                                the_action = 'cancel';
                        } else {
                        this1.addClass('thzan');
                                the_action = 'add';
                        }
                    //     text = text + data.change;
                    this1.text(data.change);
                    } else if (data.status == 2){
                    this1.removeClass('thzan');
                            if (data.isapp){
                                connectSQJavascriptBridge(function(){
                                    sq.login(function(userInfo){
                                       // alert(JSON.stringify(userInfo));
                                        if(userInfo.errmsg){
                                            document.location.reload();
                                        }
                                    });
                                 });
                            } else{
                            document.location.href = data.url;
                            }
                    } else{
                    this1.removeClass('thzan');
                            //alert("网络错误");
                    }
        
                    },
                    error: function (data) {
                    //alert("网络错误");
                    }
            });
            }

    }

    ifHasNewReplies();

        /*是否有新消息*/
        function ifHasNewReplies() {
        var lasttime = $('#replies_list ul li').eq(0).attr('data-time');
                if (lasttime && lasttime != 0) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo url('index/newreplies'); ?>",
                        dataType: "json",
                        data: {'lasttime': lasttime,lid:"<?php echo $live['id']; ?>"},
                        beforeSend: function () {
                            clearTimeout(theInterval);
                        },
                        success: function (data) {
                            if (data.status == 1) {
                                $('#newinfo').show();
                            }
                            theInterval = setTimeout(function () {
                                ifHasNewReplies();
                            }, lastsTime);
                        },
                        error: function () {
                            theInterval = setTimeout(function () {
                                ifHasNewReplies();
                            }, lastsTime);
                        }
                    });
    }
    }

 function getlive(lasttime) {
     if(!lasttime){
          lasttime = $('#topic_list ul li.topics').eq(0).attr('data-time');
     }
        $.ajax({
            type: "POST",
            url: "plugin.php?id=qidou_video_live:live_ajax",
            dataType: "json",
            data: {'ajax':"getlive",lasttime:lasttime,lid:"<?php echo $live['id']; ?>", formhash: '{FORMHASH}'},
            beforeSend: function () {
                clearTimeout(theInterval1);
            },
            success: function (data) {
                $("#partake").html(data.partake);
                $("#xzan").html(data.zan);
                if(data.html){
                    
            
                  for (var i = 0; i < data.html.length; i++) {
                      lasttime = data.html[i].addtime1;
                                    var imgs = '';
                                    var html = '';
                                    if( data.html[i].imgs){
                                    for(var t = 0; t < data.html[i].imgs.length; t++){
                                        imgs += '<img src="'+data.html[i].imgs[t]+'" data-width="200" data-height="200" />';
                                    }
                                   }
                              
                                    html += '<li id="replyid'+data.html[i].id+'">'+
                                            '<div class="main">'+
                                                '<div class="clearfix leave_bg">'+
                                                    '<img src="/avatar.php?uid='+data.html[i].uid+'&size=small" alt="" class="user_img"/>'+
                                                    '<div class="right_con">'+
                                                        '<div class="line clearfix">'+
                                                            '<p class="name">'+data.html[i].username+'</p>'+
                                                            '<p class="time">'+data.html[i].addtime+'</p>'+
                                                        '</div>'+
                                                        '<div class="detail">'+
                                                            '<style>'   +
                                                                '.icon-cream{'+
                                                                    'display: inline-block;'+
                                                                    'background: #ffab18;'+
                                                                    'color: #FFF;'+
                                                                    'padding: 0 .2rem;'+
                                                                    'border-radius: 5px;'+
                                                               ' }'+
                                                            '</style>'+
                                                           ' <div style="line-height: 1.3rem;" class="content_mix_img_container">'+
                                                               ' <p>'+data.html[i].contents+'</p>'+
                                                                '<p>'+ imgs+ '</p> '+                    
                                                            '</div>'+
                                                        '</div>'+
                                                        '<div class="tools clearfix">'+
                                                            '<div class="fr clearfix">'+
                                                                '<span class="zan tnzan '+data.html[i].my_zan+'" onclick="ilikeid(this, "topic")" likeid="'+data.html[i].id+'">'+data.html[i].zan+'</span> '+
                                                                '<span class="comment" onclick="addComment(this, 1)" topic_id="'+data.html[i].id+'" uid="'+data.html[i].uid+'" parent_uid="'+data.html[i].uid+'" parent_id="'+data.html[i].id+'" parent_username="'+data.html[i].username+'">{lang qidou_video_live:pingl}</span>'+
                                                            '</div>';
                                                            if(data.fabu){
                                                                  html +=    '<div class="manager_btn fl" onclick="manager_this_post(this)" tid="'+data.html[i].id+'"  sign="topic">  ';                                                         
                                                            }
                                                        html +=        '</div>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+
                                        '</li>';   
                 }
                 $('#topic_list ul li.topics').eq(0).prepend(html);
                
              }
                theInterval1 = setTimeout(function () {
                    getlive(lasttime);
                }, lastsTime);
            },
            error: function () {
                theInterval1 = setTimeout(function () {
                    getlive();
                }, lastsTime);
            }
        });
    }

    /*查看更多消息*/
    function getNewReplies() {
    var lasttime = $('#replies_list ul li').eq(0).attr('data-time');
            if (lasttime && lasttime != 0) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo url('index/getnewreplies'); ?>",
                        dataType: "json",
                        data: {'lasttime': lasttime,lid:"<?php echo $live['id']; ?>"},
                        beforeSend: function () {
                        },
                        success: function (data) {
                            if (data.html && data.html != '') {
                                var html = '';
                                for (var i = 0; i < data.html.length; i++) {
                                    var head = '';
                                    var coms = '';
                                    if(data.html[i].reply_ways == 1){
                                      head  = '<img src="__STATIC__/live/images/anonymous_head.png" alt="" class="user_img"/>';
                                    }else{
                                      head = '<img src="'+data.html[i].headimg+'" alt="" class="user_img"/>';
                                    }
                                     for(var c = 0; c<data.html[i].coms.length; c++){
                                        coms += '<div class="clearfix li" onclick="addReply(this,"'+data.html[i].coms[c].id+'")" parent_uid="'+data.html[i].coms[c].uid+'" parent_id="'+data.html[i].coms[c].id+'" parent_username="'+data.html[i].coms[c].username+'">'+
                                            ' <span class="name">'+data.html[i].coms[c].username+'</span>';
                                            if(data.html[i].coms[c].pid && data.html[i].coms[c].uid != data.html[i].coms[c].parent_id){
                                                coms += '<span class="content-say">回复</span>'+
                                             '<span class="name">'+data.html[i].coms[c].parent_name+'</span>';
                                            } 
                                        coms +=  '<span class="content-say">:'+data.html[i].coms[c].contents+'</span>'+
                                        ' </div>';
                                     }     
                                    html += '<li class="li-b" data-time="'+data.html[i].addtime+'" id="replyid'+data.html[i].id+'">'+
                                        '<div class="main">'+
                                           '<div class="clearfix leave_bg">'+ head +                                              
                                                '<div class="right_con">'+
                                                   ' <div class="line clearfix">'+
                                                       ' <p class="name flooer_name">'+data.html[i].username+'</p>'+
                                                       ' <p class="time">'+data.html[i].addtime1+'</p>'+
                                                    '</div>'+
                                                   ' <div class="detail">'+data.html[i].contents+'</div>';
                                      if(data.html[i].contents_t && data.html[i].contents_t != 'null'){
                                          html += data.html[i].contents_t;
                                      }    
                                       html += '<div class="tools clearfix">'+
                                                        '<div class="fr clearfix">'+
                                                            '<span class="zan tnzan '+data.html[i].my_zan+'" onclick="ilikeid(this, \'reply\')" likeid="'+data.html[i].id+'">'+data.html[i].zan+'</span>'+
                                                            '<span class="comment" onclick="addReply(this,\''+data.html[i].id+'\')" parent_id="'+data.html[i].id+'" parent_uid="'+data.html[i].uid+'" parent_username="'+data.html[i].username+'">回复</span>'+
                                                       ' </div>';
                                        if (data.fabu) { 
                                            html +=  '<div class="manager_btn fl" onclick="manager_this_post(this)" tid="'+data.html[i].id+'" sign="reply" place ="'+data.html[i].place+'" >   '+                                                       
                                               ' </div>';
                                        }
                                        html +=   '</div><div class="comment_list">'+ coms;
                                        if(data.html[i].coms_num){
                                            html +=   ' <a href="plugin.php?id=qidou_video_live&act=commentall&lid='+data.html[i].lid+'&rid='+data.html[i].id+'" data-no-cache="true" class="comment-btnmore external">{lang qidou_video_live:chakqy}<span class="rest_size">'+data.html[i].coms_num+'</span>条回复</a>';
                                        }         
                                        html +=  '</div></div></div> </div> </li>';
                                   }
                                  //console.log(html);
                                $('#replies_list').find('ul').prepend(html);
                                
                            }
                        },
                        error: function () {
                            alert('网络错误');
                        }
                    });
            }
    }

function getCookie(name) {
var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
        if (arr = document.cookie.match(reg))
        return unescape(arr[2]);
        else
        return null;
}

function hide_this_post(obj) {
        var this1 = $(obj);
        var tid = this1.parent('#manage_action').attr('tid');
        var sign = this1.parent('#manage_action').attr('sign');
                $.ajax({
                    'type': 'POST',
                    'url': "plugin.php?id=qidou_video_live:live_ajax",
                    'dataType': 'json',
                    'data': {'tid': tid, 'ajax': "hide",sign:sign, formhash: '{FORMHASH}'},
                    'beforeSend': function (data) {
                    },
                    'success': function (data) {
                        alert(data.msg);
                        location.reload(true);
                    },
                    'error': function (data) {
                        alert('网络错误');
                        location.reload(true);
                    }
                });
}

function elite_action(obj) {
var this1 = $(obj);
        var iselite = this1.attr('iselite'); //1加精，0{lang qidou_video_live:qux}加精
        var tid = this1.parent('#manage_action').attr('tid');
        var sign = this1.parent('#manage_action').attr('sign');
        var place = this1.parent('#manage_action').attr('place');
                $.ajax({
                    'type': 'POST',
                    'url': "plugin.php?id=qidou_video_live:live_ajax",
                    'dataType': 'json',
                    'data': {'tid': tid, 'ajax': "jinghua",sign:sign, formhash: '{FORMHASH}'},
                    'beforeSend': function (data) {
                    },
                    'success': function (data) {
                        alert(data.msg);
                        location.reload(true);
                    },
                    'error': function (data) {
                        alert('网络错误');
        //                location.reload(true);
                    }
                });

}

//点赞


function manyclicks(obj) {
        var this1 = $(obj);
        var zan_click = this1.find('.zan-click');
        var text_container = this1.find('p').eq(1);
        var box_time = 0;
        actionBox(zan_click,box_time);
//                $.tipsBox({
//                    obj: zan_click
//                });
                $.ajax({
                    'type': 'POST',
                    'url': "<?php echo url('index/ajax_zan'); ?>",
                    'dataType': 'json',
                    'data': {'lid': '<?php echo $live["id"]; ?>'},
                    'beforeSend': function () {
                    },
                    'success': function (data) {
                        var click_size = parseInt(data.msg);
                        if (click_size < 10000) {
                            text_container.text(click_size);
                        } else {
                            click_size = Math.round((click_size / 10000), 2);
                            text_container.text(click_size + 'w');
                        }
                    },
                    'error': function (e) {
                        console.log('网络错误');
                        return false;
                    }
                });
            if (zan_click.hasClass('no-touch')) {
            zan_click.removeClass('no-touch').addClass('has-touch');
            }
}

function actionBox(obj,box_time) {
        
        this1 = $(obj);
     
      
        var images = [];
        images[0] = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAiCAYAAAA3WXuFAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MENENkY1MUE1OTE1MTFFNkIxNDVEMEVBOEE4NzY4ODMiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MENENkY1MUI1OTE1MTFFNkIxNDVEMEVBOEE4NzY4ODMiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDowQ0Q2RjUxODU5MTUxMUU2QjE0NUQwRUE4QTg3Njg4MyIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDowQ0Q2RjUxOTU5MTUxMUU2QjE0NUQwRUE4QTg3Njg4MyIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PhiiexoAAAIuSURBVHjazJjNKwRxGMdnx9vFW0oOCnlJSoqSi4gQ68JNKcKV4oCVgwOJHPwF5C1WKEXE5mXVyks4iSQX5eKlVlFore+jZ2tNO8uO3Z3ftz5tOzu/mc/M/l6eGcPnRLekkkzQAspANggD7+AcWMAYuFJpGwcaQA3IA1HgE9wAK5gBu7SjoXHoR0PZw8Fi+WQXoBPksgwlnL93gUswzvu7H6+dTzwKilnG9Vs6X+QOC2UoT64UogYnoJnkJe+h35vAGcgC0WCFRWKk30Oyp85Jk1FNKJmtUyXfksJXvAmMPraNBMuQKlEKhYIFkChpSwIo0NiWusM8pOLdhVpBvqRfSGbwux9glEXg85Y36hkHSKI7VCuADCUE1MsaOmIgUy7r3HeUySGhNIGEEmS3WViIyJJgIaFHgXyeZS8rth65lHkNEiWrJLQmiIwTzJHQEdgXQGgDxdq1a5T1CCA04D7s96gE0FFmCnfHppyH2sCDDjJ3oMPTxHjPhXkwQ4V/A+7Ok9pMvQ76gyjUC5mt35aOPrAUBJlZMPyXtczJf50tgDIWfmJx/nVxfQXV9JgSAJkDfoB893W1t4NSnjj9lWNQyResqfwgqQo/SR1SicrH/Fc95JKy/kNmm++23V8FmktqUYPMHKjy9jdprRipE9aBER/a0LCuV+vA/ihhHfzmg4bsh5f93njqMHka2oGoqSdAIT/xKkPbisB0sIt8Gnn0MsoMXhgzvz/SPCq/BBgARph14/RwWa4AAAAASUVORK5CYII=';
        images[1] = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAiCAYAAAA3WXuFAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6OUFGODhEQjc1OTFCMTFFNjhCQUZDRUY2OTc3QkM2REMiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6OUFGODhEQjg1OTFCMTFFNjhCQUZDRUY2OTc3QkM2REMiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo5QUY4OERCNTU5MUIxMUU2OEJBRkNFRjY5NzdCQzZEQyIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo5QUY4OERCNjU5MUIxMUU2OEJBRkNFRjY5NzdCQzZEQyIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Ps8t1skAAAIoSURBVHjazJhNKARhGMdnx8fFR8oWB0lxoJTcJDm44LjRWiLiQKHkQBFyECkHDloHuUn5yEdIiXyFyEdOSshBOfgIUbtY/6eeqTVm1u7Y3Zl//S4788785p153/d512RvcwgqSQY2kANSQShwgnOwBSbApUrbGFAM8kE6iARf4AbsgRmwSyfW9oT9aBiqcLFo0AmswCQ7FsY3IOrAJOgGz3xcBNWgGUTJ2tKxJMbGYi3gSn6Se+jkZVCiICOPiaVXQAr3whjoUpBRShbda6TdmacmlMBPnCj4FqndOMjzsW0EGIVUtlyIXp0dxAvaYgaZGtvSvYchFesuVAUyBP1CMq2SUDhoEPSPFb0UR0IFbKh3QoBF1PAhBjK5os7fjjxp0mRllJhFldlat4iCwUJCjwbyeRU9rNh65IKENg0ktEpCawaRcYE5EjoBhwYQ2kCxdi2Nsj4DCA25D/t9sKCjzBR650A+D3WABx1k7rgM/jUx3oOmIMtQ4d+E3nlSm6nXwWAQhfohs/3X0jEAloIgM0ulqzdrmYtf3UEAZbZ4q+TydnF9B5XgLAAyR6CGN50+rfYvvD878aPMKSjnB9ZUfpBUmZ+kjkEpX/Nf9ZAktfcPmR3u7Rd/FWiS1KIGmTlQ4ek1aa0Y6SOs5x2ut6Fh3aj2AfujhP0EPTxkPzyc5+Cpo1dpaAeipqY/FyzgVuEY/VYEpoNd5NPIKwTz4I2Z552w5lH5LcAAxEN1VM5awqkAAAAASUVORK5CYII=';
        images[2] = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAiCAYAAAA3WXuFAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RTI2NDZGODQ1OTFCMTFFNkI5RjhGNUVGREMxNkYwNjgiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RTI2NDZGODU1OTFCMTFFNkI5RjhGNUVGREMxNkYwNjgiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpFMjY0NkY4MjU5MUIxMUU2QjlGOEY1RUZEQzE2RjA2OCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpFMjY0NkY4MzU5MUIxMUU2QjlGOEY1RUZEQzE2RjA2OCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PrVuxs8AAAIySURBVHjazJhNS1RRGIDvTObCVFAMWggGBvaxC0LQRdsIdacrFTdFCY4VmIQgI6LRIhQEESwi9RdIKhrUquhDJ0YqaFOhUgRSfszYUGI+L5wL18u9k3Pn454Xnplhzj13Hs495z3vmUDL7bjhEhXQABegEvLgL3yGNzANKy59i+EyXITTUAB78A0iMKfejYl7BQc65jncrAg6oQ4CtrajUKVohhkYhm3VHoQmuAKFtr7SVq5oUEKDsGq/yBpy8WOod5CxR0BJT8JJOAb34aaDjFOcl76t3Ts1B25qeWQn4AEcN1KPn/AdznnouwshHt2SdYSOwF2PMhKlHmXMaTPASJVYhRrhrOFfiMx1Uygf2gz/o55RKguqpVmigZC4XJKXWkOfqBahMxoJnTKTlS5RGnTJ1r5OJEM3oU2NfOLBJDu2H/FVhF5rJPRChF5qIvMP5kXoAyxrIPSKHX/NXGWjGgg9si77d/DUR5lZRidqz0NS7W34ILMOQ06J8Rf05VhGCv8wo7PllqllxT3ModAYMm//t3WMw/McyMzLKegwe5nkgzBEsygj57p+9VuH2lwTcAs+ZUHmPXSpQ2dKu30M2lXizFR8VIfQhNfyQ6RCGZKSe3Soe6ZVD5lSkTRkFtVoxzJVoJlSzzzILMCNZI/Ja8Uok7AHplLoI8u6120Cux1jU82sI/AF7iTp/0f9szGXq5r6CVyFHw5t8t01LzLpFvmyalpVlfBbIZ9b0lmV+wIMAE0jeRcEsb6KAAAAAElFTkSuQmCC';
        images[3] = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAiCAYAAAA3WXuFAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NTg0NDE1MEU1OTIwMTFFNjg1NzlCMjJCODc0QjY3QzQiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6NTg0NDE1MEY1OTIwMTFFNjg1NzlCMjJCODc0QjY3QzQiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo1ODQ0MTUwQzU5MjAxMUU2ODU3OUIyMkI4NzRCNjdDNCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo1ODQ0MTUwRDU5MjAxMUU2ODU3OUIyMkI4NzRCNjdDNCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PixAKYcAAAIjSURBVHjazJjLK0RhGMbPfKbcopFbEbESWbCRsGGhLJSFpS1Jimb+BLbklkSSbESiZMEek5EFGiKXLFxGohhjJoznrffUzGlmzDlzOeepXzPNd5nnfOd9v+89x/RjnZTCqBA0gUpQBFLAN3gATrALnsKMzQT1oAaUgjTgB8/gEtjBBXUUI/1BA80hJssAnaABmBRt1L+EaQX7YBV8cjv1bwHtIF0xltoKmEY2tARcQZ0UK0SdB0CeFL1eAE3yCrpBtYqxXjCLVTqVfxABjbnAptKMPM4KBlWaIaWCvl/bVIXSEH32AIukTdmgXONYis1umMoKNNQMyiT9RGY6ZEMUqG2S/mrAKlnIUC071FvkpU5oCMREqkroHDtKFZOhfAMZyhacdoaRkAwmMuQ2kJ8vEeHE1kOPgksJo+iYDJ0YxAzVSw4ydAuuDGDIiTLEJWfZugEMbQWmPZWVhzqasWN1rpT70DL40MHMG1gJtTG+gwUdAnkBq+MOt1OfyvcySdqAmfP/jo5NcJQEMwdgO5qzzM+3LpFbwRlY5P+K6nD18aPNXQLMXINpfuhUddp7wChvnPESzTXBF6yp/CBTY3EydcNzeWKth2RTFzGYOefV9sSrQKOJxjVmn4Pj0RfvipGCcA7sqBhDaT0fLoBDyazyan/BGr+S6YpQj3/zmw272uU0a4yJPXAPekGOoo3egsxoTQQRYwoPc4x4Gfo+FEtW/gkwAFjTfG2JD9MvAAAAAElFTkSuQmCC';
        images[4] = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAiCAYAAAA3WXuFAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QkNDNTA1Q0Y1OTIwMTFFNkIyMUZERkFERUNERTdERUIiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QkNDNTA1RDA1OTIwMTFFNkIyMUZERkFERUNERTdERUIiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpCQ0M1MDVDRDU5MjAxMUU2QjIxRkRGQURFQ0RFN0RFQiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpCQ0M1MDVDRTU5MjAxMUU2QjIxRkRGQURFQ0RFN0RFQiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PvStnHUAAAITSURBVHjazJjbKwRRHMdnj7XL5pYQRdsWD8IDkjwoT96IUp74K/gr/Bke3SLaKJFLyeUJa5Hb2nV5cItiaeP7029qTTNr5+xl5luftnb2zHzmzDm/c2Yd0d0RxSCloBF4QRkQIAYewBXYB08GbfNAA6gFFcAFvsELuAZH/Km4Wsf+NHTqnMwNulhGmxy+ANEGDsAqiPJxB2gBHXye+NCxEqYJhMGS9qaEphH9eMhARi/0u2HuTeqFfr4ZdxJtq+lan3ujPiOhIjAIihVzUdsNAJ/JtrmgD1I1WiH67AEFilw8oEqy7e+1IZUfL9QMKhXrQjKdqhAN1HbF+jSilwpIqI4NrQ7NwnohMRAzGa+weOxoUy649tglHqFTHC2NrWRUoXcb+XyKBCu2FXkUvJWwS85I6NxGQkESugM3NpC5xGbtWZ1l6zYQ2oqf9rR7O7ZQJoDeiWjr0LJFJeANrOgVRpLxZ1mGNv5+9M6HUaW+UJ9llrIBmdB/S8cmOM2CDL0KbSe7ltGji2RQhorxopnF9QvMgPsMyNyCWX7pNLXa08vfBBfOdIXONcU3LLX9IKnJNEnd8rmiqe6HVKlwCjIh7u1oujZoqtSJzIIJphM9JtkdIw3CebBjog1N6wWjAawXp0RlXeO/ZLoT3FCM/9kImO1Op+SYOGSpXlCoOfYK5mQngkhxCo/zGPligvyd9Kz8EWAArXV3lWtXjIwAAAAASUVORK5CYII=';
        var str1 = images[Math.floor(Math.random() * images.length)];
       
        box_time = box_time + 1;
        
        var classname = 'stylie' + parseInt(Math.floor(Math.random() * (images.length - 1)));
        var idname = 'img' + box_time;
        var imgobj = $('<img class="num ' + classname + '" id="' + idname + '" />');
        $(".page-group").append(imgobj);
        imgobj.attr('src', images[Math.floor(Math.random() * images.length)]);
        var random_width = parseInt(Math.floor(Math.random() * (parseInt(this1.width()) - 1)));
        var box = imgobj;
        var left = this1.offset().left + random_width;
        var top = this1.offset().top;
        var time_array = ['600', '900', '1200', '1500'];
        var time_queue = parseInt(time_array[Math.floor(Math.random() * 4)]);
       
        imgobj.css({
        "position": "absolute",
                "left": left + "px",
                "top": top + "px",
                "z-index": 9999 + box_time
        });
        setTimeout(function () {
        box.remove();
        }, time_queue);
        //        box.animate({
        //            "top": top - 30 + "px"
        //        }, time_queue, function () {
        //            box.remove();
        //        });
}

    var lee = (function(l){
        l.modal = {
            build:function(){
                var html = '<div id="modal_container" class="modal">' +
                    '<div class="modal-inner">' +
                    '<div class="modal-title"><p class="item-title"></p><p></p></div>' +
                    '<div class="modal-text">' +
                    '</div>' +
                    '</div>' +
                    '<div class="modal-buttons"><span class="modal-button"></span></div>' +
                    '</div>'+
                    '<div class="modal-overlay" id="modal-overlay-visible"></div>';
                $('body').append(html);
            },
            show:function(title,content){
                var modal_overlay_visible = $('#modal-overlay-visible');
                var modal_container = $('#modal_container');
                modal_overlay_visible.addClass('modal-overlay-visible');
                modal_container.show(800);
                setTimeout(function(){
                    modal_container.addClass('modal-in');
                },50);
                var item_title = modal_container.find('.item-title');
                item_title.html(title);
                var modal_text = modal_container.find('.modal-text');
                modal_text.html(content);
                var modal_buttons = modal_container.find('.modal-buttons');
                modal_buttons.on('click',function(){
                    lee.modal.close();
                });
            },
            close:function(modal_mask,dialog_container){
                var modal_container = $('#modal_container');
                var modal_overlay_visible = $('#modal-overlay-visible');
                modal_container.removeClass('modal-in');
                modal_container.hide(800);
                modal_overlay_visible.removeClass('modal-overlay-visible');
            }
        };
        //表单验证
        l.validate = {
            isEmpty: function(str) {
                return str.replace(/(^\s*)|(\s*$)/g, "") ? false : true
            },
            isEmail: function(str) {
                return /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/i.test(str)
            },
            isPhone: function(str) {
                return /^0?1[3|4|5|8][0-9]\d{8}$/.test(str)
            },
            isID: function(str) {
                return /^\d{6}(18|19|20)?\d{2}(0[1-9]|1[12])(0[1-9]|[12]\d|3[01])\d{3}(\d|X)$/i.test(str)
            },
            isMobile: function(){
                var sUserAgent = navigator.userAgent.toLowerCase();
                var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
                var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
                var bIsMidp = sUserAgent.match(/midp/i) == "midp";
                var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";
                var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
                var bIsAndroid = sUserAgent.match(/android/i) == "android";
                var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
                var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";
                if (bIsIpad || bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM) {
                    //document.writeln("phone");
                    return true;
                } else {
                    //document.writeln("pc");
                    return false;
                }
            }
        };
        return l;
    })(window.lee || {});

                                                                            
function sendrl(obj) {
    var this1 = $(obj);
    var dialog_relay_box = this1.parents('.video_reply_container');
    var parent_id = dialog_relay_box.find('input[name=parent_id]').val();
    var parent_uid = dialog_relay_box.find('input[name=parent_uid]').val();
    var parent_name = dialog_relay_box.find('input[name=parent_username]').val();
    var contents = dialog_relay_box.find('textarea').val();
      if (dialog_relay_box.find('input[name=reply_ways]').size() == 0) {
         var reply_ways = 0;
      } else {
         var reply_ways = dialog_relay_box.find('input[name=reply_ways]').val();
      }
          if (!contents) {
          alert('{lang qidou_video_live:tianxnr}');
                  return false;
          }
          $api.openLogin();
          $.ajax({
              type: "POST",
              url: "<?php echo url('index/reply'); ?>",
              dataType: "json",
              data: {uid:uid,'parent_id': parent_id, 'parent_uid': parent_uid, lid:'<?php echo $live['id']; ?>',parent_name:parent_name,'contents': contents, 'reply_ways': reply_ways},
              beforeSend: function () {
              },
              success: function (data) {
                  if (data.status == 1) {
                      closeNMB('video_container');
                      var li_b = $('#replyid' + data.pid);
                      var comment_list = li_b.find('.comment_list');
                      index_add_reply(li_b, comment_list, data.parent_uid, data.parent_id, data.parent_username, data.content, data.reply_username, li_b.find('.flooer_name').text());
                      localhost_page_jump(0);
  //                    window.location="///default?aid=//&&replyhost=success";
                      getMoreRepies();
                  }  else if(data.status == 2) {
                        
                         document.location.href = data.url;
                        
                   }else {
                      alert(data.msg);
                  }
              },
              error: function () {
                  alert('{lang qidou_video_live:shuaxcs}');
              }
          });
}
videohtml =      '<header class="video_text">'+
                       ' <div class="video-live" style="z-index:0;">'+
                            <?php if($live['video']): ?>
                            '<?php echo $live['video']; ?>'+
                           <?php elseif($live['img']): ?>
                            '<img src="<?php echo $live['img']; ?>"  />'+
                            <?php endif; ?>
                        '</div> '+
                    '</header>';
                    
function sendpl(obj) {

        $('.video_text').html(videohtml);
        var this1 = $(obj);
        var dialog_relay_box = this1.parents('.dialog-relay-box');
        var topic_id = dialog_relay_box.find('input[name=topic_id]').val();
        var contents = dialog_relay_box.find('textarea').val();
        if (dialog_relay_box.find('input[name=reply_ways]').size() == 0) {
            var reply_ways = 0;
        } else {
             var reply_ways = dialog_relay_box.find('input[name=reply_ways]').val();
        }
        if (!contents) {
              alert('{lang qidou_video_live:tianxnr}');
                return false;
        }
  $api.openLogin();
    $.ajax({
        type: "POST",
        url: "<?php echo url('index/reply'); ?>",
        dataType: "json",
        data: {uid:uid,'tid': topic_id, lid:"<?php echo $live['id']; ?>",'contents': contents, 'reply_ways': reply_ways},
        beforeSend: function () {
        },
        success: function (data) {
          //  console.log(data);
        if (data.status == 1) {
                closeNMB('send_pl_container');
                index_add_cnmb_pl(topic_id, data.pl_username, data.pl_avatar, data.pl_content, data.pl_time, data.pl_id, data.pl_uid, data.topic_content, data.pl_time_advance);
                //                    window.location="///default?aid=//&&reply=success";
                localhost_page_jump(0);
                //                    getMoreRepies();
        } else if(data.status == 2) {
                   if (data.isapp){
                        connectSQJavascriptBridge(function(){
                            sq.login(function(userInfo){
                               // alert(JSON.stringify(userInfo));
                                if(userInfo.errmsg){
                                    document.location.reload();
                                }
                            });
                         });
                    } else{
                    document.location.href = data.url;
                    }
        }else{
               alert(data.msg);
        }
        },
        error: function (data) {
        alert(data.msg);
        }
});
}

        function closeNMB(obj) {
		$('.video_text').html(videohtml);
        if (obj == 'video_container' || obj == 'send_pl_container') {
        var objss = '#' + obj;
                $(objss).hide(100);
        } else {
        var this1 = $(obj);
                this1.parents('.parent_container').hide(100);
        }
        }

    function index_add_cnmb_pl(topic_id, pl_username, pl_avatar, pl_content, pl_time, pl_id, pl_uid, topic_content, pl_time_advance) {
            var html = '';
            html += '<li class="li-b" data-time="' + pl_time + '" id="replyid' + pl_id + '">' +
                    '<div class="main">' +
                    '<div class="clearfix leave_bg">' +
                    '<img src="' + pl_avatar + '" alt="" class="user_img" />' +
                    '<div class="right_con">' +
                    '<div class="line clearfix">' +
                    '<p class="name flooer_name">' + pl_username + '</p>' +
                    '<p class="time">' + pl_time_advance + '</p>' +
                    '</div>' +
                    '<div class="detail">' + pl_content + '</div>' + topic_content +
                    '<div class="tools clearfix">' +
                    '<div class="fr clearfix">' +
                    '<span class="zan tnzan" onclick="ilikeid(this,"reply")" likeid="' + pl_id + '">0</span>' +
                    '<span class="comment" onclick="addReply(this,' + pl_id + ')" parent_id="' + pl_id + '" parent_uid="' + pl_uid + '" parent_username="' + pl_username + '">回复</span>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</li>';
            $("#replies_list").find('ul input[name=page]').after(html);
    }
    
     
        </script>
    </body>
    <script type="text/javascript" src="__STATIC__/live/js/common.js"></script>
</html>