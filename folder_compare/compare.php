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
input.onlyread{background:#f9f9f9;}
.hide{display:none !important;}
.address{margin:20px auto;width:40%;display:table;*zoom:1;}
.item{width:100%;float:left;border:3px solid #ccc;background:#fff;padding:15px;line-height:36px;position:relative;}
.item-h{margin:-15px -15px 10px;padding:0 15px;background:#f0f0f0;color:#333;}
.item li{padding-left:90px;margin-top:15px;position:relative;}
.item .t{position:absolute;left:0;top:0;}
.show-box{margin:30px 0;}
.show-list li{position:relative;height:30px;line-height:30px;list-style:decimal outside;margin-left:20px;}
.show-list .no-number{list-style:none;}
.show-list .current{color:#4285F4;}
.show-list .t{position:absolute;top:0;width:80px;white-space:nowrap;text-overflow:ellipsis;overflow:hidden;}
.show-list .m{margin:0 90px 0 80px;}
.show-list .f{position:absolute;right:0;top:0;width:90px;height:30px;}
.icon{float:right;width:30px;height:30px;position:relative;cursor:pointer;font-size:0;}
.icon::before,.icon::after{content:"";position:absolute;left:50%;top:50%;background:#ccc;}

.editor::before{width:16px;height:6px;transform:rotate(-45deg);margin-left:-8px;margin-top:-3px;}
.editor::after{width:0;height:0;overflow:hidden;border:2px solid #ccc;background:transparent;border-color:transparent transparent #ccc #ccc;margin-left:-8px;margin-top:4px;}
.editor:hover::before{background:#4285F4;}
.editor:hover::after{border-color:transparent transparent #4285F4 #4285F4;}

.select::before{width:8px;height:3px;transform:rotate(45deg);margin-left:-8px;}
.select::after{width:15px;height:3px;transform:rotate(-45deg);margin-left:-5px;margin-top:-2px;}
.select:hover::before,.select:hover::after,.current .select::before,.current .select::after{background:#4285F4;}

.delete::before{width:16px;height:4px;margin-left:-8px;}
.delete:hover::before{background:#4285F4;}

.add::before{width:16px;height:4px;margin-left:-8px;margin-top:-2px;}
.add::after{width:4px;height:16px;margin-left:-2px;margin-top:-8px;}
.add:hover::after,.add:hover::before{background:#4285F4;}
	</style>
</head>
<body>
<?php 

$n = isset($_GET["n"]) ? $_GET["n"] : false;
$m = isset($_GET["m"]) ? $_GET["m"] : false;
$s = isset($_GET["s"]) ? $_GET["s"] : false;
$t = isset($_GET["t"]) ? $_GET["t"] : false;

// 当前选中第几个
// $num = isset($_GET["num"]) ? $_GET["num"] : 0;

// 是否复制文件
$gain = isset($_GET["gain"]) ? $_GET["gain"] : false;

// 是否写入数据
$write = isset($_GET["write"]) ? $_GET["write"] : false;

// 是否删除数据
$delete = isset($_GET["deleteinfo"]) ? $_GET["deleteinfo"] : false;

// 写入数据文件的数组
$inArr = array();

// 设置json文件路径
$path = "compare_data.json";

// 创建一个数组用于存放数据的名字部分
$data_name = array();

// 判断文件是否存在，且有内容不为空
if(file_exists($path)&&filesize($path)!=0){
	//echo 123;
	// 获取json文件
	$json = file_get_contents($path);
	// 将获取到的json文件字符串转换为数组
	$data = json_decode($json);

	// 如果需要删除数据，则删除相关数据
	if($delete){
		foreach($data as $key => $val){
			if($val[0]==$delete){
				array_splice($data,$key,1);
			}
		}
		// 将结果数组解析成字符串
		$json = json_encode($data);

		// 将字符串写入到文件
		writeFn($path,$json);
	}
	//print_r($data);

	// 将数据写入页面供js使用
	echo "<script>var json = ".$json."</script>";
}else{
	$data = false;
	$json = "\"\"";
	echo "<script>var json = ".$json."</script>";
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
			$isThree = false;
			// 如果要存入的数据在原数据中存在，则替换原来的数据
			if($n==$val[0]){
				$isThree = true;
				// unset($data[$key]);
				$middleArr = array();
				array_push($middleArr,$arr);
				array_splice($data,$key,1,$middleArr);
			}
		}
		if(!$isThree){
			// 将新数据添加到数据的前面
			// array_unshift($data,$arr);
			array_push($data,$arr);
		}
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


// 将要复制的文件名写入数组(发布分支里面的样式图片)
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
// 输出要复制的文件
/*print_r($allFiles);
echo "<br />";*/

// 将复制的样式写入数组
$copyFiles = array();

// 将要复制的文件夹里面的重复的文件放入改数组
$trimFile = array();

// 复制文件夹里面的文件,
function copyFile($arr,$dir,$tar){
	global $copyFiles,$trimFile;
	// 复制文件到 $tar 目标文件
	if(is_dir($dir)){
    if($dh = opendir($dir)){
      while(($file = readdir($dh)) !== false){
        if($file!="." && $file!=".."&&!is_dir($dir."/".$file)){
					// echo $file."<br />";
          list($filesname,$kzm)=explode(".",$file);//获取扩展名
          // 判断文件类型是否和传入的文件类型匹配
          if(in_array($file,$arr)){
						// 判断文件是否存在，如果存在，则不复制，否则就复制
						if(!file_exists($tar."/".$file)){
							// 将要复制的文件路径写入到数组末尾
							array_push($copyFiles,$dir."/".$file);
							// 复制文件
							copy($dir."/".$file,$tar."/".$file);
						}else{
							// 将要重复文件名的文件路径写入到数组末尾
							array_push($trimFile,$dir."/".$file);
						}
          }
        }else if($file!="." && $file!=".."&&is_dir($dir."/".$file)&&$file!="wip"&&$file!="bak"){// 如果是文件夹，且不是wip或bak文件夹
					copyFile($arr,$dir."/".$file,$tar);
        }
      }
      closedir($dh);
    }
  }
}
// 判断是否复制文件
if($gain){
	copyFile($allFiles,$s,$t);
	/*echo "复制的文件";
	print_r($copyFiles);
	echo "<br />重复的文件";
	print_r($trimFile);*/
}

// 根据数据写入内容
function showList($arr){
	if($arr){
		foreach($arr as $key=>$val){
			echo '<li><span class="t">'.$val[0].'</span><div class="m">'.$val[2].'</div><div class="f"><span class="icon select" title="选择">选择</span><span class="icon editor" title="编辑">编辑</span><span class="icon delete" title="删除">删除</span></div></li>';
		}
	}
}

// 如果有修改数据、填写数据或删除数据，则重定向页面
if($n||$delete){
	Header("HTTP/1.1 303 See Other"); 
	Header("Location: http://prototype.local.sh.ctriptravel.com/code_beta/a_practice/folder_compare/compare.php");
	exit; //from www.w3sky.com 
}

?>
<div id="address" class="address">
	<div class="show-box">
		<h3>记录</h3>
		<ol class="show-list">
			<li class="no-number"><span class="t">标题</span><div class="m">目标文件路径</div><div class="f"><span class="icon add" id="addInfo"></span></div></li>
		</ol>
		<ol class="show-list" id="showList">
			<?php showList($data); ?>
		</ol>
	</div>
	<div class="item" id="current">
		<h3 id="title" class="item-h">复制样式表</h3>
		<form action="" method="get" id="form">
			<input type="text" name="gain" class="hide" />
			<input type="text" name="write" class="hide" />
			<input type="text" name="deleteinfo" class="hide" />
		<ul id="infoList">
			<li>
				<span class="t">名字：</span>
				<div class="m">
					<input type="text" name="n" id="name" <?php if($json&&$json!="[]"){echo "readonly";} ?> value="<?php if($n){ echo $n; } ?>">
				</div>
			</li>
			<li>
				<span class="t">发布主分支：</span>
				<div class="m">
					<input type="text" name="m" id="mailine" <?php if($json&&$json!="[]"){echo "readonly";} ?> value="<?php if($m){ echo $m; } ?>">
				</div>
			</li>
			<li>
				<span class="t">源文件夹：</span>
				<div class="m">
					<input type="text" name="s" id="source" <?php if($json&&$json!="[]"){echo "readonly";} ?> value="<?php if($s){ echo $s; } ?>">
				</div>
			</li>
			<li>
				<span class="t">目标文件夹：</span>
				<div class="m">
					<input type="text" name="t" id="target" <?php if($json&&$json!="[]"){echo "readonly";} ?> value="<?php if($t){ echo $t; } ?>">
				</div>
			</li>
			<li><input type="submit" value="获取文件" id="getFile" class=<?php if(!($json&&$json!="[]")){echo "hide";} ?> ><input type="submit" value="确认" id="submit" class=<?php if($json&&$json!="[]"){echo "hide";} ?> /></li>
		</ul>
		</form>
	</div>
</div>
<script>
var $ = {
	getAttr : function(p,t,attr,v){
		var arr = p.getElementsByTagName(t);
		var result = [];
		for(var i=0;i<arr.length;i++){
			if(arr[i][attr] == v){
				result.push(arr[i]);
			}
		}
		return result;
	},
	getClass : function(p,t,c){
		var arr = p.getElementsByTagName(t),
			len = arr.length;
		var result = [];
		for(var i=0;i<len;i++){
			/*if(arr[i]["classList"].indexOf(c)!=-1){
				result.push(arr[i]);
			}*/
			if(arr[i].className.split(" ").indexOf(c)!=-1){
				result.push(arr[i]);
			}
		}
		return result;
	},
	addClass : function(o,c){
		if(!o.className){
			o.className = c;
		}else{
			var arr = o.className.split(" ");
			if(arr.indexOf(c)==-1){
				arr.push(c);
			}
			o.className = arr.join(" ");
		}
	},
	removeClass : function(o,c){
		var arr = o.className.split(" ");
		var num = arr.indexOf(c);
		if(num!=-1){
			arr.splice(num,1);
		}
		o.className = arr.join(" ");
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
				// arr[i].className = "error";
				$.addClass(arr[i],"error");
				is_submit = false;
			}
			arr[i].value = val;
		}
		return is_submit;
	},
	canedit : function(arr){
		// console.log(arr);
		for(var i=0;i<arr.length;i++){
			//arr[i].setAttribute("disabled",false);
			arr[i].readOnly = false;
		}
	},
	cannoedit : function(arr){
		for(var i=0;i<arr.length;i++){
			arr[i].readOnly = true;
		}
	},
	onlyone : function(arr,cur,classN){
		for(var i=0;i<arr.length;i++){
			$.removeClass(arr[i].parentNode.parentNode,classN);
			// arr[i].parentNode.parentNode.className = "";
		}
		$.addClass(cur.parentNode.parentNode,classN);
		// cur.parentNode.parentNode.className = classN;
	}
}

// 当前是否是编辑状态
var is_editor = false;

// 将当前选择的是第几个写入localStorage
var localName = "num";
var num = 0;
if(window.localStorage){
	if(localStorage.getItem(localName)){
		num = localStorage.getItem(localName);
	}
}

var osource = document.querySelector("#source"),
	otitle = document.querySelector("#title"),
	oaddInfo = document.querySelector("#addInfo"),
	oshowList = document.querySelector("#showList"),
	oinfoList = document.querySelector("#infoList"),
	omailine = document.querySelector("#mailine"),
	otarget = document.querySelector("#target"),
	oname = document.querySelector("#name"),
	ogetFile = document.querySelector("#getFile"),
	osubmit = document.querySelector("#submit"),
	oform = document.querySelector("#form");

var aTxt = $.getAttr(oinfoList,"input","type","text"),
	aSelect = $.getClass(oshowList,"span","select"),
	aEditor = $.getClass(oshowList,"span","editor"),
	aDelete = $.getClass(oshowList,"span","delete");



// 给input添加focus和blur事件
function addEvent(){
	for(var i in aTxt){
		// input 聚焦不提示
		aTxt[i].addEventListener("focus",function(){
			this.className = "";
		},false);
		// input 失焦没有内容提示
		aTxt[i].addEventListener("blur",function(){
			if(!$.trim(this.value)&&!this.readOnly){
				this.className = "error";
			}
		},false);
	}
}
addEvent();

// 选择按钮事件
function selectFn(){
	var len = aSelect.length;
	for(var i=0;i<len;i++){
		aSelect[i].index = i;
		aSelect[i].addEventListener("click",function(){
			if(this.parentNode.parentNode.className=="current"){
				return false;
			}else{
				$.onlyone(aSelect,this,"current");
				/*for(var i=0;i<aSelect.length;i++){
					aSelect[i].parentNode.parentNode.className = "";
				}
				this.parentNode.parentNode.className = "current";*/
				localStorage.setItem(localName,this.index);
				$.removeClass(ogetFile,"hide");
				$.addClass(osubmit,"hide");
				// 将内容填充到input
				fillInfoFn(aTxt,json[this.index]);
			}
			otitle.innerHTML = "复制样式表";
		},false);
	}
}
selectFn();

// 数据填充
function fillInfoFn(oarr,json){
	if(json){
		for(var i=0;i<oarr.length;i++){
			oarr[i].value = json[i];
		}
	}else{
		for(var i=0;i<oarr.length;i++){
			oarr[i].value = "";
		}
	}
}

// 默认将第一个数据填入
if(json){
	fillInfoFn(aTxt,json[num]);
}


// 编辑按钮事件
function editorFn(){
	var len = aEditor.length;
	for(var i=0;i<len;i++){
		aEditor[i].index = i;
		aEditor[i].addEventListener("click",function(){
			$.canedit(aTxt);
			// 将当前数据写入input
			fillInfoFn(aTxt,json[this.index]);
			$.addClass(ogetFile,"hide");
			$.removeClass(osubmit,"hide");
			otitle.innerHTML = "编辑";
		},false);
	}
}
editorFn();

// 删除按钮事件
function deleteFn(){
	var len = aDelete.length;
	for(var i=0;i<len;i++){
		aDelete[i].index = i;
		aDelete[i].addEventListener("click",function(){
			// oform.deleteinfo.value = json[this.index][0];
			// 判断删除的是选中的信息之前的，则将标注数字提前一个
			if(this.index<num){
				num -= 1;
			}else if(this.index==num){ // 如果删除的是选择的当前行，则将标注改成第一个
				num = 0;
			}
			localStorage.setItem(localName,num);

			var str = json[this.index][0];
			location.href = location.href+"?deleteinfo="+str;
		},false);
	}
}
deleteFn();

if(json.length){
	// 设置默认显示的信息
	$.addClass(aSelect[num].parentNode.parentNode,"current");
}

// 添加一条信息
oaddInfo.addEventListener("click",function(event){
	$.canedit(aTxt);
	fillInfoFn(aTxt,false);
	$.addClass(ogetFile,"hide");
	$.removeClass(osubmit,"hide");
	otitle.innerHTML = "添加";
},false);

// 确认添加或修改
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

// 复制文件
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