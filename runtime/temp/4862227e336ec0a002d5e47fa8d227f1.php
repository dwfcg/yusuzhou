<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:65:"D:\phpStudy\WWW\yusuzhou/application/auction\view\index\bond.html";i:1524102213;}*/ ?>
<!doctype html>
<html>

	<head>
		<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta charset="utf-8">
		<meta name="format-detection" content="telephone=no" />
		<script type="text/javascript" src="__STATIC__/live/js/jquery-2.1.0.js"></script>
		<title>竞拍保证金</title>
		<style>
		   *{
		       padding: 0;
		       margin: 0;
		       
		   }
		   body{
		       background-color: #f7f7f7;
		       font-size: 12px;
		   }
		   .bzj{
		       display: flex;
		       background: #fff;
	           padding: 0 1rem;
	           border-bottom: 1px solid #ededed;
		   }
		   .yjn,.zongjia{
		       padding: 1rem 0;
		       flex:1;
		   }
		   .yjn{
		       border-right: 1px solid #ededed;
		   }
		   .zongjia{
		       padding-left: 1rem;
		   }
		   .yjn p,.zongjia p{
		       padding-top:.8rem;
		       color: #e61919;
		   }
		   .yjn_title{
		       color: #909090;
		       padding:1rem;
		   }
		   .yjn_top{
		       width: 100%;
		       display: table;
		       background:#fff;
		       color: #6b6b6b;
		       height: 3.2rem;
		       line-height: 3.2rem;
		       border-bottom: #ededed;
		        position: relative;
		   }
		   
		   .yjn_tbox{
		      
		       text-align: center;
		       display: table-cell;
		   }
		   .black{
		       color: #000;
		   }
		   .moren{
		       left: 0;
		       top: 0;
		       width: 100%;
		       height: 100%;
		       position: absolute;
		       opacity: 0;
		   }
		   .yjn_top .check{
		       width: 3rem;
		       background: url('__STATIC__/home/image/check.png') no-repeat center;
		       background-size: 1.5rem;
		   }
		   .on .check{
		       background: url('__STATIC__/home/image/dui.png') no-repeat center;
		       background-size: 1.5rem;
		   }
		   .qzf{
		       width: 80%;
		       height: 2.5rem;
		       border-radius: 3rem;
		       color: #fff;
		       background-color: #e61717;
		       line-height: 2.5rem;
		       text-align: center;
		       margin:3rem auto;
		   }
		   .content{
		       padding:0 1rem;
		   }
		</style>
	</head>

	<body>
		<div class="main-home">
		    <div class="canyu">
		        
		    </div>
		    <div class="bzj">
		        <div class="yjn">
		            已缴纳保证金
		            <p>￥<?php echo $user['bond']; ?></p>
		        </div>
		        <div class="zongjia">
		            可出价总额
		            <p>￥<?php echo $user['bond_price']; ?></p>
		        </div>
		    </div>
		    <div class="yjnbzj">
		        <div class="yjn_title">
		            已缴纳保证金
		        </div>
		        <div class="yjn_top">
		            <div class="yjn_tbox">
		                保证金金额
		            </div>
		            <div class="yjn_tbox">
		                可出价总额
		            </div>
		            <div class="yjn_tbox">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
		        </div>
		        
		        <?php if(is_array($config['rule']) || $config['rule'] instanceof \think\Collection || $config['rule'] instanceof \think\Paginator): $i = 0; $__LIST__ = $config['rule'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
		        <div class="yjn_top">
		            <div class="yjn_tbox black">
		                ￥<?php echo $key; ?>
		            </div>
		            <div class="yjn_tbox black">
		                ￥<?php echo $v; ?>
		            </div>
		            <div class="yjn_tbox check "></div>
		            <input type="radio" name="money" class="moren" value="<?php echo $key; ?>"/>
		        </div>
		        <?php endforeach; endif; else: echo "" ;endif; ?>
		        
		    </div>
		    <div class="qzf">
		        去支付
		    </div>
		    <div class="content">
		        <?php echo $config['rule_info']; ?>
		    </div>
		</div>
		<script type="text/javascript" src="__STATIC__/home/js/api.js?113"></script>
        <script type="text/javascript">
            apiready = function() { 
                
            }
		    $(".yjn_top").click(function(){
		        $(".yjn_top").removeClass('on');
		        $(this).addClass('on');
		    });
		    
		    $(".qzf").click(function(){
		        var money = $("input[type='radio']:checked").val();
		        if(!money){
		            alert('请选择保证金');
		            return false;
		        }
		        $api.openLogin();
		         $.ajax({
                    type:'post',
                    url:"<?php echo url('index/ajax_bzj'); ?>",
                    data:{'money':money},
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