<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>二维码生成</title>
<style>
*{box-sizing:content-box;}
body{font:14px/1.5em tahoma,arial,"Microsoft yahei";color:#666;}
.wrap{width:400px;margin:0 auto;}
.show_qr{margin:30px auto;text-align:center;}
.show_qr img{max-width:100%;}
.txt{width:100%;height:32px;line-height:24px;padding:3px;border:1px solid #999;border-radius:3px;box-sizing:border-box;}
.btn{height:32px;border:1px solid #333;padding:0 15px;cursor:pointer;color:#fff;margin:10px 0;border-radius:3px;
background:-webkit-linear-gradient(top,#555,#444);
}
</style>
</head>
<body>
<div class="wrap">
<h1>二维码生成器</h1>
<?php
/**
 * 使用phpqrcode生成二维码
 * $chl参数：二维码内容
 * $size参数：生成二维码的尺寸，width*height
 * $level参数：可选参数，纠错等级，L-(默认)可以识别已损失7%的数据；M-可以识别已损失15%的数据；Q-可以识别已损失25%的数据；H-可以识别已损失30%的数据;
 * $margin 是指生成的二维码离边框的距离;
*/
function qrssss($data){
  $level = 'Q';
  $size = 8;
  $logo = 'logo.jpg';
  $QR = 'qrcode.png';
  $margin = 0;
  QRcode::png($data,$QR,$level,$size,$margin);
  echo "<img src='".$QR."'/>";

  // 用新生成的二维码图片覆盖原来那个为二维码图片，达到logo嵌入效果
  if($logo !== FALSE){
    $QR = imagecreatefromstring(file_get_contents($QR));
    $logo = imagecreatefromstring(file_get_contents($logo));
    $QR_width = imagesx($QR);
    $QR_height = imagesy($QR);
    $logo_width = imagesx($logo);
    $logo_height = imagesy($logo);
    $logo_qr_width = $QR_width / 5;
    $scale = $logo_width / $logo_qr_width;
    $logo_qr_height = $logo_height / $scale;
    $from_width = ($QR_width - $logo_qr_width) / 2;
    imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
  }
  imagepng($QR,'qrcode.png');
}

/**
 * 使用google api生成二维码
 * $chl参数：二维码内容
 * $size参数：生成二维码的尺寸，width*height
 * $level参数：可选参数，纠错等级，L-(默认)可以识别已损失7%的数据；M-可以识别已损失15%的数据；Q-可以识别已损失25%的数据；H-可以识别已损失30%的数据;
 * $margin 是指生成的二维码离边框的距离;
*/
function generateQRfromGoogle($chl, $size = '300', $level = 'L', $margin= '0') {
  $chl = urlencode($chl);
  $img = '<img src="http://chart.apis.google.com/chart?chs='.$size.'x'.$size.'&amp;cht=qr&chld='.$level.'|'.$margin.'&amp;chl='.$chl.'" alt="使用Google api生成二维码" widht="'.$size.'" height="'.$size.'" />';
  return $img;
}
?>
<div class="show_qr">
<?php 
if(isset($_POST["qrcode"])){
  $data = $_POST["qrcode"];
  // 利用 phpQRcode 生成二维码
  include('QRcode.php');
  qrssss($data);


  // google QRcode 方法2
  //echo generateQRfromGoogle($data);
}else{
  echo "<p>链接地址不正确或没有填写，请重新输入</p>";
}
?>
</div>
<form action="index.php" method="post">
  <input type="text" class="txt" name="qrcode" placehoddle="输入地址"/><br /><input type="button" value="获取二维码" class="btn" />
</form>
</div>
<script>
var oTxt = document.querySelector(".txt"),
  oForm = document.getElementsByTagName("form")[0],
  oBtn = document.querySelector(".btn");
oTxt.onkeypress = function(event){
  if(event.keyCode==13){
    showQr();
  }
}
oBtn.onclick = showQr;
function showQr(){
  if(!oTxt.value){
    return false;
  }
  oForm.submit();
}
</script>
</body>
</html>