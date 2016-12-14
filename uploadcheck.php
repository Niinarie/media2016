<?php 
session_start();
include('header.php');
?>
<!DOCTYPE HTML>
<html>
    <head>
    <title>create.it</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    </head>
<body id="index">
    
<main class="center">
    <header id="indexheader">
    <sub>do create &amp; share</sub> <a class="header" href="index.php">create.it</a>
    </header>
    
<div id="mainbox">
<?php
    
    
//page for checking upload info, image size and other things
    
//function for adding stuff to associative array
function array_push_assoc($array, $key, $value){
            $array[$key] = $value;
            return $array;
}

//checks whether user is uploading artwork, or changing avatar or banner. type comes from hidden field in form
    
$imagetype= $_POST['it'];
switch($imagetype){
    case 'avatar':
        $imagesize = 102400;
        $width = 100;
        $height = 100;
        break;
    case 'banner':
        $imagesize = 1000000;
        $width=1200;
        $height= 450;
        break;
    default:
        $imagesize = 3145728;
}
    
$data = $_POST["data"]; 


//names target directory
    
$target_dir = "images/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    
// Check if image file is a actual image or fake image
    
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    $image_width = $check[0];
    $image_height = $check[1];
    if($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Your file is not an image!<br>";
        $uploadOk = 0;
    }
}
 
//this and one below, check the dimensions of banner and avatar, avatar needs to be exact size, banner needs to be smaller than stated
if($imagetype === 'avatar'){
    if($image_width!==$width || $image_height!==$height){
        $uploadOk = 0;
        echo("Your avatar is the wrong size.<br>");
    }else {
        $uploadOk = 1;
    }
}
    
if($imagetype === 'banner'){
    if($image_width>$width || $image_height>$height){
        $uploadOk = 0;
        echo("Your banner has the wrong dimensions.<br>");
    }else {
        $uploadOk = 1;
    }
}

//checks if title and description of artwork are correct    
    
if($imagetype !== 'avatar' && $imagetype !== 'banner'){
if(preg_match("/^[0-9a-zA-Z-_.,!#@äåöÄÅÖ ]+$/",$data['UploadName'])) {
    $uploadOk = 1;
  }else {
    echo("Faulty title. Only alphanumeric characters and spaces are allowed.<br>");
    $uploadOk = 0;
}
if(preg_match("/^(?:[0-9a-zA-Z-_.,!#@äåöÄÅÖ ]|\r?\n)+$/",$data['Description'])) {
    $uploadOk = 1;
}else {
    echo("Faulty description. Only alphanumeric characters, spaces and line breaks are allowed.<br>");
    $uploadOk = 0;
}
}
    
// Check file size
    
if ($_FILES["fileToUpload"]["size"] > $imagesize) {
    echo "Sorry, your file is too large.<br>";
    $uploadOk = 0;
}
    
// Allow certain file formats
    
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
    $uploadOk = 0;
}
    
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Your file was not uploaded.<br>";
    
// if everything is ok, try to upload file
} else {
    
    //renames file to "random" numbers, based on microtime
    $temp = explode(".", $_FILES["fileToUpload"]["name"]);
    $newname = round(microtime(true)) . '.' . end($temp);
    $newfilename = $target_dir . $newname;
    
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newfilename)) {
        echo "<p>The file has been uploaded.</p>";
        
        //if downloading avatar
        if($imagetype == 'avatar'){
        try {
            $sql= $DBH->prepare("UPDATE a_Users SET Avatar = :avatar WHERE Id = ".$_SESSION['id']);
            $sql->bindParam(':avatar', $newname, PDO::PARAM_STR);
            $sql->execute();
            echo("<p>Avatar has been set successfully.<br></p>
            <a href='profile.php?Id=".$_SESSION['id']."'><button>Back to profile</button></a>");
            $_SESSION['avatar']=$newname;
        }catch(PDOException $e){
            echo("<p>There was an error uploading your avatar.<br></p>
            <a href='profile.php?Id=".$_SESSION['id']."'><button>Back to profile</button></a>");
        } }
        
        //if downloading banner
        elseif($imagetype == 'banner'){
        try {
            $sql= $DBH->prepare("UPDATE a_Users SET Banner = :banner WHERE Id = ".$_SESSION['id']);
            $sql->bindParam(':banner', $newname, PDO::PARAM_STR);
            $sql->execute();
            echo("<p>Banner has been set successfully.<br></p>
            <a href='profile.php?Id=".$_SESSION['id']."'><button>Back to profile</button></a>");
        }catch(PDOException $e){
            echo("<p>There was an error uploading your banner.<br></p>
            <a href='profile.php?Id=".$_SESSION['id']."'><button>Back to profile</button></a>");
        } }
        
        //if downloading art/etc
        else {
            
            $date = date('Y-m-d');
            $data = array_push_assoc($data,'UploadDate', $date);
            $data = array_push_assoc($data,'Uploader', $_SESSION['id']);
            $data = array_push_assoc($data,'Url',$newname);
            try {
            $sql = $DBH->prepare("INSERT INTO 
                a_Upload (UploadName,Description,Url,UploadDate,Uploader)
                VALUES (:UploadName,:Description,:Url,:UploadDate, :Uploader);");    
            if($sql->execute($data)){
                $sql = "SELECT * FROM a_Upload WHERE Id = ".$DBH->lastInsertId().";";
					   $STH3 = $DBH->query($sql);
					   $STH3->setFetchMode(PDO::FETCH_OBJ);
					   $upload = $STH3->fetch();
                    echo("<p>Your file has been uploaded, taking you to the upload page.</p>");
                       header( "refresh:4; url='postinfo.php?id=".$DBH->lastInsertId()."'" ); 
            }else {
                echo("Something went wrong. Try again.");
            }
            }catch(PDOException $e){
                echo("Error inserting file to database. Try again.<br>");
            }
        }
    } else {
        echo "Sorry, there was an error uploading your file.<br>";
    }
}
?>
    
    </div>
    </main>
    
    
<script src="js/menu.js"></script>
</body>
</html>