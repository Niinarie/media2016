<?php
session_start();
include('header.php');

if ($_SERVER['REQUEST_METHOD'] != 'POST') exit; // Don't allow anything but POST

//action for saving a comment to database, gives error messages to the jQuery script if needed, otherwise states success


if ( strlen($_POST["Content"])>0 ) { 
    $commment = htmlspecialchars( $_POST["Content"] );
    $sender = $_POST['Sender'];
    $uploadId = $_POST['UploadID'];
    $date = date('Y-m-d');
    
    if(strlen($_POST["Content"])<500){
    
    try{
        $sql = $DBH->prepare("INSERT INTO a_Comment (Sender,UploadID,Content,CommentDate) VALUES (?,?,?,?)");        
        if($sql->execute(array($sender,$uploadId,$commment,$date))) {           
            $response="Comment sent successfully.";            
        }else {
            $response="Error fetching comment";
        }
                
        
    }catch(PDOException $e){
        echo("Error adding comment to database");
        $response = "Error";
    }
    }else {
        $response = "Too long comment, max 500 characters.";
    }
    
      
} else {
     $response = "Please, enter a comment";
}
echo $response;  // This will be sent/returned to AJAX
exit;


?>