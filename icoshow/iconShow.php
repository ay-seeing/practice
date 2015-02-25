<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>jmp展示</title>
  <link rel="stylesheet" href="../../flight/book/css/book.css">
  <link rel="stylesheet" href="../../flight/search2.1/css/searchresult_v2.1.css">
  <script src="../js/cQuery_110421.js"></script>
  <script src="../js/jquery-1.8.3.min.js"></script>
<style>
*{margin:0;padding:0;}
body{font-size:12px;line-height:2;font-family:Tahoma, Arial, \5b8b\4f53, sans-serif;color:#555;}
header{display:block;background:#2577E3;color:white;margin-bottom:20px;}
header h1{font-weight:normal;text-align:center;}
em{font-style:normal;} 
.mt5{margin-top:5px;}
.auto_align{padding-left:calc(100vw - 100%);}
.wrap{width:90%;margin:0 auto;}
.wrap:after{content:"";display:table;height:0;overflow:hidden;clear:both;}
.iconShow-list{margin:20px 0;}
.iconShow-list:after{content:"";display:table;height:0;overflow:hidden;clear:both;}
.iconShow-list li.list-item{width:15%;display:inline-block;vertical-align:top;margin:10px 10px;border:1px solid #ccc;background:#f0f0f0;border-radius:3px;padding:8px;box-sizing:border-box;}
.iconShow-list .icon-item{min-height:40px;}
.iconShow-list .icon-item::after{content:"";display:table;clear:both;}
.iconShow-list .ico-parent{position:relative;}
.iconShow-list .ico-parent>span,.iconShow-list .ico-parent>em,.iconShow-list .ico-parent>i{left:0 !important;top:0 !important;margin:0 !important;}
.iconShow-list input{width:100%;line-height:2em;padding:3px;border:1px solid #999;box-sizing:border-box;}
</style>
</head>
<body>
<?php 
// 默认配置
$configuration = array(
  "path"=>"icon_tip", // 设置读取文件夹路径
  "type"=>"php" // 设置文件类型
);

// 获取当前文件所在目录路径
// $dirPath = dirname(__FILE__);
// 获取当前文件域名
$hostPath = $_SERVER["HTTP_HOST"];
// 获取文件域名后面的文件路径
$localUrl = $_SERVER["REQUEST_URI"];
// $hostName = $_SERVER["SCRIPT_NAME"];
// 获取文件路径，但不包括文件名
$url=dirname('http://'.$hostPath.$localUrl); 

// 遍历文件夹函数，传入文件夹路径和要遍历的文件后缀名
function listDir($dir,$name){
  // 判断是否为文件夹
  if(is_dir($dir)){
    // 打开文件夹
    if ($dh = opendir($dir)){
      // 循环文件夹
      while (($file = readdir($dh)) !== false){
        // 判断当前文件是否为文件夹
        if((is_dir($dir."/".$file)) && $file!="." && $file!=".."){
          //echo "<b><font color='red'>文件名：</font></b>",$file,"<br><hr>";
          listDir($dir."/".$file,$name);
        }else{
          // echo get_extension($file);
          if($file!="." && $file!=".." && get_extension($file)==$name){
            // 引入文件，传入文件路径
            include_file($dir."/".$file);
            // echo $dir."<br />";
          }
        }
      }
      closedir($dh);
    }
  }
}
// 获取文件后缀名
function get_extension($file){
  return substr(strrchr($file, '.'), 1);
}

// 获取页面第一行内容
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
  if($line){
    return getInfo($line);
  }

  /*//显示最后一行
  $fp = file("e:/test/users1.sql");
  echo $fp[count($fp)-1];*/
}

// 获取字符串中@@之间的字符
function getInfo($str){
  if(preg_match("/@(.*?)@/i", $str, $matches)){
    return trim($matches[1]);
  }
}


// 引入文件函数
function include_file($path){
  if(!isset($url)){
    global $url;
  }
  // 将注释里面的样式打散成数组
  $firstLine = getFileOneLine($path);
  if($firstLine){
    $line_arr = preg_split("/\s+/",$firstLine);
    if($line_arr[0]==""){
      array_shift($line_arr);
    }
  }
  
  echo "<li class='list-item'><div class='icon-item'>";// data-path=".$hostPath."/".$path."
  // 嵌套外层div-开始
  if($firstLine && $line_arr){
    foreach($line_arr as $n=>$v){
      // 判断是否传入dom标签，如果有标签，则创建该标签，否则创建默认的div
      if(strpos($v,".")!=0){
        $arr = explode(".",$v);
        echo "<$arr[0] class='$arr[1]'>";
      }else{
        $str = substr($v,1);
        echo "<div class='$str'>";
      }
    }
  }
  echo "<div class='ico-parent'>".iconv("gb2312","utf-8",file_get_contents($path))."</div>";
  // 嵌套外层div-结束
  if($firstLine && $line_arr){
    foreach($line_arr as $n=>$v){
      // 判断是否传入dom标签，如果有标签，则创建该标签，否则创建默认的div
        if(strpos($v,".")!=0){
          $arr = explode(".",$v);
          echo "</$arr[0]>";
        }else{
          echo "</div>";
        }
    }
  }
  echo "</div><div class=mt5><input type='text' value='".$url."/".$path."' /></div>";
  echo "</li>";
}
?>
<header class="auto_align"><h1 class="wrap">ico展示</h1></header>
<div class="wrap">
  <ul class="iconShow-list search_table">
    <?php listDir($configuration["path"],$configuration["type"]); ?>
  </ul>
</div>


<script>
// cQuery.config("namespace","cq");
(function($){
  $.ready(function () {
    $.mod.load('jmp','1.0',function(){
      var ins=$(document).regMod('jmp','1.0',{cc:2});
    });
  });
})(cQuery);
</script>

<div id="jmp_text" style="display: none" class="base_jmp jmp_text base_jmp_t">
    <div id="Div1" class="jmp_bd">
        ${txt0}</div>
</div>

<div class="tooltip" id="new_tip" style="display: none">
  ${txt0}
</div>

<div class="tooltip" id="jmp_base" style="display: none">
  ${txt0}
</div>

<div style="display: none" id="jmp_title">
    <div class="jmp_hd" style="width: 280px">
        <h3>${txt0}</h3>
    </div>
    <div class="jmp_bd" style="width: 260px">
        ${txt1}</div>
</div>

<div style="display: none; width: 480px" id="jmp_table">
    <table class="pubJmpInfo_romList01" style="width: 480px">
        <tbody>
            <tr>
                <th>计划机型 </th>
                <th>机型名称 </th>
                <th>类型 </th>
                <th>最少座位数 </th>
                <th class="pubJmpInfo_romList01_ritBorder">最多座位数 </th>
            </tr>
            <tr>
                <td id="array1">
                    ${txt0}
                </td>
                <td id="array2">
                    ${txt1}
                </td>
                <td id="array3">
                    ${txt2}
                </td>
                <td id="array4">
                    ${txt3}
                </td>
                <td id="array5" class="pubJmpInfo_romList01_ritBorder">
                    ${txt4}
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div style="display: none" id="jmp_table2">
     ${txt1}
</div>

<div class="pop-success" id="pop-success" style="display:none;">
  <table class="table_success_text">
      <tr class="tr_line">
        <th>成功率</th>
        <td>80%成功率保证申请</td>
      </tr>
        <th>申请说明</th>
        <td>您选购的机票需单独向航空公司申请, 一旦申请成功将立刻出票并短信通知您。</td>
      </tr>
  </table>
</div>
</body>
</html>