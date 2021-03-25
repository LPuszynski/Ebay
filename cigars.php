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
    
    /*$db = new PDO('mysql:host=localhost;port=3306;dbname=ebay;', 'root', '');*/ /* Port de thomas = 3307 / Port de Lois = 3306 */
    
    
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}


if (isset($_POST['cart'])){
    if ($_SESSION['profilFound']==0){
        $stmt = $db->prepare('INSERT INTO cart (idCustomer, idItem) VALUES ("0", "'.$_POST['id'].'")');
    }
    else{
        $stmt = $db->prepare('INSERT INTO cart (idCustomer, idItem) VALUES ("'.$_SESSION['id'].'", "'.$_POST['id'].'")');
    }
    $stmt->execute();
}

if (isset($_POST['buyNow'])){
    if ($_SESSION['profilFound']==0){
        $stmt = $db->prepare('INSERT INTO cart (idCustomer, idItem) VALUES ("0", "'.$_POST['id'].'")');
    }
    else{
        $stmt = $db->prepare('INSERT INTO cart (idCustomer, idItem) VALUES ("'.$_SESSION['id'].'", "'.$_POST['id'].'")');
    }
    $stmt->execute();
}

$stmt = $db->prepare('SELECT * FROM item WHERE category LIKE "%cigars%"');
$stmt->execute();
$cigar = $stmt->fetchAll();

echo "<h1>This is our products</h1>";

echo "<div class='content'>";

foreach($cigar as $c):
    
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
        
        echo '<div class="cart"> <button type="submit" id="cart" name="cart"> Cart </div>';
        echo '<input type="hidden" id="id" name="id" value = "'.$c['id'].'"/>';
        echo "</form>";
        
        echo "<p class='quantity'>Quantity : ".$c['quantity']."</p>";

        

     echo "</div>";
    endforeach;

    echo "</div>";
    ?>

</body>
</html>