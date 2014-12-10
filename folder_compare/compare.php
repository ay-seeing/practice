<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>提取对比文件</title>
	<style>
*{box-sizing:border-box;padding:0;margin:0;}
ul,li{list-style:none;}
body{font:14px/1.5 tehomal,arial,"microsoft yahei";color:#666;background:#f9f9f9;}
input[type=text]{width:100%;padding:10px;}
input[type=button],input[type=submit]{padding:10px 30px;cursor:pointer;font-size:16px;font-family:"microsoft yahei";margin-right:10px;}
input.error{border-color:red;}
.hide{display:none !important;}
.address{margin:20px auto;width:40%;display:table;*zoom:1;}
.item{width:100%;float:left;border:3px solid #ccc;background:#fff;padding:15px;line-height:36px;position:relative;}
.item li{padding-left:90px;margin-top:15px;position:relative;}
.item .t{position:absolute;left:0;top:0;}
.item .add{position:absolute;right:10px;top:10px;width:16px;height:16px;cursor:pointer;}
.item .add::after,.item .add::before{content:"";position:absolute;left:50%;top:50%;background:#ccc;}
.item .add::before{width:16px;height:4px;margin-left:-8px;margin-top:-2px;}
.item .add::after{width:4px;height:16px;margin-left:-2px;margin-top:-8px;}
.item .add:hover::after,.item .add:hover::before{background:#4285F4;}
.show-box{margin:30px 0;}
.show-list li{position:relative;height:30px;line-height:30px;list-style:decimal outside;margin-left:20px;}
.show-list .no-number{list-style:none;}
.show-list .t{position:absolute;top:0;width:80px;white-space:nowrap;text-overflow:ellipsis;overflow:hidden;}
.show-list .m{margin:0 60px 0 80px;}
.show-list .f{position:absolute;right:0;top:0;width:60px;height:30px;cursor:pointer;}
.icon{float:right;width:30px;height:30px;position:relative;}
.icon::before,.icon::after{content:"";position:absolute;left:50%;top:50%;background:#ccc;}
.editor::before{width:16px;height:6px;transform:rotate(-45deg);margin-left:-8px;margin-top:-3px;}
.editor::after{width:0;height:0;overflow:hidden;border:2px solid #ccc;background:transparent;border-color:transparent transparent #ccc #ccc;margin-left:-8px;margin-top:4px;}
.editor:hover::before{background:#4285F4;}
.editor:hover::after{border-color:transparent transparent #4285F4 #4285F4;}
.select::before{width:8px;height:3px;transform:rotate(45deg);margin-left:-8px;}
.select::after{width:15px;height:3px;transform:rotate(-45deg);margin-left:-5px;margin-top:-2px;}
.select:hover::before,.select:hover::after{background:#4285F4;}
	</style>
</head>
<body>
<?php 

$n = isset($_GET["n"]) ? $_GET["n"] : false;
$m = isset($_GET["m"]) ? $_GET["m"] : false;
$s = isset($_GET["s"]) ? $_GET["s"] : false;
$t = isset($_GET["t"]) ? $_GET["t"] : false;

// 是否复制文件
$gain = isset($_GET["gain"]) ? $_GET["gain"] : false;

// 是否写入数据
$write = isset($_GET["write"]) ? $_GET["write"] : false;

// 写入数据文件的数组
$inArr = array();

// 设置json文件路径
$path = "compare_data.json";

// 创建一个数组用于存放数据的名字部分
$data_name = array();

// 判断文件是否存在，且有内容不为空
if(file_exists($path)&&filesize($path)!=0){
	// 获取json文件
	$json = file_get_contents($path);
	// 将获取到的json文件字符串转换为数组
	$data = json_decode($json);
}else{
	$data = false;
}

// 判断是否写入文件，如果$write 为true则写入，否则不写入
if($write){
	// 将数据先写入到一个数组里面
	$arr = array();
	array_push($arr,$n);
	array_push($arr,$m);
	array_push($arr,$s);
	array_push($arr,$t);

	// 判断数据是否存在
	if($data){
		// 判断要存入的名字是否包含在数据里
		foreach($data as $key => $val){
			// 如果要存入的数据在原数据中存在，则删除原来的数据
			if($n==$val[0]){
				// unset($data[$key]);
				array_splice($data,$key,1);
			}
		}
		// 将新数据添加到数据的前面
		array_unshift($data,$arr);
		$inArr = $data;
	}else{
		array_push($inArr,$arr);
	}
	// 将数组解析成字符串
	$instr = json_encode($inArr);
	// 将字符串写入到文件
	writeFn($path,$instr);
}


// 写入数据到文件
function writeFn($file,$str){
	$fp = fopen($file,"w");
	fwrite($fp,$str);
	fclose($fp);
}


// 将要复制的文件名写入数组
$allFiles = Array();
function readDirFn($dir,$type){
	//输出参数个数
	// $argument_count = func_num_args();
	//获取参数，返回参数数组
  // $argument = func_get_args();

	global $allFiles;
	if(is_dir($dir)){
    if($dh = opendir($dir)){
      while(($file = readdir($dh)) !== false){
        if($file!="." && $file!=".."&&!is_dir($file)){
          list($filesname,$kzm)=explode(".",$file);//获取扩展名
          // 判断文件类型是否和传入的文件类型匹配
          if($kzm==$type){
						array_push($allFiles,$file);
          }
        }else if($file!="." && $file!=".."&&is_dir($file)){
					readDirFn($dir."/".$file,$type);
        }
      }
      closedir($dh);
    }
  }
}
// 将online主分支里面的样式表名称写入到数组里
readDirFn($m,"css");
//print_r($allFiles);

// 复制文件夹里面的文件,
function copyFile($arr,$dir,$tar){
	// 复制文件到 $tar 目标文件
	if(is_dir($dir)){
    if($dh = opendir($dir)){
      while(($file = readdir($dh)) !== false){
        if($file!="." && $file!=".."&&!is_dir($file)){
          list($filesname,$kzm)=explode(".",$file);//获取扩展名
          // 判断文件类型是否和传入的文件类型匹配
          if(in_array($file,$arr)&&!file_exists($tar."/".$file)){
						copy($dir."/".$file,$tar."/".$file);
          }
        }else if($file!="." && $file!=".."&&is_dir($file)){
					copyFile($arr,$dir."/".$file);
        }
      }
      closedir($dh);
    }
  }
}
// 判断是否复制文件
if($gain){
	copyFile($allFiles,$s,$t);
}


function showList($arr){
	if($arr){
		foreach($arr as $key=>$val){
			echo '<li><span class="t">'.$val[0].'</span><div class="m">'.$val[2].'</div><div class="f"><span class="icon select"></span><span class="icon editor"></span></div></li>';
		}
	}
}

?>
<div id="address" class="address">
	<div class="show-box">
		<h3>记录</h3>
		<ol class="show-list" id="showList">
			<li class="no-number"><span class="t">标题</span><div class="m">目标文件路径</div><div class="f"><span class="icon select"></span><span class="icon editor"></span></div></li>
			<?php showList($data); ?>
		</ol>
	</div>
	<div class="item" id="current">
		<span class="add"></span>
		<h3>复制样式表</h3>
		<form action="" method="get" id="form">
			<input type="text" name="gain" class="hide" />
			<input type="text" name="write" class="hide" />
		<ul id="infoList">
			<li>
				<span class="t">名字：</span>
				<div class="m">
					<?php if(!$n){ ?>
					<input type="text" name="n" id="name">
					<?php }else{ ?>
					<input type="text" name="n" id="name" value="<?php echo $n; ?>">
					<?php } ?>
				</div>
			</li>
			<li>
				<span class="t">发布主分支：</span>
				<div class="m">
					<?php if(!$m){ ?>
					<input type="text" name="m" id="mailine">
					<?php }else{ ?>
					<input type="text" name="m" id="mailine" value="<?php echo $m; ?>">
					<?php } ?>
				</div>
			</li>
			<li>
				<span class="t">源文件夹：</span>
				<div class="m">
					<?php if(!$s){ ?>
					<input type="text" name="s" id="source">
					<?php }else{ ?>
					<input type="text" name="s" id="source" value="<?php echo $s; ?>">
					<?php } ?>
				</div>
			</li>
			<li>
				<span class="t">目标文件夹：</span>
				<div class="m">
					<?php if(!$t){ ?>
					<input type="text" name="t" id="target">
					<?php }else{ ?>
					<input type="text" name="t" id="target" value="<?php echo $t; ?>">
					<?php } ?>
				</div>
			</li>
			<li><input type="submit" value="获取文件" id="getFile"><input type="submit" value="确认" id="submit"></li>
		</ul>
		</form>
	</div>
</div>
<script>
var $ = {
	getAttr : function(p,t,attr,v){
		var arr = p.getElementsByTagName(t);
		var result = [];
		for(var i in arr){
			if(arr[i][attr] == v){
				result.push(arr[i]);
			}
		}
		return result;
	},
	trim : function(str){
		return str.replace(/^\s*|\s*$/gm,"");
	},
	trimLeft : function(str){
		return str.replace(/^\s*/gm,"");
	},
	trimRight : function(str){
		return str.replace(/\s$*/gm,"");
	},
	detection : function(arr){
		var is_submit = true;
		/*if(!this.trim(oname.value)){
			oname.className = "error";
			is_submit = false;
		}
		if(!this.trim(osource.value)){
			osource.className = "error";
			is_submit = false;
		}
		if(!this.trim(otarget.value)){
			otarget.className = "error";
			is_submit = false;
		}*/
		for(var i in arr){
			var val = this.trim(arr[i].value);
			if(!val){
				arr[i].className = "error";
				is_submit = false;
			}
			arr[i].value = val;
		}
		return is_submit;
	}
}

var osource = document.querySelector("#source"),
	oinfoList = document.querySelector("#infoList"),
	omailine = document.querySelector("#mailine"),
	otarget = document.querySelector("#target"),
	oname = document.querySelector("#name"),
	ogetFile = document.querySelector("#getFile"),
	osubmit = document.querySelector("#submit"),
	oform = document.querySelector("#form");

var aTxt = $.getAttr(oinfoList,"input","type","text");

// 给input添加focus和blur事件
function addEvent(){
	for(var i in aTxt){
		// input 聚焦不提示
		aTxt[i].addEventListener("focus",function(){
			this.className = "";
		},false);
		// input 失焦没有内容提示
		aTxt[i].addEventListener("blur",function(){
			if(!$.trim(this.value)){
				this.className = "error";
			}
		},false);
	}
}
addEvent();


osubmit.addEventListener("click",function(event){
	var oevent = event || window.event;
	var is_submit = $.detection(aTxt);
	//return false;
	if(!is_submit){
		// 阻止提交
		oevent.preventDefault();
		// 阻止冒泡
		// oevent.stopPropagation();
	}
	oform.write.value = true;
},false);

// 获取文件
ogetFile.addEventListener("click",function(event){
	var oevent = event || window.event;
	var is_submit = $.detection(aTxt);
	//return false;
	if(!is_submit){
		// 阻止提交
		oevent.preventDefault();
		// 阻止冒泡
		// oevent.stopPropagation();
	}
	oform.gain.value = true;
},false);
</script>
</body>
</html>