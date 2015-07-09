"use strict";

process.title = 'nodejs-chat';

var webSocketsServerPort = 5000,
	webSocketServer = require('websocket').server,
	http = require('http'),
	db = require('./database/mongodb'),
	connections = new Array(),
	util = require('./helpers/helper'),
	server = http.createServer(function(request, response) {});

server.listen(webSocketsServerPort, function() {
	console.log(util.formatDate(new Date()) + " -> Server is listening on port: " + webSocketsServerPort);
});

var wsServer = new webSocketServer({ httpServer: server });

wsServer.on('request', function(request) 
{
	console.log(util.formatDate(new Date()) + ' -> Connection from origin: ' + request.origin);

	if (!util.originIsAllowed(request.origin)) 
	{
      request.reject();
      console.log(util.formatDate(new Date()) + ' -> Connection rejected');
      return;
    }

	var connection = request.accept(null, request.origin), 
		userName = false;

	console.log(util.formatDate(new Date()) + ' -> Connection accepted.');

	connection.on('message', function(message) 
	{
		if (message.type === 'utf8') 
		{ 
			if (userName === false) 
			{ 
				var obj = JSON.parse(message.utf8Data);
				connections.push({id: obj.sender_id, socket: connection});

				db.findUser(obj.sender_id, function(data)
				{
					userName = data;
					connection.sendUTF(JSON.stringify({ type:'first-time' }));
					console.log(util.formatDate(new Date()) + ' -> The user is known as: ' + userName);
				});
			} 
			else 
			{
				console.log(util.formatDate(new Date()) + ' -> Received Message from ' + userName + ': ' + message.utf8Data);	
				var obj = JSON.parse(message.utf8Data);

				if(obj._id === "" || obj._id === undefined)
				{
					db.createChat(obj, function(data)
					{
						var json = JSON.stringify({ type:'message', 'data': data });

						for (var i = 0; i < connections.length; i++)
						{
							if(connections[i].id === data.sender_id || connections[i].id === data.receiver_id)
								connections[i].socket.sendUTF(json);
						}
					});
				}
				else
				{
					db.findChat(obj, function(data)
					{
						var json = JSON.stringify({ type:'message', 'data': data });

						for (var i = 0; i < connections.length; i++)
						{
							if(connections[i].id === data.sender_id || connections[i].id === data.receiver_id)
								connections[i].socket.sendUTF(json);
						}
					});
				}
			}
		}
	});

	connection.on('close', function(reasonCode, description) 
	{
		if (userName !== false) 
		{		
	        console.log(util.formatDate(new Date()) + ' -> The user ' + userName + ', address: ' + connection.remoteAddress + ' is disconnected');
	        
	        for (var i = 0; i < connections.length; i++)
			{
				if(connections[i].socket === connection)
				{
					connections.splice(i, 1);
					return;
				}
			}
		}
    });
});