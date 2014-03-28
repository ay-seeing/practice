/*
// 基础方法1
var http = require("http");
http.createServer(function(req,res){
  res.writeHead(200,{"Content-Type":"text/html"});
  res.write("welcome");
  res.end();
}).listen(6001);
console.log("http server is listening at port 6001.");
*/

/*
// 基础方法2
var http = require("http");
backFn = function(req,res){
  res.writeHead(200,{"Content-Type":"text/html"});
  res.write("另一种模式");
  res.end();
}
var cc = http.createServer(backFn);
cc.listen(6001);
console.log("http server is listening at port 6001.");
*/

/*
// 异步式读取文件 readfile.txt
var fs = require("fs");
backfn = function(err,data){
  if(err){
    console.log(err);
  }else{
    console.log(data);
  }
}
// 异步式读取文件
fs.readFile("readfile.txt","utf-8",backfn);
// 同步式读取文件
fs.readFileSync("readfile.txt","utf8")
console.log("File read finish.");
*/


/*
// 同步式读取文件 readfile.txt
var fs = require("fs");
var data = fs.readFileSync("readfile.txt","utf8");
console.log(data);
console.log("File read finish.");
*/


/*
// 事件
var event_emitter = require("events").EventEmitter;
var event = new event_emitter();
// 自定义事件
event.on("some_event",function(){
  console.log("some event occured.");
});
setTimeout(function(){
  // 触发事件
  event.emit("some_event");
},3000);
*/


// 调用自定义 self_package.js 包
var self = require("./self_package");
self.setName("yiyang");
self.sayName();
