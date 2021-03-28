<!DOCTYPE html>
<html>
<html lang="en">
<head>
<link rel="icon" type="image/png" href="icon.png"/>
<link rel="stylesheet" href="form.css">


	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="validateform.js"></script>

<title>Command succed</title>

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
<li><a href="">Accessories</li></li>
</ul><li> <a href="sellObject.php">Sell </a></li>
<li><a href="">Your account </a></li></ul>
<a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
</div><br><br>

<div id='title3'>
    Your command will arrive soon!
</div>

<?php
    session_start();
    try
    {
        $db = new PDO('mysql:host=localhost;port=3306;dbname=ebay;', 'root', ''); /* Port de thomas = 3307 / Port de Lois = 3306 */	
        //$db = new PDO('mysql:host=localhost;port=3307;dbname=ebay;', 'root', ''); /* Port de thomas = 3307 / Port de Lois = 3306 */
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }
    date_default_timezone_set('Europe/Paris');
    $date = date('y-m-d');
    $time = date('h:i');
    $records = $db->prepare('INSERT INTO orderbuynow (id_item, id_customer, id_seller, price, date, time) VALUES ("'.$_SESSION['idItemBuyNow'].'", "'.$_SESSION['id'].'", "'.$_SESSION['idseller'].'", "'.$_SESSION['priceItem'].'", "'.$date.'", "'.$time.'")');
    $records->execute();
?>

<form action = 'index.php' method = 'POST' id='formReturnToMenu'>
        <button type='submit' name='home' value='submit'> Return to home page </button>
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