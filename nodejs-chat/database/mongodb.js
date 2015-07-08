"use strict";

var mongoose = require('mongoose'),
models = require('../model/models');

mongoose.connect('mongodb://localhost/devsfarm');

function getName(userId, callback){
	models.user.findOne({_id: userId}, function(err, user){
		if(err) return callback(err);
		else if(user.rank === 'university') {
			models.university.findOne({_id: user._id}, function(err, university){
				if(err) return callback(err);
				return callback(university.acronym);	
			});
		}
		else if(user.rank === 'student'){
			models.student.findOne({_id: user._id}, function(err, student){
				if(err)  return callback(err);
				return callback(student.name + ' ' + student.last_name);	
			});
		}
		else if(user.rank === 'teacher'){
			models.student.findOne({_id: user._id}, function(err, teacher){
				if(err) return callback(err);
				return callback(student.name + ' ' + student.last_name);	
			});
		}
	});
};

module.exports = {
	findUser: getName,
	createChat: function(data, callback){
		var chat = new models.chat({
			_id: mongoose.Types.ObjectId(),
			participants: [data.sender_id, data.receiver_id],
			conversations: [{
				_id: mongoose.Types.ObjectId(),
				sender_id: data.sender_id,
				receiver_id: data.receiver_id,
				date_sended: new Date(),
				message: data.message
			}]
		});

		chat.save(function(err){
			if(err) return callback(err);
		});

		getName(data.sender_id, function(name){
			var result = {
				author: name,
				chat_id: chat._id,
				receiver_id: data.receiver_id,
				sender_id: data.sender_id,
				message: data.message,
				date: new Date()
			};
			return callback(result);
		});	
	},
	findChat: function(data, callback){

		var conversation = {
			_id: mongoose.Types.ObjectId(),
			sender_id: data.sender_id,
			receiver_id: data.receiver_id,
			date_sended: new Date(),
			message: data.message
		};

		models.chat.findByIdAndUpdate(data._id, { $push: {conversations: conversation} }, function (err, doc) {
			if (err) return handleError(err);

			getName(data.sender_id, function(name){
				var result = {
					author: name,
					chat_id: data._id,
					receiver_id: data.receiver_id,
					sender_id: data.sender_id,
					message: data.message,
					date: new Date()
				};
				return callback(result);
			});
		});
	}
}