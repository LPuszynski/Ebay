<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="products.css">
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

    $stmt = $db->prepare('SELECT * FROM item WHERE category LIKE "%cigars%"');
	$stmt->execute();
	$cigar = $stmt->fetchAll();

    
    ?>

</body>
</html>