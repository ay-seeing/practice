<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>写入</title>
</head>
<body>
<?php
$filePath = "answer.json";
if(isset($_GET["data"])){
	$data = $_GET["data"];
	$file = fopen($filePath,"w");
	echo fwrite($file,$data);
	fclose($file);
}

//转换为json对象
//json_decode($data);


// delete answer.js file
if(isset($_GET["deletefile"]) && $_GET["deletefile"] == true){
	if (file_exists($filePath)){
		if(unlink($filePath)){
			echo("Deleted $filePath");
		}else{
			echo("Error deleting $filePath");
		}
	}
}

if(!isset($_GET["close"])){
	echo"<script>window.close();</script>";
}
?>
</body>
</html>