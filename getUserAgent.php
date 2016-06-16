<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>获取 UserAgent 信息 </title>
    <style>
*{margin:0;padding:0;}
body{font:16px/2em tahoma,arial,"microsoft yahei",simsun;color:#666;}
li{list-style:none;margin-top:20px;line-height:1.3em;}
strong{display:block;font-size:1.4em;margin-bottom:5px;}
.wraper{width:90%;margin:10px auto;}
#ua{margin-bottom:20px;}
#ua .m{line-height:1.2em;}
.t{color:#333;font-weight:bold;}
  </style>
</head>
<body>
  <a href="http://www.tera-wurfl.com/explore/search.php">http://www.tera-wurfl.com/explore/search.php</a><br />
  <div class="box">
    <h3>php获取</h3>
    <p><?php echo $_SERVER['HTTP_USER_AGENT']; ?></p>
  </div>
  <div class="box">
    <h3>js获取</h3>
    <p id="view"></p>
  </div>
  
  <script>
var oview = document.getElementById("view");
oview.innerHTML = navigator.userAgent;
  </script>

<hr>

<ul id="box"></ul>
<script>
var ua = navigator.userAgent.toLowerCase();
var system= ["windows","Linux","Macintosh","Mobile"];
var equipment = ["Mac","iPad;","iphone;","ipod;","HTC Desire S","M040","M356","SAMSUNG GT-I9502"];
var browser = ["chrome","UCBrowser","MSIE","firefox","safari"];
var eqs = {
  "windows nt":"PC Windows",
  "iPad;":"iPad",
  "iphone":"iPhone",
  "ipod":"iPod",
  "HTC Desire S":"HTC G12",
  "M040":"魅族MX2",
  "M356":"魅族MX3"
}
var resultStr = "";

function isGet(str,fn){

  if(ua.indexOf(str)!=-1){
    resultStr += str;

   
    var regE = str+"\/(\\S+)\\s";
    var reg = new RegExp(regE,"i");
    if(reg.test(ua)){
      resultStr += " "+ua.match(reg)[1];
    }
    resultStr += ";";
  }
  
}
function repeat(arr,fn){
  var num = arr.length;
  for(var i=0;i<num;i++){
    isGet(arr[i].toLowerCase());
  }
  if(typeof fn == "function"){
    fn();
  }
}

// 设备系统查找
repeat(system);
console.log("设备系统："+resultStr);

/*repeat(system,function(){
  repeat(browser,function(){repeat(equipment);});
});

console.log(resultStr);*/




var json = {
  "Chrome":"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.131 Safari/537.36",
  "Firefox":"Mozilla/5.0 (Windows NT 6.1; WOW64; rv:28.0) Gecko/20100101 Firefox/28.0",
  "IE11 / 360_6.2 compatible":" Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET CLR 1.1.4322; .NET4.0C; .NET4.0E; rv:11.0) like Gecko",
  "IE10":"Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/7.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET CLR 1.1.4322; .NET4.0C; .NET4.0E)",
  "IE9":"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/7.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET CLR 1.1.4322; .NET4.0C; .NET4.0E)",
  "IE8":"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.2; .NET CLR 1.1.4322; .NET CLR 2.0.50727)",
  "IE7":"Mozilla/4.0 (compatible: MSIE 7.0; Windows NT 5.2; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)",
  "IE6":"Mozilla/4.0 (compatible: MSIE 6.0; Windows NT 5.2; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)",
  "360_6.2 rapid":"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1",
  "Meizu MX3 UC":"Mozilla/5.0 (Linux; U; Android 4.2.1; zh-CN; M356 Build/JOP40D) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 UCBrowser/9.7.0.398 U3/0.8.0 Mobile Safari/533.1",
  "Meizu MX3 Default":"Mozilla/5.0 (Linux; U; Android 4.2.1; zh-cn; M356 Build/JOP40D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30",
  "Meizu MX2 Default":"Mozilla/5.0 (Linux; U; Android 4.1; xx-xx; M040 Build/JRO03H) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30",
  "HTC G12 UC":"Mozilla/5.0 (Linux; U; Android 4.0.4; zh-CN; HTC Desire S Build/IMM76D) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 UCBrowser/9.6.0.378 U3/0.8.0 Mobile Safari/533.1",
  "HTC G12 Chrome":"Mozilla/5.0 (Linux; Android 4.0.4; HTC Desire S Build/IMM76D) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.99 Mobile Safari/537.36",
  "HTC G12 Default":"Mozilla/5.0 (Linux; U; Android 4.0.4; zh-cn; HTC_DesireS_S510e Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30",
  "HTC c620e IE":"Mozilla/5.0 (compatible; MSIE 10.0; Windows Phone 8.0; Trident/6.0; IEMobile/10.0; ARM; Touch; HTC; c620e)",
  "Mac OS X 10_8_4 Chrome":"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.131 Safari/537.36",
  "Mac OS X 10_8_4 Safari":"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/536.30.1 (KHTML, like Gecko) Version/6.0.5 Safari/536.30.1",
  "Mac OS X 10_8_4 Firefox":"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:26.0) Gecko/20100101 Firefox/26.0",
  "Ipad chrome":"Mozilla/5.0 (iPad; CPU OS 7_0_3 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) CriOS/30.0.1599.12 Mobile/11B511 Safari/8536.25",
  "Ipad chrome js":"Mozilla/5.0 (iPad; CPU OS 7_0_3 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) CriOS/30.0.1599.12 Mobile/11B511 Safari/8536.25 (B39998B8-B665-4099-88F6-D63E802B275B)",
  "Ipad default":"Mozilla/5.0 (iPad; CPU OS 7_0_3 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11B511 Safari/9537.53",
  "Iphone default":"Mozilla/5.0 (iPhone; CPU iPhone OS 7_0_4 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11B554a Safari/9537.53",
  "Ipod":"Mozilla/5.0 (iPod; U; CPU iPhone OS 4_3_2 like Mac OS X; zh-cn) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8H7 Safari/6533.18.5",
  "Samsung Galaxy S4":"Mozilla/5.0 (Linux; Android 4.2.2; zh-cn; SAMSUNG GT-I9502 Build/JDQ39) AppleWebKit/535.19 (KHTML, like Gecko) Version/1.0 Chrome/18.0.1025.308 Mobile Safari/535.19"
}
/*var json = {"js  Chrome":"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.131 Safari/537.36","php Chrome":"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.131 Safari/537.36","js  Firefox":"Mozilla/5.0 (Windows NT 6.1; WOW64; rv:29.0) Gecko/20100101 Firefox/29.0","php Firefox":"Mozilla/5.0 (Windows NT 6.1; WOW64; rv:29.0) Gecko/20100101 Firefox/29.0","js IE11":"Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET CLR 1.1.4322; .NET4.0C; .NET4.0E; rv:11.0) like Gecko","php IE11":"Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko","js/php IE10":"Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)","js/php IE9":"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)","js/php IE8":"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.2; .NET CLR 1.1.4322; .NET CLR 2.0.50727)","js/php IE7":"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2; .NET CLR 1.1.4322; .NET CLR 2.0.50727)","js/php IE6":"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)","js 360_6.2 rapid":"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1","php 360_6.2 rapid":"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1","js 360_6.2 compatible":"Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET CLR 1.1.4322; .NET4.0C; .NET4.0E; rv:11.0) like Gecko","php 360_6.2 compatible":"Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko"}*/
var obox = document.querySelector("#box");
for(var i in json){
  var oli = document.createElement("li");
  oli.innerHTML = "<strong>"+i+"</strong>"+json[i];
  obox.appendChild(oli);
}
</script>
<div style="margin-top:50px;color:#999;">
  Mozilla产品的声明<br />
  Trident在IE9才被引入<br />
  Windows NT 6.1  操作系统<br />
  .NET CLR 2.0.50727  微软.NET运行环境<br />
  compatible  兼容性标志，表示该浏览器支持通用功能<br />
</div>
<div style="margin-top:50px;color:#999;">
  <h3>User Agent详解</h3>
  Mozilla/5.0 (Linux; U; Android 4.2.1; zh-CN; M356 Build/JOP40D) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 UCBrowser/9.7.0.398 U3/0.8.0 Mobile Safari/533.1
  <p>Mozilla/Version [Language] (Platform; Encryption)</p>
  <ul>
    <li>1.Mozilla - 产品的声明。</li>
    <li>2.5.0 - 产品的声明的版本。</li>
    <li>3.Linux; - 应用程序用的是哪个语言。</li>
    <li>4.Android 4.2.1 - 应用程序是在什么操作系统和/或平台中运行。</li>
    <li>5.U  - 应用程序包含了什么安全加密类型。其中的值可能是U(128位加密)、I(40位加密)、N(没加密)。</li>
    <li>6.zh-CN  - 地区。zh-CN中国</li>
    <li>7.WOW64  - 32位兼容子系统。</li>
    <li>8.M356  - 设备型号。</li>
    <li>9.JOP40D  - 产品线。</li>
    <li>9.UCBrowser  - UC浏览器</li>
  </ul>
</div>
</body>
</html>