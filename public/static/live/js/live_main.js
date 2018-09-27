(function(a) {
	a.fn.extend({
		minTipsBox: function(b) {
			b = a.extend({
				tipsContent: "",
				tipsTime: 1
			}, b);
			var c = 1E3 * parseFloat(b.tipsTime);
			0 < a(".min_tips_box").length ? a(".min_tips_box").show() : a('<div class="min_tips_box"><b class="bg"></b><span class="tips_content"></span></div>').appendTo("body");
			(function() {
				a(".min_tips_box .tips_content").html(b.tipsContent);
				var c = a(".min_tips_box .tips_content").width() / 2 + 10;
				a(".min_tips_box .tips_content").css("margin-left", "-" + c + "px")
			})();
			setTimeout(function() {
				a(".min_tips_box").hide()
			}, c)
		}
	})
})(jQuery);
String.prototype.HttpHtml = function(){
	var reg = /(http:\/\/|https:\/\/)((\w|=|\?|\.|\/|&|-)+)/g;
	return this.replace(reg, '<a href="$1$2">$1$2</a>');
};

Date.prototype.format =function(format)
{
    var o = {
    	"M+" : this.getMonth()+1, //month
		"d+" : this.getDate(),    //day
		"h+" : this.getHours(),   //hour
		"m+" : this.getMinutes(), //minute
		"s+" : this.getSeconds(), //second
		"q+" : Math.floor((this.getMonth()+3)/3),  //quarter
		"S" : this.getMilliseconds() //millisecond
    }
    if(/(y+)/.test(format)) format=format.replace(RegExp.$1,
    (this.getFullYear()+"").substr(4- RegExp.$1.length));
    for(var k in o)if(new RegExp("("+ k +")").test(format))
    format = format.replace(RegExp.$1,
    RegExp.$1.length==1? o[k] :
    ("00"+ o[k]).substr((""+ o[k]).length));
    return format;
}
function showTips(text,seconds){
	$(".textTip").show();
	$(".textTip").children("p").text(text);
	setTimeout(function(){
		$(".textTip").hide();
	},seconds);
}
/*微信支付开始*/
function jsApiCall(parameters){
	var jsdata=JSON.parse(parameters.jsdata);
	debugger;
	WeixinJSBridge.invoke('getBrandWCPayRequest',jsdata,function(res){
	   WeixinJSBridge.log(res.err_msg);
	   if(res.err_msg == "get_brand_wcpay_request:ok") {
			$.getJSON(location.href,{id:parameters.id,active_id:parameters.active_id,op:"pay"},function(result){
				  if(result.success==1){
					  if(result.vodid==undefined || result.vodid==null){
						  location.href=jumpurl+"&active_id="+result.active_id+"&a=1";
					  }else{
						  location.href=jumpurl+"&active_id="+result.active_id+"&a=1&vod_id="+result.vodid;
					  }
				  }else{
					  showTips("支付失败，请重试",2000);
					  location.href=location.href+"&a=1";//刷新页面
				  }
		  	});
       }else if(res.err_msg == "get_brand_wcpay_request:cancel"){
    	   
       }else{
       	  alert(res.err_msg);
       }
	});
}


var clock_index=0,currentPlaying=null,avatar=user_info.headimgurl,nickname=user_info.nickname;
	var clock_handler=null,current_voiclocalid=null,globalObj=new Object();
	WEB_SOCKET_DEBUG = true;globalObj.chat_images=[];
	var ws, name=user_info.nickname, client_list={};
    var is_firstload=1;
    var is_autoplay=false;
    var fnTimeCountDown = function(d, o){
    	var f = {
    		haomiao: function(n){
    			if(n < 10)return "00" + n.toString();
    			if(n < 100)return "0" + n.toString();
    			return n.toString();
    		},
    		zero: function(n){
    			var n = parseInt(n, 10);//解析字符串,返回整数
    			if(n > 0){
    				if(n <= 9){
    					n = "0" + n;	
    				}
    				return String(n);
    			}else{
    				return "00";	
    			}
    		},
    		dv: function(){
    			//d = d || Date.UTC(2050, 0, 1); //如果未定义时间，则我们设定倒计时日期是2050年1月1日
    			var now = new Date();
    			//现在将来秒差值
    			//alert(future.getTimezoneOffset());
    			var dur = (d - now.getTime()) / 1000 , mss = d - now.getTime() ,pms = {
    				hm:"000",
    				sec: "00",
    				mini: "00",
    				hour: "00",
    				day: "00",
    				month: "00",
    				year: "0"
    			};
    			if(mss > 0){
    				pms.hm = f.haomiao(mss % 1000);
    				pms.sec = f.zero(dur % 60);
    				pms.mini = Math.floor((dur / 60)) > 0? f.zero(Math.floor((dur / 60)) % 60) : "00";
    				pms.hour = Math.floor((dur / 3600)) > 0? f.zero(Math.floor((dur / 3600)) % 24) : "00";
    				pms.day = Math.floor((dur / 86400)) > 0? f.zero(Math.floor((dur / 86400))) : "00";// % 30
    				//月份，以实际平均每月秒数计算
    				pms.month = Math.floor((dur / 2629744)) > 0? f.zero(Math.floor((dur / 2629744)) % 12) : "00";
    				//年份，按按回归年365天5时48分46秒算
    				pms.year = Math.floor((dur / 31556926)) > 0? Math.floor((dur / 31556926)) : "0";
    			}else{
    				pms.year=pms.month=pms.day=pms.hour=pms.mini=pms.sec="00";
    				pms.hm = "000";
    				//location.reload(true);
    				return;
    			}
    			return pms;
    		},
    		ui: function(){			
    			if(o.hm){
    				o.hm.html(f.dv().hm);
    			}
    			if(o.sec){
    				o.sec.html(f.dv().sec);
    			}
    			if(o.mini){
    				o.mini.html(f.dv().mini);
    			}
    			if(o.hour){
    				o.hour.html(f.dv().hour);
    			}
    			if(o.day){
    				o.day.html(f.dv().day);
    			}
    			if(o.month){
    				o.month.html(f.dv().month);
    			}
    			if(o.year){
    				o.year.html(f.dv().year);
    			}			
    			setTimeout(f.ui, 1);			
    		}
    	};	
    f.ui();
   };
  //初始化表情
   var EmotionDic={};
   function initEmotionUL() {
	   
        for (var index in webim.Emotions) {
            var emotions = $('<img>').attr({
                "id": webim.Emotions[index][0],
                "src": webim.Emotions[index][1],
                "style": "cursor:pointer;"
            }).click(function () {
                selectEmotionImg(this);
            });
            $('<li>').append(emotions).appendTo($('#emoj_list'));
            var dic_key=webim.Emotions[index][0];

            var dic_val=webim.Emotions[index][1];
            var my_dic={};
            EmotionDic[dic_key]=dic_val;
        }
        
        $("#emoj_list li").click(function(){
        	
        	if(globalObj.emojbox)
        	$("."+globalObj.emojbox).val($("."+globalObj.emojbox).val()+$(this).find('img').attr('id'));
        	$(".p-more").css("display", "none");
			$(".p-send-btn").css("display", "block");
        	//$("#enterfont").val($("."+globalObj.emojbox).val()+$(this).find('img').attr('id'));
        });
    }
   
	function TransferString(content){  
	       var string = content;  
	       try{  
	           string=string.replace(/\r\n/g,"<br>")  
	           string=string.replace(/\n/g,"<br>");  
	       }catch(e) {  
	           alert(e.message);  
	       }  
	       return string;  
	}
    /*转换为标签*/
    function convertEmotion(str){
    	if(str==""){return "";}
    	var reg = new RegExp('\\[(.+?)\\]',"g");
    	var matchs=str.match(reg);
    	if(matchs){
	    	for(i=0;i<matchs.length;i++){
	    		str=str.replace(matchs[i],"<img style='float:left;' src='" + EmotionDic[matchs[i]] + "'/>");
	    	}
    	}
       str=str.HttpHtml();
       str=TransferString(str);
       return str; 
    }
    /*表情面板*/
    function showEmotionDialog(target){
    	$(".control_emojbox").toggleClass('on')
    	//$(".control_emojbox").css({'bottom':'0.1rem'});
		globalObj.emojbox="speakInput";
    }
	//当前正在播放语音信息
	function startRec(){
		$(".second_dd var").eq(0).text(clock_index);
		clock_index++;
		if(clock_index==59){
			clock_index=60;
			$("#btnStopRec").click();
		}
	}
		
	function get_contenthtml(tcpdata){
		var text="";
    	if(tcpdata.msgtype=='text'){
			text='<dd class="left_bubble hasTime" msg_id="'+tcpdata.msg_id+'" id="msg_'+tcpdata.msg_id+'">';
			text+='<div class="lc-item">';
				text+='<div class="lc-container flex2">';
					text+='<div class="lc-info">';
						text+='<div class="avatar">';
						text+='<img src="'+tcpdata.headimg+'" width="100%" height="100%">';
					text+='</div>';
				text+='</div>';
				text+='<div class="lc-info-main sub">';
					text+='<div class="lc-name gray">';
						text+='<span class="fr f12">'+tcpdata.time+'</span>';
						text+=tcpdata.from_client_name;
					text+='</div>';
					text+='<div class="lc-box">';
						text+='<p>'+convertEmotion(tcpdata.content)+'</p>';
					text+='</div>';
					text+='</div>';
				text+='</div>';
			text+='</div>';
			text+='</dd>';
    	}
		if(tcpdata.msgtype=='voice'){
			
			 var voice_class=getRecordClass(tcpdata.last);
				text='<dd class="left_bubble hasTime" msg_id="'+tcpdata.msg_id+'" id="msg_'+tcpdata.msg_id+'">';
				   text+=' <div class="lc-item">';
				   text+='<div class="lc-container flex2">';
					   text+='<div class="lc-info">';
						   text+='<div class="avatar">';
							   text+='<img src="'+tcpdata.headimg+'" width="100%" height="100%">';
								   text+='</div>';
									   text+='</div>';
										   text+='<div class="lc-info-main sub">';
											   text+='<div class="lc-name gray">';
												   text+='<span class="fr f12">'+tcpdata.time+'</span>';
												   text+=tcpdata.from_client_name;
								text+='</div>';
//								text+='<div>';
//									text+='<audio style="width:200px;" src="'+tcpdata.content+'" controls="controls">您的浏览器不支持 audio 标签。</audio>';
//							    text+='</div>';
								text+='<div class="lc-box lc-voice '+voice_class+'" attr-src="'+tcpdata.content+'">';
									text+=tcpdata.last;
								text+='</div>';
								
									text+='</div>';
										text+='</div>';
											text+='</div>';
				text+='</dd>';
		}
		
		if(tcpdata.msgtype=='image'){
			text='<dd class="left_bubble hasTime" msg_id="'+tcpdata.msg_id+'" id="msg_'+tcpdata.msg_id+'">';
				text+='<div class="lc-item">';
					text+='<div class="lc-container flex2">';
						text+='<div class="lc-info">';
							text+='<div class="avatar">';
								text+='<img src="'+tcpdata.headimg+'" width="100%" height="100%">';
							text+='</div>';
						text+='</div>';
						text+='<div class="lc-info-main sub">';
							text+='<div class="lc-name gray">';
								text+='<span class="fr f12">'+tcpdata.time+'</span>';
								text+=tcpdata.from_client_name;
							text+='</div>';
							text+='<div class="lc-box album">';
								text+='<ul class="is-one flex clearfix">';
									text+='<li  mediaid="'+tcpdata.content+'">';
									text+='<img class="chat_img" src="'+tcpdata.content+'" >';
									text+='</li>';
								text+='</ul>';
							text+='</div>';
						text+='</div>';
					text+='</div>';
				text+='</div>';
			text+='</dd>';
		}
		
		if(tcpdata.msgtype=='ask'){
			try{
				var Question=JSON.parse(tcpdata.content);
				text='<dd class="left_bubble hasTime" msg_id="'+tcpdata.msg_id+'" id="msg_'+tcpdata.msg_id+'">';
				text+='<div class="speak_time">'+tcpdata.time+'</div>';
				text+='<div class="head_portrait"><img src="'+tcpdata.headimg+'"></div>';
				text+='<div class="speaker_name"><b>'+tcpdata.from_client_name+'</b>'+tcpdata.role_name+'</div>';
				text+='<div class="bubble_content "><p><b>'+Question.N+':</b><em class="ask_label">问</em>'+Question.Q+'</p><p><b>回复:</b>'+Question.replay+'</p></div>';
				if(tcpdata.revoke&&(user_info.is_manager||user_info.is_guest))
				text+='<a class="btn_revoke" href="javascript:;"></a>';
				if(data_setting.reward_status==1)
				  text+='<a class="btn_ilike" href="javascript:;">赏</a>';
				text+='</dd>';
			}
			catch(e){
				text="";
				console.dir(e);
			}
		}
		return text;
	}
	
	//获取评论信息分页
	function get_discontenthtml(tcpdata){
		var text="";
    	if(tcpdata.msgtype=='text'){
			text='<dd class="left_bubble hasTime" msg_id="'+tcpdata.msg_id+'" id="msg_'+tcpdata.msg_id+'">';
			text+='<div class="lc-item">';
				text+='<div class="lc-container flex2">';
					text+='<div class="lc-info">';
						text+='<div class="avatar">';
						text+='<img src="'+tcpdata.headimg+'" width="100%" height="100%">';
					text+='</div>';
				text+='</div>';
				text+='<div class="lc-info-main sub">';
					text+='<div class="lc-name gray">';
						text+='<span class="fr f12">'+tcpdata.time+'</span>';
						text+=tcpdata.from_client_name;
					text+='</div>';
					text+='<div class="lc-box">';
						text+='<p>'+convertEmotion(tcpdata.content)+'</p>';
					text+='</div>';
					text+='</div>';
				text+='</div>';
			text+='</div>';
			text+='</dd>';
    	}
		if(tcpdata.msgtype=='voice'){
			
			 var voice_class=getRecordClass(tcpdata.last);
				text='<dd class="left_bubble hasTime" msg_id="'+tcpdata.msg_id+'" id="msg_'+tcpdata.msg_id+'">';
				   text+=' <div class="lc-item">';
				   text+='<div class="lc-container flex2">';
					   text+='<div class="lc-info">';
						   text+='<div class="avatar">';
							   text+='<img src="'+tcpdata.headimg+'" width="100%" height="100%">';
								   text+='</div>';
									   text+='</div>';
										   text+='<div class="lc-info-main sub">';
											   text+='<div class="lc-name gray">';
												   text+='<span class="fr f12">'+tcpdata.time+'</span>';
												   text+=tcpdata.from_client_name;
								text+='</div>';
//								text+='<div>';
//									text+='<audio style="width:200px;" src="'+tcpdata.content+'" controls="controls">您的浏览器不支持 audio 标签。</audio>';
//							    text+='</div>';
								text+='<div class="lc-box lc-voice '+voice_class+'" attr-src="'+tcpdata.content+'">';
									text+=tcpdata.last;
								text+='</div>';
								
									text+='</div>';
										text+='</div>';
											text+='</div>';
				text+='</dd>';
		}
		
		if(tcpdata.msgtype=='image'){
			text='<dd class="left_bubble hasTime" msg_id="'+tcpdata.msg_id+'" id="msg_'+tcpdata.msg_id+'">';
				text+='<div class="lc-item">';
					text+='<div class="lc-container flex2">';
						text+='<div class="lc-info">';
							text+='<div class="avatar">';
								text+='<img src="'+tcpdata.headimg+'" width="100%" height="100%">';
							text+='</div>';
						text+='</div>';
						text+='<div class="lc-info-main sub">';
							text+='<div class="lc-name gray">';
								text+='<span class="fr f12">'+tcpdata.time+'</span>';
								text+=tcpdata.from_client_name;
							text+='</div>';
							text+='<div class="lc-box album">';
								text+='<ul class="is-one flex clearfix">';
									text+='<li  mediaid="'+tcpdata.content+'">';
									text+='<img class="chat_img" src="'+tcpdata.content+'" >';
									text+='</li>';
								text+='</ul>';
							text+='</div>';
						text+='</div>';
					text+='</div>';
				text+='</div>';
			text+='</dd>';
		}
		return text;
	}

	//根据时间长度获取对应显示语音宽度
	function getRecordClass(last_second){
		if(last_second<12)
			return "recordwid1";
		else if(last_second>=12 && last_second<24)
			return "recordwid2";
		else if(last_second>=24 && last_second<36)
			return "recordwid3";
		else if(last_second>=36 && last_second<48)
			return "recordwid4";
		else if(last_second>48)
			return "recordwid5";
		else 
			return "recordwid1";
	}
	
	/*声音播放完毕事件*/
	function voicePlayOver(){
		$(".lc-voice").removeClass("active");
		if(globalObj.voicePlaying){
			globalObj.voicePlaying.removeClass("isPlaying");
			globalObj.voicePlaying.addClass("isReaded ");
			globalObj.isPlaying=false;
			var msg_id=globalObj.voicePlaying.parents('dd').attr('msg_id');
			$(".recordingMsg").each(function(){
				if(parseInt($(this).parents('dd').attr('msg_id'))>parseInt(msg_id)){
					$(this).click();
					return false;
				}
			});
		}
	}
	
   function stopEventBubble(event){
        var e=event || window.event;
        if (e && e.stopPropagation){
            e.stopPropagation();    
        }
        else{
            e.cancelBubble=true;
        }
    }
   
	/*下载语音事件*/
	function voiceDown(){
		$(".lc-voice").unbind();
		$(".lc-voice").click(function(e){
			stopEventBubble(e);
			var recordMsg=$(this);
			var voice_str=recordMsg.attr('attr-src');
    		$(".isPlaying").removeClass('isPlaying');
    		var attr_voice=recordVoice.attr('attr-src');
    		
    		if(attr_voice&&attr_voice.indexOf('http')==0){
    			if($("#audioPlayer").attr('src')!=attr_voice)
    		  	   $("#audioPlayer").attr('src',attr_voice);
    		  	var media = $('#audioPlayer')[0];
    		  	if(media.paused) { 
    		  		media.play();
    		  		recordMsg.addClass("isPlaying");
    		  		globalObj.isPlaying=true;
    		    } else {  
    		    	media.pause(); 
    		    	recordMsg.removeClass('isPlaying')
    		    }
    		  	globalObj.voicePlaying=recordMsg;
    		  	media.removeEventListener("ended",voicePlayOver,false);
    		  	media.addEventListener("ended",voicePlayOver,false);
    		  	//ppt2
    		  	return;
    		} 
    		  		
    		if(recordMsg.attr("localid")){
    		    var localId=recordMsg.attr("localid");
    		    if($(this).hasClass('active')){
    		    	wx.pauseVoice({
    		    	    localId: localId // 需要暂停的音频的本地ID，由stopRecord接口获得
    		    	});
    		    	$(this).removeClass('active')
    		    }else{
    		    	wx.playVoice({
    		    	    localId: localId // 需要播放的音频的本地ID，由stopRecord接口获得
    		    	});
    		    	$(this).addClass("active");
    		    	wx.onVoicePlayEnd({
    		    	    success: function (res) {
    		    	    	recordMsg.removeClass("active");
    		    	    }
    		    	});
    		    }
    		    return;	 
    		 }
     		
 			wx.downloadVoice({
 				    serverId: recordVoice.attr('attr-src'), // 需要下载的音频的服务器端ID，由uploadVoice接口获得
 				    success: function (res) {
 				        var localId = res.localId; // 返回音频的本地ID
 				        recordMsg.addClass("isPlaying");
 				        recordVoice.attr('localid',localId);
 				        wx.playVoice({
 				            localId: localId // 需要播放的音频的本地ID，由stopRecord接口获得
 				        });
 				        globalObj.isPlaying=true;
 				        
 				        wx.onVoicePlayEnd({
 				    	    success: function (res) {
 				    	    	recordMsg.removeClass("isPlaying");
 				    	    	recordMsg.addClass("isReaded ");
 				    	    	globalObj.isPlaying=false;
 				    	    }
 				    	});
 				    }
 				});  
		 });
	}
	
	//上传语音接口
    function uploadVoic(localId){
		wx.uploadVoice({
		    localId: localId, // 需要上传的音频的本地ID，由stopRecord接口获得
		    isShowProgressTips: 1, // 默认为1，显示进度提示
		    success: function (res) {
			    var serverId = res.serverId; // 返回音频的服务器端ID
			    
	 	        var jsonObj = {type:"say",target:$("#tabval").val(),msgtype:"voice",headimg:avatar,"last":clock_index,"from_client_name":user_info.nickname,content:serverId};
			    sentContent(jsonObj);
				clock_index=0; 
				current_voiclocalid=null;
		    }
		});
	}

    /*保存信息*/
	function sentContent(json_data){
		var posturl=location.href;
		
		$.post(posturl,json_data,function(result){
			
			if(result.success==-1){
				alert(result.data);
				return;
			}
			
			json_data.msg_id=result.msg_id;
			json_data.time=new Date().format('MM/dd hh:mm:ss');
			json_data.uid=user_info.uid;
			onSendMsg(JSON.stringify(json_data));
			globalObj.reward=null;
			globalObj.reward_last=null;
			if(json_data.target=='discuss'){
				$(".btnCommentCancel").click();
			}
			document.getElementById('i-container').scrollTop = document.getElementById('i-container').scrollHeight+150;
		});
	}
	 // 服务端发来消息时
	 function onmessage(e){
		 
		    	//console.log(e.data);
		        var data = JSON.parse(e.data);
		        switch(data['type']){
		            case 'ping':
		                onSendMsg('{"type":"pong"}');
		                break;
		            case 'login':
		            	if(tcpdata.revoke&&(user_info.is_manager||user_info.is_guest))
		            	   $(".qlOLPeople").text(data['users']);
		            	else
	            	   $(".qlOLPeople").text(parseInt($(".qlOLPeople").text())+1);
	                break;
	            case 'say':
	            	if(data.target=='main'){
	            		var msg_last=$("#speakBubbles").find('dd').last();
	            		if(msg_last.size()>0&&data.msg_id){
	            			if(msg_last.attr('msg_id')<data.msg_id){
	            				say(data);
	            			}
	            		}else{
	                        say(data);
	            		}
	            		voicePlay();
	            	}
	            	else{
	            		say_discuss(data);
	            	}
	                break;
	            case 'logout':
	                break;
	            case 'tipmsg':
	            	if(tcpdata.revoke&&(user_info.is_manager||user_info.is_guest))
		            	 $(".qlOLPeople").text(data['users']);
	        }
	    }
 
 		//讨论
		function say_discuss(tcpdata){
			var text="";
	    	if(tcpdata.msgtype=='text'){
				text='<dd class="left_bubble hasTime" msg_id="'+tcpdata.msg_id+'" id="msg_'+tcpdata.msg_id+'">';
					text+='<div class="lc-item">';
						text+='<div class="lc-container flex2">';
							text+='<div class="lc-info">';
								text+='<div class="avatar">';
								text+='<img src="'+tcpdata.headimg+'" width="100%" height="100%">';
							text+='</div>';
						text+='</div>';
						text+='<div class="lc-info-main sub">';
							text+='<div class="lc-name gray">';
								text+='<span class="fr f12">'+tcpdata.time+'</span>';
								text+=tcpdata.from_client_name;
							text+='</div>';
							text+='<div class="lc-box">';
								text+='<p>'+convertEmotion(tcpdata.content)+'</p>';
							text+='</div>';
							text+='</div>';
						text+='</div>';
					text+='</div>';
				text+='</dd>';
	    	}
	    	
			if(tcpdata.msgtype=='voice'){
				 var voice_class=getRecordClass(tcpdata.last);
					text='<dd class="left_bubble hasTime" msg_id="'+tcpdata.msg_id+'" id="msg_'+tcpdata.msg_id+'">';
					   text+=' <div class="lc-item">';
					   text+='<div class="lc-container flex2">';
						   text+='<div class="lc-info">';
							   text+='<div class="avatar">';
								   text+='<img src="'+tcpdata.headimg+'" width="100%" height="100%">';
									   text+='</div>';
										   text+='</div>';
											   text+='<div class="lc-info-main sub">';
												   text+='<div class="lc-name gray">';
													   text+='<span class="fr f12">'+tcpdata.time+'</span>';
													   text+=tcpdata.from_client_name;
									text+='</div>';
//										text+='<div>';
//											text+='<audio style="width:200px;" src="'+tcpdata.content+'" controls="controls">您的浏览器不支持 audio 标签。</audio>';
//										text+='</div>';
										text+='<div class="lc-box lc-voice '+voice_class+'" attr-src="'+tcpdata.content+'">';
											text+=tcpdata.last;
										text+='</div>';
									
										text+='</div>';
											text+='</div>';
												text+='</div>';
					text+='</dd>';
			}
			
			if(tcpdata.msgtype=='image'){	
				text='<dd class="left_bubble hasTime" msg_id="'+tcpdata.msg_id+'" id="msg_'+tcpdata.msg_id+'">';
					text+='<div class="lc-item">';
						text+='<div class="lc-container flex2">';
							text+='<div class="lc-info">';
								text+='<div class="avatar">';
									text+='<img src="'+tcpdata.headimg+'" width="100%" height="100%">';
								text+='</div>';
							text+='</div>';
							text+='<div class="lc-info-main sub">';
								text+='<div class="lc-name gray">';
									text+='<span class="fr f12">'+tcpdata.time+'</span>';
									text+=tcpdata.from_client_name;
								text+='</div>';
								text+='<div class="lc-box album">';
									text+='<ul class="is-one flex clearfix">';
										text+='<li  mediaid="'+tcpdata.content+'">';
										text+='<img class="chat_img"  src="'+tcpdata.content+'" >';
										text+='</li>';
									text+='</ul>';
								text+='</div>';
							text+='</div>';
						text+='</div>';
					text+='</div>';
				text+='</dd>';
			}			
	    	
			$("#commentDl").append(text); 
	    	$("#i-container").scrollTop($("#i-container")[0].scrollHeight+100);
	    	
	    	if(tcpdata.msgtype=='voice'){
		    	voiceDown();
		    	if(!globalObj.isPlaying||globalObj.isPlaying==false){
		    	   if(user_info.is_manager||user_info.is_guest){
		    		   if(is_autoplay){
		    		      $(".recordingMsg").last().click();
		    		   }
		    	   }else{
		    		   $(".recordingMsg").last().click();
		    	   }
		    	}
	    	}
	    	$(".chat_img").unbind();
	    	$(".chat_img").click(function(){
	    		if($.inArray($(this).attr('src'),globalObj.chat_images)==-1){
	    			globalObj.chat_images.push($(this).attr('src'));
	    		}
	    		wx.previewImage({
	    		    current: $(this).attr('src'), // 当前显示图片的http链接
	    		    urls: globalObj.chat_images // 需要预览的图片http链接列表
	    		});
	    	 });
	    	 voicePlay();
		}
	    // 发言
	    function say(tcpdata){
	    	tcpdata.revoke=tcpdata.uid==user_info.uid||user_info.is_manager?1:0;
	    	var text="";
	    	if(tcpdata.msgtype=='text'){
				text='<dd class="left_bubble hasTime" msg_id="'+tcpdata.msg_id+'" id="msg_'+tcpdata.msg_id+'">';
					text+='<div class="lc-item">';
						text+='<div class="lc-container flex2">';
							text+='<div class="lc-info">';
								text+='<div class="avatar">';
								text+='<img src="'+tcpdata.headimg+'" width="100%" height="100%">';
							text+='</div>';
						text+='</div>';
						text+='<div class="lc-info-main sub">';
							text+='<div class="lc-name gray">';
								text+='<span class="fr f12">'+tcpdata.time+'</span>';
								text+=tcpdata.from_client_name;
							text+='</div>';
							text+='<div class="lc-box">';
								text+='<p>'+convertEmotion(tcpdata.content)+'</p>';
							text+='</div>';
							text+='</div>';
						text+='</div>';
					text+='</div>';
				text+='</dd>';
	    	}
	    	
			if(tcpdata.msgtype=='voice'){
				 var voice_class=getRecordClass(tcpdata.last);
					text='<dd class="left_bubble hasTime" msg_id="'+tcpdata.msg_id+'" id="msg_'+tcpdata.msg_id+'">';
					   text+=' <div class="lc-item">';
					   text+='<div class="lc-container flex2">';
						   text+='<div class="lc-info">';
							   text+='<div class="avatar">';
								   text+='<img src="'+tcpdata.headimg+'" width="100%" height="100%">';
									   text+='</div>';
										   text+='</div>';
											   text+='<div class="lc-info-main sub">';
												   text+='<div class="lc-name gray">';
													   text+='<span class="fr f12">'+tcpdata.time+'</span>';
													   text+=tcpdata.from_client_name;
									text+='</div>';
//										text+='<div>';
//											text+='<audio style="width:200px;" src="'+tcpdata.content+'" controls="controls">您的浏览器不支持 audio 标签。</audio>';
//										text+='</div>';
										text+='<div class="lc-box lc-voice '+voice_class+'" attr-src="'+tcpdata.content+'">';
											text+=tcpdata.last;
										text+='</div>';
									
										text+='</div>';
											text+='</div>';
												text+='</div>';
					text+='</dd>';
			}
			
			if(tcpdata.msgtype=='image'){	
				text='<dd class="left_bubble hasTime" msg_id="'+tcpdata.msg_id+'" id="msg_'+tcpdata.msg_id+'">';
					text+='<div class="lc-item">';
						text+='<div class="lc-container flex2">';
							text+='<div class="lc-info">';
								text+='<div class="avatar">';
									text+='<img src="'+tcpdata.headimg+'" width="100%" height="100%">';
								text+='</div>';
							text+='</div>';
							text+='<div class="lc-info-main sub">';
								text+='<div class="lc-name gray">';
									text+='<span class="fr f12">'+tcpdata.time+'</span>';
									text+=tcpdata.from_client_name;
								text+='</div>';
								text+='<div class="lc-box album">';
									text+='<ul class="is-one flex clearfix">';
										text+='<li  mediaid="'+tcpdata.content+'">';
										text+='<img class="chat_img"  src="'+tcpdata.content+'" >';
										text+='</li>';
									text+='</ul>';
								text+='</div>';
							text+='</div>';
						text+='</div>';
					text+='</div>';
				text+='</dd>';
			}
			
			$("#speakBubbles").append(text); 
	    	$("#i-container").scrollTop($("#i-container")[0].scrollHeight+100);
	    	if(tcpdata.msgtype=='voice'){
		    	voiceDown();
		    	if(!globalObj.isPlaying||globalObj.isPlaying==false){
		    	   if(user_info.is_manager||user_info.is_guest){
		    		   if(is_autoplay){
		    		      $(".recordingMsg").last().click();
		    		   }
		    	   }else{
		    		   $(".recordingMsg").last().click();
		    	   }
		    	}
	    	}
	    	$(".chat_img").unbind();
	    	$(".chat_img").click(function(){
	    		
	    		if($.inArray($(this).attr('src'),globalObj.chat_images)==-1){
	    			globalObj.chat_images.push($(this).attr('src'));
	    		}
	    		wx.previewImage({
	    		    current: $(this).attr('src'), // 当前显示图片的http链接
	    		    urls: globalObj.chat_images // 需要预览的图片http链接列表
	    		});
	    	 });
	    	 voicePlay();
	  }
	  
	 /*滚动事件处理函数*/
     function scroll_func(){
    	 
    	 var scrollTop = $(this).scrollTop();
         var scrollHeight = $(this)[0].scrollHeight;
         var windowHeight = $(this)[0].clientHeight; 
         
         if (scrollTop + windowHeight+2 >= scrollHeight) {  //滚动到底部执行事件
         	if(page_object.sub_pindex<sub_pages){ 
         	  $(".btnLoadSpeakEnd").addClass("on");
         	  page_object.sub_pindex=page_object.sub_pindex+1;
         	  ajax_content(page_object.sub_pindex,"down",0);
         	}
         }
     }
     
     /*声音播放事件*/
     function voicePlay(){
     	$(".lc-voice").unbind();
     	$(".lc-voice").click(function(){
     		$(".lc-voice").removeClass("active");
     		var recordMsg=$(this);
     		var voice_str=recordMsg.attr('attr-src');

     		if(voice_str.indexOf('http')==0){
      		  	var media = $('#audioPlayer')[0];
      		  	if($("#audioPlayer").attr('src')!=voice_str)
      		  	   $("#audioPlayer").attr('src',voice_str);
      		  	if(media.paused) { 
      		  		media.play();
      		  		recordMsg.addClass("active");
      		  		globalObj.isPlaying=true;
      		    } else {  
      		    	media.pause(); 
      		    	recordMsg.removeClass('active')
      		    }
      		  	globalObj.voicePlaying=recordMsg;

      		  	media.removeEventListener("ended",voicePlayOver,false);
     		  	media.addEventListener("ended",voicePlayOver,false);
     		  	return;
     		}
     		if(recordMsg.attr("localid")){
     			var localId=recordMsg.attr("localid");
     		    if($(this).hasClass('active')){
     		    	wx.pauseVoice({
     		    	    localId: localId // 需要暂停的音频的本地ID，由stopRecord接口获得
     		    	});
     		    	$(this).removeClass('active')
     		    }else{
     		    	wx.playVoice({
     		    	    localId: localId // 需要播放的音频的本地ID，由stopRecord接口获得
     		    	});
     		    	$(this).addClass("active");
     		    	wx.onVoicePlayEnd({
     		    	    success: function (res) {
     		    	    	
     		    	    	$(this).removeClass("active");
     		    	    }
     		    	});
     		    }
     		    return;	 
     		 }
     		
     		  wx.downloadVoice({
     			    serverId: recordMsg.attr('attr-src'), // 需要下载的音频的服务器端ID，由uploadVoice接口获得
     			    isShowProgressTips: 0, // 默认为1，显示进度提示
     			    success: function (res) {
     			        var localId = res.localId; // 返回音频的本地ID
     			        recordMsg.addClass("active");
     			        recordMsg.attr('localid',localId);
     			        wx.playVoice({
     			            localId: localId // 需要播放的音频的本地ID，由stopRecord接口获得
     			        });
     			        wx.onVoicePlayEnd({
     			    	    success: function (res) {
     			    	    	recordMsg.removeClass("active");
     			    	    }
     			    	});
     			    }
     			});  
     	  });
     }
     
     /*下载语音事件*/
 	function voiceDown(){
 		$(".recordingMsg").unbind();
 		$(".recordingMsg").click(function(e){
 			stopEventBubble(e);
     		var recordVoice=$(this).children("i");
     		var recordMsg=$(this);
     		$(".isPlaying").removeClass('isPlaying');
     		var attr_voice=recordVoice.attr('attr-src');
     		var ppt_id=recordMsg.parents('dd').attr('ppt_id');
     		if(istopic_end&&ppt_id!=0&&swiper_objs.length>0){
     			var temp_index=-1;
     			for(var i=0;i<swiper_objs.length;i++){
     				if(swiper_objs[i].id==ppt_id){
     					temp_index=i;
     				}
     			}
     			if(temp_index>=0)
     			   swiper.slideTo(temp_index, 100, false);
     		}
     		if(attr_voice&&attr_voice.indexOf('http')==0){
     			if($("#audioPlayer").attr('src')!=attr_voice)
     		  	   $("#audioPlayer").attr('src',attr_voice);
     		  	var media = $('#audioPlayer')[0];
     		  	if(media.paused) { 
     		  		media.play();
     		  		recordMsg.addClass("isPlaying");
     		  		globalObj.isPlaying=true;
     		    } else {  
     		    	media.pause(); 
     		    	recordMsg.removeClass('isPlaying')
     		    }
     		  	globalObj.voicePlaying=recordMsg;
     		  	media.removeEventListener("ended",voicePlayOver,false);
     		  	media.addEventListener("ended",voicePlayOver,false);
     		  	//ppt2
     		  	return;
     		} 
     		  		
     		 if(recordVoice.attr("localid")){
      		    var localId=recordVoice.attr("localid");
      		    if(recordMsg.hasClass('isPlaying')){
      		    	wx.pauseVoice({
      		    	    localId: localId // 需要暂停的音频的本地ID，由stopRecord接口获得
      		    	});
      		    	recordMsg.removeClass('isPlaying')
      		    }else{
      		    	wx.playVoice({
      		    	    localId: localId // 需要播放的音频的本地ID，由stopRecord接口获得
      		    	});
      		    	
      		    	globalObj.isPlaying=true;
      		    	recordMsg.addClass("isPlaying");
      		    	wx.onVoicePlayEnd({
  			    	    success: function (res) {
  			    	    	recordMsg.removeClass("isPlaying");
  			    	    	recordMsg.addClass("isReaded ");
  			    	    	globalObj.isPlaying=false;
  			    	    }
  			    	});
      		    }
      		    return;	 
      		 }
      		
  			wx.downloadVoice({
  				    serverId: recordVoice.attr('attr-src'), // 需要下载的音频的服务器端ID，由uploadVoice接口获得
  				    success: function (res) {
  				        var localId = res.localId; // 返回音频的本地ID
  				        recordMsg.addClass("isPlaying");
  				        recordVoice.attr('localid',localId);
  				        wx.playVoice({
  				            localId: localId // 需要播放的音频的本地ID，由stopRecord接口获得
  				        });
  				        globalObj.isPlaying=true;
  				        
  				        wx.onVoicePlayEnd({
  				    	    success: function (res) {
  				    	    	recordMsg.removeClass("isPlaying");
  				    	    	recordMsg.addClass("isReaded ");
  				    	    	globalObj.isPlaying=false;
  				    	    }
  				    	});
  				    }
  				});  
 		 });
 	}
 	
 	/*分页获取信息课程*/
 	var page_object={sub_pindex:1,sub_pages:sub_pages,com_pindex:1,com_pages:discuss_pages,loaded:[],loadeddis:[]};
 	function ajax_content(pindex,dir,isfirst){
 		
 		if($.inArray(pindex,page_object.loaded)==-1){
 			page_object.loaded.push(pindex);
 		}else{
 			$(".btnLoadSpeakEnd").removeClass("on");
 		    $(".btnLoadSpeak").removeClass("on");
 			return;
 		}
 		var geturl=location.href;
 		$.getJSON(geturl,{pindex:pindex,target:'main'}, function(data){
 			
 			page_object.sub_pages=data.total;
 			page_object.sub_pindex=data.pindex;
 			var last_content="";
 			$.each(data.rows, function(i,item){
 				if(item.msgtype=='image'){
 					if($.inArray(item.content,globalObj.chat_images)==-1)
 					    globalObj.chat_images.push(item.content);
 				}
 				
 				last_content+=get_contenthtml(item);	   
 		    });
 			$(".speakContentBox").unbind();	
 			
 			if(dir=='down')
 			  $("#speakBubbles").append(last_content);   
 			else
 			  $("#speakBubbles").prepend(last_content);   
 	    	//voiceDown();
 	    	voicePlay();
 	    	$(".chat_img").unbind();
 	    	$(".chat_img").click(function(){
 	    		wx.previewImage({
 	    		    current: $(this).attr('src'), // 当前显示图片的http链接
 	    		    urls: globalObj.chat_images // 需要预览的图片http链接列表
 	    		});
 	    	});
 	    	if(dir=='down'){
 	    		if(isfirst==1){
 	    	       $(".speakContentBox").scrollTop(18);
 	    		}
 	    	}else
 	    		$(".speakContentBox").scrollTop(18);
 	    	
 	    	$(".btnLoadSpeakEnd").removeClass("on");
 		    $(".btnLoadSpeak").removeClass("on"); 		    
 		    
 		     is_firstload=0;
 		     
 		     $(".speakContentBox").scroll(scroll_func);	
 		     
 		     $(".btn_revoke").unbind();
 		     $(".btn_revoke").click(function(){
 				  var msg_id=$(this).parents("dd").attr('msg_id');
 				  var conf=confirm("确认撤销此消息吗？");
 				  if(!conf){return;}
 				  $.post(location.href,{msg_id:msg_id,revoke:1},function(result){
 					  if(result.success==1){
 						  var jsonObj = {type:"say",target:$("#tabval").val(),msgtype:"del","from_client_name":user_info.nickname,content:msg_id};
 						  sentContent(jsonObj);
 					  }
 				  });
 			 });
 		     
 		     $(".speakContentBox").click(function(){
 		    	 
 		    	 $(".control_emojbox").removeClass('on')
 			  });
 		     
 		});
 	}
 	
 	function ajax_discuss_content(pindex){
 		if($.inArray(pindex,page_object.loadeddis)==-1){
 			page_object.loadeddis.push(pindex);
 		}else{
 			$(".btnLoadComment ").removeClass("on");
 			return;
 		}
 		var geturl=location.href;
 		$.getJSON(geturl,{pindex:pindex,target:'discuss'}, function(data){
 			
 			page_object.com_pages=data.total;
 			//$("#common_num").text(data.items);
 			page_object.com_pindex=data.pindex;
// 			if(pindex==1&&data.rows.length>0){
// 				$("#loadNone").hide();		
// 			}
 			var last_content="";
 			$.each(data.rows, function(i,item){
 				if(item.msgtype=='image'){
 					if($.inArray(item.content,globalObj.chat_images)==-1)
 					    globalObj.chat_images.push(item.content);
 				}
 				last_content+=get_discontenthtml(item);	
 				//get_disdamu(item,'asc');
 		    });
 			
 			$("#commentDl").append(last_content);   
 			
 			$(".btn_wall").click(function(){
 				  var ask_name= $(this).parents('dd').children('.author_name').text();
 				  var ask_question=$(this).parents('dd').children('.content').text();
 				  if(ask_question.indexOf('问')==0){
 					  ask_question=ask_question.replace('问','');
 				  }
 				  globalObj.Question={N:ask_name,Q:ask_question};
 				  $(".commentReplyBox").show();
 			});
 			
 			$(".commentManage").unbind();
 			$(".commentManage").click(function(){
 				var display=$(this).children().css('display');
 				if(display=='none'){
 					$(this).children().show();
 				}else{
 					$(this).children().hide();
 				}
 			});
 			voicePlay();
 			$(".chat_img").unbind();
 	    	$(".chat_img").click(function(){
 	    		wx.previewImage({
 	    		    current: $(this).attr('src'), // 当前显示图片的http链接
 	    		    urls: globalObj.chat_images // 需要预览的图片http链接列表
 	    		});
 	    	});
 		});
 	}

 	$(function(){
	    ajax_content(page_object.sub_pindex,'down',1);
    	ajax_discuss_content(page_object.com_pindex);
    	
    	$(".btn_ask").click(function(){
    		$(this).toggleClass('on');
    	});
    		    	
    	$("#btn_send").click(function(){
    	   var inputText = $(".speakInput").val();
    	   
    	   if(inputText==''){
    		   return;
    	   }
    	   var jsonObj = {type:"say",target:$("#tabval").val(),msgtype:"text","from_client_name":user_info.nickname,headimg:avatar,content:inputText};
    	   
    	   sentContent(jsonObj);
    	   //$('.i-container').animate({scrollTop:$('.publish-panel').offset().top}, 800);
    	   
  	       $(".speakInput").val('');
  	       $(".p-more").css("display", "block");
  	       $(".control_emojbox").removeClass("active");
  	       var sbgreen = $(".p-switch-btn");
  	       var pmgreen = $(".p-more");
  	       sbgreen.removeClass("green");
 		   pmgreen.removeClass("green");
    	});
    	
    	
    	$(".btn_img").click(function(){
    		 wx.chooseImage({
    			    count: 1, 
    			    sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
    			    sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
    			    success: function (res) {
    			       var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
    			       var i = 0, length = 1;
    			       globalObj.localIds=localIds;

    			       function upload(){
		    			     var firstId=globalObj.localIds[i].toString();
		    			      wx.uploadImage({
		    			    	    localId: firstId, // 需要上传的图片的本地ID，由chooseImage接口获得
		    			    	    isShowProgressTips: 1, // 默认为1，显示进度提示
		    			    	    success: function (res) {
		    			    	        var serverId = res.serverId; // 返回图片的服务器端ID
		    			    	        $.post(down_url,{'mid':serverId,"mtype":'image'},function(result){
		    			    	        	 var img_url=result.data;
		    			    	        	 var jsonObj = {type:"say",target:$("#tabval").val(),msgtype:"image","from_client_name":user_info.nickname,headimg:avatar,content:img_url};
				    					  	 sentContent(jsonObj);
		    			    	        });  
		    					  	    i++;
		    					  	    if (i < 1) {
		    					            upload();
		    					        }
		    					  	    $(".p-more-box").removeClass("active");
		    	    		    	    $(".p-more").removeClass("green");
		    			    	    }
		    			    });
    			       }
    			       
    			       upload();
    			       
    			    }
    		}); 
    		
    		return false;
    	});
	    	
	    //评论框加载事件
	     $(".commentContentBox").scroll(function(){
	    	 var scrollTop = $(this).scrollTop();
	            var scrollHeight = $(this)[0].scrollHeight;
	            var windowHeight = $(this)[0].clientHeight; 
	            //console.dir(scrollTop + windowHeight +"__"+ scrollHeight);
	            if (scrollTop + windowHeight+1 >= scrollHeight) {  //滚动到底部执行事件
	            	if(page_object.com_pindex<page_object.com_pages){
	            	   page_object.com_pindex=page_object.com_pindex+1;
	            	   $(".btnLoadComment ").addClass("on"); 
	            	   ajax_discuss_content(page_object.com_pindex);
	            	}
	            }
	      });
	     
	     
	     $(".speakContentBox").scroll(scroll_func);	 
	     
	     /*上墙*/
	      $(".btn_wall").click(function(){
			  var ask_name= $(this).parents('dd').children('.author_name').text();
			  var ask_question=$(this).parents('dd').children('.content').html();
			  globalObj.Question={N:ask_name,Q:ask_question};
			  $(".commentReplyBox").show();
		  });
		  $(".gene_cancel").click(function(){
			  $(".geneBox").hide()
		  });

		  $(".commentManage").first().click(function(){
				var display=$(this).children().css('display');
				if(display=='none'){
					$(this).children().show();
				}else{
					$(this).children().hide();
				}
			});
		  
		  //上墙确认按钮
		  $(".commentReplyBox .gene_confirm").click(function(){
			  var reply_text=$(".commentReplyBox .reply_textarea").val();
			  if(reply_text==''){
				  return;
			  }
			  if(!globalObj.Question){
				  return;
			  }
			  //给赋值
			  globalObj.Question.replay=reply_text;
			  var jsonObj = {type:"say",target:$("#tabval").val(),msgtype:"ask",headimg:avatar,"from_client_name":user_info.nickname,content:JSON.stringify(globalObj.Question)};
	    	  sentContent(jsonObj);
	    	  //onSendMsg(JSON.stringify(jsonObj));
	  	      $(".reply_textarea").val('');
			  $(".commentReplyBox").hide();
		  });
		  /*取消*/
		  $(".redbag_cancel").click(function(){
			  $(".redbag_box").hide();
		  });
		  
		  /*讨论区禁言*/
		  $("#allShutup").click(function(){
			  $(this).toggleClass('swon');  
			  if($(this).hasClass('swon')){
					 var jsonObj = {type:"say",target:$("#tabval").val(),msgtype:"shutup",headimg:avatar,content:"on"};
					 sentContent(jsonObj);
				 }else{
					 var jsonObj = {type:"say",target:$("#tabval").val(),msgtype:"shutup",headimg:avatar,content:"off"};
					 sentContent(jsonObj);
				 }
		  });
		  /*自动播放*/
		  $("#btnAutoPlay").click(function(){
			 $(this).toggleClass('swon');  
			 if($(this).hasClass('swon')){
				 is_autoplay=true;
			 }else{
				 is_autoplay=false;
			 }
			 
		  });		  	 
   });
	  
$(function(){	  
	  $(".btnBackVoice").click(function(){
	      $(".speakBox").removeClass("textBottom");
		  $(".speakBox").addClass("hasTabBottom");
	  });
	  		
	  $(".tabToComment,.write_dan_a,.commBtn").click(function(){
	      $(".commentBox").show();
	  });

      $(".backToLive").click(function(){
	      $(".commentBox").hide();
	  });
      
      $(".commentInput").click(function(){
	      $(".commentBox").addClass('typing');
		  $(".danmuBottom").show();
		  $(".danmuBottom").css("max-height",'25rem');
		  $(".qlDanmuBg").show();
	  });
	 
	  $(".btnCommentCancel").click(function(){
	       $(".commentBox").removeClass('typing');
		  $(".danmuBottom").hide();
		  $(".danmuBottom").css("max-height",'0rem');
		  $(".qlDanmuBg").hide();
		  $(".control_emojbox").removeClass('on')
	  });
	  
	  $("#btn_discuss_send").click(function(){
		 var text=$(".danmuInput").val(); 
		 if(text==''){
			 return;
		 }
		 var jsonObj = {type:"say",target:"discuss",msgtype:"text",headimg:avatar,"from_client_name":user_info.nickname,content:text};
  	     if($('.btn_ask').hasClass('on')){
  	    	jsonObj.is_ask=true;
  	     }
		 sentContent(jsonObj);
	     $(".danmuInput").val('');
	     $('.btn_ask').removeClass('on')
	     $(".control_emojbox").removeClass('on')
	  });

	  $(".isdan_btn_a").click(function(){
		  $(".danmu_bar").toggleClass("on");
		  if($(this).text()=='关'){$(this).text('弹');}else{$(this).text('关');}
		  $(".danmuBox").toggle(500)
	  });
	  
	  $(".btn_gtb_close").click(function(){
		  $(".setGuestTips").hide();
	  });

	  $(".tab_others").click(function(){
		 if(!$(".speakBox").hasClass('othersBottom'))
		     $(".speakBox").removeClass("hasTabBottom");
	      else
	    	 $(".speakBox").addClass("hasTabBottom");
	     $(".speakBox").removeClass("textBottom");
	     $(".speakBox").removeClass("voiceBottom");
		 $(".speakBox").toggleClass("othersBottom");
	 });
	 
	 $(".tab_text").click(function(){
		 if(!$(".speakBox").hasClass('textBottom'))
		     $(".speakBox").removeClass("hasTabBottom");
	      else
	    	 $(".speakBox").addClass("hasTabBottom");
	     $(".speakBox").removeClass("othersBottom");
	     $(".speakBox").removeClass("voiceBottom");
		 $(".speakBox").toggleClass("textBottom");
	  });

	 $(".tab_voice").click(function(){
	      $(".speakBox").removeClass("othersBottom");
	      $(".speakBox").removeClass("textBottom");
	      if(!$(".speakBox").hasClass('voiceBottom'))
		     $(".speakBox").removeClass("hasTabBottom");
	      else
	    	  $(".speakBox").addClass("hasTabBottom");
		  $(".speakBox").toggleClass("voiceBottom");
	 });
	 
	  $(".btnControlBox").click(function(){
	     $(".cbox_main").css("margin-bottom","0px");
		 $(".control_box").addClass("on");
	  });

	  $(".btn_closeCBox").click(function(){
	      $(".cbox_main").css("margin-bottom","-250px");
		  $(".control_box").removeClass("on");
	  });
	  
	  $(".close_elt").click(function(){
		  $(".qlMsgTips").hide();
	  });
	  
	  $(".btn_finish_live").click(function(){
		  var data_id=$(this).attr('attr-dataid');
		  var conf=confirm("确定要结束吗?");
		  if(conf){
			  $.post(data_overurl,{data_id:data_id},function(result){
				  if(result.success==1){
					  location.href=location.href+"&r=1";
				  }else{
					  alert(result.data);
				  }
			  });
		  }
	  });
	  
	 var zxx = {
		  obj: function(){
		             return {
		                 sec: $("#sec"),
		                 mini: $("#mini"),
		                 hour: $("#hour"),
		                 day: $("#day")
		             }
		  }
	 };
		 
	
	$(".start_remind").click(function(){
		$.post(location.href,{tips:true},function(result){
			if(result.success==1){
				$(document).minTipsBox({
					tipsContent: "设置成功",
					tipsTime: 2
				});
				$(".start_remind").text('开播前将会提醒您');
			}else{
				$(document).minTipsBox({
					tipsContent: "已取消",
					tipsTime: 2
				});
				$(".start_remind").text('点击设置开播提醒');
			}
		});
	});
	
	$(".gzBtn").click(function(e){
		$(".geneBox.focusQr2Box").show();
	});
	
	$(".geneBox.focusQr2Box").click(function(){
		$(".geneBox.focusQr2Box").hide();
	});
	
	$(".focusQr2Box .gene_content").click(function(e){
		stopEventBubble(e);
	});	
	
	$(".tab_ppt").click(function(){
		$(".pptBox").show();
		$(".backSpeak").unbind();
		$(".backSpeak").click(function(){
			$(".pptBox").hide();
		});
	});
	
	$(".backSpeak").click(function(){
		$(".pptBox").hide();
	});
	
	$(".ppt_add").click(function(){
   		 wx.chooseImage({
   			    count: 9, 
   			    sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
   			    sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
   			    success: function (res) {
   			       var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
   			       var i = 0, length = 1;
   			       function upload(){
		    			     var firstId=localIds[i].toString();
		    			      wx.uploadImage({
		    			    	    localId: firstId, // 需要上传的图片的本地ID，由chooseImage接口获得
		    			    	    isShowProgressTips: 1, // 默认为1，显示进度提示
		    			    	    success: function (res) {
		    			    	        var serverId = res.serverId; // 返回图片的服务器端ID
		    			    	        $.post(down_url,{'mid':serverId,"mtype":'image','data_id':user_info.data_id,'up_type':'ppt'},function(result){
		    			    	        	 var html=getPPtImgHtml(result);
		    			               	     $(".pptList").append(html);
		    			               	     i++;
				    					  	 if (i < localIds.length) {
				    					          upload();
				    					     }
				    					  	 if(i==localIds.length){
				    					  		//init_fun_ppt();
				    					  	 }
		    			    	        });  
		    					  	   
		    			    	    }
		    			 });
   			       } 
   			       upload();
   			       
   			    }
   		}); 
   		return false;
	});
	
	if($(".swiper-slide").size()>0){
		$(".slideT").show(0);
		$("body").removeClass("BdSwitch");	
	}
	//resetBtnPosition();
    
//	if($(".swiper-container").size()>0){
//	    swiper = new Swiper('.swiper-container', {
//			pagination: '.swiper-pagination',
//			paginationType : 'fraction',
//			speed: 400,
//			autoplayDisableOnInteraction: false,
//		});
//	    
//	    $(".swiper-slide").each(function(){
//	    	var img_url=$(this).children('img').attr('src');
//	    	swiper_objs.push({id:$(this).attr('attr-id'),index:$(this).attr('attr-index'),img_url:img_url});
//	    });
//	    
//	    preview_pptimgs();
//	}
    if(location.href.indexOf("live_index")>0){
    	initEmotionUL();
    }
	//init_fun_ppt();
});
