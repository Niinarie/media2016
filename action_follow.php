<?php
session_start();
require_once "config/config.php";

//checks which action jQuery script gave and does correct changes to database after user has clicked follow-button
$id=$_POST['id'];
$user=$_SESSION['id'];
$action=$_POST['action'];
echo($id);
if ($action=='follow'){
 $sql=$DBH->prepare("SELECT * FROM a_Follow WHERE Followed=? and Follower=?");
 $sql->execute(array($id,$user));
 $matches=$sql->rowCount();
 if($matches==0){
 $sql=$DBH->prepare("INSERT INTO a_Follow (Followed,Follower) VALUES(?, ?)");
 $sql->execute(array($id,$user));
 }else{
 die("There is No User With That ID");
 }
}
if ($action=='unfollow'){
 $sql = $DBH->prepare("SELECT 1 FROM a_Follow WHERE Followed=? and Follower=?");
 $sql->execute(array($id,$user));
 $matches = $sql->rowCount();
 if ($matches != 0){
 $sql=$DBH->prepare("DELETE FROM a_Follow WHERE Followed=? AND Follower=?");
 $sql->execute(array($id,$user));
 }
}

?>