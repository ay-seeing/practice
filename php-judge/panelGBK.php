<!-- ������������-start -->
<?php 
//$test=array(10,20,30,"10",10,"20","30");
//print_r(array_keys($test,10,true));
//print_r(pathinfo(__FILE__));
// ������
$configuration = array(
	"wip"=>"wip", // ���ÿ�����Ŀ¼����
	"wipPath"=>"../wip" // ���ÿ�����Ŀ¼������Ը���������֧�����·��
);
$hostPath = $_SERVER["HTTP_HOST"];
// ��ǰ�ļ�����Ŀ¼���·��
$relativePath = $_SERVER["PHP_SELF"];
//echo $_SERVER["SCRIPT_NAME"];
$relativePath = $hostPath.$relativePath;
// ��ȡ������ļ����ļ�·��
$currentDirPathUrl = $_SERVER["SCRIPT_NAME"];

// ��ǰ�ļ�����Ŀ¼·��(��include��������õ����ǵ�ǰ�ļ��Ķ��������뵽���ļ���Ŀ¼)
//$currentDirPath = dirname(__FILE__);
//������ķ��������ȡ��ǰ�ļ�����Ŀ¼����
$currentDirPath = preg_split("/[\\\\\/]/",$currentDirPathUrl);
$currentDirPathCount = count($currentDirPath);
$currentDirPath = $currentDirPath[$currentDirPathCount-2];
//echo $currentDirPath;
// ��ǰ�ļ�����(��include��������õ����ǵ�ǰ�ļ��Ķ��������뵽���ļ�������)
//$currentFile = basename(__FILE__);
//������ķ��������ȡ��ǰ�ļ�����
$currentFile = array_pop(preg_split("/[\\\\\/]/",$currentDirPathUrl));
//echo $currentFile;
// ��ǰ�ļ�����Ŀ¼·������������
$aDir = preg_split("/[\\\\\/]/",$relativePath);
// ��ǰ�ļ�����Ŀ¼����
$currentDir = array_pop(preg_split("/[\\\\\/]/",$currentDirPath));

// ��ȡ��Ŀ¼����
$mainDir = explode("-",$currentDir);
$mainDir = $mainDir[0];

$otherstr = iconv("gb2312","utf-8","������֧");
$aInfo = Array($otherstr);

// �жϵ�ǰ�ļ��Ƿ��ڷ�֧����
if(in_array($configuration["wip"],$aDir)){
	//preg_replace("/[\\\\\/]/","",$currentDirPath);
	$pattern='/[\\\\\/]'.$configuration["wip"].'[\\\\\/].+/';
	$dir = preg_replace($pattern,"",$relativePath);
	$manPath = "http://".$dir."/".$mainDir."/".$currentFile;
	// gbk������ת��
	$getstr = iconv("gb2312","utf-8","����֧");
	array_push($aInfo,array($getstr,$manPath));
	loopTree("../..");

	//$tier = count($aDir);
	/*echo $currentDirPath."<br />";
	echo $dir."<br />";*/
	//echo $_SERVER['HTTP_USER_AGENT'];
	//$wip_path = array_keys($aDir,$configuration["wip"],true);
	//echo $wip_path[0];
	//echo $currentDirPath."---".$wip_path;
}else{
	loopTree($configuration["wipPath"]);
}

$resultType = array($aInfo);




// ��ȡ���ӵ�ַ
function getHath($key,$num){
	// ��ȡurl��hashֵ
	$urlPath = $_SERVER["QUERY_STRING"];
	if(empty($urlPath)){
		return "?".$key."=".$num;
	}
	// ���� $key ��λ��
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

// ��ȡ��֧·��
function loopTree($dir){
	$currentDirPathUrl = $_SERVER["SCRIPT_NAME"];
	if(!isset($aInfo)){
			global $aInfo;
		}
	// ��ȡ��ǰ�ļ����������жϷ�֧����ļ��Ƿ�Ϊ���ļ��ķ�֧
	//$currentFileName = basename(__FILE__);
	$currentFileName = array_pop(preg_split("/[\\\\\/]/",$currentDirPathUrl));
	// �����ļ�����·��
	//__FILE__;
	// ��ȡ��ǰ�ļ�������Ŀ¼����
	//$parentDir = dirname(__FILE__);
	$parentDir = preg_split("/[\\\\\/]/",$currentDirPathUrl);
	$currentDirPathCount = count($parentDir);
	$parentDir = $parentDir[$currentDirPathCount-2];
	//echo $parentDir;
	//echo array_pop(explode("\\",$parentDir));
	$name = array_pop(preg_split("/[\\\\\/]/",$parentDir));

	// $dirĿ¼��$name��ǰ�ļ�����Ŀ¼���ơ�$fileName��ǰ�ļ�����
	function listDir($dir,$name,$fileName){
		if(!isset($aInfo)){
			global $aInfo;
		}
		if(is_dir($dir)){
			if ($dh = opendir($dir)){
				while (($file = readdir($dh)) !== false){
					if((is_dir($dir."/".$file)) && $file!="." && $file!=".."){
						//echo "<b><font color='red'>�ļ�����</font></b>",$file,"<br><hr>";
						listDir($dir."/".$file,$name,$fileName);
					}else{
						if($file!="." && $file!=".." && $file==$fileName){
							// ��ȡ��ǰ�ļ�����Ŀ¼���������ж��Ƿ�Ϊ����֧�ķ�֧
							$curentParent = array_pop(preg_split("/[\\\\\/]/",$dir));
							if($curentParent!=$name){
								$mainDirName = explode("-",$curentParent);
								$branchDirName = explode("-",$name);
								//if(strpos($curentParent,$name)!==false){
								if($mainDirName[0]==$branchDirName[0]&&getFileOneLine($dir."/".$file)){
									//print_r(getFileOneLine($dir."/".$file));
									array_push($aInfo,getFileOneLine($dir."/".$file));
								}
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
		��ȡ�����ļ�
		while (!feof($f))
		{
			$line = fgets($f);
			echo "site: ",$line,"<br />";
		}*/
		// ��õ�һ��
		$line = fgets($f);
		fclose($f);
		//return $line;
		return getInfo($path,$line);

		/*//��ʾ���һ��
		$fp = file("e:/test/users1.sql");
		echo $fp[count($fp)-1];*/
	}
	function getInfo($path,$str){
		if(preg_match("/@(.*?)@/i", $str, $matches)){
			// gbk������ת��
			$getstr = iconv("gb2312","utf-8",$matches[1]);
			$arr = Array($getstr,$path);
			return $arr;
		}
	}
	//print_r(getFileOneLine("test/test3/c.php"));
	listDir($dir,$name,$currentFileName);
	//echo json_encode($aInfo);
}


//��ȡĳһ������
function getOneParameter($Parameter,$asend,$end){
	if(!isset($resultType)){
		global $resultType;
	}
	if($Parameter!=""){
		// ��ȡĳ��������ֵ
		$send = isset($_GET[$Parameter])?$_GET[$Parameter]:1;
		$getstr = iconv("gb2312","utf-8",$asend[0]);
		$a_send = array($getstr);
		foreach($asend as $key => $value){
			if($key!=0){
				//array($send,"��������",��ַ����������),
				$otherstr = iconv("gb2312","utf-8",$value);
				$arr = array($key,$otherstr,getHath($Parameter,$key));
				array_push($a_send,$arr);
			}
		}
		array_push($resultType,$a_send);
		if(isset($end)&&$end){
			echo "<textarea id='demoData' style='display:none;'>".json_encode($resultType)."</textarea>";
		}
		return $send;
	}else{
		if(isset($end)&&$end){
			echo "<textarea id='demoData' style='display:none;'>".json_encode($resultType)."</textarea>";
		}
	}
}

?>


<style>
.demo-interaction-panel{position:fixed;top:5px;left:5px;z-index:9999;max-width:300px;border:2px solid #666;background:white;
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
<div class="demo-interaction-panel" id="demoInteractionPanel">
	<div class="demo-panel-hd" id="demoPanelHd"><h3 class="demo-panel-title">�������</h3><span class="demo-min" id="demoMin">��С</span></div>
	<div class="demo-panel-bd" id="demoPanelBd">
	</div>
</div>
<script>
function addloads(func) {
  if(window.addEventListener){
    window.addEventListener("load",func);
  }else{
    var old = window.onload;
    if (typeof window.onload != "function") {
        window.onload = func;
    } else {
        window.onload = function() {
            old();
            func();
        }
    }
  }
};
addloads(panelFn);
//window.addEventListener("load",panelFn);
function panelFn(){
	var odata = document.getElementById("demoData"),
		data = odata.value,
		ominBtn = document.getElementById("demoMin"),
		odemoInteractionPanel = document.getElementById("demoInteractionPanel"),
		odemoPanelBd = document.getElementById("demoPanelBd");
	if(JSON.parse){
		data = JSON.parse(data);
	}else{
		data = eval ("(" + data + ")");
	}
	
	// û���������˳�
	if(data.length==1&&data[0].length==1){
		odemoInteractionPanel.style.display = "none";
		return false;
	}

	for(var i=0;i<data.length;i++){
		// ��ĳ��ֻ�б���ʱ����
		if(data[i].length==1){
			continue;
		}
		
		var oCreateItem = document.createElement("div");
		oCreateItem.className = "demo-type demo-branch-list";
		var oh4 = document.createElement("h4");
		oh4.className = "demo-h4";
		oh4.innerHTML = data[i][0];
		var oUl = document.createElement("ul");
		oUl.className = "demo-list";
		
		//���õ�ǰul��Ӧ��hash�ؼ���
		if(i>0){
			oUl.setAttribute("dataType",data[i][1][2].substring(1).split("&").pop().split("=")[0]);
		}

		for(var j=1;j<data[i].length;j++){
			if(i==0){
				oUl.innerHTML += "<li><a href='"+data[i][j][1]+"'>"+data[i][j][0]+"</a></li>";
			}else{
				oUl.innerHTML += "<li><a href='"+data[i][j][2]+"'>"+data[i][j][1]+"</a></li>";
			}
		}
		oCreateItem.appendChild(oh4);
		oCreateItem.appendChild(oUl);
		odemoPanelBd.appendChild(oCreateItem);
	}

	var panel_a = odemoPanelBd.getElementsByTagName("a"),
	panel_ul = odemoPanelBd.getElementsByTagName("ul");
	var hash;
	//��ȡurl�еĲ���
	var url = location.href;
	if(url.indexOf("?")==-1){
		hash = "";
		/*for(var q=1;q<panel_ul.length;q++){
			hash += "&"+panel_ul[q].getAttribute("datatype")+"=1";
		}*/
	}else{
		hash = location.href.split("?")[1];
	}
	for(var q=1;q<panel_ul.length;q++){
		if(hash.indexOf(panel_ul[q].getAttribute("datatype"))==-1){
			hash += "&"+panel_ul[q].getAttribute("datatype")+"=1";
		}
	}
	if(hash&&hash.indexOf("&")==0){
		hash = hash.substring(1);
	}
	aHash = hash.split("&");
	//console.log(aHash);
	for(var m=0;m<panel_a.length;m++){
		//var listType = panel_a[m].parentNode.parentNode.getAttribute("datatype");
		var aHref = panel_a[m].href;
		if(aHref.indexOf("?")==-1){
			continue;
		}
		//var aHrefHash = panel_a[m].href.split("?")[1].split("&").pop();
		if(panel_a[m].href.indexOf("&")==-1){
			var aHrefHash = panel_a[m].href.split("?").pop();
		}else{
			var aHrefHash = panel_a[m].href.split("&").pop();
		}
		//console.log(aHrefHash);
		//var ocur = true;
		for(var n=0;n<aHash.length;n++){
			/*if(aHrefHash.indexOf(aHash[n])==-1){
				ocur = false;
			}*/
			if(aHrefHash==aHash[n]){
				panel_a[m].parentNode.className = "current";
			}
		}
		/*if(ocur){
			panel_a[m].parentNode.className = "current";
		}*/
	}




	//console.log(data);
	var oDemoMin = document.querySelector(".demo-min"),
		odemoPanel = document.querySelector(".demo-interaction-panel");
	oDemoMin.addEventListener("click",function(){
		if(odemoPanel.className =="demo-interaction-panel"){
			odemoPanel.className = "demo-interaction-panel demo-interaction-panel-min";
			oDemoMin.innerHTML = "չ��";
		}else{
			odemoPanel.className = "demo-interaction-panel";
			oDemoMin.innerHTML = "��С";
		}
	},false);
}
</script>
<!-- ������������-end -->