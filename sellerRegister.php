<!DOCTYPE html>
<html>
<html lang="en">
<head>
<link rel="icon" type="image/png" href="icon.png"/>
<link rel="stylesheet" href="sellerRegister.css">


	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="validateform.js"></script>
<title>Connection</title>
    

			


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
<li><a href="">Accessories</li></li></ul>
<?php
session_start();
	if($_SESSION['profilFound']==2){
		echo '<li> <a href="sellObject.php">Sell </a></li>';
	}
?>
<?php
	if($_SESSION['profilFound']!=3){
		echo '<li><a href="yourAccount.php">Your account </a></li></ul>';
	}
?>

<?php
if($_SESSION['profilFound']!=0 && $_SESSION['profilFound']!=3){
	echo '<div id="personnalInfo">'.$_SESSION['firstname'].'&emsp; &emsp;'.$_SESSION['lastname'].'</div>';
	echo '<a href="message.php" id="message"><img src="message.png" width="50px"></i></a>';
}
?>
<a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
</div>

<?php
$profilFound = 0;
try

{	
//	$db = new PDO('mysql:host=localhost;port=3306;dbname=ebay;', 'root', ''); /* Port de thomas = 3307 / Port de Lois = 3306 */
	$db = new PDO('mysql:host=localhost;port=3307;dbname=ebay;', 'root', '');/* Port de thomas = 3307 / Port de Lois = 3306 */

}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

if (isset ($_POST['submit'])){ //we get all the information that the user enter
	
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

//we put all information on database
$records = $db->prepare('INSERT INTO seller (email, password, lastname, firstname) VALUES ("'.$mail.'", "'.$password.'", "'.$lastname.'", "'.$firstname.'")');
$records->execute();
echo "New seller account registered";
$profilFound = 2;
}
?>



<form name = "inputForm" action = "" method = "post">
	<div id="Register_form">
	<br>	
	<h3>PERSONAL INFORMATIONS</h3>
			
				 
				<input type="text" class="infos" id="firstname" name="firstname" placeholder="First name"> <br>
				<input type="text" class="infos" id="lastname" name="lastname" placeholder="Last name"><br>
				
				<input type="text"  class="infos" id="mail" name="mail" placeholder="Mail"> <br>

				<input type="password" class="infos" id="password" name="password" placeholder="Password"> <br>
				
		
			<br> 
			<input type = "submit" class="bouton"  value = "SUBMIT" name = "submit"/>
			
			

	</div>

</form></section>
		
					
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