$(function(){
	//点赞切换
//	$(document).on('click','.zan,.discusss-content .zan',function(){
//		var num = parseInt($(this).text());
//		if($(this).hasClass('tnzan')){
//			$(this).removeClass('tnzan').addClass('thzan');
////			num = num + 1;
////			$(this).text(num);
//		}
//		else{
//			$(this).removeClass('thzan').addClass('tnzan');
////			num = num - 1;
////			$(this).text(num);
//		}
//	});
	$(document).on('click','.dialog-discuss .left',function(){
		$('.dialog-fix').hide();
	});
	
	$(document).on('click','.video-intro .btn-more',function(){
		$('.vedio-text-main').css({ "-webkit-line-clamp":"100","margin-right":"10px"});
		$(this).hide();
	});
	
	$(document).on('click','.video-intro .discuss',function(){
		$('.dialog-fix').show();
	});

	$('.relay-close').on('click',close_reply_form);
});

var manage_action = $('#manage_action');

function manager_this_post(obj){
	var this1 = $(obj);
	var other_events_box = $('.other-events-box');
	var bj_container = $('#bj_container');
	var editor_msg = $('#editor_msg');
	var tid = this1.attr('tid');
	var sign = this1.attr('sign');
	var place = this1.attr('place');
	var text = this1.attr('text');
	other_events_box.css('display','block');
	editor_msg.attr({'tid':tid,'sign':sign,'text':text});
	other_events_box.find('.elite').attr({'place':place});
	other_events_box.find('.hideOrDelete').text('\u9690\u85cf');
	if(sign=='reply' && place=='topic'){
          
		other_events_box.find('.hideOrDelete').text('\u9690\u85cf');
                other_events_box.find('#editor_msg').addClass('displayNone');
		other_events_box.find('.elite').text('\u53d6\u6d88\u7cbe\u534e');
		other_events_box.find('.elite').attr('isElite','0');
		editor_msg.attr({'tid':tid,'sign':'topic_reply'});
                manage_action.attr({'tid':tid,'sign':sign,'place':place});
	}else if(sign=='topic'){
           
                other_events_box.find('#editor_msg').removeClass('displayNone');
		other_events_box.find('.elite').addClass('displayNone');
		other_events_box.find('.hideOrDelete').text('\u5220\u9664');
                manage_action.attr({'tid':tid,'sign':sign});
	}else if(sign=='reply'){
       
            other_events_box.find('#editor_msg').addClass('displayNone');
            other_events_box.find('.elite').text('\u7cbe\u534e');
            manage_action.attr({'tid':tid,'sign':sign});
        }
	manage_action.attr({'tid':tid,'sign':sign,'place':place});
}
function cancel_manage_container(){
	//var $this = $(obj);
	var other_events_box = $('.other-events-box');
	manage_action.attr({'tid':'','sign':''});
	other_events_box.css('display','none');
	other_events_box.find('.elite').removeClass('displayNone');
}

function close_reply_form(){
	$('.dialog-relay-box').hide(1000);
	$('.dialog-relay-box textarea').val('');
	$('.input_container').empty();
	$.closeModal('.popup.modal-in');
}

function jumpLogin(){
	QFH5.jumpLogin(function(state,data){});
}

function isInApp() {
	var index = navigator.userAgent.indexOf('QianFan');
	if (index == -1)
	{
		return false;
	}
	else
	{
		return true;
	}
}
/*查看版本，判断是安卓、ios、或者微信*/
var checkVersonObj = function(){
	var browser = {
		versions: function () {
			var u = navigator.userAgent, app = navigator.appVersion;
			return {         //移动终端浏览器版本信息
				trident: u.indexOf('Trident') > -1, //IE内核
				presto: u.indexOf('Presto') > -1, //opera内核
				webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
				gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
				mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端
				ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
				android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或uc浏览器
				iPhone: u.indexOf('iPhone') > -1, //是否为iPhone或者QQHD浏览器
				iPad: u.indexOf('iPad') > -1, //是否iPad
				webApp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部
			};
		}(),
		language: (navigator.browserLanguage || navigator.language).toLowerCase(),
		is_ios:function() {
			if (browser.versions.ios || browser.versions.iPhone || browser.versions.iPad) {
				return true;
			}
			return false;
		},
		is_android:function() {
			if (browser.versions.android) {
				return true;
			}
			return false;
		},
		is_wechat:function() {
			var ua = navigator.userAgent.toLowerCase();
			if (ua.match(/MicroMessenger/i) == 'micromessenger') {
				return true;
			} else {
				return false;
			}
		}
	};
	return browser;
};

$('#close_button').on('click',function(){
	$('#share_top').css('display','none');
	$('.page-group').css('top','0');
	$('.main-bottom').css('bottom','0');
});