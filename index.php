<!DOCTYPE html>
<html>
<html lang="en">
<head>
<link rel="icon" type="image/png" href="icon.png"/>
<link rel="stylesheet" href="index.css">	
<script src="https://kit.fontawesome.com/3581d4e558.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="index.js"></script>
<title>Cigar shop</title>



</head>
<body>

<!--
<div class="wrapper">
    <ul>

<li> Category
            <ul>
<li><a href="cigars.php">Cigars</a></li>
<li><a href="">Accessories</li></li>
</ul><li> <a href="sellObject.php">Sell </a></li>
<li><a href="">Your account </a></li>
</div>
-->
<?php
	session_start();

	//connection with the db
	try
	{

	//$db = new PDO('mysql:host=localhost;port=3307;dbname=ebay;', 'root', '');	
	$db = new PDO('mysql:host=localhost;port=3306;dbname=ebay;', 'root', ''); /* Port de thomas = 3307 / Port de Lois = 3306 */

	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}

	if(isset($_SESSION['id'])==0){
		$_SESSION['id']=0;
	}

	if(isset($_SESSION['profilFound']) && $_SESSION['profilFound']==1){ //if the user is a buyer
		$i=0;
		date_default_timezone_set('Europe/Paris');
		$date = date('y-m-d');
		$time = date('H:i');
		$stmt = $db->prepare('SELECT * FROM auctions WHERE id_buyer="'.$_SESSION['id'].'"');
		$stmt->execute();
		$items = $stmt->fetchAll();
	
		foreach($items as $item): //we get all the informations of all on the auctions he is currently winning
			$i=$i+1;
			$idAuction = $item['id'];
			$idItem = $item['id_item'];
			$timeEnd = $item['timeEnd'];
			$dateEnd = $item['dateEnd'];
			$timeStart = $item['timeStart'];
			$dateStart = $item['dateStart'];
			$_SESSION['priceItemAuction'] = $item['price1'];
		endforeach;

		if($i>0){
			if ((strtotime($date)-strtotime($dateEnd)==0 && strtotime($time)<strtotime($timeEnd)) || (strtotime($date)>=strtotime($dateStart) && strtotime($date)<strtotime($dateEnd))){
			}
			else{ // if the time is over
				$stmt = $db->prepare('UPDATE auctions SET end = "1" WHERE id="'.$idAuction.'"'); //we set the auction as "end"
				$stmt->execute();
				$stmt = $db->prepare('UPDATE item SET price = "'.$_SESSION['priceItemAuction'].'" WHERE id="'.$idItem.'"'); // we change the real price of the item for payment
				$stmt->execute();
			}
		}
	}
//there is a lot of if conditions below because we wanted to personalise the menu for each type of user*/

?>


<div id="tlois">
	 &emsp;CIGAR SHOP SINCE 1955 &emsp; &emsp; &emsp;&emsp; &emsp;&emsp; &emsp;&emsp; &emsp; &emsp; &emsp; &emsp; &emsp; 
	 <?php
	 if (isset($_SESSION['profilFound'])==0){ //if the variable that indicate the type of the user isnt declared
		$_SESSION['profilFound']=0;  // the user is considered as a visitor
	 }

	 if($_SESSION['profilFound']==0){
		 echo '<a href="register.php">REGISTER</a> &emsp; &emsp;';
	 }
	 if($_SESSION['profilFound']!=2){
		echo '<a href="sellerRegister.php">BECOME A SELLER</a>&emsp; &emsp; &emsp;&emsp; &emsp;  &emsp; &emsp; &emsp;&emsp;&emsp;&emsp; &emsp; &emsp;&emsp; &emsp;';
	}
	if($_SESSION['profilFound']==0){
		echo '	 <a href="login.php">LOGIN</a>  &emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;';
	}
	if($_SESSION['profilFound']!=0){
		echo '	 <a href="signOut.php" >SIGN OUT</a>  &emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;';
	}
	if($_SESSION['profilFound']==3){
		echo '<a href="admin.php" class="admin" > <i class="fas fa-user-cog"></i> </a>';
	}
	?>
</div>	


<div id="title"> 
	Cigar Shop
</div>

<!--  TEST TA CAPTE
<div id="Categories">
&emsp;<a href="cigars.php">Buy</a>    &emsp;     
     &emsp;  
<a href="sellObject.php">Sell </a>    &emsp; &emsp; &emsp; &emsp; &emsp; 

<a href="financing.html"><img src="basket.png " height="20" width="20" ></a>   

<a href="financing.html"><img src="basket.png " height="20" width="20" ></a> 
</div>
-->




<div class="wrapper">
    <ul>
	<li><a href="index.php">Home</li>
<li> Categories
            <ul>
<li><a href="cigars.php">Cigars</a></li>
<li><a href="">Accessories</li></li></ul>
<?php
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




<div id="Carousel">
	
	 <img src="cigares1.jpg" class="images" id="cigare">
    <button id="previous">Previous</button>
    <button id="next">Next</button>
	</div>

<div id="cba">
<div id="abc">
Our online store offers a wide selection of premium cigars from Cuba, Dominican Republic, Nicaragua and Honduras. <br><br>

<br>Our team of enthusiasts travels every year to the countries of production in order to perfect their knowledge, define trends, <br>produce new ranges of house-branded cigars, and develop private labels for their various prestigious clients.

<br><br><br>Our online store distinguishes itself from its competitors by its unique relationship with the exclusive (Swiss) importers <br> of the cigar brands you buy every day. We do not buy any cigars on the parallel market! Therefore, we ensure 100% traceability and certification <br>of the cigars we offer for sale to our customers worldwide.

<br><br><br>CigarShop.com belongs to a Swiss family group active in the cigar business for more than 40 years.

<br><br><br>Our prices are the most competitive of the market for a 100% certified quality of the official import Habanos - Intertabak AG <br>the only Official Importer of Cuban cigars for Switzerland, Davidoff - Oettinger Group AG for the Dominican cigars of <br>this Basel family group, A. Fuente, for the cigars of the Fuente brand with which we have maintained friendly and commercial relations for more than 25 years, <br>and likewise for all the brands of cigars imported in Switzerland via their authorized and certified importers.

<br><br><br>Cigar Shop, your trusted partner for the online purchase of premium cigars.

<br><br><br>Your Cigar Shop Team
</div>
</div>

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