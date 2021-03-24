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
$records = $db->prepare('INSERT INTO customer (email, password, lastname, firstname) VALUES ("'.$mail.'", "'.$password.'", "'.$lastname.'", "'.$firstname.'")');
$records->execute();
}
?>


<form name = "inputForm" action = "" method = "post">
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
			</table>

		
			<br> <br><br> <br><br> <br>
			<input type = "submit"  value = "submit" name = "submit"/>
</form>
		
		
		
			<button onclick="reset()">Reset</button>
		
		
		
 </body>
</html>