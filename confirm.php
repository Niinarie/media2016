<?php
session_start();
include('header.php');
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
        
<!--   Page where user can confirm, that their registering-info is correct -->
<?php
$userdata = unserialize($_SESSION['userinfo']);
?>
    <main class="center">
    <header id="indexheader">
    <sub>do create &amp; share</sub> <a class="header" href="index.php">create.it</a>
</header>
    <div id="mainbox">
    <?php
        echo "<p>Your username is:<br/>".$userdata["Username"]."</p>";
        echo "<p>Your email is:<br/>".$userdata["Email"]."</p>";
    ?>
    <p>Is this correct?</p>
    <a href="saveuser.php"><button>Register account</button></a>
    <a href="register.php"><button>Change information</button></a>
        </div>
    </main>
    </body>
</html>