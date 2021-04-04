<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="products.css">
    <title>Cart</title>
     <link rel="icon" type="image/png" href="icon.png"/>
</head>
<body>
<?php 
session_start();

    $total = 0;
    //connection cith the db
    try{
        $db = new PDO('mysql:host=localhost;port=3306;dbname=ebay;', 'root', ''); /* Port de thomas = 3307 / Port de Lois = 3306 */
    /*$db = new PDO('mysql:host=localhost;port=3306;dbname=ebay;', 'root', '');*/ /* Port de thomas = 3307 / Port de Lois = 3306 */

        
    }
    catch (Exception $e)
    {
            die('Erreur : ' . $e->getMessage());
    }

    //if objects in the cart while not connected, the objects are put in the cart of the one who connects
    if(isset($_SESSION['id'])){ // if someone is connected
        $stmt = $db->prepare('SELECT * FROM cart');
        $stmt->execute();
        $items = $stmt->fetchAll();
        foreach($items as $item):
            if($item['idCustomer']==0){
                $item['idCustomer']=$_SESSION['id']; //we change the id of the article in the cart
            }
        endforeach;
    }

    date_default_timezone_set('Europe/Paris'); // we set the date and the time
    $day = date('d');
    $date = date('y-m-d');
    $time = date('H:i:00');

    if (isset($_POST['buyNow'])){ // if the user click on buyNow
        if ($_SESSION['profilFound']!=1){
            header('Location: http://localhost/GitHub/Ebay/login.php'); //If nobody is connected we go to login
        }
        else{
            $_SESSION['idItemBuyNow']=$_POST['id'];
            header('Location: http://localhost/GitHub/Ebay/buyingConfirmation.php');  // else we go to the buying page
        }
    }

    if (isset($_POST['bid'])){ // if the user click on bid
        date_default_timezone_set('Europe/Paris'); // we set the date and the time
        $date = date('y-m-d');
        $time = date('H:i');
        if ($_SESSION['profilFound']!=1){
            header('Location: http://localhost/GitHub/Ebay/login.php'); //If nobody is connected we go to login
        }
        else{
            if ($_POST['bidAmout']!='' && $_POST['bidAmout']!='0'){ //we check if the user enter a number
                $stmt = $db->prepare('SELECT * FROM auctions WHERE id_item="'.$_POST['id'].'"');
                $stmt->execute();
                $items = $stmt->fetchAll();
                
                foreach($items as $item): // we load the informations on the item wanted
                    $price1 = $item['price1'];
                    $price2 = $item['price2'];
                    $timeEnd = $item['timeEnd'];
                    $dateEnd = $item['dateEnd'];
                    $timeStart = $item['timeStart'];
                    $dateStart = $item['dateStart'];
                endforeach;
    
                    if ((strtotime($date)-strtotime($dateEnd)==0 && strtotime($time)<strtotime($timeEnd)) || (strtotime($date)>=strtotime($dateStart) && strtotime($date)<strtotime($dateEnd))){ //we check if its still on time
                        if ($_POST['bidAmout'] <= $price1){ // if price is too low
                            echo 'enter a value greater than the displayed price';
                        }
    
                        elseif ($_POST['bidAmout'] > $price1){ 
    
                            $stmt = $db->prepare('SELECT * FROM cart WHERE idItem="'.$_POST['id'].'" AND idCustomer="'.$_SESSION['id'].'"');
                            $stmt->execute();
                            $user = $stmt->fetch();
                            /*if ($user==NULL) { // important when we are not on the cart but here it's useless
                                $stmt = $db->prepare('INSERT INTO cart (idCustomer, idItem, date, time, auction) VALUES ("'.$_SESSION['id'].'", "'.$_POST['id'].'", "'.$date.'", "'.$time.'","1")');
                                $stmt->execute();
                            }*/
    
                            if ($price2 == NULL){ // if it is the first 
                                $stmt = $db->prepare('UPDATE auctions SET price2 = "'.$_POST['bidAmout'].'" WHERE id_item="'.$_POST['id'].'"'); //we set the price2 
                                $stmt->execute();
                                $stmt = $db->prepare('UPDATE auctions SET price1 = "'.($price1+1).'" WHERE id_item="'.$_POST['id'].'"');//we set the price1
                                $stmt->execute();
                                $stmt = $db->prepare('UPDATE item SET price = "'.($price1+1).'" WHERE id="'.$_POST['id'].'"'); //we set the price of the item
                                $stmt->execute();
                                $stmt = $db->prepare('UPDATE auctions SET id_buyer = "'.$_SESSION['id'].'" WHERE id_item="'.$_POST['id'].'"');//we set the id of the buyer
                                $stmt->execute();
                            }
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
            header('Location: http://localhost/GitHub/Ebay/login.php');
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
                }
    
                else{
                    echo 'Vous avez déja fait une offre pour ce produit, veuillez vérifier votre messagerie afin de voir si le vendeur vous a répondu';
                }
            }
        }
    }

        $stmt = $db->prepare('SELECT * FROM cart WHERE idCustomer="'.$_SESSION['id'].'"');
        $stmt->execute();
        $items = $stmt->fetchAll();



        echo "<h1>Your Shopping Cart</h1>";

        echo "<div class='content'>";
        
        foreach($items as $item):
            if ($item['auction']==NULL){
                $dayItem = substr($item['date'],8,2);
                $differenceTime = strtotime($time)-strtotime($item['time']);
                if($dayItem != $day){
                    $records = $db->prepare('DELETE FROM cart WHERE id="'.$item['id'].'"');
                    $records->execute();
                }
                if($differenceTime >= 3600){
                    $records = $db->prepare('DELETE FROM cart WHERE id="'.$item['id'].'"');
                    $records->execute();
                }
            }

            elseif ($item['auction']==1){
                $stmt2 = $db->prepare('SELECT * FROM auctions WHERE id_item="'.$item['idItem'].'"');
                $stmt2->execute();
                $auctions = $stmt2->fetchAll();
                foreach($auctions as $auc):
                    $timeEnd = $auc['timeEnd'];
                    $dateEnd = $auc['dateEnd'];
                    if ((strtotime($date)-strtotime($dateEnd)==0 && strtotime($time)<strtotime($timeEnd)) || (strtotime($date)<strtotime($dateEnd))){ //we check if its still on time
                    }
                    else{
                        $records = $db->prepare('DELETE FROM cart WHERE id="'.$item['id'].'"');
                        $records->execute();
                    }   
                endforeach;

            }
    endforeach;

    $stmt = $db->prepare('SELECT * FROM cart WHERE idCustomer="'.$_SESSION['id'].'"');
        $stmt->execute();
        $items = $stmt->fetchAll();

        foreach($items as $item):

        $stmt2 = $db->prepare('SELECT * FROM item WHERE id="'.$item['idItem'].'"');
        $stmt2->execute();
        $cigars = $stmt2->fetchAll();
        foreach($cigars as $c):
            $total = $total + $c['price'];

            echo "<div class='product'>";

            echo "<h3>".$c['name']."</h3>";

            //echo "<img src=Cigars_pictures/".$c['photos']." width='150px' >";
        
            echo $c['photos'] = substr($c['photos'],36); // thomas enleve cette ligne si pour toi ça bug
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
            else{
                echo "<input type='number' name='bidAmout' placeholder='Enter your bid'>";
                echo "<button type='submit' name='bid'>Bid !</button>";
            }
            echo '<input type="hidden" id="id" name="id" value = "'.$c['id'].'"/>';

            echo "</form>";

            echo "</div>";
        endforeach;
        endforeach;
        echo "</div>";
        echo "<div class='totalPrice'>";
        echo "Total price of your cart : ".$total."$";
        echo "</div>";
    ?>

</body>
</html>