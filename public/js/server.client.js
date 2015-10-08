"use strict";

$(function () 
{
	var content = $('#content'),
		input = $('#write-message'),
		status = $('#status'),
		button = $('#send-message'),
		id = $('#_id').val(),
		receiver = $('#receiver_id'),
		chat_id = $('#chat_id'),
		langsAvailables = ['es', 'en'],
		language = window.navigator.userLanguage || window.navigator.language,
		sender = "";

	language = language.substring(0, 2).toLowerCase();
	
	if($.inArray(language, langsAvailables) === -1)
		language = 'en';

	var dict = {
		"support": {
			en: "Sorry, but your browser doesn\'t support WebSockets",
			es: "Lo sentimos, pero tu navegador no soporta WebSockets"
		},
		"no_connect": {
			en: "Sorry, but there\'s some problem with your connection or the server is down",
			es: "Lo sentimos, pero hay algún problema con la conexión o el servidor está abajo"
		},
		"error": {
			en: "Unable to communicate with the WebSocket server",
			es: "No se puede comunicar con el servidor WebSocket"
		},
		"online": {
			en: "Online",
			es: "En linea"
		}
	}

	window.WebSocket = window.WebSocket || window.MozWebSocket;

	if (!window.WebSocket) 
	{
		content.html(dict["support"][language]);
		input.hide();
		button.hide();
		$('span').hide();
		return;
	}	

	var connection = new ReconnectingWebSocket('ws://' + $('#ip').val() + ':5000');

	connection.onopen = function () 
	{
		connection.send
		(
			JSON.stringify({
				'sender_id': id
			})
		);
	};

	connection.onerror = function (error) 
	{
		status.removeClass('text-success');
		status.html(dict["no_connect"][language]);
		status.addClass('text-warning');
		input.attr('disabled', 'disabled').val(dict["error"][language]);
		button.addClass("disabled");
	};

	connection.onmessage = function (message) 
	{
		var json = JSON.parse(message.data);
		
		if (json.type === 'first-time') 
		{ 
			input.removeAttr('disabled').val('');
			button.removeClass("disabled");
			status.html(dict["online"][language]);
			status.addClass('text-success');
		}
		else if (json.type === 'message') 
		{
			console.log(json.data);
			
			if(sender != "")
				sender = json.data.receiver_id;

			if(chat_id.val() == json.data.chat_id)
				addMessage(json.data.author, json.data.message, new Date(json.data.date));
			
			//chat_id.val(json.data.chat_id);	
		} 
	};

	input.keydown(function(e) 
	{
		if (e.keyCode === 13) 
			sendData($(this).val());
	});

	$("#send-message").on("click", function() { 
		sendData($('#write-message').val()); 
	});

	function sendData (msg) 
	{
		if(receiver.val() !== "" && receiver.val() !== undefined)
		{
			connection.send
			(
				JSON.stringify({
					'message': msg,
					'_id': chat_id.val(),
					'receiver_id': receiver.val(),
					'sender_id': id
				})
			);
			
			$('#write-message').val('');
			sender = id;			
		}
	}

	function addMessage(author, message, datetime) 
	{
		var photo = $('#' + sender).html();
		
		sender = "";
		console.log(photo);
		content.append
		(	
			'<a class="list-group-item"> ' + photo +
			'<span class="username">' + author + ' <span class="time"> ' + 
			formatDate(datetime) + '</span> </span> <p>' + message + '</p></a>'
		);

		scrollDiv();
	}

	function formatDate(date) 
	{
		var hours = date.getHours(),
			minutes = date.getMinutes(),
			ampm = hours >= 12 ? 'pm' : 'am';

		hours = hours % 12;
		hours = hours ? hours : 12;
		minutes = minutes < 10 ? '0'+minutes : minutes;
		
		var strTime = hours + ':' + minutes + ' ' + ampm;

		return date.getDate() + '/' + (date.getMonth()+1) + '/' + date.getFullYear() + " " + strTime;
	}

	function scrollDiv()
	{
		var height = content[0].scrollHeight;
	  	content.scrollTop(height);
	}
});