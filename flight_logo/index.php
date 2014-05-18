<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>航空公司logo</title>
	<style>
*{margin:0;padding:0;}
#flight_list img{width:50px;height:50px;}
	</style>

</head>
<body>
	<h1>航空公司logo展示</h1>
	<ul id="flight_list">
	</ul>
<script>
var ua = window.navigator.userAgent;
if(!(/mise/i.test(ua)||/\srv:\d+/i.test(ua))){
	document.body.innerHTML = "<h1>请使用IE浏览器查看本页！</h1>"
}else{
	ajax("flight.json",resuletFn,Failure);
}

// 判断图片是否存在
function IsExist(url){
	x = new ActiveXObject("Microsoft.XMLHTTP");
	x.open("HEAD",url,false);
	x.send();
	return x.status==200;
}


// ajax请求json文件
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
var o = document.getElementById("flight_list"),
	imgfiles = "img/";
function resuletFn(str){
	var json = eval(str);
	var num = json.length;
	for(var i=0;i<num;i++){
		if(IsExist(imgfiles+json[i][0]+".jpg")){
			var li = document.createElement("li");
			li.innerHTML = "<img src='"+imgfiles+json[i][0]+".jpg' /><br />"+json[i][1]+"<br />"+json[i][2];
			o.appendChild(li);
		}
	}
}
function Failure(str){
	alert(str);
}


	</script>
</body>
</html>