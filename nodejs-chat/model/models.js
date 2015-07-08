"use strict";

var mongoose = require('mongoose'),
Schema = mongoose.Schema;

var userSchema = new Schema({
	_id: Schema.Types.ObjectId,
	user: String,
	rank: String
});

var universitySchema = new Schema({
	_id: Schema.Types.ObjectId,
	email: String,
	name: String,
	acronym: String
});

var studentSchema = new Schema({
	_id: Schema.Types.ObjectId,
	email: String,
	name: String,
	last_name: String
});

var teacherSchema = new Schema({
	_id: Schema.Types.ObjectId,
	email: String,
	name: String,
	last_name: String
});

var subjectSchema = new Schema({
	_id: Schema.Types.ObjectId,
	name: String,
	university_id: Schema.Types.ObjectId,
	sections: [{
		_id: Schema.Types.ObjectId
		,code: String
	}]
});

var chatSchema = new Schema({
	_id: Schema.Types.ObjectId,
	subject_id: Schema.Types.ObjectId,
	section_id: Schema.Types.ObjectId,
	participants: [ Schema.Types.ObjectId ],
	conversations: [{
		_id: Schema.Types.ObjectId,
		sender_id: Schema.Types.ObjectId,
		receiver_id: Schema.Types.ObjectId,
		date_sended: Date,
		message: String
	}]
}, { versionKey: false });

var User = mongoose.model('users', userSchema),
University = mongoose.model('universities', universitySchema),
Student = mongoose.model('students', studentSchema),
Teacher = mongoose.model('teachers', teacherSchema),
Chat = mongoose.model('chats', chatSchema);

module.exports = {
	'user': User, 
	'university': University, 
	'student': Student, 
	'teacher': Teacher,
	'chat': Chat
};