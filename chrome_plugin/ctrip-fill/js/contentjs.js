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
    }
}

var listBox = _$.getClass(document,"exam_check_cont","div")[0];
var aDt = listBox.getElementsByTagName("dt");
var aDtLenth = aDt.length;

function getInfo(){
    var info = [];
    for(var i=0;i<aDtLenth;i++){
        aDt[i].o = {};
        var oDd = _$.nextTag(aDt[i]);
        aDt[i].o.title = _$.getClass(oDd,"exam-q","p")[0].innerHTML;

        //var is_multiple = (aDt[i].innerHTML=="多选题");
        //console.log(is_multiple);
        var aInput = oDd.getElementsByTagName("input");
        //console.log(oDd);
        var yes = _$.getClass(oDd,"label_comm_a_cont","div")[0];
        if(yes && yes.className.indexOf("label_error")!=-1){
            yes = false;
        }else{
            yes = true;
        }
        for(var j=0;j<aInput.length;j++){
            if(aInput[j].getAttribute("checked") == ""){
                if(yes){
                    aDt[i].o.choose = [];
                    aDt[i].o.choose.push(j);
                }else{
                    aDt[i].o.choose = false;
                }
            }
        }
        info.push(aDt[i].o);
    }
    return info;
    //console.log(info);
}


function setInfo(url){
    // 获取数据
    $.ajax(url).done(function(data) {
        for(var i=0;i<aDtLenth;i++){
          var o = {};
          var oDd = _$.nextTag(aDt[i]);
          var aInput = oDd.getElementsByTagName("input");
          o.title = _$.getClass(oDd,"exam-q","p")[0].innerHTML;

          for(var d in data){
              if(o.title == data[d].title){
                  var currentO = data.splice(d,1);
              }
          }
          var currentAnswer = currentO[0]["choose"];
          if(currentAnswer){
              for(var j=0;j<currentAnswer.length;j++){
                //console.log(currentAnswer[j]);
                aInput[currentAnswer[j]].setAttribute("checked","checked");
              }
          }else{
            oDd.style.background = "#f0f0f0";
            oDd.style.border = "3px solid red";
          }
        }
    });
}

//侦听消息
chrome.runtime.onMessage.addListener(function(request, sender, sendResponse) {
    //console.log(sender.tab ? "from a content script:" + sender.tab.url : "from the extension");
    if(request.getInfo){
        var datas = getInfo();
        datas = JSON.stringify(datas);
        window.open("write-answer.php?data="+datas,"newWindow","height=500,width=800,top=0,left=0, toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no");
    }

    if(request.setInfo){
        setInfo("http://prototype.local.sh.ctriptravel.com/code_beta/a_practice/chrome_plugin/source_file/answer.json");
    }

    if (request.greeting == "hello"){
        sendResponse({farewell: "goodbye"});
    }
});