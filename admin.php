<!DOCTYPE html>
<html>
<head>
<link rel="icon" type="image/png" href="icon.png"/>
<link rel="stylesheet" href="admin.css">


	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<title>Admin Page</title>
</head>
<body>


<?php 
session_start();

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


$stmt = $db->prepare('SELECT * FROM seller');
$stmt->execute();
$sellers = $stmt->fetchAll();

foreach($sellers as $seller):
    
    echo "<div class='product'>";
    
     echo $seller['firstname'];
     echo $seller['lastname'];
     //echo "<button type='submit' value='Delete Seller' id='".$seller['
     echo '<a href="admin.php?delete='.$seller["id"].'">Delete this seller </a>';
        

     echo "</div>";
    endforeach;

    if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    	$idSeller=$_GET['delete'];

        // $stmt = $db->prepare('DELETE FROM item WHERE idSeller ='.$idSeller.'');
        // $stmt->execute();

        $stmt = $db->prepare('DELETE FROM seller WHERE id ='.$idSeller.'');
        $stmt->execute();
    }

    ?>


 
</body>
</html>