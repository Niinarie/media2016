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
    
 
<body id="index">
    
<!-- User's feed, shows most recent posts from people the user has followed
    
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
    $sql=$DBH->prepare("SELECT * FROM a_Upload WHERE Uploader IN(SELECT Followed FROM a_Follow WHERE Follower = ".$_SESSION['id'].") ORDER BY UploadDate DESC");
    $sql->execute();
        
        
    while($row= $sql->fetch(PDO::FETCH_ASSOC)) {
        
        $pid=$row[Id];
        //finds the amount of likes for the post
        $smt = $DBH->prepare("SELECT COUNT(*) FROM a_Likes where UploadId = ?");
        $smt->execute([$pid]);
        $likes = $smt->fetchColumn();
        
        //finds the amount of comments for the post
        $com= $DBH->prepare("SELECT COUNT(*) FROM a_Comment where UploadID = ?");
        $com->execute([$pid]);
        $comments = $com->fetchColumn();
        
        //finds the poster's info
        $slq = $DBH->prepare("SELECT * FROM a_Users WHERE Id = ?");
        $slq->execute([$row[Uploader]]);
        $uploader = $slq->fetch(PDO::FETCH_OBJ);
    
        
        //checks whether the user has liked the post        
        $smq=$DBH->prepare("SELECT * FROM a_Likes WHERE UploadID=".$pid." and Sender=".$_SESSION['id']."");
        $smq->execute();
              
        echo("<a href='postinfo.php?id=".$row[Id]."' class='feedPost'><article class='profileAndFeedPost'>
        <img src='images/uploads/".$row['Url']."' class='resize'>
        <h3><div class='titleDesc'><div class='feedTitle'>".$row['UploadName']."</div></h3>
        <p><div class='feedInfo'>".$row['Description']."</div></p>
        <p><div class='feedDate'> file uploaded ".$row['UploadDate']."</div></div></p>
        
        <h3><div class='pBox'><a href='profile.php?Id=".$uploader->Id."'><img src='images/uploads/".$uploader->Avatar."' height='60px' width='auto'></a></div></h3>");
        
        //container for likes icon
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