<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Sell an object</title>
    <link rel="stylesheet" href="sellObject.css">
    <link rel="icon" type="image/png" href="icon.png"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    

</head>
<body>
<script>
    function showAuctions(){
    document.getElementById('AAA').style.display="block";
    
    }
    function hideAuctions(){
    document.getElementById('AAA').style.display="none";
    
    }

    </script>
<div id="tlois">
	 &emsp;CIGAR SHOP SINCE 1955 

</div>	


<div id="title"> 
	Cigar Shop
</div>

<section>
<div class="wrapper">
    <ul>
	<li><a href="index.php">Home</li>
<li> Categories
            <ul>
<li><a href="cigars.php">Cigars</a></li>
<li><a href="">Accessories</li></li>
</ul><li> <a href="sellObject.php">Sell </a></li>
<li><a href="">Your account </a></li></ul>
<a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
</div><br><br>

<form action="" method="post">
<div id="Register_form">

<h3>SELL AN ITEM</h3>

<select name="Category" class="infos">
<option value="Cigars" >Cigars</option>
<option value="Accessories">Accessories </option>
</select><br>

 <input type="text" class="infos" id="name" name="name" placeholder="Name of the product :"><br>
 <input type="name"  class="infos" id="description" name="description" placeholder="Description of the product" ><br>
Picture of the product : <input type="file" id="product_picture" name="product_picture"placeholder="Name of the product "> <br>
<input type="text" class="infos" id="price" name="price"placeholder="Price of the product (£)"><br>

<!--
<select name="saleType" class="infos" >
<option value="1" id='Sell'>Sell it now</option>
<option value="0" id='Auctions' onclick='showAuctions()'>Auctions</option>
<option value="2" id='Best_offers'>Best Offer</option>
<option value="3" id='sell&Offer'>Sell it now and Best Offer</option>
</select><br>-->

<input type="radio" name="saleType" id="Sell" onclick="hideAuctions()" value="1">
<label for="saletype">Sell it now</label>
<input type="radio" name="saleType" id="Auctions" onclick="showAuctions()" value="0">
<label for="saletype">Auctions</label>
<input type="radio" name="saleType" id="Best_offers" onclick="hideAuctions()" value="2">
<label for="saletype">Best offers</label>
<input type="radio" name="saleType" id="sell&Offer" onclick="hideAuctions()" value="3">
<label for="saletype">Sell it now and Best Offers</label>

    <div id='AAA'>
     <input type="text" class="infos" id="startDate" name="startDate" placeholder="Beginning : (YEAR/MONTH/DAY)"><br>
    <input type="text" class="infos" id="startTime" name="startTime"placeholder="Beginning : (H:MIN)"><br>
     <input type="text" class="infos" id="endDate" name="endDate"placeholder="End : (YEAR/MONTH/DAY)"><br>
    <input type="text" class="infos" id="endTime" name="endTime"placeholder="End : (H:MIN)"><br>
   </div>
            


 <input type = "submit" class="bouton"  value = "SUBMIT" name = "submit"/>

 </div>
<form></section>


<br><br>
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


<?php

    session_start();

    try
    {
    	$db = new PDO('mysql:host=localhost;port=3306;dbname=ebay;', 'root', ''); /* Port de thomas = 3307 / Port de Lois = 3306 */
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }

        if(isset($_POST['submit'])){ //we get all information that we need on the object we want to sell
            $category =$_POST['Category'];
            $name = $_POST['name'];
            $picture=$_POST['product_picture']; 
            $description = $_POST['description'];
            $price = $_POST['price']; 
            $buyItNow = $_POST['saleType'];
            $timeStart = $_POST['startTime'];
            $timeEnd = $_POST['endTime'];
            $dateStart = $_POST['startDate'];
            $dateEnd = $_POST['endDate'];
            //we put them on the database
            $records = $db->prepare('INSERT INTO item (name, photos, description, price, category, BuyNow, idseller) VALUES ("'.$name.'", "'.$picture.'", "'.$description.'", "'.$price.'", "'.$category.'","'.$buyItNow.'", "'.$_SESSION['id'].'")');
            $records->execute();

            if ($buyItNow == 0){      //if the type of the sell is by Auction
                $stmt = $db->prepare('SELECT * FROM item WHERE idseller="'.$_SESSION['id'].'"');
                $stmt->execute();
                $items = $stmt->fetchAll();


                $array = array();
                foreach($items as $item):
                    $array[] = $item['id'];
                endforeach;
                echo end($array);  // id of the object that the seller just enter

                //we set an auction on the auctions table
                $records = $db->prepare('INSERT INTO auctions (id_seller, price1, id_item, timeStart, timeEnd, dateStart, dateEnd) VALUES ("'.$_SESSION['id'].'", "'.$_POST['price'].'", "'.end($array).'", "'.$timeStart.'", "'.$timeEnd.'","'.$dateStart.'", "'.$dateEnd.'")');
                $records->execute();

            }
        }
    ?>

       

</body>
</html>