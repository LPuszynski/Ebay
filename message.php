<!DOCTYPE html>
<html>
<html lang="en">
<head>
<link rel="icon" type="image/png" href="icon.png"/>
<link rel="stylesheet" href="message.css">	
<script src="https://kit.fontawesome.com/3581d4e558.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="index.js"></script>
<title>MailBox</title>



</head>
<body>

<?php
    session_start();

    //connection cith the db
    try
    {
        
        $db = new PDO('mysql:host=localhost;port=3306;dbname=ebay;', 'root', ''); /* Port de thomas = 3307 / Port de Lois = 3306 */
        /*$db = new PDO('mysql:host=localhost;port=3306;dbname=ebay;', 'root', '');*/ /* Port de thomas = 3307 / Port de Lois = 3306 */
        
        
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }

?>

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

/*there is the meaning of the state of a best offer
1 = new buyer offer
2 = new seller offer
3 = accepted by the buyer
4 = accepted by the seller
5 = decline (end of the 5 try)*/
    if($_SESSION['profilFound']==1){  //the user is a customer
        if (isset($_POST['accept'])){ //If he accepts an offer
            $stmt = $db->prepare('UPDATE bestoffer SET state = "3" WHERE id="'.$_POST['idBestOffer'].'"'); // we update the state of the bestoffer
            $stmt->execute();
        }
        if (isset($_POST['pay'])){ //If the customer click on pay on a best offer item
            $stmt = $db->prepare('SELECT * FROM bestoffer WHERE id="'.$_POST['idBestOffer'].'"');
                $stmt->execute();
                $users = $stmt->fetchAll();
                foreach($users as $user): // we get informations that we need on the bestoffer
                    $_SESSION['idItemBestOffer'] = $user['id_item'];
                    $_SESSION['idsellerbestoffer'] = $user['id_seller'];
                    $_SESSION['pricebestoffer'] = $user['price'];
                    $stmt1 = $db->prepare('UPDATE item SET price = "'.$_SESSION['pricebestoffer'].'" WHERE id="'.$_POST['idItemBestOffer'].'"'); //we set the price of the item for the payment
                    $stmt1->execute();
                endforeach;
            $_SESSION['payBestOffer']=1; // we warn buyingConfirmation.php that the followed transaction will be a best offer
            $stmt = $db->prepare('UPDATE bestoffer SET state = "6" WHERE id="'.$_POST['idBestOffer'].'"'); // we update the state of the bestoffer
            $stmt->execute();
            header("Location: http://localhost/GitHub/Ebay/buyingConfirmation.php"); /* Browser redirection */
        }
        if (isset($_POST['payAuction'])){ // If the customer click on pay on a bauction item

            $stmt = $db->prepare('SELECT * FROM auctions WHERE id="'.$_POST['idAuction'].'"');
                $stmt->execute();
                $users = $stmt->fetchAll();
                foreach($users as $user): //we get information that we need on the auction
                    $_SESSION['idsellerauction'] = $user['id_seller'];
                endforeach;
            $_SESSION['idItemAuction'] = $_POST['idItemAuction'];

            $_SESSION['payBestOffer']=2; // we warn buyingConfirmation.php that the followed transaction will be a auction


            header("Location: http://localhost/GitHub/Ebay/buyingConfirmation.php"); /* Browser redirection */
        }
        if (isset($_POST['decline'])){ // if the offer is declined after 5 try, the item is deleted from the bestoffer table
            $records = $db->prepare('DELETE FROM bestoffer WHERE id="'.$_POST['idBestOffer'].'"');
            $records->execute();
        }
        if (isset($_POST['proposition'])){ // if the user do a proposition
            if($_POST['amount']!=''){ //we check if the proposition is not empty
                $stmt = $db->prepare('UPDATE bestoffer SET state = "1" WHERE id="'.$_POST['idBestOffer'].'"'); // we update the state of the bestoffer
                $stmt->execute();
                $stmt = $db->prepare('UPDATE bestoffer SET price = "'.$_POST['amount'].'" WHERE id="'.$_POST['idBestOffer'].'"'); //we update the price on the best offer table
                $stmt->execute();
                $stmt = $db->prepare('SELECT * FROM bestoffer WHERE id_customer="'.$_SESSION['id'].'"');
                $stmt->execute();
                $users = $stmt->fetchAll();
                foreach($users as $user):
                    $count = $user['count']+1; // we count each proposition of the buyer, after 5, the best offer is over
                endforeach;
                $stmt = $db->prepare('UPDATE bestoffer SET count = "'.$count.'" WHERE id="'.$_POST['idBestOffer'].'"');
                $stmt->execute();
            }
        }

        echo "<div class='box'>";
        $stmt = $db->prepare('SELECT * FROM auctions WHERE id_buyer="'.$_SESSION['id'].'" AND end="1"');  // all auctions ended and won by the customer
        $stmt->execute();
        $users = $stmt->fetchAll();
        foreach($users as $user):
            
                $stmt2 = $db->prepare('SELECT * FROM item WHERE id="'.$user['id_item'].'"');
                $stmt2->execute();
                $cigar = $stmt2->fetchAll();

                
                
                foreach($cigar as $c):
                    echo "<div class='message'>";
                    
                    echo "<div class='product'>";
                    
                    echo "<h3>".$c['name']."</h3>";
                    
                    
                    echo $c['photos'] = substr($c['photos'],36);
                    echo "<img src=Cigars_pictures/".$c['photos']." class='images'>";
                    
                    
                    echo "<p class='description'>".$c['description']."</p>";
                    echo "<p class='price'>Price : £".$c['price']."</p>";
                    echo "<form action = '' method = 'POST'>";
                    echo '<input type="hidden" name="idAuction" value = "'.$user['id'].'"/>';
                    echo '<input type="hidden" name="idItemAuction" value = "'.$c['id'].'"/>';
                    
                    echo '</div>';
                endforeach;
                echo "<div class='proposition'>";
                echo '<br>';
                echo '<br>';
                echo 'you won a auction : ';
                echo '<br>';
                echo '<br>';
                echo '<br>';
                echo $user['price1'].'$';
                echo '<br>';
                echo '<br>';
                echo '<br>';
                
                echo "<button type='submit' name='payAuction'>Pay</button>";
                
                echo '</form>';
                echo '</div>';
                echo '</div>';
        endforeach;
        $stmt = $db->prepare('SELECT * FROM bestoffer WHERE id_customer="'.$_SESSION['id'].'"');
        $stmt->execute();
        $users = $stmt->fetchAll();
        foreach($users as $user):
            if($user['state']==2 || $user['state']==4 || $user['state']==3){ //depending on the state of the best offer, it's displayed differently
                $stmt2 = $db->prepare('SELECT * FROM item WHERE id="'.$user['id_item'].'"');
                $stmt2->execute();
                $cigar = $stmt2->fetchAll();

                
                
                foreach($cigar as $c):
                    echo "<div class='message'>";
                    
                    echo "<div class='product'>";
                    
                    echo "<h3>".$c['name']."</h3>";
                    
                    
                    echo $c['photos'] = substr($c['photos'],36); // thomas enleve cette ligne si pour toi ça bug
                    echo "<img src=Cigars_pictures/".$c['photos']." class='images'>";
                    
                    
                    echo "<p class='description'>".$c['description']."</p>";
                    echo "<p class='price'>Price : £".$c['price']."</p>";
                    echo "<form action = '' method = 'POST'>";
                    echo '<input type="hidden" name="idBestOffer" value = "'.$user['id'].'"/>';
                    echo '<input type="hidden" name="idItemBestOffer" value = "'.$c['id'].'"/>';
                    
                    echo '</div>';
                endforeach;
                echo "<div class='proposition'>";
                echo '<br>';
                echo '<br>';
                if($user['state']==4){
                    echo 'Le vendeur vous a accepté votre offre :';
                }
                elseif($user['state']==2){
                    echo 'Le vendeur vous a fait une contre-offre :';
                }
                else{
                    echo 'Offre acceptée, veuillez procéder au paiement :';
                }
                echo '<br>';
                echo '<br>';
                echo '<br>';
                echo $user['price'].'$';
                echo '<br>';
                echo '<br>';
                echo '<br>';
                if ($user['count']<4 && $user['state']==2){
                    echo "<input type ='number' name='amount' placeholder='Enter your proposition'>";
                }
                echo '<br>';
                echo '<br>';
                if($user['state']==4 || $user['state']==3){
                    echo "<button type='submit' name='pay'>Pay</button>";
                }
                else{
                    if ($user['count']<4){
                        echo "<button type='submit' name='proposition'>Make an other offer</button>";
                    }
                    else{
                        echo "<button type='submit' name='decline'>Decline (you will not be able to do an other proposition)</button>";
                    }
                    echo '<br>';
                    echo "<button type='submit' name='accept'>Accept</button>";
                }
                echo '</form>';
                echo '</div>';
                echo '</div>';
            }
        endforeach;
        echo '</div>';
    }
    elseif($_SESSION['profilFound']==2){  //the user is a seller
        if (isset($_POST['accept'])){
            $stmt = $db->prepare('UPDATE bestoffer SET state = "4" WHERE id="'.$_POST['idBestOffer'].'"');// we update the state of the bestoffer
            $stmt->execute();
        }
        if (isset($_POST['proposition'])){ // whene the seller make a counter-offer
            if($_POST['amount']!=''){
                $stmt = $db->prepare('UPDATE bestoffer SET state = "2" WHERE id="'.$_POST['idBestOffer'].'"'); // we update the state of the bestoffer
                $stmt->execute();
                $stmt = $db->prepare('UPDATE bestoffer SET price = "'.$_POST['amount'].'" WHERE id="'.$_POST['idBestOffer'].'"'); // we set the price of the best offer
                $stmt->execute();
            }
        }
        $stmt = $db->prepare('SELECT * FROM bestoffer WHERE id_seller="'.$_SESSION['id'].'"');
        $stmt->execute();
        $users = $stmt->fetchAll();
        echo "<div class='box'>";
        foreach($users as $user):
            if($user['state']==1){ 
                $stmt2 = $db->prepare('SELECT * FROM item WHERE id="'.$user['id_item'].'"');
                $stmt2->execute();
                $cigar = $stmt2->fetchAll();

                
                
                foreach($cigar as $c):
                    echo "<div class='message'>";
                    
                    echo "<div class='product'>";
                    
                    echo "<h3>".$c['name']."</h3>";
                    
                    
                    echo $c['photos'] = substr($c['photos'],36); // thomas enleve cette ligne si pour toi ça bug
                    echo "<img src=Cigars_pictures/".$c['photos']." class='images'>";
                    
                    
                    echo "<p class='description'>".$c['description']."</p>";
                    echo "<p class='price'>Price : £".$c['price']."</p>";
                    echo "<form action = '' method = 'POST'>";
                    echo '<input type="hidden" name="idBestOffer" value = "'.$user['id'].'"/>';
                    

                    
                    echo '</div>';
                endforeach;
                echo "<div class='proposition'>";
                echo '<br>';
                echo '<br>';
                echo 'Un acheteur a fait une offre pour votre produit :';
                echo '<br>';
                echo '<br>';
                echo '<br>';
                echo $user['price'].'$';
                echo '<br>';
                echo '<br>';
                echo '<br>';
                echo "<input type ='number' name='amount' placeholder='Enter your proposition'>";
                echo '<br>';
                echo '<br>';
                echo "<button type='submit' name='proposition'>Make an other offer</button>";
                echo '<br>';
                echo "<button type='submit' name='accept'>Accept</button>";
                echo '</form>';
                echo '</div>';
                echo '</div>';
            }
        endforeach;
        echo '</div>';
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