document.addEventListener('DOMContentLoaded',function(){
	var oGet = document.querySelector("#getBtn"),
		oSet = document.querySelector("#setBtn"),
    oClear = document.querySelector("#clearBtn"),
    oMask = document.querySelector("#mask"),
    oClearData = document.querySelector("#clearData"),
    oDetermineClear = document.querySelector("#determineClear"),
    oCancelClear = document.querySelector("#cancelClear");

	oGet.addEventListener("click",function(){
		//getInfo();

		// 发送消息
		chrome.tabs.query({
      active: true,
      currentWindow: true
    }, function(tabs) {
      var tab = tabs[0];
      chrome.tabs.sendMessage(tab.id, {getInfo:true,greeting:"hello"}, function handler(response){
        console.log(response.farewell);
      });

    });
	});

  oSet.addEventListener("click",function(){
    // 发送消息
    chrome.tabs.query({
      active: true,
      currentWindow: true
    }, function(tabs) {
      var tab = tabs[0];
      chrome.tabs.sendMessage(tab.id, {setInfo:true,greeting:"hello"}, function handler(response){
        console.log(response.farewell);
      });

    });
  });

  oClear.addEventListener("click",function(){
    oMask.style.display = oClearData.style.display = "block";
  });

	oCancelClear.addEventListener("click",function(){
    oMask.style.display = oClearData.style.display = "none";
	});

  oDetermineClear.addEventListener("click",function(){
    oMask.style.display = oClearData.style.display = "none";
    // 发送消息
    chrome.tabs.query({
      active: true,
      currentWindow: true
    }, function(tabs) {
      var tab = tabs[0];
      chrome.tabs.sendMessage(tab.id, {clearInfo:true,greeting:"hello"}, function handler(response){
        console.log(response.farewell);
      });
    });
  })

  // 获取 background 页面，然后就可以运行 background 页面的函数和变量
	var bg = chrome.extension.getBackgroundPage();
	//bg.aa();
  if(bg.fill && bg.fill==true){
    oGet.style.display = oClear.style.display = "none";
  }else{
    oSet.style.display = "none";
    // 隐藏清除数据按钮
    oClear.style.display = "none";
    $(".fill-page").hide();
  }
});


