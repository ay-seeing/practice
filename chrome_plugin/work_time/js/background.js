// 可设置 browserAction 中 icon 图片
//chrome.browserAction.setIcon({path:"../images/icon.png"});
function updateIcon(){
  chrome.browserAction.setIcon({path:"../images/icon.png"});

  chrome.tabs.executeScript({code:"document.body.bgColor='red'"});
}

// React when a browser action's icon is clicked.
chrome.browserAction.onClicked.addListener(updateIcon);
