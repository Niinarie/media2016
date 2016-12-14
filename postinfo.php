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
        <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>
    
<body id="index">
    
    <?php include('navmenu.php'); ?>
    
<main id="feed">
    
<?php

 //page for viewing detailed data about artwork   
    
$id=htmlspecialchars($_GET["id"]);

    try{    
        $postinfo = array();
        $sql=$DBH->prepare("SELECT a_Upload.Id as uId,Pageview,  Url,Username,a_Users.Id as usId,Avatar,UploadName,a_Upload.Description,UploadDate,Uploader, COUNT(*) as Count FROM a_Upload JOIN a_Users ON a_Upload.Uploader=a_Users.Id JOIN a_Likes ON a_Upload.Id=a_Likes.UploadID WHERE a_Upload.Id= ?");
        $sql->execute([$id]);
        
        $postinfo = $sql->fetch(PDO::FETCH_OBJ);
        
         $pgv =$DBH->prepare("UPDATE a_Upload SET Pageview = Pageview +1 WHERE Id = ?");
        $pgv->execute([$id]);
        

    }catch(PDOException $e){
        return false;
    }

        $pid=$postinfo->uId;
        
        

        echo("<article class='profileAndFeedPost'>
        <img src='images/uploads/".$postinfo->Url."' class='resize'>
        
        <div id='postinfoN'><h3>".$postinfo->UploadName."</h3></div>
        
        <div id='postinfoP'><a href='profile.php?Id=".$postinfo->usId."'><img src='images/uploads/".$postinfo->Avatar."' class='profilepic2' height='50px'></a></div>
        
        
        <div id='postinfoD'><h3>".nl2br($postinfo->Description)."</h3></div></div>");
    
        echo("<div id='postinfoDT'><h3>file uploaded ".$postinfo->UploadDate." by <a class='uploader' href='profile.php?Id=".$postinfo->usId."'>".$postinfo->Username."</h3></a></div>");
    
    echo('<div class="likeComCenter2">');
        echo("<div id='postinfoViews'><h3>".$postinfo->Pageview." views</h3></div>");
        if($_SESSION['loggedin']){
        $smq=$DBH->prepare("SELECT * FROM a_Likes WHERE UploadID=".$pid." and Sender=".$_SESSION['id']."");
        $smq->execute();
         if($smq->rowCount()===1){
            echo ('<a href="#" class="like" id="'.$pid.'" title="Unlike" onclick="return false" value="'.$postinfo->Count.'"><div class="likeComContainer2"><img src="images/liked2.png">');
        }else{ 
             if($postinfo->usId!==$_SESSION['id']){
            echo ('<a href="#" class="like" id="'.$pid.'" title="Like" onclick="return false" value="'.$postinfo->Count.'"><div class="likeComContainer2"><img src="images/liked.png"> ');
             }else{
                 echo('<div class="likeComContainer2"><img src="images/liked2.png">');
             }
        };           
        }
        echo("<p class='likeComContainerText2 likes'>".$postinfo->Count."</a></p>");
        echo('</div></div>');
        
        if($_SESSION['id'] === $postinfo->Uploader || $_SESSION['isadmin']){
           
            echo("<div id='deledit'><button id='delete'>Delete</button>");
            echo("<button id='edit'>Edit</button></div>");
            
            echo("<div id='deletebox'>
            Do you really want to delete this upload?<br>
            <button id='deletepostbutton' value=".$pid." name=".$postinfo->usId.">Delete upload</button>
            <button id='dontdelete'>Don't delete</button></div>
            
            <div id='editbox'>
            <form action='action_editpost.php' method='POST'>
            <p>New title:  
            <input type='text' name='UploadName' value=".$postinfo->UploadName.">
            <input type='hidden' name='UploadId' value=".$pid."></p>
            <p>New description:
            <textarea id= 'desc' name='Description' rows='4' cols='50'>".$postinfo->Description."
            </textarea></p>
            <input type='submit' name='submit' value='Save changes'>
            </form>
            </div>"); 
             
          
        }
    

        echo("</article>");  ?>
    
        <div id="commentBox" class='profileAndFeedPost'>
        <form id="commentForm" method="post"> 
            
       <?php 
                
            if($_SESSION['loggedin']) {
                /*echo ("<div class='commentAvatar'>
                <img src='images/uploads/".$_SESSION['avatar']."'></a>
                </div>"); */
                $commenter = $_SESSION['id'];
                $commentername = $_SESSION['username'];
            
            } else {
                /* echo ("<div class='commentAvatar'>
                <img src='images/uploads/default.jpg'></a>
                </div>"); */
                $commenter = 6;
                $commentername = "Visitor";
            }
            
        echo("<div id='commentName'>Write a comment:<br></div>");    
        ?> 
        <input type="hidden" id="postId" value="<?php echo($pid); ?>">
        <input type="hidden" name="UploadID" value="<?php echo($id); ?>">
        <input type="hidden" name="Sender" value="<?php echo($commenter); ?>">
        <textarea name="Content" id="body" cols="50" rows="3" placeholder="max. 500 characters"></textarea><br>
        <input type="submit" id="submitComment" value="submit comment"/>            

        </form>
    </div>
    
    <div id="comments">
    
        <?php
        $com = $DBH->prepare("SELECT UploadID,a_Comment.Id as cId,Avatar,Username,CommentDate,Content,Sender FROM a_Comment JOIN a_Users ON Sender=a_Users.Id WHERE UploadID = ? ORDER BY CommentDate DESC");
        $com->execute([$id]);
        
        while($row = $com->fetch(PDO::FETCH_ASSOC)){
            echo('<div class="profileAndFeedPost">');
            echo('<div id="commentPBox"><a href="profile.php?Id='.$row['Sender'].'"><img id="commentP" src="images/uploads/'.$row['Avatar'].'" height="40px" width="auto"></a><br>');  
            echo("<div id='commentU'><b>".$row['Username']."</b></div>");  
            echo("<div id='commentD'>comment written ".$row['CommentDate']."</div></div><br>");  
            echo("<div id='comment'>".nl2br($row['Content'])."</div>");  
            if($_SESSION['loggedin']){
                if($_SESSION['id'] === $row['Sender'] || $_SESSION['isadmin']){
                    echo('<a href="#" class="deleteComment" id='.$row['cId'].' onclick="return false" value='.$row['Sender'].'><button>Delete comment</button></a>');
                }
            }
            
            echo('</div>');
        }
        
        ?>
        
    
    </div>
        
    
        
        
    </main>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="js/menu.js"></script>

    
</body>
</html>
    