<?php /*@分支呢@*/ ?>
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
<?php include($_SERVER['DOCUMENT_ROOT']."/code_beta/a_practice/php-judge/panelUTF8.php"); ?>

<?php 
// send 注释
$asend = array("种类1","send1","send2","send3","send4");
$send = getOneParameter("send",$asend,false);

// type 注释
$atype =  array("种类2","type1","type2","type3","type4");
$type = getOneParameter("type",$atype,false);

// type 注释
$es =  array("种类3","12","34");
$ee = getOneParameter("eee",$es,true);
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
</body>
</html>