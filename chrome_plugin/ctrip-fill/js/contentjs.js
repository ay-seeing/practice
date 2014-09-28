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
				if(!oNext){return false;}
				oNext = curent.nextSibling;
			}
		}else{
			while(oNext.nodeType!=1){
				if(!oNext){return false;}
				oNext = curent.nextSibling;
			}
		}
		return oNext;
	}
}

/*var listBox = _$.getClass(document,"exam_check_cont","div")[0];
var aDt = listBox.getElementsByTagName("dt");
var aDtLenth = aDt.length;

function getInfo(){
	var info = [];
	for(var i=0;i<aDtLenth;i++){
		var o = {};
		var oDd = _$.nextTag(aDt[i]);
		if(i==0){
		console.log(oDd);
			var yes = _$.getClass(oDd,"label_comm_a_cont","div")[0];
			if(yes.className.indexOf("label_error")!=-1){
				yes = true;
			}else{
				yes = false;
			}
			console.log(yes);
		}
		//o.title = aDt[i].innerHTML;

	}
}
getInfo();*/
