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

<?php
session_start();
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
			header("Location: http://localhost/GitHub/Ebay/index.php"); /* Redirection du navigateur */
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
			header("Location: http://localhost/GitHub/Ebay/index.php"); /* Redirection du navigateur */
		}
	endforeach;
	if($_SESSION['profilFound'] == 0){    //in order to allow a visitor to have a cart
		$_SESSION['id']=0;
		header("Location: http://localhost/GitHub/Ebay/index.php"); /* Redirection du navigateur */
	}
}
?>


<form name = "inputForm" action = "" method = "post">
		<legend>PERSONAL INFORMATIONS</legend>
			<table border="1">
			<tr>
			<td>Mail :</td>
				<td><input type="text" id="mail" name="mail"> </td>

				
			<td>Password:</td>
			
			<td>	<input type="password" id="password" name="password"> </td>	
	</tr>
    </table>
	<br> <br><br> <br><br> <br>
			<input type = "submit"  value = "submit" name = "submit"/>
</form>
		
		
		
			<button onclick="reset()">Reset</button>
		
		
		
 </body>
</html>