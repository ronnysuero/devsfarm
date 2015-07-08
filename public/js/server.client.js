$(function () {
	"use strict";

	var content = $('#content'),
	input = $('#write-message'),
	status = $('#status'),
	button = $('#send-message'),
	myColor = false,
	myName = false,
	id = $('#_id').val(),
	receiver = $('#receiver_id'),
	chat_id = $('#chat_id');
	
	window.WebSocket = window.WebSocket || window.MozWebSocket;

	if (!window.WebSocket) {
		content.html('Sorry, but your browser doesn\'t support WebSockets.');
		input.hide();
		button.hide();
		$('span').hide();
		return;
	}

	var connection = new WebSocket('ws://localhost:5000');

	connection.onopen = function () {
		connection.send(JSON.stringify({
			'sender_id': id
		}));
	};

	connection.onerror = function (error) {
		status.html('Sorry, but there\'s some problem with your connection or the server is down.');
		status.addClass('text-error');
	};

	connection.onmessage = function (message) {
		try {
			var json = JSON.parse(message.data);
		} catch (e) {
			console.log('This doesn\'t look like a valid JSON: ', message.data);
			return;
		}

		if (json.type === 'first-time') { 
			myName = json.user;
			input.removeClass('disabled');
			button.removeClass("disabled");
			status.html('Online');
			status.addClass('text-success');
		}else if (json.type === 'message') {
			chat_id.val(json.data.chat_id);
			addMessage(json.data.author, json.data.message, new Date(json.data.date));
		} 
	};

	input.keydown(function(e) {

		if (e.keyCode === 13) {
			var msg = $(this).val();
			sendData(msg);
		}
	});

	$("#send-message").on("click", function() { sendData($('#write-message').val()); });

	function sendData (msg) {

		if(receiver.val() !== "" && receiver.val() !== undefined)
		{
			connection.send(JSON.stringify({
				'message': msg,
				'_id': chat_id.val(),
				'receiver_id': receiver.val(),
				'sender_id': id
			}));
			$('#write-message').val('');			
		}
	}

	setInterval(function() {

		if (connection.readyState !== 1){
			input.attr('disabled', 'disabled').val('Unable to comminucate with the WebSocket server.');
			button.addClass("disabled");
		}
	}, 5000);

	function addMessage(author, message, datetime) {
		content.append('<a class="list-group-item"> <img src="images/profile.png" class="chat-user-avatar" alt="">'+
			'<span class="username">' + author + ' <span class="time">'+ formatDate(datetime) + '</span> </span>'+
			'<p>' + message + '</p></a>');
	}

	function formatDate(date) {
		var hours = date.getHours(),
		minutes = date.getMinutes(),
		ampm = hours >= 12 ? 'pm' : 'am';

		hours = hours % 12;
		hours = hours ? hours : 12;
		minutes = minutes < 10 ? '0'+minutes : minutes;
		var strTime = hours + ':' + minutes + ' ' + ampm;

		return date.getMonth()+1 + "/" + date.getDate() + "/" + date.getFullYear() + "  " + strTime;
	}
});