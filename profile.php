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
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway|Roboto+Slab" rel="stylesheet">

</head>
    

    
    
<body id="index">
    

    
   
    
    <!-- INCLUDE FEED -->
    <main id="feed">    
        
    <?php include('navmenu.php'); ?>
  <?php include('profilefeed.php'); ?>
    </main>
    


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="js/menu.js"></script>

    
</body>
</html>