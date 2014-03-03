var http = require("http"),
  server = http.createServer(function(request,response){});

// 设定监听端口
server.listen(4564,function(){
  console.log((new Date())+"server is listening on port 4564");
});

// 启动服务器
var WebSocketServer = require("socket.io").server;
var wsServer = new WebSocketServer({
  httpServer:server
});

var connection;
wsServer.on('request', function(req){
    connection = req.accept('echo-protocol', req.origin);
});

wsServer.on('request', function(r){
    connection = req.accept('echo-protocol', req.origin);

    connection.on('message', function(message) {
        var msgString = message.utf8Data;
        connection.sendUTF(msgString);
    });
});

connection.on('close', function(reasonCode, description) {
    console.log(connection.remoteAddress + ' disconnected.');
});