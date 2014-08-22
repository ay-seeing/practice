<?php /*@best test@*/ ?>
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
<?php include($_SERVER['DOCUMENT_ROOT']."/code_beta/a_practice/php-judge/panel.php"); ?>

<?php 
// send 注释
$asend = array("种类1","send1","send2","send3","send4");
$send = getOneParameter("send",$asend,false);

// type 注释
$atype =  array("种类2","type1","type2","type3","type4");
$type = getOneParameter("type",$atype,true);

 ?>
</body>
</html>