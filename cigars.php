﻿<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="products.css">
    <title>Cigars to buy</title>
     <link rel="icon" type="image/png" href="icon.png"/>
</head>
<body>
<?php 

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

    $stmt = $db->prepare('SELECT * FROM item WHERE category LIKE "%cigars%"');
	$stmt->execute();
	$cigar = $stmt->fetchAll();

    echo "<h1>This is our products</h1>";

    echo "<div class='content'>";


    foreach($cigar as $c):

     echo "<div class='product'>";

    echo "<h3>".$c['name']."</h3>";
    echo "<img src=Cigars_pictures/".$c['photos']." width='150px' >";
    // echo $c['photos'] = substr($c['photos'],36); // thomas enleve cette ligne si pour toi ça bug

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

    echo "</div>";
    ?>

</body>
</html>