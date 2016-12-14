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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    </head>
    
 
<body id="index">
    
<main class="center">
    
<header id="indexheader">
    <sub>do create &amp; share</sub> <a class="header" href="main.php">create.it</a>
</header>
    

<div id="mainbox">
    

    
<?php

//Checks whether new info is correct and displays error-messages if needed. Otherwise updates the new info to database
if(isset($_POST["submit"])){
    unset($errors);
    $errors = array();
    
    $pid = $_POST['UploadId'];
    $user = $_SESSION['id'];    
   
     if(preg_match("/^[a-öA-Ö0-9-_.,!#@äåöÄÅÖ ]*$/",$_POST['UploadName'])) {
         if(preg_match("/^(?:[0-9a-zA-Z-_.,!#@äåöÄÅÖ ]|\r?\n)+$/",$_POST['Description'])) {
            try {
                $sql = $DBH->prepare("UPDATE a_Upload SET UploadName= ?, Description = ? WHERE Id= ? AND Uploader = ?");
                $sql->execute(array($_POST['UploadName'],$_POST['Description'],$pid,$user));
                array_push($errors,"<br>Changes have been saved.");
                array_push($errors,"<br><a href='postinfo.php?id=".$pid."'><button>Back</button></a>");
                
            }catch(PDOException $e){
                array_push($errors, "There was an error updating information.");
            }
         }else {
             array_push($errors,"Faulty description. Try again.");
         }
    }else {
         array_push($errors,"Faulty title. Try again.");
     }
    
}


?>
    
     
<div>    
    <?php 
    
    
    if(sizeof($errors)>0){
        foreach ($errors as $i => $value) {
            echo($errors[$i]);
        }
    } ?>
</div>
    </div>
   
   
    </main>
<script src="js/menu.js"></script>

    
</body>
</html>