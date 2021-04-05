<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="products.css">
    <title>Cigars to buy</title>
     <link rel="icon" type="image/png" href="icon.png"/>

     <script type="text/javascript">
    
    function submit(){
        window.location.href = "add.php?var1=" + document.getElementById("cart").value;
    }

    </script>
</head>
<body>
<?php 
session_start();

/*if (isset($_GET["var1"]){
    echo $_GET["var1"];
}*/

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

$_SESSION['payBestOffer']=0;
if (isset($_POST['cart'])){
    date_default_timezone_set('Europe/Paris');
    $date = date('y-m-d');
    $time = date('H:i');


// the item is connected to the cart with the id of the customer
    if ($_SESSION['profilFound']==0){ // if the user is an guest
        $stmt = $db->prepare('SELECT * FROM cart WHERE idItem="'.$_POST['id'].'" AND idCustomer="0"');
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user) { //if the item is already on cart, we just update the hour and date
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
        else{ // if the user is connected
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
    if ($_SESSION['profilFound']!=1){ // if nobody is connected we go to login
        header('Location: http://localhost/GitHub/Ebay/login.php');
    }
    else{ // else wa go to the buying page
        $_SESSION['idItemBuyNow']=$_POST['id'];
        header('Location: http://localhost/GitHub/Ebay/buyingConfirmation.php');
    }
}

if (isset($_POST['bid'])){
    date_default_timezone_set('Europe/Paris');//we set the time and the date
    $date = date('y-m-d');
    $time = date('H:i');
    if ($_SESSION['profilFound']!=1){// if nobody is connected we go to login
        header('Location: http://localhost/GitHub/Ebay/login.php');
    }
    else{
        if ($_POST['bidAmout']!='' && $_POST['bidAmout']!='0'){ // we check if an amount is set
            $stmt = $db->prepare('SELECT * FROM auctions WHERE id_item="'.$_POST['id'].'"');
            $stmt->execute();
            $items = $stmt->fetchAll();
            
            foreach($items as $item): // we take all of the informations we need on the item
                $price1 = $item['price1'];
                $price2 = $item['price2'];
                $timeEnd = $item['timeEnd'];
                $dateEnd = $item['dateEnd'];
                $timeStart = $item['timeStart'];
                $dateStart = $item['dateStart'];
                $id_buyer = $item['id_buyer'];
            endforeach;

                if ((strtotime($date)-strtotime($dateEnd)==0 && strtotime($time)<strtotime($timeEnd)) || (strtotime($date)>=strtotime($dateStart) && strtotime($date)<strtotime($dateEnd))){ //we check if its still on time
                    if ($_POST['bidAmout'] <= $price1){
                        echo 'enter a value greater than the displayed price';
                    }

                    elseif ($_POST['bidAmout'] > $price1){

                        $stmt = $db->prepare('SELECT * FROM cart WHERE idItem="'.$_POST['id'].'" AND idCustomer="'.$_SESSION['id'].'"');
                        $stmt->execute();
                        $user = $stmt->fetch();
                        if ($user==NULL) { // put the article on the cart
                            $stmt = $db->prepare('INSERT INTO cart (idCustomer, idItem, date, time, auction) VALUES ("'.$_SESSION['id'].'", "'.$_POST['id'].'", "'.$date.'", "'.$time.'","1")');
                            $stmt->execute();
                        }

                        if ($price2 == NULL){ // if it is the first bid
                            $stmt = $db->prepare('UPDATE auctions SET price2 = "'.$_POST['bidAmout'].'" WHERE id_item="'.$_POST['id'].'"');//we set the price2 
                            $stmt->execute();
                            $stmt = $db->prepare('UPDATE auctions SET price1 = "'.($price1+1).'" WHERE id_item="'.$_POST['id'].'"');//we set the price1
                            $stmt->execute();
                            $stmt = $db->prepare('UPDATE item SET price = "'.($price1+1).'" WHERE id="'.$_POST['id'].'"');//we set the price of the item
                            $stmt->execute();
                            $stmt = $db->prepare('UPDATE auctions SET id_buyer = "'.$_SESSION['id'].'" WHERE id_item="'.$_POST['id'].'"');//we set the id of the buyer
                            $stmt->execute();
                        }
                        
                        // if the price is bigger than the hidden price (price2)
                        // we update the price2 and the price1 and the id of the buyer
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

                        elseif ($_POST['bidAmout'] == $price2){//if the price is equal than the price2 we dont change the id of the buyer, we consider that the item is still won by the first buyer
                            $stmt = $db->prepare('UPDATE auctions SET price1 = "'.$_POST['bidAmout'].'" WHERE id_item="'.$_POST['id'].'"');
                            $stmt->execute();
                            $stmt = $db->prepare('UPDATE item SET price = "'.$_POST['bidAmout'].'" WHERE id="'.$_POST['id'].'"');
                            $stmt->execute();
                        }
                        elseif ($_POST['bidAmout'] < $price2){//if the price is betwenn the price1 and price2
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
            date_default_timezone_set('Europe/Paris'); // we set the date and the time
            $date = date('y-m-d');
            $time = date('H:i');
            $stmt = $db->prepare('SELECT * FROM bestoffer WHERE id_item="'.$_POST['id'].'" AND id_customer="'.$_SESSION['id'].'"');
            $stmt->execute();
            $user = $stmt->fetch();
            if ($user==NULL) { //if there is not already a best offer
                $stmt = $db->prepare('SELECT * FROM item WHERE id="'.$_POST['id'].'"');
                $stmt->execute();
                $items = $stmt->fetchAll();
                
                foreach($items as $item):
                    $id_seller = $item['idseller'];
                endforeach;
                //we set the best offer and put the item on the cart
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

$stmt = $db->prepare('SELECT * FROM item WHERE category="cigars"');
$stmt->execute();
$cigar = $stmt->fetchAll();

echo "<h1>This is our products</h1>";

echo "<div class='content'>";

foreach($cigar as $c):
    
    echo "<div class='product'>";
    
     echo "<h3>".$c['name']."</h3>";
     
     
     $c['photos'] = substr($c['photos'],36); // thomas enleve cette ligne si pour toi ça bug
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
    echo '<input type="hidden" id="id" name="id" value = "'.$c['id'].'"/>';  // in order to have the id of the item that we click on
    echo "</form>";
        

        

     echo "</div>";
    endforeach;

    echo "</div>";
    ?>

</body>
</html>