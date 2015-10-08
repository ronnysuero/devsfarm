"use strict";

function evaluateDigit(num)
{
	return (num > 9) ? num : '0' + num;
}

module.exports = {
	formatDate: function(date) 
	{
		var hours = date.getHours(),
		minutes = date.getMinutes(),
		ampm = hours >= 12 ? 'pm' : 'am';

		hours = hours % 12;
		hours = hours ? hours : 12;
		minutes = minutes < 10 ? '0' + minutes : minutes;
		var strTime = hours + ':' + minutes + ' ' + ampm;

		return date.getFullYear() + '-' + evaluateDigit(date.getMonth()+1) + '-' + evaluateDigit(date.getDate()) + " " + strTime;
	},
	originIsAllowed:function(origin) 
	{
		origin = origin.substring(origin.indexOf("//")+2);

		if(origin === 'localhost' || origin === '127.0.0.1' || origin === 'soldev01.soldeva.com:90' || origin === 'devsfarm.com:90')
			return true; 

		return false;	
	}
}