document.addEventListener('DOMContentLoaded',function(){
  chrome.tabs.getSelected(null,function(tab) {
    jQuery('#qrcodeTable').qrcode({
      width:"200",
      height:"200",
      text  : tab.url
    });
  });
});