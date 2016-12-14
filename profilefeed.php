<?php
    $Id = htmlspecialchars($_GET["Id"]);

    //Get user info
    $sql = $DBH->prepare("SELECT * FROM a_Users WHERE Id = ?");
    $sql->execute([$Id]);
    $user = $sql->fetch(PDO::FETCH_OBJ);

    

    // Display profile banner
    if($user->Banner !== null){
        echo("<div id='bannerimg'><img src='images/uploads/".$user->Banner."' class='resize'></div>");
    }else {
        echo("<div id='bannerimg'><img src='images/banner/default.jpg' class='resize'></div>");
    }
    // Display profile description and username
    
    echo('<div id="profileDescription">');

    echo("<br><div id='profileBox'><div id='profileName'>".$user->Username."</div><br>");
    echo nl2br("<div id='profileDesc'>".$user->Description ."</div></div>");
    
    //show user avatar

    echo("<div id='picbox'><img class='profilepic' src='images/uploads/".$user->Avatar."'>");
    if($_SESSION['loggedin']){

        $smq=$DBH->prepare("SELECT * FROM a_Follow WHERE Followed=".$Id." and Follower=".$_SESSION['id']."");
        $smq->execute();
            //Follow button
            if($smq->rowCount()===1){
                echo ('<a href="#" class="follow" id="'.$Id.'" title="Unfollow" onclick="return false"><img class="follow" src="images/unfollow.png"></a>');
            }else{ 
                if($Id!==$_SESSION['id']){
                echo ('<a href="#" class="follow" id="'.$Id.'" title="Follow" onclick="return false"><img class="follow" src="images/follow.png"></a>');
                }
            }; 
         }


    echo('</div></div>');
    
    //Display user's posts
    try{
        $sql = $DBH->prepare("SELECT * FROM a_Upload WHERE Uploader = ? ORDER BY UploadDate DESC");
        $sql->execute([$Id]);
        
        
        while($row= $sql->fetch(PDO::FETCH_ASSOC)) {
            $smt = $DBH->prepare("SELECT COUNT(*) FROM a_Likes where UploadId = ?");
            $smt->execute([$row[Id]]);
            $likes = $smt->fetchColumn();
            
             $com= $DBH->prepare("SELECT COUNT(*) FROM a_Comment where UploadID = ?");
            $com->execute([$row[Id]]);
            $comments = $com->fetchColumn();
            
            $pid=$row[Id];

              
            echo("<a href='postinfo.php?id=".$row['Id']."' class='feedPost' value='".$row['Id']."'
            ><article class='profileAndFeedPost'>
            <img src='images/uploads/".$row['Url']."' class='resize' />
            <h3><div id='uploadN'>".$row['UploadName']."</div></h3>
            <div id='uploadD'>".$row['Description']."</div>
            <div id='uploadDT'>File uploaded ".$row['UploadDate']."</div>");
                 
            //Display like-button if logged in
            if($_SESSION['loggedin']){
                
                
                 $smq=$DBH->prepare("SELECT * FROM a_Likes WHERE UploadID=".$pid." and Sender=".$_SESSION['id']."");
                $smq->execute();
                
                
            //container for likes icon
        echo('<div class="likeComCenter">');
        if($smq->rowCount()===1){
            echo ('<a href="#" class="like" id="'.$pid.'" title="Unlike" onclick="return false" value="'.$likes.'"><div class="likeComContainer"><img src="images/liked2.png">');
        }else{ 
            if($Id!==$_SESSION['id']){
            echo ('<a href="#" class="like" id="'.$pid.'" title="Like" onclick="return false" value="'.$likes.'"><div class="likeComContainer"><img src="images/liked.png"> ');
            }else{
                echo ('<div class="likeComContainer"><img src="images/liked.png"> ');
            }
        };
        echo('<p class="likeComContainerText likes">'.$likes.'</a></p>');
        echo('</div>');
        
        //container for comments icon
        echo('<div class="likeComContainer">');
        echo("<img src='images/comments.png'>");
        echo('<p class="likeComContainerText">'.$comments.'</p>
        </div></div>');
            
            echo("</article></a>");            
        }}
           
        
    }catch(PDOException $e){
        echo("No posts");
    }


?>           
