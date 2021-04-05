<!DOCTYPE html>
<html>
<html lang="en">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>


<?php
    session_start();
    $_SESSION['profilFound']=0; // we just set this variable to 0
    $_SESSION['id']=0; // and the id go back to 0 because a guest has no id so we consider his id as 0
    header('Location: http://localhost/GitHub/Ebay/index.php'); // browser redirection
?>

 </body>
</html>
