<?php

//force user to login
if($username=='' || $username==null){
    // echo "<script>alert('!No session value please login');</script>";
    // header("Location: ../../index.php");
    header("Location: /templates/401.php");
    exit;
}
    
?>
