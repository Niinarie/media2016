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
    
<!-- Page for uploading artwork -->
    
<body id="index"> 
    
    
<main class="center">
    <header id="indexheader">
    <sub>do create &amp; share</sub> <a class="header" href="index.php">create.it</a>
    </header>

    
    <div id="mainbox">
    <form action="uploadcheck.php" method="post" enctype="multipart/form-data" id="uploadform">
    <br>Upload your artwork
    <input type="hidden" name="it" value="upload"> 
    <input type="file" name="fileToUpload" id="fileToUpload">
    <br>
        <p id='filesize'>max. file size: 3Mb</p><br>
        <p>Title for your artwork:</p>
    <div class="formsubmit"><input type="text" size="50" name="data[UploadName]" pattern="^(?:[0-9a-zA-Z-_.,!#@äåöÄÅÖ ]|\r?\n)+$" required></div>
    <div class="formsubmit">Write a description:</div>
    <div class="formblockwide"><textarea form="uploadform" name="data[Description]" pattern="^(?:[0-9a-zA-Z-_.,!#@äåöÄÅÖ ]|\r?\n)+$" required></textarea></div>
    <div class="formsubmit"><input type="submit" value="Upload Image" name="submit"></div>
</form>
    </div>
</main>
    
<script src="js/menu.js"></script>
</body>
</html>