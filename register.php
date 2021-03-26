<!DOCTYPE html>
<html>
<html lang="en">
<head>
<link rel="icon" type="image/png" href="icon.png"/>
<link rel="stylesheet" href="index.css">
<link rel="stylesheet" href="form.css">


	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="validateform.js"></script>
<title>Create an account</title>

</head>

<body>


<div id="tlois">
	 &emsp;CIGAR SHOP SINCE 1955 

</div>	


<div id="title"> 
	Cigar Shop
</div>

<div class="wrapper">
    <ul>
	<li><a href="index.php">Home</li>
<li> Categories
            <ul>
<li><a href="cigars.php">Cigars</a></li>
<li><a href="">Accessories</li></li>
</ul><li> <a href="sellObject.php">Sell </a></li>
<li><a href="">Your account </a></li></ul>
<a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
</div><br><br>

<?php
try
{
	//$db = new PDO('mysql:host=localhost;port=3306;dbname=ebay;', 'root', ''); /* Port de thomas = 3307 / Port de Lois = 3306 */	
$db = new PDO('mysql:host=localhost;port=3307;dbname=ebay;', 'root', ''); /* Port de thomas = 3307 / Port de Lois = 3306 */
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

if (isset ($_POST['submit'])){
	
	if (isset ($_POST['firstname']))
    {
        $firstname = $_POST['firstname'];
	}
	if (isset ($_POST['mail']))
    {
        $mail = $_POST['mail'];
	}
	if (isset ($_POST['lastname']))
    {
        $lastname = $_POST['lastname'];
	}
	if (isset ($_POST['password']))
    {	
        $password = $_POST['password'];
	}
	if (isset($_POST['city']))
	{
		$city=$_POST['city'];
	}
	if (isset($_POST['Address']))
	{
		$address=$_POST['Address'];
	}
	if (isset($POST['postal_code']))
	{
		$postal_code=$POST['postal_code'];
	}
	if (isset($POST['FullName']))
	{
	 $fullName=$POST['FullName'];
	}
	if (isset($POST['card_number']))
	{
		$card_number=$POST['card_number'];
	}
	if (isset($POST['expiration_date']))
	{
	 $expiration_date=$POST['expiration_date'];
	}
	if(isset($POST['cvc']))
	{
		$cvc=$POST['cvc'];
	}


$records = $db->prepare('INSERT INTO customer (email, password, lastname, firstname, adress_line1, city, postal_code, fullname, cardnumber, expiration_date, cvc ) VALUES ("'.$mail.'", "'.$password.'", "'.$lastname.'", "'.$firstname.'", "'.$address.'", "'.$city.'", "'.$postal_code.'", "'.$fullName.'", "'.$card_number.'", "'.$expiration_date.'", "'.$cvc.'")');
$records->execute();
}
?>


<form name = "inputForm" action = "" method = "post">
	<div id="Register_form">
	<br>	
	<h3>PERSONAL INFORMATIONS</h3>
			
				 
				<input type="text" id="firstname" name="firstname" placeholder="First name"> <br>
				<input type="text" id="lastname" name="lastname" placeholder="Last name"><br>
				
				<input type="text" id="mail" name="mail" placeholder="Mail"> <br>

				<input type="password" id="password" name="password" placeholder="Password"> <br>
				<input type="text" id="city" name="city" placeholder="City"> <br>
				<input type="text" id="Address" name="Address" placeholder="Address line"> <br>
				<input type="text" id="postal_code" name="postal_code" placeholder="Postal code"> <br>

			<div id="VisaMethod">
		<h3> Payment details</h3>
		<input type="text" id="FullName" name="FullName" placeholder="Full Name"><br>
		<input type="text" id="card_number" name="card_number" placeholder="Credit card number"><br>
		<input type="text" id="expiration_date" name="expiration_date" placeholder="Expiration date"><br>
		<input type="text" id="cvc" name="cvc" placeholder="CVC"><br>

		</div>
		
			<br> 
			<input type = "submit"  value = "submit" name = "submit"/>

	</div>

</form>
		
		
		
			<button onclick="reset()">Reset</button>

			
<div id="bottom"> 
 <br>CONTACT<br><br>
 Opus Management S.A.<br>
Impasse de Champ Colin N°6<br>
1260 Nyon - Suisse <br>
Hotline +41 (0)79 104 19 98<br>
Email info@cigarshop.com <br>
<br>
<span id="social"> <img src="socialnetwork.png"></span>

</div>

<div id="credits"> 
<div id="copyright">Copyright 2021 © Cigar Shop - Opus Management S.A.</div>
<span id="payments"> <img src="payments.png"></span>
</div>
		
		
		
 </body>
</html>