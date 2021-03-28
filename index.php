<!DOCTYPE html>
<html>
<html lang="en">
<head>
<link rel="icon" type="image/png" href="icon.png"/>
<link rel="stylesheet" href="index.css">	
<script src="https://kit.fontawesome.com/3581d4e558.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="index.js"></script>
<title>Cigar shop</title>
    



</head>
<body>

<!--
<div class="wrapper">
    <ul>

<li> Category
            <ul>
<li><a href="cigars.php">Cigars</a></li>
<li><a href="">Accessories</li></li>
</ul><li> <a href="sellObject.php">Sell </a></li>
<li><a href="">Your account </a></li>
</div>
-->




<div id="tlois">
	 &emsp;CIGAR SHOP SINCE 1955 &emsp; &emsp; &emsp;&emsp; &emsp;&emsp; &emsp;&emsp; &emsp; &emsp; &emsp; &emsp; &emsp; 
	 <a href="register.php">REGISTER</a> &emsp; &emsp;
	 <a href="sellerRegister.php">BECOME A SELLER</a>
	 &emsp; &emsp; &emsp;&emsp; &emsp;  &emsp; &emsp; &emsp;&emsp;&emsp;&emsp; &emsp; &emsp;&emsp; &emsp;
	 <a href="login.php">LOGIN</a>  &emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;&emsp; &emsp; &emsp;
	<a href="" class="admin" > <i class="fas fa-user-cog"></i> </a>
</div>	


<div id="title"> 
	Cigar Shop
</div>

<!--  TEST TA CAPTE
<div id="Categories">
&emsp;<a href="cigars.php">Buy</a>    &emsp;     
     &emsp;  
<a href="sellObject.php">Sell </a>    &emsp; &emsp; &emsp; &emsp; &emsp; 

<a href="financing.html"><img src="basket.png " height="20" width="20" ></a>   

<a href="financing.html"><img src="basket.png " height="20" width="20" ></a> 
</div>
-->




<div class="wrapper">
    <ul>
	<li><a href="index.php">Home</li>
<li> Categories
            <ul>
<li><a href="cigars.php">Cigars</a></li>
<li><a href="">Accessories</li></li>
</ul><li> <a href="sellObject.php">Sell </a></li>
<li><a href="yourAccount">Your account </a></li></ul>
<?php
session_start();	
if($_SESSION['profilFound']!=0){
	echo '&emsp; &emsp;&emsp;&emsp;&emsp; &emsp;&emsp; &emsp; &emsp;'.$_SESSION['firstname'].'&emsp; &emsp;'.$_SESSION['lastname'];
}
?>
<a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
</div>




<div id="Carousel">
	
	 <img src="cigares1.jpg" class="images" id="cigare">
    <button id="previous">Previous</button>
    <button id="next">Next</button>
	</div>

<div id="cba">
<div id="abc">
Our online store offers a wide selection of premium cigars from Cuba, Dominican Republic, Nicaragua and Honduras. <br><br>

<br>Our team of enthusiasts travels every year to the countries of production in order to perfect their knowledge, define trends, <br>produce new ranges of house-branded cigars, and develop private labels for their various prestigious clients.

<br><br><br>Our online store distinguishes itself from its competitors by its unique relationship with the exclusive (Swiss) importers <br> of the cigar brands you buy every day. We do not buy any cigars on the parallel market! Therefore, we ensure 100% traceability and certification <br>of the cigars we offer for sale to our customers worldwide.

<br><br><br>CigarShop.com belongs to a Swiss family group active in the cigar business for more than 40 years.

<br><br><br>Our prices are the most competitive of the market for a 100% certified quality of the official import Habanos - Intertabak AG <br>the only Official Importer of Cuban cigars for Switzerland, Davidoff - Oettinger Group AG for the Dominican cigars of <br>this Basel family group, A. Fuente, for the cigars of the Fuente brand with which we have maintained friendly and commercial relations for more than 25 years, <br>and likewise for all the brands of cigars imported in Switzerland via their authorized and certified importers.

<br><br><br>Cigar Shop, your trusted partner for the online purchase of premium cigars.

<br><br><br>Your Cigar Shop Team
</div>
</div>

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


 </body>
</html>