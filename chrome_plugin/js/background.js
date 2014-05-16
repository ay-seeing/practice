// 可设置 browserAction 中 icon 图片
chrome.browserAction.setIcon({path:"../images/icon.png"});


// React when a browser action's icon is clicked.
chrome.browserAction.onClicked.addListener(function(tab) {
      chrome.tabs.create();
});


function ba(){
 alert(789);
}