var fs = require('fs'),
  http = require('http'),
  socketio = require('socket.io');
 
var server = http.createServer(function(req, res) {
    res.writeHead(200, { 'Content-type': 'text/html'});
    res.end(fs.readFileSync(__dirname + '/talk.html'));
}).listen(4564, function() {
    console.log('Listening at: http://localhost:4564');
});

//on函数接受字符串"connection"作为客户端发起连接的事件，当连接成功后，调用回调函数
socketio.listen(server).on('connection', function (socket) {
    // 接受 message 事件
    socket.on('message', function (msg) {
        console.log('Message Received: ', msg);
        // 提交（发出）message 事件
        socket.broadcast.emit('message', msg);
    });
});