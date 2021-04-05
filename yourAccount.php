<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="yourAccount.css">
    <title>Your Account</title>
    <link rel="icon" type="image/png" href="icon.png"/>
     <script type="text/javascript">

    </script>
</head>

<body>


<div id="tlois">
	 &emsp;CIGAR SHOP SINCE 1955 &emsp; &emsp; &emsp;&emsp; &emsp;&emsp; &emsp;&emsp; &emsp; &emsp; &emsp; &emsp; &emsp; 
	 <?php
     session_start();
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
<?php 
   // session_start();


    //connection cith the db
    try{
	$db = new PDO('mysql:host=localhost;port=3307;dbname=ebay;', 'root', ''); /* Port de thomas = 3307 / Port de Lois = 3306 */
   /*$db = new PDO('mysql:host=localhost;port=3306;dbname=ebay;', 'root', '');*/ /* Port de thomas = 3307 / Port de Lois = 3306 */
    }

    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }

    if($_SESSION['profilFound']==0 || isset($_SESSION['profilFound'])==0){
        header('Location: http://localhost/GitHub/Ebay/login.php'); //if the user is not connected we lead him to login page
    }
    elseif($_SESSION['profilFound']==1){ //if the user is a customer
        echo '<div id="YourHistory" align="center"><h2> YOUR HISTORY</h2></div>';
        $stmt = $db->prepare('SELECT * FROM ordercustomer WHERE id_customer="'.$_SESSION['id'].'"');
    $stmt->execute();
    $orders = $stmt->fetchAll();
    foreach($orders as $order):



    echo "<div class='content'>";
    $stmt2 = $db->prepare('SELECT * FROM item WHERE id="'.$order['id_item'].'"');
    $stmt2->execute();
    $cigar = $stmt2->fetchAll();
    foreach($cigar as $c): //we display all items he bought 
        
        echo "<div class='product'>";
        
        echo "<h3>".$c['name']."</h3>";
        
        
      //  echo $c['photos'] = substr($c['photos'],36); // thomas enleve cette ligne si pour toi ça bug
        echo "<img src=Cigars_pictures/".$c['photos']." width='150px' >";
        
        
        echo "<p class='description'>".$c['description']."</p>";
        echo "<p class='price'>Price : £".$c['price']."</p>";
        
        
        echo '<input type="hidden" id="id" name="id" value = "'.$c['id'].'"/>';
        echo "<p> price you paid : £".$order['price']."</p>";
        echo "<p> time: ".$order['time']."</p>";
        echo "<p> date : ".$order['date']."</p>";

        echo "</div>";
        endforeach;

        echo "</div>";
    endforeach;
    }

    elseif($_SESSION['profilFound']==2){ //if the user is a customer
           echo '<div id="YourHistory" align="center"><h2> YOUR HISTORY </h2></div>';
        
        
        
        echo "<div class='content'>";
    $stmt2 = $db->prepare('SELECT * FROM item WHERE idseller="'.$_SESSION['id'].'"');
    $stmt2->execute();
    $cigar = $stmt2->fetchAll();
    foreach($cigar as $c): // we display all items the seller has sold or is selling
        
        echo "<div class='product'>";
        
        echo "<h3>".$c['name']."</h3>";
        
        
     //   echo $c['photos'] = substr($c['photos'],36); // thomas enleve cette ligne si pour toi ça bug
        echo "<img src=Cigars_pictures/".$c['photos']." width='150px' >";
        
        
        echo "<p class='description'>".$c['description']."</p>";
        echo "<p class='price'>Price : £".$c['price']."</p>";
        
        
        echo '<input type="hidden" id="id" name="id" value = "'.$c['id'].'"/>';
        if ($c['category'])
        if (strcmp ( $c['category'], 'vendu') == 0){
            echo "<p>Vendu</p>";
        }


        echo "</div>";
        endforeach;

        echo "</div>";

    }
    
    

    
    ?>

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