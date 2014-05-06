<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>获取 UserAgent 信息</title>
</head>
<body>
  <div class="box">
    <h3>php获取</h3>
    <p><?php echo $_SERVER['HTTP_USER_AGENT']; ?></p>
  </div>
  <div class="box">
    <h3>js获取</h3>
    <p id="view"></p>
  </div>
  <script>
var oview = document.getElementById("view");
oview.innerHTML = navigator.userAgent;
  </script>
</body>
</html>