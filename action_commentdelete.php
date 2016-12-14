<?php
session_start();
require_once "config/config.php";
//action for deleting a comment, after jQuery has detected that user has clicked the delete-button
$cid=$_POST['cid'];
$sender=$_POST['sender'];


 $sql=$DBH->prepare("SELECT * FROM a_Comment WHERE Id=? AND (Sender=? OR Sender=?)");
 $sql->execute(array($cid,$sender,8));
 $matches=$sql->rowCount();
 if($matches>0){
 $sql=$DBH->prepare("DELETE FROM a_Comment WHERE Id=?");
 $sql->execute(array($cid));
 }else{
 die("There is no comment with that id");
 }


?>