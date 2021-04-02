<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="message.css">
    <title>MailBox</title>
</head>
<body>

<?php
    session_start();

    //connection cith the db
    try
    {
        
        $db = new PDO('mysql:host=localhost;port=3306;dbname=ebay;', 'root', ''); /* Port de thomas = 3307 / Port de Lois = 3306 */
        /*$db = new PDO('mysql:host=localhost;port=3306;dbname=ebay;', 'root', '');*/ /* Port de thomas = 3307 / Port de Lois = 3306 */
        
        
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }


    if($_SESSION['profilFound']==1){  //the user is a customer
        if (isset($_POST['accept'])){
            $stmt = $db->prepare('UPDATE bestoffer SET state = "3" WHERE id="'.$_POST['idBestOffer'].'"');
            $stmt->execute();
        }
        if (isset($_POST['pay'])){
            $stmt = $db->prepare('SELECT * FROM bestoffer WHERE id="'.$_POST['idBestOffer'].'"');
                $stmt->execute();
                $users = $stmt->fetchAll();
                foreach($users as $user):
                    $_SESSION['idItemBestOffer'] = $user['id_item'];
                    $_SESSION['idsellerbestoffer'] = $user['id_seller'];
                    $_SESSION['pricebestoffer'] = $user['price'];
                    $stmt1 = $db->prepare('UPDATE item SET price = "'.$_SESSION['pricebestoffer'].'" WHERE id="'.$_POST['idItemBestOffer'].'"');
                    $stmt1->execute();
                endforeach;
            $_SESSION['payBestOffer']=1;
            $stmt = $db->prepare('UPDATE bestoffer SET state = "6" WHERE id="'.$_POST['idBestOffer'].'"');
            $stmt->execute();
            header("Location: http://localhost/GitHub/Ebay/buyingConfirmation.php"); /* Redirection du navigateur */
        }
        if (isset($_POST['payAuction'])){
            //echo $_POST['idItemAuction'];
            //echo $_POST['idAuction'];

            $stmt = $db->prepare('SELECT * FROM auctions WHERE id="'.$_POST['idAuction'].'"');
                $stmt->execute();
                $users = $stmt->fetchAll();
                foreach($users as $user):
                    $_SESSION['idsellerauction'] = $user['id_seller'];
                endforeach;
            $_SESSION['idItemAuction'] = $_POST['idItemAuction'];

            $_SESSION['payBestOffer']=2;


            header("Location: http://localhost/GitHub/Ebay/buyingConfirmation.php"); /* Redirection du navigateur */
        }
        if (isset($_POST['decline'])){
            $records = $db->prepare('DELETE FROM bestoffer WHERE id="'.$_POST['idBestOffer'].'"');
            $records->execute();
        }
        if (isset($_POST['proposition'])){
            if($_POST['amount']!=''){
                $stmt = $db->prepare('UPDATE bestoffer SET state = "1" WHERE id="'.$_POST['idBestOffer'].'"');
                $stmt->execute();
                $stmt = $db->prepare('UPDATE bestoffer SET price = "'.$_POST['amount'].'" WHERE id="'.$_POST['idBestOffer'].'"');
                $stmt->execute();
                $stmt = $db->prepare('SELECT * FROM bestoffer WHERE id_customer="'.$_SESSION['id'].'"');
                $stmt->execute();
                $users = $stmt->fetchAll();
                foreach($users as $user):
                    $count = $user['count']+1;
                endforeach;
                $stmt = $db->prepare('UPDATE bestoffer SET count = "'.$count.'" WHERE id="'.$_POST['idBestOffer'].'"');
                $stmt->execute();
            }
        }
        echo "<div class='box'>";
        $stmt = $db->prepare('SELECT * FROM auctions WHERE id_buyer="'.$_SESSION['id'].'" AND end="1"');  // toutes les auctions finit et gagnées par le customer
        $stmt->execute();
        $users = $stmt->fetchAll();
        foreach($users as $user):
            
                $stmt2 = $db->prepare('SELECT * FROM item WHERE id="'.$user['id_item'].'"');
                $stmt2->execute();
                $cigar = $stmt2->fetchAll();

                
                
                foreach($cigar as $c):
                    echo "<div class='message'>";
                    
                    echo "<div class='product'>";
                    
                    echo "<h3>".$c['name']."</h3>";
                    
                    
                    echo $c['photos'] = substr($c['photos'],36); // thomas enleve cette ligne si pour toi ça bug
                    echo "<img src=Cigars_pictures/".$c['photos']." class='images'>";
                    
                    
                    echo "<p class='description'>".$c['description']."</p>";
                    echo "<p class='price'>Price : £".$c['price']."</p>";
                    echo "<form action = '' method = 'POST'>";
                    echo '<input type="hidden" name="idAuction" value = "'.$user['id'].'"/>';
                    echo '<input type="hidden" name="idItemAuction" value = "'.$c['id'].'"/>';
                    
                    echo '</div>';
                endforeach;
                echo "<div class='proposition'>";
                echo '<br>';
                echo '<br>';
                echo 'you won a auction : ';
                echo '<br>';
                echo '<br>';
                echo '<br>';
                echo $user['price1'].'$';
                echo '<br>';
                echo '<br>';
                echo '<br>';
                
                echo "<button type='submit' name='payAuction'>Pay</button>";
                
                echo '</form>';
                echo '</div>';
                echo '</div>';
        endforeach;
        $stmt = $db->prepare('SELECT * FROM bestoffer WHERE id_customer="'.$_SESSION['id'].'"');
        $stmt->execute();
        $users = $stmt->fetchAll();
        foreach($users as $user):
            if($user['state']==2 || $user['state']==4 || $user['state']==3){ 
                $stmt2 = $db->prepare('SELECT * FROM item WHERE id="'.$user['id_item'].'"');
                $stmt2->execute();
                $cigar = $stmt2->fetchAll();

                
                
                foreach($cigar as $c):
                    echo "<div class='message'>";
                    
                    echo "<div class='product'>";
                    
                    echo "<h3>".$c['name']."</h3>";
                    
                    
                    echo $c['photos'] = substr($c['photos'],36); // thomas enleve cette ligne si pour toi ça bug
                    echo "<img src=Cigars_pictures/".$c['photos']." class='images'>";
                    
                    
                    echo "<p class='description'>".$c['description']."</p>";
                    echo "<p class='price'>Price : £".$c['price']."</p>";
                    echo "<form action = '' method = 'POST'>";
                    echo '<input type="hidden" name="idBestOffer" value = "'.$user['id'].'"/>';
                    echo '<input type="hidden" name="idItemBestOffer" value = "'.$c['id'].'"/>';
                    
                    echo '</div>';
                endforeach;
                echo "<div class='proposition'>";
                echo '<br>';
                echo '<br>';
                if($user['state']==4){
                    echo 'Le vendeur vous a accepté votre offre :';
                }
                elseif($user['state']==2){
                    echo 'Le vendeur vous a fait une contre-offre :';
                }
                else{
                    echo 'Offre acceptée, veuillez procéder au paiement :';
                }
                echo '<br>';
                echo '<br>';
                echo '<br>';
                echo $user['price'].'$';
                echo '<br>';
                echo '<br>';
                echo '<br>';
                if ($user['count']<4 && $user['state']==2){
                    echo "<input type ='number' name='amount' placeholder='Enter your proposition'>";
                }
                echo '<br>';
                echo '<br>';
                if($user['state']==4 || $user['state']==3){
                    echo "<button type='submit' name='pay'>Pay</button>";
                }
                else{
                    if ($user['count']<4){
                        echo "<button type='submit' name='proposition'>Make an other offer</button>";
                    }
                    else{
                        echo "<button type='submit' name='decline'>Decline (you will not be able to do an other proposition)</button>";
                    }
                    echo '<br>';
                    echo "<button type='submit' name='accept'>Accept</button>";
                }
                echo '</form>';
                echo '</div>';
                echo '</div>';
            }
        endforeach;
        echo '</div>';
    }
    elseif($_SESSION['profilFound']==2){  //the user is a seller
        if (isset($_POST['accept'])){
            $stmt = $db->prepare('UPDATE bestoffer SET state = "4" WHERE id="'.$_POST['idBestOffer'].'"');
            $stmt->execute();
        }
        if (isset($_POST['proposition'])){
            if($_POST['amount']!=''){
                $stmt = $db->prepare('UPDATE bestoffer SET state = "2" WHERE id="'.$_POST['idBestOffer'].'"');
                $stmt->execute();
                $stmt = $db->prepare('UPDATE bestoffer SET price = "'.$_POST['amount'].'" WHERE id="'.$_POST['idBestOffer'].'"');
                $stmt->execute();
            }
        }
        $stmt = $db->prepare('SELECT * FROM bestoffer WHERE id_seller="'.$_SESSION['id'].'"');
        $stmt->execute();
        $users = $stmt->fetchAll();
        echo "<div class='box'>";
        foreach($users as $user):
            if($user['state']==1){ 
                $stmt2 = $db->prepare('SELECT * FROM item WHERE id="'.$user['id_item'].'"');
                $stmt2->execute();
                $cigar = $stmt2->fetchAll();

                
                
                foreach($cigar as $c):
                    echo "<div class='message'>";
                    
                    echo "<div class='product'>";
                    
                    echo "<h3>".$c['name']."</h3>";
                    
                    
                    echo $c['photos'] = substr($c['photos'],36); // thomas enleve cette ligne si pour toi ça bug
                    echo "<img src=Cigars_pictures/".$c['photos']." class='images'>";
                    
                    
                    echo "<p class='description'>".$c['description']."</p>";
                    echo "<p class='price'>Price : £".$c['price']."</p>";
                    echo "<form action = '' method = 'POST'>";
                    echo '<input type="hidden" name="idBestOffer" value = "'.$user['id'].'"/>';
                    

                    
                    echo '</div>';
                endforeach;
                echo "<div class='proposition'>";
                echo '<br>';
                echo '<br>';
                echo 'Un acheteur a fait une offre pour votre produit :';
                echo '<br>';
                echo '<br>';
                echo '<br>';
                echo $user['price'].'$';
                echo '<br>';
                echo '<br>';
                echo '<br>';
                echo "<input type ='number' name='amount' placeholder='Enter your proposition'>";
                echo '<br>';
                echo '<br>';
                echo "<button type='submit' name='proposition'>Make an other offer</button>";
                echo '<br>';
                echo "<button type='submit' name='accept'>Accept</button>";
                echo '</form>';
                echo '</div>';
                echo '</div>';
            }
        endforeach;
        echo '</div>';
    }

?>




</body>
</html>