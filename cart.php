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
if ($_SESSION['profilFound']==0){
    echo 'You must log in if you want to access to your shopping cart'; //Faire un truc plus soins pour quand le mec est pas co genre un bouton pour qu'il se log et tout
}
else{
    $total = 0;
    //connection cith the db
    try{
    /*$db = new PDO('mysql:host=localhost;port=3306;dbname=ebay;', 'root', '');*/ /* Port de thomas = 3307 / Port de Lois = 3306 */

        
    }
    catch (Exception $e)
    {
            die('Erreur : ' . $e->getMessage());
    }

        $stmt = $db->prepare('SELECT * FROM cart WHERE idCustomer="'.$_SESSION['id'].'"');
        $stmt->execute();
        $items = $stmt->fetchAll();

        echo "<h1>Your Shopping Cart</h1>";

        echo "<div class='content'>";


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

            echo "<form name = '' action = '' method = ''>";
            if ($c['BuyNow']==1) 
            {
            echo "<div class='BuyNow'>";
            echo "<button type='submit' class='BuyItNow' name='submit'>Buy it now !</button>"; 
            echo "<input type = 'number' placeholder='Your best offer'>";
            echo "<button type='submit' name='submit'>Place offer!</button>";
            echo "</div>";
            }
            else{
                echo "<input type = 'number' placeholder='Enter your bid'>";
                echo "<button type='submit' name='submit'>Bid !</button>";
            }

            echo "</form>";

            echo "</div>";
        endforeach;
        endforeach;
        echo "</div>";
        echo "<div class='totalPrice'>";
        echo "Total price of your cart : ".$total."$";
        echo "</div>";
    }
    ?>

</body>
</html>