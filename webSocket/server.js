var fs = require('fs'),
  http = require('http'),
  socketio = require('socket.io');
 
var server = http.createServer(function(req, res) {
    res.writeHead(200, { 'Content-type': 'text/html'});
    res.end(fs.readFileSync(__dirname + '/talk.html'));
}).listen(4564, function() {
    console.log('Listening at: http://localhost:4564');
});
 
socketio.listen(server).on('connection', function (socket) {
    socket.on('message', function (msg) {
        console.log('Message Received: ', msg);
        socket.broadcast.emit('message', msg);
    });
});

/*
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
});*/