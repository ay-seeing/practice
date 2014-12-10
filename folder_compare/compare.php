<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>提取对比文件</title>
	<style>
*{box-sizing:border-box;padding:0;margin:0;}
ul,li{list-style:none;}
body{font:14px/1.5 tehomal,arial,"microsoft yahei";color:#666;background:#f9f9f9;}
input.error{border-color:red;}
.address{margin:20px auto;width:40%;display:table;*zoom:1;}
.item{width:100%;float:left;border:3px solid #ccc;background:#fff;padding:15px;line-height:36px;position:relative;}
.item li{padding-left:90px;margin-top:15px;position:relative;}
.item .t{position:absolute;left:0;top:0;}
.item .m input{width:100%;padding:10px;}
.item input[type=button]{padding:10px 30px;cursor:pointer;font-size:16px;font-family:"microsoft yahei";}
.item .add{position:absolute;right:10px;top:10px;width:16px;height:16px;cursor:pointer;}
.item .add::after,.item .add::before{content:"";position:absolute;left:50%;top:50%;background:#ccc;}
.item .add::before{width:16px;height:4px;margin-left:-8px;margin-top:-2px;}
.item .add::after{width:4px;height:16px;margin-left:-2px;margin-top:-8px;}
.item .add:hover::after,.item .add:hover::before{background:#4285F4;}
.show-box{margin:30px 0;}
.show-list li{position:relative;height:30px;line-height:30px;list-style:decimal outside;margin-left:20px;}
.show-list .t{position:absolute;top:0;width:80px;white-space:nowrap;text-overflow:ellipsis;overflow:hidden;}
.show-list .m{margin:0 60px 0 80px;}
.show-list .f{position:absolute;right:0;top:0;width:60px;height:30px;cursor:pointer;}
.show-list .f span{float:right;width:30px;height:30px;position:relative;}
.show-list .f span::before,.show-list .f span::after{content:"";position:absolute;left:50%;top:50%;background:#ccc;}
.show-list .f .editor::before{width:16px;height:6px;transform:rotate(-45deg);margin-left:-8px;margin-top:-3px;}
.show-list .f .editor::after{width:0;height:0;overflow:hidden;border:2px solid #ccc;background:transparent;border-color:transparent transparent #ccc #ccc;margin-left:-8px;margin-top:4px;}
.show-list .f .editor:hover::before{background:#4285F4;}
.show-list .f .editor:hover::after{border-color:transparent transparent #4285F4 #4285F4;}
.show-list .f .current::before{width:8px;height:3px;transform:rotate(45deg);margin-left:-8px;}
.show-list .f .current::after{width:15px;height:3px;transform:rotate(-45deg);margin-left:-5px;margin-top:-2px;}
.show-list .f .current:hover::before,.show-list .f .current:hover::after{background:#4285F4;}
	</style>
</head>
<body>
<?php 
$s = isset($_GET["s"]) ? $_GET["s"] : false;
$t = isset($_GET["t"]) ? $_GET["t"] : false;
?>
<div id="address" class="address">
	<div class="show-box">
		<h3>记录</h3>
		<ol class="show-list" id="showList">
			<li><span class="t">国内</span><div class="m">url</div><div class="f"><span class="current"></span><span class="editor"></span></div></li>
		</ol>
	</div>
	<div class="item" id="current">
		<span class="add"></span>
		<h3>复制样式表</h3>
		<form action="" method="get" id="form">
		<ul>
			<li>
				<span class="t">源文件夹：</span>
				<div class="m"><input type="text" name="s" id="source"></div>
			</li>
			<li>
				<span class="t">目标文件夹：</span>
				<div class="m"><input type="text" name="t" id="target"></div>
			</li>
			<li><input type="submit" value="获取文件" id="getFile"> <input type="submit" value="确认" id="submit"></li>
		</ul>
		</form>
	</div>
</div>
<script>
var $ = {
	trim : function(str){
		return str.replace(/^\s*|\s*$/gm,"");
	},
	trimLeft : function(str){
		return str.replace(/^\s*/gm,"");
	},
	trimRight : function(str){
		return str.replace(/\s$*/gm,"");
	},
	detection : function(){
		var is_submit = true;
		if(!this.trim(osource.value)){
			osource.className = "error";
			is_submit = false;
		}
		if(!this.trim(otarget.value)){
			otarget.className = "error";
			is_submit = false;
		}
		return is_submit;
	}
}

var osource = document.querySelector("#source"),
	otarget = document.querySelector("#target"),
	ogetFile = document.querySelector("#getFile"),
	osubmit = document.querySelector("#submit"),
	oform = document.querySelector("#form");

osource.addEventListener("focus",function(){
	this.className = "";
},false);

otarget.addEventListener("focus",function(){
	this.className = "";
},false);

osource.addEventListener("blur",function(){
	//
},false);

osubmit.addEventListener("click",function(event){
	var oevent = event || window.event;
	var is_submit = $.detection();
	//return false;
	if(!is_submit){
		// 阻止提交
		oevent.preventDefault();
		// 阻止冒泡
		// oevent.stopPropagation();
	}else{
		// 写入数据
	}
},false);

// 获取文件
ogetFile.addEventListener("click",function(){
	// 
},false);
</script>
</body>
</html>