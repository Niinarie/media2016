<?php
session_start();
include('header.php');
include('password/lib/password.php');
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
        
        
        <div class='profileAndFeedPost'>
        <div class="centerSearch">    
        <div id="searchH"><h2>Search results:</h2></div>
            
        <form action='search.php' method='POST'>
            <input type='text' name='search'>
            <button type='submit' name='submit'>Search</button>
        </form>
            </div>
        
        <?php
            
        if (isset($_POST["search"]) && !empty($_POST["search"])) {
        $search = htmlspecialchars($_POST['search']);
        echo("<div id='searchResults'><br>Your search '<b>".$search."</b>' brought the following results:<br><br></div>");
            
            //try the searched word against database entries using fulltext-search
        try{
            $sql=$DBH->prepare("SELECT UploadName, Url, a_Upload.Id as upId, a_Upload.Description as upDesc, Username FROM a_Upload JOIN a_Users ON a_Upload.Uploader=a_Users.Id WHERE MATCH(a_Upload.UploadName,a_Upload.Description) AGAINST ('*$search*' IN BOOLEAN MODE)");
            $sql->execute();
            
            echo('<div id="searchRstAll">');
            
            if($result->rowCount()>0){ //still missing the echo if no results were found, but for some reason rowCount bugged for us all the time
            
            while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                
                echo('<div class="searchRst">');
                
                echo('<a href="postinfo.php?id='.$row['upId'].'"><div class="cropBox"><img src="images/uploads/'.$row['Url'].'" class="resize"></div>');
                echo("<p id='uname'>".$row['Username']."</p>");
                echo("<p id='upname'>".$row['UploadName']."</p>");
                echo("<p>".$row['UpDesc']."</p>");
                
                echo('</a></div>');
            }
            echo('</div>');
                
            }else{
                echo("No results.");
            }
        }catch(PDOException $e){
            echo("Error performing search.");
        }
        }
        
            
        ?>
            
         </div>
    </main>    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>


<script src="js/menu.js"></script>
    </body>
</html>