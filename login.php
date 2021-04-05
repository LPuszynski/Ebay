<!DOCTYPE html>
<html>
<html lang="en">
<head>
<link rel="icon" type="image/png" href="icon.png"/>
<link rel="stylesheet" href="login.css">


	
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
$_SESSION['profilFound'] = 0;
//connection cith the db
try
{

//$db = new PDO('mysql:host=localhost;port=3307;dbname=ebay;', 'root', '');	
$db = new PDO('mysql:host=localhost;port=3306;dbname=ebay;', 'root', ''); /* Port de thomas = 3307 / Port de Lois = 3306 */

}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

//We put informations of the form on variables
if (isset ($_POST['submit'])){
	
	if (isset ($_POST['mail']))
    {
        $mail = $_POST['mail'];
	}
	if (isset ($_POST['password']))
    {	
        $password = $_POST['password'];
	}

	/*We check if informations that the user wrote are in the database*/
	//If he is a customer
	$stmt = $db->prepare('SELECT * FROM customer WHERE email="'.$mail.'"');
	$stmt->execute();
	$users = $stmt->fetchAll();
	foreach($users as $user):
		if (strcmp ( $user['password'], $password) == 0){
			$_SESSION['id']=$user['id'];
			$_SESSION['lastname']=$user['lastname'];
			$_SESSION['firstname']=$user['firstname'];
			$_SESSION['adress_line1']=$user['adress_line1'];
			$_SESSION['city']=$user['city'];
			$_SESSION['email']=$user['email'];
			$_SESSION['password']=$user['password'];
			$_SESSION['postal_code']=$user['postal_code'];
			$_SESSION['fullname']=$user['fullname'];
			$_SESSION['cardnumber']=$user['cardnumber'];	
			$_SESSION['expiration_date']=$user['expiration_date'];
			$_SESSION['cvc']=$user['cvc'];
			$_SESSION['profilFound'] = 1; //He is a customer in the DB
			header("Location: http://localhost/GitHub/Ebay/index.php"); /* Browser redirection */
		}
	endforeach;

	//If he is a seller
	$stmt = $db->prepare('SELECT * FROM seller WHERE email="'.$mail.'"');
	$stmt->execute();
	$users = $stmt->fetchAll();
	foreach($users as $user):
		if (strcmp ( $user['password'], $password) == 0){
			$_SESSION['id']=$user['id'];
			$_SESSION['lastname']=$user['lastname'];
			$_SESSION['firstname']=$user['firstname'];	
			$_SESSION['profilFound'] = 2; //He is a seller in the DB
			header("Location: http://localhost/GitHub/Ebay/index.php"); /* Browser redirection */
		}
	endforeach;

	$stmt = $db->prepare('SELECT * FROM administrator WHERE username="'.$mail.'"');
	$stmt->execute();
	$users = $stmt->fetchAll();
	foreach($users as $user):
		if (strcmp ( $user['password'], $password) == 0){
			$_SESSION['id']=$user['id'];
			$_SESSION['profilFound'] = 3; //He is a admin in the DB
			header("Location: http://localhost/GitHub/Ebay/index.php"); /* Browser redirection */
		}
	endforeach;
	if($_SESSION['profilFound'] == 0){    //in order to allow a visitor to have a cart
		$_SESSION['id']=0;
		header("Location: http://localhost/GitHub/Ebay/index.php"); /* Browser redirection */
	}

	//if objects in the cart while not connected, the objects are put in the cart of the one who connects
	$stmt = $db->prepare('SELECT * FROM cart WHERE idCustomer="0"');
	$stmt->execute();
	$users = $stmt->fetchAll();
	foreach($users as $user):
		$stmt = $db->prepare('UPDATE cart SET idCustomer = "'.$_SESSION['id'].'" WHERE id="'.$user['id'].'"');
        $stmt->execute();
	endforeach;
}
?>



		
		
		
		
<form name = "inputForm" action = "" method = "post">
	<div id="Register_form">
	<br>	
	<h3>PERSONAL  INFORMATIONS</h3>
			
				 
				<input type="text" class="infos" id="mail" name="mail" placeholder="Mail"> <br>
				

				<input type="password" class="infos" id="password" name="password" placeholder="Password"> <br>
				
		
			<br> 
			<input type = "submit" class="bouton"  value = "LOG IN" name = "submit"/>
			
			

	</div>

</form></section>
		
					
<div id="bottom"> 
 <br>CONTACT<br><br>
 Opus Management S.A.<br>
Impasse de Champ Colin N�6<br>
1260 Nyon - Suisse <br>
Hotline +41 (0)79 104 19 98<br>
Email info@cigarshop.com <br>
<br>
<span id="social"> <img src="socialnetwork.png"></span>

</div>

<div id="credits"> 
<div id="copyright">Copyright 2021 � Cigar Shop - Opus Management S.A.</div>
<span id="payments"> <img src="payments.png"></span>
</div>
		
		
		
 </body>
</html>