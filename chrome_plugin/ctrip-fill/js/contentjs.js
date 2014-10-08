//document.body.style.background = "black";

var _$ = {
    getId : function(str){
        if(typeof str == "string"){
            return document.getElementById(str);
        }else{
            return str;
        }
    },
    getClass : function(p,c,t){
        var aChild,aClass=[];
        if(arguments.length==2){
            aChild = p.getElementsByTagName(t);
        }else{
            aChild = p.getElementsByTagName("*");
        }
        var length = aChild.length;
        for(var i=0;i<length;i++){
            if(aChild[i].className.indexOf(c) != -1){
                aClass.push(aChild[i]);
            }
        }
        return aClass;
    },
    nextTag : function(curent,c){
        var oNext = curent.nextSibling;
        if(arguments.length==2){
            while(oNext.nodeType!=1 && oNext.className.indexOf(c) == -1){
                oNext = oNext.nextSibling;
                if(!oNext){return false;}
            }
        }else{
            while(oNext.nodeType!=1){
                oNext = oNext.nextSibling;
                if(!oNext){return false;}
            }
        }
        return oNext;
    },
    postwith : function(to, p){
        var myForm = document.createElement("form");
        myForm.method = "post";
        myForm.action = to;
        // 设置新开窗口
        myForm.target = "newwindowname";
        // 或
        //myForm.target = "_blank";
        /*for ( var k in p) {
            var myInput = document.createElement("input");
            myInput.setAttribute("name", k);
            myInput.setAttribute("value", p[k]);
            myForm.a(myInput);
        }*/
        var myInput = document.createElement("input");
        myInput.setAttribute("name","data");
        myInput.setAttribute("value", p);
        myForm.appendChild(myInput);
        document.body.appendChild(myForm);
        myForm.submit();
        document.body.removeChild(myForm);
    },
    // js触发点击事件
    tiggerClick : function(obj){  
        if(document.all){  
            obj.click();  
        }else{  
            var evt = document.createEvent("MouseEvents");  
            evt.initEvent("click", true, true);  
            obj.dispatchEvent(evt);  
        }  
    }  
}

var listBox = _$.getClass(document,"exam_check_cont","div")[0];
var aDt = listBox.getElementsByTagName("dt");
var aDds = listBox.getElementsByTagName("dd");
var aDtLenth = aDt.length;
var aDdLenth = aDds.length;
// var data_url = "http://prototype.local.sh.ctriptravel.com/code_beta/a_practice/chrome_plugin/source_file/answer.json";
// var writePhp = "http://prototype.local.sh.ctriptravel.com/code_beta/a_practice/chrome_plugin/source_file/write-answer.php";
var data_url = "http://doc.ui.sh.ctriptravel.com/utools/write-answer/answer.json";
var writePhp = "http://doc.ui.sh.ctriptravel.com/utools/write-answer/write-answer.php";

function getInfo(url){
    listBox = _$.getClass(document,"exam_check_cont","div")[0];
    aDt = listBox.getElementsByTagName("dt");
    aDds = listBox.getElementsByTagName("dd");
    aDtLenth = aDt.length;
    aDdLenth = aDds.length;

    var info;
   $.ajax({url:url,async:false,error:function(){
        //console.log("失败");
        info = [];
        info = oneSet(info);
    }}).done(function(data){
        //console.log("成功");
        // 本地环境获得的是json对象，而ui环境则是字符串
        try{
            if(typeof data != "object"){
                data = JSON.parse(data);
            }
        }catch(err){
            //
        }
        //console.log(data);
        if(typeof data!="object"){
            info = [];
            info = oneSet(info);
        }else{
            info = data;
            info = agenSet(info);
        }
        //console.log(info);

    });
    return info;
    //localStorage.setItem(fillanswer,info);
}
function oneSet(info){
    for(var i=0;i<aDdLenth;i++){
        aDds[i].o = {};
        //var oDd = _$.nextTag(aDt[i]);
        var oDd = aDds[i];
        var yes = _$.getClass(oDd,"label_comm_a_cont","div")[0];
        if(yes && yes.className.indexOf("label_error")!=-1){
            yes = false;
        }else{
            yes = true;
        }

        aDds[i].o.title = _$.getClass(oDd,"exam-q","p")[0].innerHTML;

        //var is_multiple = (aDds[i].innerHTML=="多选题");
        //console.log(is_multiple);
        //var aInput = oDd.getElementsByTagName("input");
        var aLi = oDd.getElementsByTagName("li");
        //console.log(oDd);
        if(yes){
            aDds[i].o.choose = [];
            for(var j=0;j<aLi.length;j++){
                var oInput = aLi[j].getElementsByTagName("input")[0];
                if(oInput.getAttribute("checked") == ""){
                    var str = aLi[j].innerText;
                    str = str.replace(/[a-zA-Z]\s/g,"");
                    aDds[i].o.choose.push(str);
                }
            }
        }else{
            aDds[i].o.choose = false;
        }
        info.push(aDds[i].o);
    }
    return info;
}
function agenSet(info){
    for(var i=0;i<aDdLenth;i++){
        aDds[i].o = {};
        //var oDd = _$.nextTag(aDt[i]);
        var oDd = aDds[i];
        var yes = _$.getClass(oDd,"label_comm_a_cont","div")[0];
        if(yes && yes.className.indexOf("label_error")!=-1){
            yes = false;
        }else{
            yes = true;
        }

        aDds[i].o.title = _$.getClass(oDd,"exam-q","p")[0].innerHTML;

        var aLi = oDd.getElementsByTagName("li");

        if(yes){
            var is_title = false;
            for(var m in info){
                if(info[m].title == aDds[i].o.title){
                    is_title = true;

                    for(var j=0;j<aLi.length;j++){
                        var oInput = aLi[j].getElementsByTagName("input")[0];
                        if(oInput.getAttribute("checked") == ""){
                            var str = aLi[j].innerText;
                            str = str.replace(/[a-zA-Z]\s/g,"");

                            var is_there = false;
                            var aChoose = info[m].choose;
                            for(var n=0;n<aChoose.length;n++){
                                if(aChoose[n]==str){
                                    is_there = true;
                                }
                            }
                            if(!is_there){
                                aChoose.push(str);
                            }
                        }
                    }
                }
            }
            if(!is_title){
                aDds[i].o.choose = [];
                for(var j=0;j<aLi.length;j++){
                    var oInput = aLi[j].getElementsByTagName("input")[0];
                    if(oInput.getAttribute("checked") == ""){
                        var str = aLi[j].innerText;
                        str = str.replace(/[a-zA-Z]\s/g,"");
                        aDds[i].o.choose.push(str);
                    }
                }
                info.push(aDds[i].o);
            }
        }
    }
    return info;
}


function setInfo(url){
    listBox = _$.getClass(document,"exam_check_cont","div")[0];
    aDt = listBox.getElementsByTagName("dt");
    aDds = listBox.getElementsByTagName("dd");
    aDtLenth = aDt.length;
    aDdLenth = aDds.length;


    // 获取数据
    $.ajax({url:url,error:function(){alert("没有数据");}}).done(function(data) {
        try{
            if(typeof data != "object"){
                data = JSON.parse(data);
            }
        }catch(err){
            alert("数据格式不对");
            return false;
        }
        if(typeof data != "object"){
            alert("数据格式不对");
            return false;
        }
        //alert(data instanceof Array);
        for(var i=0;i<aDdLenth;i++){
        //console.log(aDdLenth);
          var o = {};
          //var oDd = _$.nextTag(aDt[i]);
          var oDd = aDds[i];
          var aInput = oDd.getElementsByTagName("input");
          var aLi = oDd.getElementsByTagName("li");
          var title = _$.getClass(oDd,"exam-q","p")[0];
          o.title = title.getElementsByTagName("strong")[0].innerHTML;
          o.title = o.title.replace(/\d+\.\&nbsp\;\&nbsp\;/g,"");
          //console.log(o.title);

          var is_answer = false;
          for(var d in data){
              if(o.title == data[d].title){
                is_answer = true;
                var currentO = data.splice(d,1);
              }
          }
          if(is_answer){
              var currentAnswer = currentO[0]["choose"];
              if(currentAnswer){
                  for(var j=0;j<currentAnswer.length;j++){
                    //console.log(currentAnswer[j]);
                    //aInput[currentAnswer[j]].setAttribute("checked","checked");
                    for(var m=0;m<aLi.length;m++){
                        var str = aLi[m].innerText;
                        str = str.replace(/[a-zA-Z]\s/g,"");
                        if(str==currentAnswer[j]){
                            //aLi[m].getElementsByTagName("input")[0].setAttribute("checked","checked")
                            //aLi[m].getElementsByTagName("input")[0].checked = "checked";
                            _$.tiggerClick(aLi[m].getElementsByTagName("input")[0]);
                        }
                    }
                  }
              }else{
                oDd.style.background = "#f0f0f0";
                oDd.style.border = "3px solid red";
              }
          }else{
            oDd.style.background = "#f0f0f0";
            oDd.style.border = "3px solid blue";
          }
        }
    });
}

//侦听消息
chrome.runtime.onMessage.addListener(function(request, sender, sendResponse) {
    //console.log(sender.tab ? "from a content script:" + sender.tab.url : "from the extension");
    if(request.getInfo){
        var datas = getInfo(data_url);
        datas = JSON.stringify(datas);
        //window.open(writePhp+"?data="+datas,"newWindow","height=200,width=300,top=0,left=0, toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no");
        _$.postwith(writePhp,datas);
        //alert(datas);
    }

    if(request.setInfo){
        setInfo(data_url);
    }

    if(request.clearInfo){
        window.open(writePhp+"?deletefile=true","newWindow","height=200,width=300,top=0,left=0, toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no");
    }

    if (request.greeting == "hello"){
        sendResponse({farewell: "goodbye"});
    }
});


//判断页面
var  fillPage= document.getElementById("divQuestionContent");

if(fillPage){
    // 发送消息（该种发送请求方法只能由 popup 页面想 content 页面发送）
    /*chrome.tabs.query({
      active: true,
      currentWindow: true
    }, function(tabs) {
      var tab = tabs[0];
      alert(tab.id);
      chrome.tabs.sendMessage(tab.id, {fill:true,greetings:"hello"}, function handler(response){
        console.log(response.farewell);
      });
    });*/
    // 向 background 页面发送请求（content js 不能想 popup 页面发送请求）
    chrome.runtime.sendMessage({fill:true,greeting: "hello"}, function(response) {
      console.log(response.farewell);
    });
}

