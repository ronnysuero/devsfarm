"use strict";

process.title = 'node-chat';

var webSocketsServerPort = 5000,
webSocketServer = require('websocket').server,
http = require('http'),
db = require('./database/mongodb'),
clients = new Array(),
server = http.createServer(function(request, response) {});

server.listen(webSocketsServerPort, function() {
	console.log((new Date()) + " Server is listening on port: " + webSocketsServerPort);
});

var wsServer = new webSocketServer({ httpServer: server });

wsServer.on('request', function(request) {

	console.log((new Date()) + ' Connection from origin ' + request.origin);

	var connection = request.accept(null, request.origin), 
	index = clients.push(connection) - 1,
	userName = false;
	
	console.log((new Date()) + ' Connection accepted.');

	connection.on('message', function(message) {

		if (message.type === 'utf8') { 

			if (userName === false) { 
				var obj = JSON.parse(message.utf8Data);

				db.findUser(obj._id, function(data){
					userName = data;

					connection.sendUTF(JSON.stringify({ type:'first-time', user: userName }));
					console.log((new Date()) + ' User is known as: ' + userName);
				});
			} else {

				console.log((new Date()) + ' Received Message from ' + userName + ': ' + message.utf8Data);

				var obj = JSON.parse(message.utf8Data);

				if(obj.chat_id === "" || obj.chat_id === undefined)
				{
					db.createChat(obj, function(data){
						var json = JSON.stringify({ type:'message', 'data': data });

						for (var i=0; i < clients.length; i++) 
							clients[i].sendUTF(json);
					});
				}

				// var obj = {
				// 	time: (new Date()).getTime(),
				// 	text: message.utf8Data,
				// 	author: userName,
				// };


				// var json = JSON.stringify({ type:'message', data: obj });
				// for (var i=0; i < clients.length; i++) {
				// 	clients[i].sendUTF(json);
				// }
			}
		}
	});

connection.on('close', function(connection) {

	if (userName !== false) {	
		console.log((new Date()) + " Peer " + connection.remoteAddress + " disconnected.");
		clients.splice(index, 1);
	}
});
});