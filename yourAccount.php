<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="yourAccount.css">
    <title>Your Account</title>

     <script type="text/javascript">

    </script>
</head>

<body>

<?php 
    session_start();


    //connection cith the db
    try{
	$db = new PDO('mysql:host=localhost;port=3306;dbname=ebay;', 'root', ''); /* Port de thomas = 3307 / Port de Lois = 3306 */
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
        echo '<h2> Your history </h2>';
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
        
        
        echo $c['photos'] = substr($c['photos'],36); // thomas enleve cette ligne si pour toi ça bug
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
        echo '<h2> Your history </h2>';
        
        
        
        echo "<div class='content'>";
    $stmt2 = $db->prepare('SELECT * FROM item WHERE idseller="'.$_SESSION['id'].'"');
    $stmt2->execute();
    $cigar = $stmt2->fetchAll();
    foreach($cigar as $c): // we display all items the seller has sold or is selling
        
        echo "<div class='product'>";
        
        echo "<h3>".$c['name']."</h3>";
        
        
        echo $c['photos'] = substr($c['photos'],36); // thomas enleve cette ligne si pour toi ça bug
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

</body>
</html>