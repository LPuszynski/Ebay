﻿<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Sell an object</title>
    <link rel="stylesheet" href="sellObject.css">
    <link rel="icon" type="image/png" href="icon.png"/>
</head>
<body>

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
<select name="saleType" class="infos" >
<option value="1">Sell it now</option>
<option value="0">Auctions</option>
<option value="2">Best Offer</option>
<option value="3">Sell it now and Best Offer</option>
</select><br>


    
     <input type="text" class="infos" id="startDate" name="startDate" placeholder="Beggining of the auctions : (YEAR/MONTH/DAY)"><br>
    <input type="text" class="infos" id="startTime" name="startTime"placeholder="Time of the begining : (H/MIN/S)"><br>
     <input type="text" class="infos" id="endDate" name="endDate"placeholder="End of the auctions : (YEAR/MONTH/DAY)"><br>
    <input type="text" class="infos" id="endTime" name="endTime"placeholder="Time of the end : (H/MIN/S)"><br>
   
            


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

    try
    {
    	$db = new PDO('mysql:host=localhost;port=3306;dbname=ebay;', 'root', ''); /* Port de thomas = 3307 / Port de Lois = 3306 */
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }

        if(isset($_POST['submit'])){
            $category =$_POST['Category'];
            $name = $_POST['name'];
            $picture=$_POST['product_picture']; 
            $description = $_POST['description'];
            $price = $_POST['price']; 
            $buyItNow=$_POST['saleType'];


            $records = $db->prepare('INSERT INTO item (name, photos, description, price, category, BuyNow) VALUES ("'.$name.'", "'.$picture.'", "'.$description.'", "'.$price.'", "'.$category.'","'.$buyItNow.'")');
            $records->execute();

             /*echo ' Category :' .$category. '/ name :' .$name. '/ photo: '.$picture.' / Description: '.$description.'/ Price: '.$price;*/
              $startdate =$_POST['startDate'];
              $endDate = $_POST['endDate'];
              $startTime =$_POST['startTime'];
              $endTime = $_POST['endTime'];
        }
    ?>
</body>
</html>