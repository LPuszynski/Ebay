<!DOCTYPE html>
<html>
<html lang="en">
<head>
<link rel="icon" type="image/png" href="icon.png"/>
<link rel="stylesheet" href="form.css">


	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="validateform.js"></script>

<title>Enter your information</title>

</head>

<body>


<div id="tlois">
	 &emsp;CIGAR SHOP SINCE 1955 

</div>	


<div id="title"> 
	Cigar Shop
</div>

<section>
<div class="wrapper">
    <ul>
	<li><a href="index.php">Home</li>
<li> Categories 
<ul>
<li><a href="cigars.php">Cigars</a></li>
<li><a href="Accessories.php">Accessories</li></li>
</ul><li> <a href="sellObject.php">Sell </a></li>
<li><a href="">Your account </a></li></ul>
<a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
</div><br><br>

<?php
session_start();
try
{
$db = new PDO('mysql:host=localhost;port=3307;dbname=ebay;', 'root', ''); /* Port de thomas = 3307 / Port de Lois = 3306 */	
//$db = new PDO('mysql:host=localhost;port=3307;dbname=ebay;', 'root', ''); /* Port de thomas = 3307 / Port de Lois = 3306 */
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

// in order to change informations of the user  before making command

if (isset ($_POST['submit'])){
	
	if ($_POST['firstname']!='')
    {
		$stmt = $db->prepare('UPDATE customer SET firstname = "'.$_POST['firstname'].'" WHERE id="'.$_SESSION['id'].'"');
		$stmt->execute();
	}
	if ($_POST['mail']!='')
    {
        $stmt = $db->prepare('UPDATE customer SET email = "'.$_POST['mail'].'" WHERE id="'.$_SESSION['id'].'"');
		$stmt->execute();
	}
	if ($_POST['lastname']!='')
    {
        $stmt = $db->prepare('UPDATE customer SET lastname = "'.$_POST['lastname'].'" WHERE id="'.$_SESSION['id'].'"');
		$stmt->execute();
	}
	if ($_POST['password']!='')
    {	
        $stmt = $db->prepare('UPDATE customer SET password = "'.$_POST['password'].'" WHERE id="'.$_SESSION['id'].'"');
		$stmt->execute();
	}
	if ($_POST['city']!='')
	{
		$stmt = $db->prepare('UPDATE customer SET city = "'.$_POST['city'].'" WHERE id="'.$_SESSION['id'].'"');
		$stmt->execute();
	}
	if ($_POST['Address']!='')
	{
		$stmt = $db->prepare('UPDATE customer SET adress_line1 = "'.$_POST['Address'].'" WHERE id="'.$_SESSION['id'].'"');
		$stmt->execute();
	}
	if ($_POST['postal_code']!='')
	{
		$stmt = $db->prepare('UPDATE customer SET postal_code = "'.$_POST['postal_code'].'" WHERE id="'.$_SESSION['id'].'"');
		$stmt->execute();
	}
	if ($_POST['FullName']!='')
	{
		$stmt = $db->prepare('UPDATE customer SET fullname = "'.$_POST['FullName'].'" WHERE id="'.$_SESSION['id'].'"');
		$stmt->execute();
	}
	if ($_POST['card_number']!='')
	{
		$stmt = $db->prepare('UPDATE customer SET cardnumber = "'.$_POST['card_number'].'" WHERE id="'.$_SESSION['id'].'"');
		$stmt->execute();
	}
	if ($_POST['expiration_date']!='')
	{
		$stmt = $db->prepare('UPDATE customer SET expiration_date = "'.$_POST['expiration_date'].'" WHERE id="'.$_SESSION['id'].'"');
		$stmt->execute();
	}
	if($_POST['cvc']!='')
	{
		$stmt = $db->prepare('UPDATE customer SET cvc = "'.$_POST['cvc'].'" WHERE id="'.$_SESSION['id'].'"');
		$stmt->execute();
	}

	header("Location: http://localhost/Ebay/buyingConfirmation.php"); /* Redirection du navigateur */

}
?>
<h3>Enter informations that you want to modify</h3>

<form name = "inputForm" action = "" method = "post">
	<div id="Register_form">
	<br>	
	<h3>PERSONAL INFORMATIONS</h3>
			
				 
				<input type="text" class="infos" id="firstname" name="firstname" placeholder="First name"> <br>
				<input type="text" class="infos" id="lastname" name="lastname" placeholder="Last name"><br>
				
				<input type="text"  class="infos" id="mail" name="mail" placeholder="Mail"> <br>

				<input type="password" class="infos" id="password" name="password" placeholder="Password"> <br>
				<input type="text" class="infos"  id="city" name="city" placeholder="City"> <br>
				<input type="text" class="infos" id="Address" name="Address" placeholder="Address line"> <br>
				<input type="number"  class="infos" id="postal_code" name="postal_code" placeholder="Postal code" data-mask='00000'> <br>

			<div id="VisaMethod">
		<h3> Payment details</h3>
		<input type="text" class="infos" id="FullName" name="FullName" placeholder="Full Name"><br>
		<input type="number" class="infos" id="card_number" name="card_number" placeholder="Credit card number"><br>
		<input type="text" class="infos" id="expiration_date" name="expiration_date" placeholder="Expiration date"><br>
		<input type="number" class="infos" id="cvc" name="cvc" placeholder="CVC"><br>

		</div>
		
			<br> 
			<input type = "submit" class="bouton"  value = "Order" name = "submit"/>
			
			

	</div>

</form>
	</section>	
		
		
			

			
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
		
		
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js%22%3E"></script>	
	<script src="https://code.jquery.com/jquery-3.6.0.min.js%22%3E"></script>
 </body>
</html>