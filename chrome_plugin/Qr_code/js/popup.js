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
var oTxt,oBtn;
document.addEventListener('DOMContentLoaded',function(){
  var str = "";
  chrome.tabs.getSelected(null,function(tab) {
    str = tab.url;
    createImg(str);
  });
  oTxt = jQuery("#inputTxt");
  oBtn = jQuery("#inputBtn");
  oTxt.keyup(function(event){
    if(event.which == 13){
      isCreate();
    }
  });
  oBtn.on("click",isCreate);
});
function isCreate(){
  if(oTxt.val()){
    jQuery('#qrcodeTable').html("");
    createImg(oTxt.val());
  }
}
function createImg(str){
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
    ecLevel:"H",
    text  : toUtf8(str),
    image :"image/logo.png"
  });
}