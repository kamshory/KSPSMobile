function getSMS() 
{
	var sms = null;
	if(typeof Android !== "undefined" && Android !== null) 
	{
		console.log('Read SMS');
		sms = Android.getSMS();				
	} 
	else 
	{
		console.log("Not viewing in webview");
	}
	return sms;
}
function clearSMS()
{
	if(typeof Android !== "undefined" && Android !== null) 
	{
		console.log('Clear SMS');
		Android.clearSMS();		
	} 
	else 
	{
		console.log("Not viewing in webview");
	}
}
var interval = setInterval('', 10000000);

var isNumeric = /^[-+]?(\d+|\d+\d*|\d*\d+)$/;

function validOTP(message)
{
	var otp = null;
	message = message.split("\r").join(" ");
	message = message.split("\n").join(" ");
	message = message.split("\t").join(" ");
	message = message.replace(/\s\s+/g, ' ');
	var msg = "";
	if(message.indexOf(">>>") != -1 && message.indexOf("<<<") != -1)
	{
		var messages = message.split(" ");
		for(i = 0; i<messages.length; i++)
		{
			if(isNumeric.test(messages[i]) && messages[i].length == 6)
			{
				otp = messages[i];
				break;
			}
		}
	}
	return otp;
}
