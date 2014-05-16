// 可以访问页面 DOM ，但是不能访问页面里面的 js


var port = chrome.extension.connect();

document.getElementById('myCustomEventDiv').addEventListener('myCustomEvent', function() {
  var eventData = document.getElementById('myCustomEventDiv').innerText;
  port.postMessage({message: "myCustomEvent", values: eventData});
});