<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>php参数判断</title>
	<style>
*{margin:0;padding:0;}
body{font-size:14px;line-height:1.5em;font-family:tahoma,arial,"microsoft yahei";color:#666;}
.wraper{width:800px;margin:10px auto;}
ul,li,ol{list-style:none;}
.red{color:red;}
.green{color:green;}
.blue{color:blue;}
	</style>
</head>
<body>
<?php 
// send 注释
$send = isset($_GET['send'])?$_GET['send']:1;

// type 注释
$type = isset($_GET['type'])?$_GET['type']:1;
?>

<div class="wraper">

	<?php  if($send==1){ ?>
		<div class="red">当send=1时候显示</div>
	<?php  }elseif($send==2){ ?>
		<div class="green">当send=2时候显示</div>
	<?php  }elseif($send==3){ ?>
		<div class="blue">当send=3时候显示</div>
	<?php  }elseif($send==4){ ?>
		<div>当send=4时候显示</div>
	<?php } ?>

	<?php  if($type==1){ ?>
		<div class="red">当type=1时候显示</div>
	<?php  }elseif($type==2){ ?>
		<div class="green">当type=2时候显示</div>
	<?php  }elseif($type==3){ ?>
		<div class="blue">当type=3时候显示</div>
	<?php  }elseif($type==4){ ?>
		<div>当type=4时候显示</div>
	<?php } ?>

</div>








<!-- 交互版面内容-start -->
<?php 
// 获取链接地址
function getHath($key,$num){
	// 获取url的hash值
	$urlPath = $_SERVER["QUERY_STRING"];
	if(empty($urlPath)){
		return "?".$key."=".$num;
	}
	// 返回 $key 的位置
	$is = strpos($urlPath,$key."=");
	$akey = explode('&',$urlPath);
	foreach ($akey as $item => $value){
		$aitem = explode('=',$value);
		if($aitem[0]==$key){
			unset($akey[$item]);
		}
	}
	$hash = implode("&",$akey);
	return "?".$hash."&".$key."=".$num;
}

// 获取分支路径
$aInfo = Array();
function loopTree($dir){
	$parentDir = dirname(__FILE__);
	//echo $parentDir;
	//echo array_pop(explode("\\",$parentDir));
	$name = array_pop(preg_split("/[\\\\\/]/",$parentDir));

	function listDir($dir,$name){
		if(!isset($aInfo)){
			global $aInfo;
		}
		if(is_dir($dir)){
			if ($dh = opendir($dir)){
				while (($file = readdir($dh)) !== false){
					if((is_dir($dir."/".$file)) && $file!="." && $file!=".."){
						//echo "<b><font color='red'>文件名：</font></b>",$file,"<br><hr>";
						listDir($dir."/".$file,$name);
					}else{
						if($file!="." && $file!=".."){
							$curentParent = array_pop(preg_split("/[\\\\\/]/",$dir));
							if(strpos($curentParent,$name)!==false){
								array_push($aInfo,getFileOneLine($dir."/".$file));
								//echo $dir."/".$file."<br>";
							}
						}
					}
				}
				closedir($dh);
			}
		}
	}
	function getFileOneLine($path){
		if(!file_exists($path)){return false;}
		$f= fopen($path,"r");
		/*
		读取整个文件
		while (!feof($f))
		{
			$line = fgets($f);
			echo "site: ",$line,"<br />";
		}*/
		// 获得第一行
		$line = fgets($f);
		fclose($f);
		//return $line;
		return getInfo($path,$line);

		/*//显示最后一行
		$fp = file("e:/test/users1.sql");
		echo $fp[count($fp)-1];*/
	}
	function getInfo($path,$str){
		if(preg_match("/@(.*?)@/i", $str, $matches)){
			$arr = Array($matches[1],$path);
			return $arr;
		}
	}
	//print_r(getFileOneLine("test/test3/c.php"));
	listDir($dir,$name);
	//print_r($aInfo);
}
loopTree("../wip");
?>
<style>
.demo-interaction-panel{position:fixed;top:0;left:0;z-index:9999;max-width:300px;border:2px solid #666;background:white;
}
.demo-panel-hd{background:#666;color:white;position:relative;height:30px;line-height:30px;}
.demo-panel-hd .demo-min{position:absolute;height:32px;width:40px;text-align:center;right:-2px;top:-2px;cursor:pointer;}
.demo-panel-hd .demo-min:hover{background:#999;}
.demo-panel-hd .demo-panel-title{padding:3px 5px;min-width:120px;padding-right:40px;font:16px/1.5em "microsoft yahei";color:white;}
.demo-panel-bd{padding:3px;}
.demo-interaction-panel .demo-list{padding-left:10px;}
.demo-interaction-panel .current{background:#06c;color:white;}
.demo-interaction-panel a{display:block;padding-left:10px;text-decoration:none;}
.demo-interaction-panel a:hover{text-decoration:none;background:#D1E3F2;}
.demo-interaction-panel .current a{color:white;}
.demo-interaction-panel .current a:hover{background:#06c;color:white;}
.demo-interaction-panel-min{width:40px;border:none;}
.demo-interaction-panel-min .demo-panel-title{display:none;}
.demo-interaction-panel-min .demo-panel-bd{display:none;}
.demo-branch-list{border-bottom:1px dashed #999;padding-bottom:10px;margin-bottom:10px;}
</style>
<div class="demo-interaction-panel">
	<div class="demo-panel-hd"><h3 class="demo-panel-title">交互面板</h3><span class="demo-min">缩小</span></div>
	<div class="demo-panel-bd">
		<div class="demo-type demo-branch-list">
			<h4 class="demo-h4">其他分支</h4>
			<ul class="demo-list">
				<?php 
				foreach ($aInfo as $key => $value) {
				?>
				<li><a href="<?php echo $value[1]; ?>"><?php echo $value[0]; ?></a></li>
				<?php } ?>
			</ul>
		</div>
		<div class="demo-type">
			<h4 class="demo-h4">种类1</h4>
			<ul class="demo-list">
				<li class="<?php echo $send==1? 'current':''; ?>"><a href="<?php echo getHath("send",1); ?>">send1</a></li>
				<li class="<?php echo $send==2?'current':''; ?>"><a href="<?php echo getHath("send",2); ?>">send2</a></li>
				<li class="<?php echo $send==3?'current':''; ?>"><a href="<?php echo getHath("send",3); ?>">send3</a></li>
				<li class="<?php echo $send==4?'current':''; ?>"><a href="<?php echo getHath("send",4); ?>">send4</a></li>
			</ul>
		</div>
		<div class="demo-type">
			<h4 class="demo-h4">种类2</h4>
			<ul class="demo-list">
				<li class="<?php echo $type==1? 'current':''; ?>"><a href="<?php echo getHath("type",1); ?>">type1</a></li>
				<li class="<?php echo $type==2?'current':''; ?>"><a href="<?php echo getHath("type",2); ?>">type2</a></li>
				<li class="<?php echo $type==3?'current':''; ?>"><a href="<?php echo getHath("type",3); ?>">type3</a></li>
				<li class="<?php echo $type==4?'current':''; ?>"><a href="<?php echo getHath("type",4); ?>">type4</a></li>
			</ul>
		</div>
	</div>
</div>
<script>
var oDemoMin = document.querySelector(".demo-min"),
	odemoPanel = document.querySelector(".demo-interaction-panel");
oDemoMin.addEventListener("click",function(){
	if(odemoPanel.className =="demo-interaction-panel"){
		odemoPanel.className = "demo-interaction-panel demo-interaction-panel-min";
		oDemoMin.innerHTML = "展开";
	}else{
		odemoPanel.className = "demo-interaction-panel";
		oDemoMin.innerHTML = "缩小";
	}
},false);
</script>
<!-- 交互版面内容-end -->
</body>
</html>