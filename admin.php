<!DOCTYPE html>
<html>
<head>
<link rel="icon" type="image/png" href="icon.png"/>
<link rel="stylesheet" href="admin.css">


	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<title>Admin Page</title>
</head>
<body>
<?php
	session_start();

	//connection cith the db
	try
	{

	$db = new PDO('mysql:host=localhost;port=3307;dbname=ebay;', 'root', '');	
	//$db = new PDO('mysql:host=localhost;port=3306;dbname=ebay;', 'root', ''); /* Port de thomas = 3307 / Port de Lois = 3306 */

	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}

	if($_SESSION['profilFound']==1){
		$i=0;
		date_default_timezone_set('Europe/Paris');
		$date = date('y-m-d');
		$time = date('H:i');
		$stmt = $db->prepare('SELECT * FROM auctions WHERE id_buyer="'.$_SESSION['id'].'"');
		$stmt->execute();
		$items = $stmt->fetchAll();
	
		foreach($items as $item):
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
			if ((strtotime($date)-strtotime($dateEnd)==0 && strtotime($time)<strtotime($timeEnd)) || (strtotime($date)>=strtotime($dateStart) && strtotime($date)<strtotime($dateEnd))){ //we check if its still on time
			}
			else{
				$stmt = $db->prepare('UPDATE auctions SET end = "1" WHERE id="'.$idAuction.'"');
				$stmt->execute();
				$stmt = $db->prepare('UPDATE item SET price = "'.$_SESSION['priceItemAuction'].'" WHERE id="'.$idItem.'"');
				$stmt->execute();
			}
		}
	}
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
	?>
	<a href="admin.php" class="admin" > <i class="fas fa-user-cog"></i> </a>
</div>	

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
<li><a href="yourAccount">Your account </a></li></ul>
<?php
if($_SESSION['profilFound']!=0){
	echo '<div id="personnalInfo">'.$_SESSION['firstname'].'&emsp; &emsp;'.$_SESSION['lastname'].'</div>';
}
?>
<a href="message.php" id="message"><img src="message.png" width="50px"></i></a>
<a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
</div>


<?php 
session_start();

//connection cith the db
try
{
    
    $db = new PDO('mysql:host=localhost;port=3307;dbname=ebay;', 'root', ''); /* Port de thomas = 3307 / Port de Lois = 3306 */
    /*$db = new PDO('mysql:host=localhost;port=3306;dbname=ebay;', 'root', '');*/ /* Port de thomas = 3307 / Port de Lois = 3306 */
    
    
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}


$stmt = $db->prepare('SELECT * FROM seller');
$stmt->execute();
$sellers = $stmt->fetchAll();
 echo "<div class='product'>";
  echo "<form>";
 echo "<h3>List of the sellers</h3>";
foreach($sellers as $seller):
 
    
    
     echo $seller['firstname']."  ";
     echo $seller['lastname'];
     //echo "<button type='submit' value='Delete Seller' id='".$seller['
     echo '<a href="admin.php?delete='.$seller["id"].'"><span>Delete this seller </span> </a>';
        
	
    endforeach;
	 echo "</form>";
	echo "</div>";

    if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    	$idSeller=$_GET['delete'];

        // $stmt = $db->prepare('DELETE FROM item WHERE idSeller ='.$idSeller.'');
        // $stmt->execute();

        $stmt = $db->prepare('DELETE FROM seller WHERE id ='.$idSeller.'');
        $stmt->execute();
    }

    ?>



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