<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="gb2312">
	<title>php�����ж�</title>
	<style>
*{margin:0;padding:0;}
body{font-size:14px;line-height:1.5em;font-family:tahoma,arial,"microsoft yahei";color:#666;}
.wraper{width:800px;margin:10px auto;}
ul,li,ol{list-style:none;}
.red{color:red;}
.green{color:green;}
.blue{color:blue;}
.demo-interaction-panel{top:50px !important;}
	</style>
</head>
<body>
<?php include($_SERVER['DOCUMENT_ROOT']."/code_beta/a_practice/php-judge/panelGBK.php"); ?>
<?php /*include("../panel.php");*/ ?>




<?php 
// send ע��
$asend = array("����1","send1","send2","send3","send4");
$send = getOneParameter("send",$asend,false);

// type ע��
$atype =  array("����2","type1","type2","type3","type4");
$type = getOneParameter("type",$atype,false);

// type ע��
$es =  array("����3","12","34");
$ee = getOneParameter("eee",$es,true);
 ?>

<div class="wraper">

	<?php  if($send==1){ ?>
		<div class="red">��send=1ʱ����ʾ</div>
	<?php  }elseif($send==2){ ?>
		<div class="green">��send=2ʱ����ʾ</div>
	<?php  }elseif($send==3){ ?>
		<div class="blue">��send=3ʱ����ʾ</div>
	<?php  }elseif($send==4){ ?>
		<div>��send=4ʱ����ʾ</div>
	<?php } ?>

	<?php  if($type==1){ ?>
		<div class="red">��type=1ʱ����ʾ</div>
	<?php  }elseif($type==2){ ?>
		<div class="green">��type=2ʱ����ʾ</div>
	<?php  }elseif($type==3){ ?>
		<div class="blue">��type=3ʱ����ʾ</div>
	<?php  }elseif($type==4){ ?>
		<div>��type=4ʱ����ʾ</div>
	<?php } ?>

</div>
</body>
</html>