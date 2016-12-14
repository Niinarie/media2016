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
    
    
//page for changing user info. Changing avatar or banner redirects user to uploadcheck.php which includes all picture-handling checks
    
$errors = array();
 
if(isset($_POST["submit2"])){
    
    //if username or description is being changed, send form to same page
    unset($errors);
    $errors = array();
    $data = $_POST["data"];

     if(preg_match("/^[a-öA-Ö0-9-_.,!#@äåöÄÅÖ ]*$/",$data['Username'])) {
         if(strlen($data['Username'])<21){
         if(preg_match("/^(?:[0-9a-zA-Z-_.,!#@äåöÄÅÖ ]|\r?\n)+$/",$data['Description']) || $data['Description']=== "") {
             if(strlen($data['Description'])<501){
            try {
                $sql = $DBH->prepare("UPDATE a_Users SET Username= :Username, Description = :Description WHERE Id= ".$_SESSION['id']);
                $sql->execute($data);
                $_SESSION['username'] = $data['Username'];
                $_SESSION['description']= $data['Description'];
                array_push($errors, "Changes have been saved.");
                
            }catch(PDOException $e){
                array_push($errors, "There was an error inserting information.
                Please try again.");
            }
             }else {
                 array_push($errors,"Too long description, max 500 characters.");
             }
         }else {
             array_push($errors,"Faulty description. Check your input and try again.");
         }
         }else {
             array_push($errors,"Too long username, max 20 characters.");
         }
    }else {
         array_push($errors,"Faulty username. Check your input and try again.");
     }
    
}
?>
    
<main class="center">
<header id="indexheader">
    <sub>do create &amp; share</sub> <a class="header" href="index.php">create.it</a>
    </header>
<div id="mainbox">
    
<form action="uploadcheck.php" method="post" enctype="multipart/form-data">
    <div class="formsubmit"><p><img src="images/uploads/<?php echo($_SESSION['avatar']); ?>"></p></div>
    <div class="formsubmit">Upload a new avatar:<br>
        Max. filesize 100kb, 100x100px
    <input type="hidden" name="it" value="avatar"> 
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit"></div>
</form>

<form action="uploadcheck.php" method="post" enctype="multipart/form-data">
    <div class="formsubmit">Upload a new banner:<br>
        Max filesize 1Mb, 1200x450px    
        
    <input type="hidden" name="it" value="banner"> 
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit"></div>
</form>
    
<form action="" method="POST" id="usersettings">
    <div class="formsubmit"><p>Change your username:</p>
    <input type="text" name="data[Username]" size="25" pattern="^[0-9a-zA-Z-_.,!#@äåöÄÅÖ ]+$" value="<?php echo($_SESSION['username']); ?>"></div>
    
    <div class="formsubmit"><p>Change your profile description:</p></div>
    <div class="formblockwide">
    <textarea name="data[Description]" pattern="/^(?:[0-9a-zA-Z-_.,!#@äåöÄÅÖ ]|\r?\n)+$/"><?php echo($_SESSION['description']); ?></textarea></div>
        <p><input type="submit" name="submit2" value="Save changes"><a href='index.php'><button type='button'>Back to profile</button></a>
</form>
    
    
    
<div class="center"><?php 
    if(sizeof($errors)>0){
        foreach ($errors as $i => $value) {
            echo($errors[$i]);
        }
    }?>
<br>

</div>
    
</div>
</main>

<script src="js/menu.js"></script>
</body>
</html>