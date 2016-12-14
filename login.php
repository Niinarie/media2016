<?php
session_start();
include('header.php');
include('config/userphp.php');
?>
<!DOCTYPE HTML>
<html>
    <head>
    <title>create.it</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    
    <body id="index">
    
    <main class="center">
        <header id="indexheader">
        <sub>do create &amp; share</sub> <a class="header" href="index.php">create.it</a>
        </header>
        
    <div id="mainbox">
    <?php 
        
        //Check if user has entered the page after typing in login information elsewhere, like index.php
    if(isset($_POST['login'])){ 
        //if juser was found from database with the entered info, lets user proceed to their feed
        if(login($_POST['email'],$_POST['pwd'],$DBH)){
            echo("<br> Welcome, ".$_SESSION['username']."!");
            echo("<br><a href='main.php'><button>continue</button></a>");
        };
        
        
    }
    ?>    
    
    </div>
    </main>
    
    </body>
</html>