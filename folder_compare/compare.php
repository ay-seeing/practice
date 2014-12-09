<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>提取对比文件</title>
	<style>
*{box-sizing:border-box;padding:0;margin:0;}
ul,li{list-style:none;}
body{font:14px/1.5 tehomal,arial,"microsoft yahei";color:#666;background:#f9f9f9;}
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
.show-list .m{margin:0 30px 0 80px;}
.show-list .f{position:absolute;right:0;top:0;width:30px;height:30px;cursor:pointer;}
.show-list .f::before,.show-list .f::after{content:"";position:absolute;left:50%;top:50%;background:#ccc;}
.show-list .f::before{width:8px;height:3px;transform:rotate(45deg);margin-left:-8px;}
.show-list .f::after{width:15px;height:3px;transform:rotate(-45deg);margin-left:-5px;margin-top:-2px;}
.show-list .f:hover::before,.show-list .f:hover::after{background:#4285F4;}
	</style>
</head>
<body>
	<div id="address" class="address">
		<div class="show-box">
			<h3>记录</h3>
			<ol class="show-list" id="showList">
				<li><span class="t">国内</span><div class="m">url</div><span class="f"></span></li>
			</ol>
		</div>
		<div class="item" id="current">
			<span class="add"></span>
			<h3>复制样式表</h3>
			<ul>
				<li>
					<span class="t">源文件夹：</span>
					<div class="m"><input type="text"></div>
				</li>
				<li>
					<span class="t">目标文件夹：</span>
					<div class="m"><input type="text"></div>
				</li>
				<li><input type="button" value="获取"></li>
			</ul>
		</div>
	</div>
</body>
</html>