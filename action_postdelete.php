<?php
session_start();
require_once "config/config.php";

//deletes a post/upload from database after jQuery has detetcted that used has clicked the delete-button
$id=$_POST['id'];
$user=$_POST['user'];
echo($id);
echo($user);

 $sql=$DBH->prepare("SELECT * FROM a_Upload WHERE Id=? AND Uploader=?");
 $sql->execute(array($id,$user));
 $matches=$sql->rowCount();
 if($matches>0){
 $sql=$DBH->prepare("DELETE FROM a_Upload WHERE Id=? AND Uploader=?");
 $sql->execute(array($id,$user));
redirect('profile.php?Id='.$_SESSION['id']);
 }else{
 die("There is no post with that id");
 }


?>