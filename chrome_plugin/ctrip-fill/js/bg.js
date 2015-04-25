//background监听消息(针对content js)
//chrome.extension.onRequest.addListener(function(request, sender, sendResponse) {});
/*function aa(){
	alert("41213");
}*/

//var views = chrome.extension.getViews({type:"popup"});
///alert(views);
//http://www.cnblogs.com/cart55free99/p/3753722.html

//侦听消息（接收 content 页面发送来的消息）
var fill = false;
chrome.runtime.onMessage.addListener(function(request, sender, sendResponse) {
    //console.log(sender.tab ? "from a content script:" + sender.tab.url : "from the extension");
    //alert(78423153);
    //var oClear = document.querySelector("#clearBtn");
    if(request.fill){
      fill = true;
    }
    if (request.greetings == "hello"){
        sendResponse({farewell: "goodbye"});
    }
});

//background中可以直接访问chrome.browserAction对象来设置和定义
//chrome.browserAction.setIcon({path:"icon.png"});
// 若 browser_action（manifest.json文件） 设置了 "default_popup": "popup.html"，则 chrome.browserAction.onClicked 无效
/*chrome.browserAction.onClicked.addListener(function(tab){
  alert("click");
});*/