<!DOCTYPE html>
<html>
<html lang="en">
<head>
<link rel="icon" type="image/png" href="icon.png"/>
<link rel="stylesheet" href="index.css">


	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="validateform.js"></script>
<title>Connection</title>
    

			


</head>

<body>
<fieldset>

		<legend>PERSONAL INFORMATIONS</legend>
			<table border="1">
			<tr>
			<td>	First Name : </td>
			<td>	<input type="text" id="firstname" name="firstname"> </td>
				
			
				
			
			
				<td>Mail :</td>
				<td><input type="text" id="mail" name="mail"> </td>
	</tr>
	<tr>
		<td>Last Name :</td>
			<td>	<input type="text" id="lastname" name="lastname"></td>

			<td>Password:</td>
			
			<td>	<input type="password" id="password" name="password"> </td>	
	      </td>
			</tr>
		
			<tr>
			<td><label for="address">Address </label></td>
			
				<td><textarea id="address" name="adress" rows="4" cols="30"></textarea></td>
			</tr>	
			</table>
		</fieldset>
		<div id="Buyer">
		<h2> PERSONAL INFORMATIONS</h2>
		Mail : <input type="text" id="mail" name="mail"><br>
		Password :<input type="password" id="password1" name="password1"><br>
		Confirm password :<input type="password" id="password2" name="password2"><br>
		Last Name:<input type="text" id="lastname" name="lastname"><br>
		First Name:<input type="text" id="firstname" name="firstname"><br>
		Address: <input type="text" id="Address" name="address"><br>
		City :<input type="text" id="city" name="city"><br>
		
		
		<h2>Payment method</h2>
		<div id="PaypalMethod">
		<h3>Paypal informations</h3>
		Paypal email:<input type="text" id="paypalMail" name="paypalMail"><br>
		Payal password:<input type="text" id="paypalPassword" name="paypalPassword"><br>
		</div>
		<div id="VisaMethod">
		<h3> Payment details</h3>
		Full Name :<input type="text" id="FullName" name="FullName"><br>
		</div>
		
		</div>
		
		<div id="Seller">
		<h2>Seller informations</h2>
		Username: <input type="text" id="username" name="username"><br>
		Mail: <input type="text" id="Mail" name="Mail"><br>
		Password :<input type="password" id="password1" name="password1"><br>
		Confirm password :<input type="password" id="password2" name="password2"><br>
		
		</div>
		
		
			<br> <br><br> <br><br> <br>
			<button onclick="submit()">Submit</button>
			<button onclick="reset()">Reset</button>
		
		
		
 </body>
</html>