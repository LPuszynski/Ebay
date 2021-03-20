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
$profilFound = 0;

//connection cith the db
try
{
	$db = new PDO('mysql:host=localhost;port=3306;dbname=ebay;', 'root', '');
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
	$user = $stmt->fetch();
	$stmt2 = $db->prepare('SELECT * FROM customer WHERE password="'.$password.'"');
	$stmt2->execute();
	$user2 = $stmt2->fetch();
	if ($user && $user2) {
		$profilFound = 1; //He is a customer in the DB
	}

	//If he is a seller
	$stmt = $db->prepare('SELECT * FROM seller WHERE email="'.$mail.'"');
	$stmt->execute();
	$user = $stmt->fetch();
	$stmt2 = $db->prepare('SELECT * FROM seller WHERE password="'.$password.'"');
	$stmt2->execute();
	$user2 = $stmt2->fetch();
	if ($user && $user2) {
		$profilFound = 2; //He is a seller in the DB
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