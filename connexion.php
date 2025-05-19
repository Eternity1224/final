<?php
    define('HOST','localhost');
    define('BDD','tp-php');  
    define('username','root');
    define('password','');

    $connexion = mysqli_connect(HOST,username,password,BDD) or die('Erreur de connexion de la base donnée');
?>