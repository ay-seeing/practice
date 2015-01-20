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


/*
// 调用自定义 self_package.js 包
var self = require("./self_package");
self.setName("yiyang");
self.sayName();
*/


/*
// http.Server 服务器对象
var http = require("http");
var server = new http.createServer(function(req,res){
  res.writeHead(200,{"Content-Type":"text/html"});
  
  var str = "";
  for(vara in req){
    str += vara + "<br />";
  }
  res.write(str);
  res.write(req.url);
  res.end();
}).listen(3000);
console.log("listening port 3000");
*/


/*
var http = require('http');
var server = new http.createServer(function(req,res){
  var str = "";
  req.on("data",function(chunk){
    str += chunk;
  });
  req.on("end",function(){
    res.writeHead(200,{"Content-Type":"text/html"});
    res.write("input out");
    res.write(str);
    res.end();
  });
});
server.listen(3000);
console.log("listening port 3000");
*/


/*var http = require("http");
var server = new http.Server();
server.on("request",function(req,res){
  var str = "";
  req.on("data",function(chunk){
    str += typeof chunk;
  });
  req.on("end",function(){
    res.writeHead(200,{"Content-Type":"text/html"});
    res.write(str+"input out");
    res.end();
  });
});
server.listen(3000);
console.log("listening port 3000");*/


var express = require('express');
var app = express.createServer();
app.use(express.bodyParser());
app.all('/', function(req, res) {
res.send(req.body.title + req.body.text);
});
app.listen(3000);


/*var   http = require('http');
var   url=require('url');
  
http.createServer(function(req,res){
     console.log(req.method,req.url);
     var _url=url.parse(req.url);
     var _host=req.headers.host.split(":");
      
     var option={'host':_host[0],
                  'port':Number(_host[1]||'80'),
                  'path':_url['pathname']+(_url['search']||""),
                  'method':req.method,
                  'headers':req.headers
                  };
      
     var clientReq=http.request(option);
     req.on('data',function(c){ clientReq.write(c);});
     req.on('end',function(){ clientReq.end();});
 
     clientReq.on('response', function (response) {
                 res.writeHeader(response.statusCode,response.headers);
         response.on('data',function(chunk){  res.write(chunk); });
         response.on('end',function(){ res.end(); });
     });
     clientReq.on('error',function(e){
         console.log(e);
     });
 }).listen(5000);*/

