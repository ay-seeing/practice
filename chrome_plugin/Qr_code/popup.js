function toUtf8(str){
      var out, i, len, c;
      out = "";
      len = str.length;    
      for(i = 0; i < len; i++){    
          c = str.charCodeAt(i);
          if((c >= 0x0001) && (c <= 0x007F)){
              out += str.charAt(i);
          }else if(c > 0x07FF){
            out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F));
            out += String.fromCharCode(0x80 | ((c >>  6) & 0x3F));
            out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));
          }else{
            out += String.fromCharCode(0xC0 | ((c >>  6) & 0x1F));
            out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));
          }
      }
      return out;
    } 
document.addEventListener('DOMContentLoaded',function(){
  chrome.tabs.getSelected(null,function(tab) {
    
    jQuery('#qrcodeTable').qrcode({
      /*render   : "canvas",//设置渲染方式  
      width       : 256,     //设置宽度  
      height      : 256,     //设置高度  
      typeNumber  : -1,      //计算模式  
      correctLevel    : QRErrorCorrectLevel.H,//纠错等级  
      background      : "#ffffff",//背景颜色  
      foreground      : "#000000" //前景颜色 */
      width:"200",
      height:"200",
      text  : toUtf8(tab.url)
    });
  });
});