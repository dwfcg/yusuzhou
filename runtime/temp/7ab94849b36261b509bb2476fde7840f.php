<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:66:"D:\phpStudy\WWW\yusuzhou/application/auction\view\index\index.html";i:1534470204;}*/ ?>
<!doctype html>

<html>



	<head>

		<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<meta charset="utf-8">

		<meta name="format-detection" content="telephone=no" />

		<link rel="stylesheet" href="__STATIC__/live/css/style1.css" />

		<script type="text/javascript" src="__STATIC__/live/js/jquery-2.1.0.js"></script>



		<!-- Swiper CSS -->

		<link rel="stylesheet" href="__STATIC__/live/css/swiper-3.4.1.min.css" />

	

		<!-- Swiper JS -->

		<script src="__STATIC__/live/js/swiper-3.4.1.jquery.min.js"></script>

		<title>竞拍</title>

		<style>

		    .tHome ul.living{

		        padding: 0 0;

		    }

		    .tHome ul.living li{

		        margin-top:10px;

		        padding: 0 10px;

		    }

		    .right{

		        float: right;

		        color: #999;

		    }

		    .num{

		        font-size: 10px;

		        max-width: 100%;

		        position: absolute;

		        padding-right: 20px;

		        line-height: 25px;

		        text-align: center;

		        height: 25px;

		        border-radius: 25px;

		        background: rgba(0,0,0,0.2);

		        color: #b2b1b1;

		        left: 10px;

		        top:10px;

		    }  

		    .huifang{

		        font-size: 10px;

		        margin-right: 10px;

		        display: block;

		        float: left;

		        width: 50px;

		        border-radius: 25px;

		        line-height: 25px;

		        text-align: center;

		        height: 25px;

		        background: #14b151;

		        color: #fff;

		    }

		    .h2{

		        height: 8px;

		        background: #efefef;

		    }

		    .f12{

		        padding: 5px 0px 10px 0;

		    }

		    .paimai{

		        margin-top: 5px;

		        margin-bottom: 5px;

		    }

		    .pm_status,.pm_time{

		        float: left;

		    }

		    .pm_status{

		        background: #e61717;

		        color: #fff;

		        padding:2px 5px;

		        margin-right: 10px;

		        font-size: 12px;

		    }

		    .pm_time{

		        color: #e61717;

		        line-height: 30px;

		        font-size: 14px;

		    }

		    .tHome ul.living .imgBox{

		        display: flex;

		        padding-bottom: 10px;

		    }

		    .imgBox .img{

		        flex:1;

		    }

		    .imgBox .img img{

		        width:94%;

		    }

		</style>

	</head>



	<body>

		<div class="main-home">

		

			<!--silder end-->



			<div class="tHome clearfix">

				<?php if($goods): ?>

			

				<ul class="clearfix living" id="container">

					<?php if(is_array($goods) || $goods instanceof \think\Collection || $goods instanceof \think\Paginator): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>

					<li>

						<a href="<?php echo url('index/detail',array('gid'=>$v['id'])); ?>" class="link" data-title="<?php echo $v['title']; ?>">

						    <div class="f14"><span class="right">￥<?php echo $v['price']; ?></span><?php echo $v['title']; ?></div>

						    <div class="paimai clearfix">

						        <span class="right"><?php echo $v['count']; ?>次出价</span>

						        <div class="pm_status"><?php if($v['pm_status'] == 1): ?>拍卖中<?php elseif($v['pm_status'] == 3): ?>预展中<?php elseif($v['pm_status'] == 2): ?>已结束<?php endif; ?> </div>

						        <div class="pm_time"> <?php if($v['pm_status'] == 1): ?>距结束<?php elseif($v['pm_status'] == 2): ?>距开始<?php endif; ?></div>

						    </div>

							<div class="imgBox">

							    <?php if(is_array($v['imgs']) || $v['imgs'] instanceof \think\Collection || $v['imgs'] instanceof \think\Paginator): if( count($v['imgs'])==0 ) : echo "" ;else: foreach($v['imgs'] as $key=>$i): ?>

							     <div class="img"><img src="<?php echo $i; ?>" /></div> 

							    <?php endforeach; endif; else: echo "" ;endif; ?>

							     

							</div>

							<!--<p class="f12"><span class="right">111次出价</span>拍卖中</p>-->

						</a>

					</li>

					<div class="h2"></div>

					<?php endforeach; endif; else: echo "" ;endif; ?>

					

				</ul>

				

				<?php else: ?>

				<div style="text-align:center; padding:200px 0;">暂无拍卖品</div>

				<?php endif; ?>

				

			</div>

		</div>

	</body>

	<script type="text/javascript" src="__STATIC__/home/js/api.js?1"></script>

	<script type="text/javascript" src="__STATIC__/home/js/layer/layer.js?1"></script>

	<script>



		apiready = function () {

		    $(".link").on('click',function(){

		         var url ="http://yu.7dcms.com"+$(this).attr('href');

		         var title = $(this).attr('data-title');

		         $api.openPage({

        		    	title: title,

        		    	name: 'live',

        		    	url: url

        			})

		         return false;

		    });

		   

		};

           var page_count = <?php echo $page; ?>;

           load_data('#container',page_count,{page_count},'<?php echo url('index/ajax_live'); ?>',{body_main:'#container',doc_main:'body'},

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

                     loading_item = layer.open({

                                content:'\u6b63\u5728\u52a0\u8f7d\u002e\u002e\u002e',

                                skin: 'msg',

                            });

                    $.ajax({

                        type:'post',

                        url:data_url,

                        data:$.extend(datas,{start:iNowPage*5}),

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

</html>