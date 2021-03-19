function reset(){
	document.location.reload();
	return true;
}

function submit(){
	
	var firstname = document.getElementById("firstname").value;
	
	if (firstname.length > 50 )
	{
		alert("First name too long !");
		return false;
	}
	else if (firstname.length==0)
	{
		alert("Please enter your first name !");
		return false;
	}
	else if(firstname.length <2)
	{
		alert("First name too short !");
		return false;
	}
	
	
  
	var lastname = document.getElementById("lastname").value;
  
	if (lastname.length > 50 )
	{
		alert("Last name too long !");
		return false;
	}
	else if (lastname.length==0)
	{
		alert("Please enter your last name !");
		return false;
	}
	else if(lastname.length <2)
	{
		alert("Last name too short !");
		return false;
	}
	
	
	var mail=document.getElementById("mail").value;
	if(mail.length ==0)
	{
		alert("Enter your mail please!");
		return false;
	}
	else if(mail.length<4)
	{
		alert("Your mail is too short!");
		return false;
	}
	
	var password=document.getElementById("password");
	
	if(password.length ==0)
	{
		alert("Enter your password please!");
		return false;
	}
	else if(password.length<6)
	{
		alert("Your password is too short!");
		return false;
	}
	
	var address = document.getElementById("address").value;
	
	if(address.length ==0)
	{
		alert("Enter your address!");
		return false;
	}
	else if(address.length>300)
	{
		alert("Your adress is too long!");
		return false;
	}
	else if(address.length <5)
	{
		alert("Your adress is too short!");
		return false;
	}
	alert("Firstname : " +firstname+ "\nLastname : " +lastname);
	
}