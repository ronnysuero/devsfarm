"use strict";

var mongoose = require('mongoose'),
models = require('../model/models');

mongoose.connect('mongodb://localhost/devsfarm');

module.exports = {
	findUser: function(userId, callback){
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
	},
	createChat: function(data, callback)
	{
		var chat = new models.chat({
			_id: mongoose.Types.ObjectId(),
			participants: [data._id, data.receiver_id],
			conversations: [{
				sender_id: data._id,
				receiver_id: data.receiver_id,
				date_sended: new Date(),
				message: data.message
			}]
		});

		chat.save(function(err){
			if(err) return callback(err);
		});

		var result = {
			chat_id: chat._id,
			message: chat.conversations[0].message,
			date: chat.conversations[0].date_sended
		};

		return callback(result);	
	}
}
