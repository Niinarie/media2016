<?php 
session_start();
include('header.php');
?>
<!DOCTYPE HTML>
<html>
    <head>
    <title>create.it</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    </head>
    
<body id="index">
    
<?php
    
    //redirect user to their profile is they are logged in
if($_SESSION['loggedin']){
     redirect('profile.php?Id='.$_SESSION['id']);
 } 
    
?>
    
<main class="center">
<header id="indexheader">
    <sub>do create &amp; share</sub> <a class="header" href="index.php">create.it</a>
</header>
    

<div id="mainbox">
    <ul class="loginbox">
        <li id="login" class="loginbox_li">Log in</li>
        <li id="loginform">
        <form method="POST" action="login.php">
            <input type="text" name="email" id="email" placeholder="email" required><br/>
            <input type="password" name="pwd" id="pwd" placeholder="password" required><br/>
            <input type="submit" name="login" value="Enter">
        </form>
    </li>


    <li class="loginbox_li"><a href="register.php">Register</a></li>
    </ul>
    
</div>
<sub><a class='ref' href="http://www.freepik.com/layerace" style="color:#fff">background: layerace@freepik</a></sub>
   

    </main>
<script src="js/menu.js"></script>
</body>
</html>