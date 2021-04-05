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
<li><a href="YourAccount.php">Your account </a></li></ul>
<a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
</div><br><br>

<div id='title2'>
    Buying Confirmation
</div>

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

    $stmt = $db->prepare('SELECT * FROM customer WHERE id="'.$_SESSION['id'].'"');
	$stmt->execute();
	$users = $stmt->fetchAll();
	foreach($users as $user):
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
	endforeach;

    if(isset($_SESSION['payBestOffer']) && $_SESSION['payBestOffer']==1){ //payement of a best offer
        $stmt = $db->prepare('SELECT * FROM item WHERE id="'.$_SESSION['idItemBestOffer'].'"');
        $stmt->execute();
        $items = $stmt->fetchAll();
    }
    elseif(isset($_SESSION['payBestOffer']) && $_SESSION['payBestOffer']==2){ //payement of an auction
        $stmt = $db->prepare('SELECT * FROM item WHERE id="'.$_SESSION['idItemAuction'].'"');
        $stmt->execute();
        $items = $stmt->fetchAll();
    }
    else{ //payement of a buyNow
        $stmt = $db->prepare('SELECT * FROM item WHERE id="'.$_SESSION['idItemBuyNow'].'"');
        $stmt->execute();
        $items = $stmt->fetchAll();
    }


    foreach($items as $c):
        $_SESSION['idseller']=$c['idseller'];
        echo "<div class='content'>";
            
            echo "<div class='product'>";
            
            echo "<h3>".$c['name']."</h3>";
             
            //echo "<img src=Cigars_pictures/".$c['photos']." width='150px' >";
            $c['photos'] = substr($c['photos'],36); // thomas enleve cette ligne si pour toi ça bug
            echo "<img src=Cigars_pictures/".$c['photos']." width='150px' >";
            
             
            echo "<p class='description'>".$c['description']."</p>";
            echo "<p class='price'>Price : £".$c['price']."</p>";
            $_SESSION['priceItem']=$c['price'];
            echo "</div>";
            endforeach;

    if (isset ($_POST['change'])){
        header("Location: http://localhost/Ebay/buyNow.php"); /* Redirection du navigateur */
    }

    if (isset ($_POST['confirm'])){
        header("Location: http://localhost/Ebay/buyingBDD.php"); /* Redirection du navigateur */
    }
    $numberCardend = substr($_SESSION['cardnumber'],4,strlen($_SESSION['cardnumber']));
    $numberStartCardNumber = substr($_SESSION['cardnumber'],0,4);
?>
    <div class='informations'>
        First Name : <?php echo $_SESSION['firstname'];?><br>
        Last Name : <?php echo $_SESSION['lastname'];?><br>
        Email : <?php echo $_SESSION['email'];?><br>
        Adress : <?php echo $_SESSION['adress_line1'];?><br>
        City : <?php echo $_SESSION['city'];?><br>
        Postal Code : <?php echo $_SESSION['postal_code'];?><br>
        Card Name : <?php echo $_SESSION['fullname'];?><br>
        Card Number : <?php echo $numberStartCardNumber,str_repeat('*',strlen($numberCardend));?><br>
        Expiration Date : <?php echo str_repeat('*',strlen($_SESSION['expiration_date']));?><br>
        CVC : <?php echo str_repeat('*',strlen($_SESSION['cvc']));?><br>
        <form action = '' method = 'POST' id = 'formConfirmation'>
        <button type='submit' name='confirm' value='submit' class='buttonBuyNow'> Confirm </button>
        <button type='submit' name='change' value='submit' class='buttonBuyNow'> Change informations </button>
        </form>
        </div>
        </div>
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