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
        <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway|Roboto+Slab" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    </head>
    
 <!-- Page for 'Discover', aka everyone's posts. Shows every post every user has uploaded. For detailed comments check main.php as the look of the page is quite same -->
<body id="index">
    

       <?php
if(!($_SESSION['loggedin'])){
     redirect('index.php');
 } 
    
?>
    
    
    <!-- INCLUDE FEED -->
    <main id="feed">    
        
     <?php include('navmenu.php'); ?>
 
    <?php 

        
    try {
    $sql=$DBH->prepare("SELECT * FROM a_Upload ORDER BY UploadDate DESC LIMIT 30");
    $sql->execute();
        
        
    while($row= $sql->fetch(PDO::FETCH_ASSOC)) {
        $smt = $DBH->prepare("SELECT COUNT(*) FROM a_Likes where UploadId = ?");
        $smt->execute([$row[Id]]);
        $likes = $smt->fetchColumn();
        
        $com= $DBH->prepare("SELECT COUNT(*) FROM a_Comment where UploadID = ?");
        $com->execute([$row[Id]]);
        $comments = $com->fetchColumn();
        
        
        $slq = $DBH->prepare("SELECT * FROM a_Users WHERE Id = ?");
        $slq->execute([$row[Uploader]]);
        $uploader = $slq->fetch(PDO::FETCH_OBJ);
    
        $pid=$row[Id];
        $smq=$DBH->prepare("SELECT * FROM a_Likes WHERE UploadID=".$pid." and Sender=".$_SESSION['id']."");
        $smq->execute();
              
        echo("<a href='postinfo.php?id=".$row[Id]."' class='feedPost'><article class='profileAndFeedPost'>
        <img src='images/uploads/".$row['Url']."' class='resize'>
        
        <h3><div class='titleDesc'><div class='feedTitle'>".$row['UploadName']."</div></h3>
        <p><div class='feedInfo'>".$row['Description']."</div></p>
        <p><div class='feedDate'> file uploaded ".$row['UploadDate']."</div></p>
        
        <h3><div class='pBox'><a href='profile.php?Id=".$uploader->Id."'><img src='images/uploads/".$uploader->Avatar."' height='60px' width='auto'></a></div></h3>");
        
        //containder for likes icon
        echo('<div class="likeComCenter">');
        if($smq->rowCount()===1){
            echo ('<a href="#" class="like" id="'.$pid.'" title="Unlike" onclick="return false" value="'.$likes.'"><div class="likeComContainer"><img src="images/liked2.png">');
        }else{ 
            echo ('<a href="#" class="like" id="'.$pid.'" title="Like" onclick="return false" value="'.$likes.'"><div class="likeComContainer"><img src="images/liked.png"> ');
        };
        echo('<p class="likeComContainerText likes">'.$likes.'</a></p>');
        echo('</div>');
        
        //container for comments icon
        echo('<div class="likeComContainer">');
        echo("<img src='images/comments.png'>");
        echo('<p class="likeComContainerText">'.$comments.'</p>
        </div></div>');
        
        
        
            
        echo("</article></a>");            
        }
        
    }catch(PDOException $e){
        echo("Error fetching feed.");
    }
        
    ?>
        
    </main>
    

    

<script src="js/menu.js"></script>

    
</body>
</html>