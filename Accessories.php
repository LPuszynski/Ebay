<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="products.css">
    <title>Accessories to buy</title>
     <link rel="icon" type="image/png" href="icon.png"/>

     <script type="text/javascript">
    
    function submit(){
        window.location.href = "add.php?var1=" + document.getElementById("cart").value;
    }

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
<li><a href="Accessories.php">Accessories</li></li></ul>
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
//session_start();

/*if (isset($_GET["var1"]){
    echo $_GET["var1"];
}*/

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

$_SESSION['payBestOffer']=0;
if (isset($_POST['cart'])){
    date_default_timezone_set('Europe/Paris');
    $date = date('y-m-d');
    $time = date('H:i');



    if ($_SESSION['profilFound']==0){
        $stmt = $db->prepare('SELECT * FROM cart WHERE idItem="'.$_POST['id'].'" AND idCustomer="0"');
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user) {
            $stmt = $db->prepare('UPDATE cart SET date = "'.$date.'" WHERE idItem="'.$_POST['id'].'" AND idCustomer="0"');
            $stmt->execute();
            $stmt = $db->prepare('UPDATE cart SET time = "'.$time.'" WHERE idItem="'.$_POST['id'].'" AND idCustomer="0"');
            $stmt->execute();
        }
        else{
            $stmt = $db->prepare('INSERT INTO cart (idCustomer, idItem, date, time) VALUES ("0", "'.$_POST['id'].'", "'.$date.'", "'.$time.'")');
            $stmt->execute();      
        }
    }
        else{
            $stmt = $db->prepare('SELECT * FROM cart WHERE idItem="'.$_POST['id'].'" AND idCustomer="'.$_SESSION['id'].'"');
            $stmt->execute();
            $user = $stmt->fetch();
            if ($user) {
                $stmt = $db->prepare('UPDATE cart SET date = "'.$date.'" WHERE idItem="'.$_POST['id'].'" AND idCustomer="'.$_SESSION['id'].'"');
                $stmt->execute();
                $stmt = $db->prepare('UPDATE cart SET time = "'.$time.'" WHERE idItem="'.$_POST['id'].'" AND idCustomer="'.$_SESSION['id'].'"');
                $stmt->execute();
            }
            else{
                $stmt = $db->prepare('INSERT INTO cart (idCustomer, idItem, date, time) VALUES ("'.$_SESSION['id'].'", "'.$_POST['id'].'", "'.$date.'", "'.$time.'")');
                $stmt->execute();
            }
    }
}


if (isset($_POST['buyNow'])){
    if ($_SESSION['profilFound']!=1){
        header('Location: http://localhost/Ebay/login.php');
    }
    else{
        $_SESSION['idItemBuyNow']=$_POST['id'];
        header('Location: http://localhost/Ebay/buyingConfirmation.php');
    }
}

if (isset($_POST['bid'])){
    date_default_timezone_set('Europe/Paris');
    $date = date('y-m-d');
    $time = date('H:i');
    if ($_SESSION['profilFound']!=1){
        header('Location: http://localhost/Ebay/login.php');
    }
    else{
        if ($_POST['bidAmout']!='' && $_POST['bidAmout']!='0'){
            $stmt = $db->prepare('SELECT * FROM auctions WHERE id_item="'.$_POST['id'].'"');
            $stmt->execute();
            $items = $stmt->fetchAll();
            
            foreach($items as $item):
                $price1 = $item['price1'];
                $price2 = $item['price2'];
                $timeEnd = $item['timeEnd'];
                $dateEnd = $item['dateEnd'];
                $timeStart = $item['timeStart'];
                $dateStart = $item['dateStart'];
                $id_buyer = $item['id_buyer'];
            endforeach;
                //$differenceTime = strtotime($time)-strtotime($item['time']);

                if ((strtotime($date)-strtotime($dateEnd)==0 && strtotime($time)<strtotime($timeEnd)) || (strtotime($date)>=strtotime($dateStart) && strtotime($date)<strtotime($dateEnd))){ //we check if its still on time
                    if ($_POST['bidAmout'] <= $price1){
                        echo 'rentrez une valeure plus grande que le prix affiché';
                    }

                    elseif ($_POST['bidAmout'] > $price1){

                        $stmt = $db->prepare('SELECT * FROM cart WHERE idItem="'.$_POST['id'].'" AND idCustomer="'.$_SESSION['id'].'"');
                        $stmt->execute();
                        $user = $stmt->fetch();
                        if ($user==NULL) {
                            $stmt = $db->prepare('INSERT INTO cart (idCustomer, idItem, date, time, auction) VALUES ("'.$_SESSION['id'].'", "'.$_POST['id'].'", "'.$date.'", "'.$time.'","1")');
                            $stmt->execute();
                        }

                        if ($price2 == NULL){
                            $stmt = $db->prepare('UPDATE auctions SET price2 = "'.$_POST['bidAmout'].'" WHERE id_item="'.$_POST['id'].'"');
                            $stmt->execute();
                            $stmt = $db->prepare('UPDATE auctions SET price1 = "'.($price1+1).'" WHERE id_item="'.$_POST['id'].'"');
                            $stmt->execute();
                            $stmt = $db->prepare('UPDATE item SET price = "'.($price1+1).'" WHERE id="'.$_POST['id'].'"');
                            $stmt->execute();
                            $stmt = $db->prepare('UPDATE auctions SET id_buyer = "'.$_SESSION['id'].'" WHERE id_item="'.$_POST['id'].'"');
                            $stmt->execute();
                        }
                        /*
                        //Si le meme customer fait 2 bid d'affilé
                        if(isset($id_buyer) && $id_buyer==$_SESSION['id']){
                            //si le bid est plus grand que son ancien bid on change juste price2
                            if($_POST['bidAmout'] > $price2){
                                $stmt = $db->prepare('UPDATE auctions SET price2 = "'.$_POST['bidAmout'].'" WHERE id_item="'.$_POST['id'].'"');
                                $stmt->execute();
                            }
                            //si le bid est inferieur a son ancien bid on ne fait rien
                            elseif($_POST['bidAmout'] <= $price2){
                                echo 'You already bid on that item for more money, make a better bid or wait for the end of the auction';
                            }
                        }*/
                        elseif ($_POST['bidAmout'] > $price2){
                            $stmt = $db->prepare('UPDATE auctions SET price2 = "'.$_POST['bidAmout'].'" WHERE id_item="'.$_POST['id'].'"');
                            $stmt->execute();
                            $stmt = $db->prepare('UPDATE auctions SET price1 = "'.($price2+1).'" WHERE id_item="'.$_POST['id'].'"');
                            $stmt->execute();
                            $stmt = $db->prepare('UPDATE item SET price = "'.($price2+1).'" WHERE id="'.$_POST['id'].'"');
                            $stmt->execute();
                            $stmt = $db->prepare('UPDATE auctions SET id_buyer = "'.$_SESSION['id'].'" WHERE id_item="'.$_POST['id'].'"');
                            $stmt->execute();
                        }
                        elseif ($_POST['bidAmout'] == $price2){
                            $stmt = $db->prepare('UPDATE auctions SET price1 = "'.$_POST['bidAmout'].'" WHERE id_item="'.$_POST['id'].'"');
                            $stmt->execute();
                            $stmt = $db->prepare('UPDATE item SET price = "'.$_POST['bidAmout'].'" WHERE id="'.$_POST['id'].'"');
                            $stmt->execute();
                        }
                        elseif ($_POST['bidAmout'] < $price2){
                            $stmt = $db->prepare('UPDATE auctions SET price1 = "'.($_POST['bidAmout']+1).'" WHERE id_item="'.$_POST['id'].'"');
                            $stmt->execute();
                            $stmt = $db->prepare('UPDATE item SET price = "'.($_POST['bidAmout']+1).'" WHERE id="'.$_POST['id'].'"');
                            $stmt->execute();
                        }
                    
                }
            }
        }
    }
}

if (isset($_POST['bestOffer'])){
    if ($_SESSION['profilFound']!=1){
        header('Location: http://localhost/Ebay/login.php');
    }
    else{
        if ($_POST['bestOfferAmount']!='' && $_POST['bestOfferAmount']!='0'){
            date_default_timezone_set('Europe/Paris');
            $date = date('y-m-d');
            $time = date('H:i');
            $stmt = $db->prepare('SELECT * FROM bestoffer WHERE id_item="'.$_POST['id'].'" AND id_customer="'.$_SESSION['id'].'"');
            $stmt->execute();
            $user = $stmt->fetch();
            if ($user==NULL) {
                $stmt = $db->prepare('SELECT * FROM item WHERE id="'.$_POST['id'].'"');
                $stmt->execute();
                $items = $stmt->fetchAll();
                
                foreach($items as $item):
                    $id_seller = $item['idseller'];
                endforeach;

                $stmt = $db->prepare('INSERT INTO bestoffer (id_item, id_seller, price, id_customer, state) VALUES ("'.$_POST['id'].'", "'.$id_seller.'", "'.$_POST['bestOfferAmount'].'", "'.$_SESSION['id'].'","1")');
                $stmt->execute();
                $stmt = $db->prepare('INSERT INTO cart (idCustomer, idItem, date, time, auction) VALUES ("'.$_SESSION['id'].'", "'.$_POST['id'].'", "'.$date.'", "'.$time.'","2")');
                $stmt->execute();
            }

            else{
                echo 'Vous avez déja fait une offre pour ce produit, veuillez vérifier votre messagerie afin de voir si le vendeur vous a répondu';
            }
        }
    }
}

$stmt = $db->prepare('SELECT * FROM item WHERE category="accessories"');
$stmt->execute();
$cigar = $stmt->fetchAll();

echo "<h1>This is our products</h1>";

echo "<div class='content'>";

foreach($cigar as $c):
    
    echo "<div class='product'>";
    
     echo "<h3>".$c['name']."</h3>";
     
     
    // echo $c['photos'] = substr($c['photos'],36); // thomas enleve cette ligne si pour toi ça bug
     echo "<img src=Cigars_pictures/".$c['photos']." width='150px' >";
     
     
     echo "<p class='description'>".$c['description']."</p>";
     echo "<p class='price'>Price : £".$c['price']."</p>";
     
     echo "<form action = '' method = 'POST'>";

     if ($c['BuyNow']==1 || $c['BuyNow']==2 || $c['BuyNow']==3) {
         echo "<div class='BuyNow'>";
         if($c['BuyNow']==1 || $c['BuyNow']==3){
            echo "<button type='submit' class='BuyItNow' name='buyNow'>Buy it now !</button>";
         }
         if($c['BuyNow']==2 || $c['BuyNow']==3){
            echo "<input type = 'number' name ='bestOfferAmount' placeholder='Your best offer'>";
            echo "<button type='submit' name='bestOffer'>Place offer!</button>";
        }
        echo "</div>";
    }

    if ($c['BuyNow']==0){
        echo "<input type = 'number' name='bidAmout' placeholder='Enter your bid'>";
        echo "<button type='submit' name='bid'>Bid !</button>";
    }

    echo '<div class="cart"> <button type="submit" id="cart" name="cart"> Cart </div>';
    echo '<input type="hidden" id="id" name="id" value = "'.$c['id'].'"/>';
    echo "</form>";
        

        

     echo "</div>";
    endforeach;

    echo "</div>";
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