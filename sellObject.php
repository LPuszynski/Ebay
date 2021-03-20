<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Sell an object</title>
    <link rel="stylesheet" href="index.css">
    <link rel="icon" type="image/png" href="icon.png"/>
</head>
<body>

</div id="SellObject">
<div id="Sell_title">
 Sell and object : 
</div>

<form action="" method="post">
<div id="form_SellObject">
<select name="Category">
<option value="Cigars">Cigars</option>
<option value="Accessories">Accessories </option>
</select><br><br>
Name of the product : <input type="text" id="name" name="name"><br>
Description of the product : <input type="name" id="description" name="description"><br>
Picture of the product :  <br>
Price of the product : <input type="text" id="price" name="price"><br>

</div>
 <input type="submit" name="submit" value="SUBMIT">
</div>
<form>


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
        if(isset($_POST['submit'])){
            $name = $_POST['name'];
            
            $price = $_POST['address'];
            $total = $_POST['total'];
           
        }
    ?>
</body>
</html>