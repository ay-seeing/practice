<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>写入</title>
</head>
<body>
<?php
if(isset($_GET["data"])){
	$data = $_GET["data"];
}

$file = fopen("answer.json","w");
echo fwrite($file,$data);
fclose($file);
//转换为json对象
//json_decode($data);


echo"<script>window.close();</script>";
?>
</body>
</html>