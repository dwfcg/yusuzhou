<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:63:"D:\phpStudy\WWW\yusuzhou/application/live\view\index\index.html";i:1524102223;}*/ ?>
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
		<link rel="stylesheet" href="__STATIC__/home/layer/need/layer.css" />
		<!-- Swiper JS -->
		<script src="__STATIC__/live/js/swiper-3.4.1.jquery.min.js"></script>
        
		<title>互动直播</title>
	
	
		
		<style>
		    .tHome ul.living{
		        padding: 0 0;
		    }
		    .tHome ul.living li{
		        margin-top:20px;
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
		</style>
	</head>

	<body>
		<div class="main-home">
		
			<!--silder end-->

			<div class="tHome clearfix">
				<?php if($lives): ?>
			
				<ul class="clearfix living" id="container">
					<?php if(is_array($lives) || $lives instanceof \think\Collection || $lives instanceof \think\Paginator): $i = 0; $__LIST__ = $lives;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
					<li>
						<a href="<?php echo url('index/live',array('lid'=>$v['id'])); ?>" class="link" data-title="<?php echo $v['title']; ?>">
							<div class="imgBox" style="background-image:url(<?php echo $v['img']; ?>);">
							    <div class="num"><span class="huifang">回放</span><?php echo $v['partake']; ?>人气</div>
								<!--<div class="state"><i>正</i><i>在</i><i>直</i><i>播</i></div>-->
								<div class="info">
							
								</div>
							</div>
							<p class="f12"><span class="right"><?php echo date("Y-m-d",$v['addtime']); ?></span><?php echo $v['title']; ?></p>
						</a>
					</li>
					<div class="h2"></div>
					<?php endforeach; endif; else: echo "" ;endif; ?>
					
				</ul>
				<?php endif; ?>
				
			</div>
		</div>
	</body>
	<script type="text/javascript" src="__STATIC__/home/js/api.js?1"></script>
	<script type="text/javascript" src="__STATIC__/home/js/layer/layer.js?1"></script>
	<script>

		apiready = function () {
		    $(".link").on('click',function(){
		         var url ="http://yusuzhou.youacloud.com/"+$(this).attr('href');
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