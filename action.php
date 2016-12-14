<?php
session_start();
require_once "config/config.php";

//action for like-button, updates like to database or removes it, based on what action jQuery-script has given
$pid=$_POST['pid'];
$user=$_SESSION['id'];
$action=$_POST['action'];
if ($action=='like'){
 $sql=$DBH->prepare("SELECT * FROM a_Likes WHERE UploadID=? and Sender=?");
 $sql->execute(array($pid,$user));
 $matches=$sql->rowCount();
 if($matches==0){
 $sql=$DBH->prepare("INSERT INTO a_Likes (UploadID,Sender) VALUES(?, ?)");
 $sql->execute(array($pid,$user));
 }else{
 die("There is No Post With That ID");
 }
}
if ($action=='unlike'){
 $sql = $DBH->prepare("SELECT 1 FROM a_Likes WHERE UploadID=? and Sender=?");
 $sql->execute(array($pid,$user));
 $matches = $sql->rowCount();
 if ($matches != 0){
 $sql=$DBH->prepare("DELETE FROM a_Likes WHERE UploadID=? AND Sender=?");
 $sql->execute(array($pid,$user));
 }
}


?>