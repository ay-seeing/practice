<?php
include('QRcode.php');
//$url=dirname('http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]);
?>
<form action="index.php">
  <input type="text" class="txt" name="qrcode" placehoddle="输入地址"/><input type="button" value="获取二维码" class="btn" />
</form>
<div class="show-qr">
<?php 
if(isset($_POST["qrcode"])){
  QRcode::png ($_POST["qrcode"].'/index.php');
}
 ?>
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