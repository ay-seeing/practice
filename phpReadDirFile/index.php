<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>php循环目录读取文件</title>
</head>
<body>
<?php 
$parentDir = dirname(__FILE__);
//echo $parentDir;
//echo array_pop(explode("\\",$parentDir));
//preg_split("/\\",$parentDir,)

$aInfo = Array();


function listDir($dir){
	if(!$aInfo){
		global $aInfo;
	}
	if(is_dir($dir)){
		if ($dh = opendir($dir)){
			while (($file = readdir($dh)) !== false){
				if((is_dir($dir."/".$file)) && $file!="." && $file!=".."){
					//echo "<b><font color='red'>文件名：</font></b>",$file,"<br><hr>";
					listDir($dir."/".$file);
				}else{
					if($file!="." && $file!=".."){
						array_push($aInfo,getFileOneLine($dir."/".$file));
						//echo $dir."/".$file."<br>";
					
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
listDir("./test");
print_r($aInfo);
 ?>
</body>
</html>