document.addEventListener('DOMContentLoaded',function(){
	var oGet = document.querySelector("#getBtn"),
		oSet = document.querySelector("#setBtn");

	oGet.addEventListener("click",function(){
		//getInfo();

		// 发送消息
		chrome.tabs.query({
      active: true,
      currentWindow: true
    }, function(tabs) {
      var tab = tabs[0];
      chrome.tabs.sendMessage(tab.id, {getInfo:true,setInfo:false,greeting:"hello"}, function handler(response){
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
      chrome.tabs.sendMessage(tab.id, {getInfo:false,setInfo:true,greeting:"hello"}, function handler(response){
        console.log(response.farewell);
      });

    });
	});

	var bg = chrome.extension.getBackgroundPage();
	//bg.aa();
});

