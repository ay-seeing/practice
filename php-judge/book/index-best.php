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
$test=array(10,20,30,"10",10,"20","30");
print_r(array_keys($test,10,true));

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
	// 获取当前文件名称用于判断分支里的文件是否为该文件的分支
	$currentFileName = basename(__FILE__);
	// 返回文件绝对路径
	//__FILE__;
	// 获取当前文件夹所在目录名称
	$parentDir = dirname(__FILE__);
	//echo $parentDir;
	//echo array_pop(explode("\\",$parentDir));
	$name = array_pop(preg_split("/[\\\\\/]/",$parentDir));

	function listDir($dir,$name,$fileName){
		if(!isset($aInfo)){
			global $aInfo;
		}
		if(is_dir($dir)){
			if ($dh = opendir($dir)){
				while (($file = readdir($dh)) !== false){
					if((is_dir($dir."/".$file)) && $file!="." && $file!=".."){
						//echo "<b><font color='red'>文件名：</font></b>",$file,"<br><hr>";
						listDir($dir."/".$file,$name,$fileName);
					}else{
						if($file!="." && $file!=".." && $file==$fileName){
							// 获取当前文件所在目录名称用于判断是否为主分支的分支
							$curentParent = array_pop(preg_split("/[\\\\\/]/",$dir));
							if(strpos($curentParent,$name)!==false){
								array_push($aInfo,getFileOneLine($dir."/".$file));
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
	listDir($dir,$name,$currentFileName);
	//print_r($aInfo);
}

// 配置项
$configuration = array(
	"wip"=>"wip", // 设置开发中目录名称
	"wipPath"=>"../wip" // 设置开发中目录名称相对个开发主分支的相对路径
);
$currentDirPath = dirname(__FILE__);
$aDir = preg_split("/[\\\\\/]/",$currentDirPath);

// 判断当前文件是否在分支里面
if(in_array($configuration["wip"],$aDir)){
	$wip_path = array_keys($aDir,$configuration["wip"],true);
	print_r($wip_path);
	echo $currentDirPath."---".$wip_path;
}else{
	loopTree("../wip");
	//loopTree($configuration["wipPath"]);
}





$resultType = array($aInfo);

//获取某一个参数
function getOneParameter($Parameter,$asend){
	if(!isset($resultType)){
		global $resultType;
	}
	// 获取某个参数的值
	$send = isset($_GET[$Parameter])?$_GET[$Parameter]:1;
	$a_send = array();
	foreach($asend as $key => $value){
		//array($send,"链接文字",地址栏参数处理),
		$arr = array($send,$value,getHath($Parameter,$key+1));
		array_push($a_send,$arr);
	}
	array_push($resultType,$a_send);
	return $send;
}

// send 注释
$asend = array("send1","send2","send3","send4");
$send = getOneParameter("send",$asend);

// type 注释
$atype =  array("type1","type2","type3","type4");
$type = getOneParameter("type",$atype);

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

<style>
.demo-interaction-panel{position:fixed;top:30px;left:0;z-index:9999;max-width:300px;border:2px solid #666;background:white;
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
		<?php 
		foreach ($resultType as $key => $value) {
		?>
		<div class="demo-type demo-branch-list">
			<h4 class="demo-h4">其他分支</h4>
			<ul class="demo-list">
				<?php 
				foreach($value as $childKey => $childValue){
					if($key==0){
				?>
					<li><a href="<?php echo $childValue[1]; ?>"><?php echo $childValue[0]; ?></a></li>
					<?php }else{ ?>
					<li class="<?php echo $childValue[0]==($childKey+1)?'current':''; ?>"><a href="<?php echo $childValue[2]; ?>"><?php echo $childValue[1]; ?></a></li>
				<?php 
					}
				}
				?>
			</ul>
		</div>
		<?php } ?>
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