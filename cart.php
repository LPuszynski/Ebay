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

    date_default_timezone_set('Europe/Paris');
    $day = date('d');
    $date = date('y-m-d');
    $time = date('H:i:00');

    if (isset($_POST['buyNow'])){
        if ($_SESSION['profilFound']!=1){
            header('Location: http://localhost/GitHub/Ebay/login.php');
        }
        else{
            $_SESSION['idItemBuyNow']=$_POST['id'];
            header('Location: http://localhost/GitHub/Ebay/buyingConfirmation.php');
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
            if ($c['BuyNow']==1) 
            {
            echo "<div class='BuyNow'>";
            echo "<button type='submit' class='BuyItNow' name='buyNow'>Buy it now !</button>"; 
            echo "<input type = 'number' placeholder='Your best offer'>";
            echo "<button type='submit' name='submit'>Place offer!</button>";
            echo "</div>";
            }
            else{
                echo "<input type = 'number' placeholder='Enter your bid'>";
                echo "<button type='submit' name='submit'>Bid !</button>";
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