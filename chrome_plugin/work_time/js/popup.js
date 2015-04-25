/*var oH1 = document.querySelector("h1");
oH1.innerHTML = "12345";*/
var oshow = document.querySelector("#show");
oshow.innerHTML = 00000;


function ajax(url,fnResult,fnFailure){
  var xmlhttp;
  if(window.XMLHttpRequest){
    xmlhttp=new XMLHttpRequest();
 }else{
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 }
 xmlhttp.open("GET",url,true);
 xmlhttp.send();
 xmlhttp.onreadystatechange=function(){
  if(xmlhttp.readyState==4 && xmlhttp.status==200){
     fnResult(xmlhttp.responseText);  //数据接收成功时-调用传进来的函数
   }else if(xmlhttp.status!=200 && fnFailure){
     fnFailure("数据读取失败");  //数据接收失败时-调用传进来的函数
  }
 }
}


//chrome.tabs.executeScript(null, {file: "contentScript.js"});


function countfn(str){
  oshow.innerHTML = str;
}
function b(str){
  oshow.innerHTML = str;
}
ajax("http://oa.cn1.global.ctrip.com/HR/AttendenceCalendar.aspx",countfn,b);






