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
    
<?php // Check if email address already exists

if(isset($_POST["submit"])){
        $data = $_POST["data"];
        $email = $data["Email"];
       
        $check_email = $DBH->prepare('SELECT Email FROM a_Users WHERE Email=:user_email');
        $check_email->bindValue(':user_email', $email, PDO::PARAM_STR);
        $check_email->execute();
        $result = $check_email->rowCount();
        if ($result > 0) {
           echo "<div class='center'>Someone with that email already exists.</div>";         
        } else {
	       $_SESSION['userinfo'] = serialize($data);?>
        <script>window.location.href='confirm.php';</script>
        <?php }
    }
?>
    
<body id="index">

<main class="center">
    <header id="indexheader">
    <sub>do create &amp; share</sub> <a class="header" href="index.php">create.it</a>
    </header>
    
    <div id="mainbox">
    <p id="headertxt">Sign up</p>
    <form id="register" method="POST" action="register.php">
     <?php    
        if(isset($_SESSION["userinfo"])){
            $userinfo = unserialize($_SESSION["userinfo"]); ?>
        <div class="formblock">username</div>
        <div class="formblock"><input type="text" name="data[Username]" value="<?php echo $userinfo["Username"]; ?>" pattern="^[0-9a-zA-Z]+$" required></div>
        <div class="formblock">email</div>
        <div class="formblock"><input type="text" name="data[Email]" id="email" value="<?php echo $userinfo["Email"]; ?>" pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$" required></div>
        <div class="formblock">password</div>
        <div class="formblock"><input type="password" name="data[UPassword]" id="pw1" required></div>
        <div class="formblock">password repeat</div>
        <div class="formblock"><input type="password" name="Upassword_again" id="pw2" required></div>
        <?php
        } else { ?>
        <div class="formblock">username</div>
        <div class="formblock"><input type="text" name="data[Username]" placeholder="no special characters!" pattern="^[0-9a-zA-Z]+$" size="30" required><br/></div>
        <div class="formblock">email</div>
        <div class="formblock"><input type="text" name="data[Email]" id="email" placeholder="name@email.com" pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$" size="30" required></div>
        <div class="formblock">password</div>
        <div class="formblock"><input type="password" name="data[UPassword]" id="pw1" placeholder="type your password" size="30" required></div>
        <div class="formblock">password repeat</div>
        <div class="formblock"><input type="password" name="Upassword_again" id="pw2" placeholder="...and once more" size="30" required></div>
       <?php } ?>
        <div class="formsubmit"><input type="submit" name="submit" value="Register"> </div>
        
    </form>
    <div id="errors"></div>
    </div>
</main>
    
<script src="js/userfunctions.js"></script> 
    
    
</body>
</html>