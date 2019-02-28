var websocketPort = wsPort ? wsPort : 8080,
    conn = new WebSocket('ws://localhost:' + websocketPort);

var btn = $('#chatSendButton');
var msg = $('#chatSendMessage');
var list = $('#chatMessage');

conn.onopen = function (e) {
    console.log("Connection established!");

};

conn.onerror = function (e) {
    console.log("Connection fail!");
};

conn.onmessage = function (e) {
    list.val(e.data + '\n' + list.val());
    console.log(e.data);
};


btn.on('click', function () {
    conn.send(msg.val());
});