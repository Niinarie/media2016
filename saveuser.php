<?php
session_start();
include('header.php');
include('password/lib/password.php');
?>
<!DOCTYPE HTML>
<html>
    <head>
    <title>Registering complete</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    
    <body id="index">
    
    <main class="center">
        <header id="indexheader">
            <sub>do create &amp; share</sub> <a class="header" href="index.php">create.it</a>
        </header>
        <div id="mainbox">
        
        <?php
            
        //function for adding stuff to associative array
            
         function array_push_assoc($array, $key, $value){
            $array[$key] = $value;
            return $array;
        }

        //password hashing options, medium cost
            
        $options = ['cost' => 8,];     
      
        // add missing info to userdata, like date, default avatar, hashed pw
        $userdata = unserialize($_SESSION['userinfo']);
        $userdata["UPassword"]=password_hash($userdata["UPassword"], PASSWORD_BCRYPT, $options);
        $date = date('Y-m-d');
        $avatar = 'defaultavatar.png';
        $userdata = array_push_assoc($userdata,'Joindate', $date);
        $userdata = array_push_assoc($userdata,'Avatar', $avatar);
        
            //php's own email validation
        if(filter_var($userdata["Email"], FILTER_VALIDATE_EMAIL)){
            
            //check if username is correct form
            if(preg_match("/^[a-öA-Ö0-9-_.,!#@äåöÄÅÖ ]*$/",$userdata['Username'])) {
            try {

                $sql = $DBH->prepare("INSERT INTO 
                a_Users (Username,Email,UPassword, Joindate,Avatar)
                VALUES
                (:Username,:Email,:UPassword, :Joindate,:Avatar);");    
            if($sql->execute($userdata)){
                try {   
                    
                     unset($_SESSION['userinfo']);
 
                    //set session variables and make the status of user logged in
                        $sql = "SELECT * FROM a_Users WHERE Id = ".$DBH->lastInsertId().";";
					   $STH3 = $DBH->query($sql);
					   $STH3->setFetchMode(PDO::FETCH_OBJ);
					   $user = $STH3->fetch();
					   $_SESSION["loggedin"] = true;
                       $_SESSION['id']=$user->Id;
					   $_SESSION["username"] = $user->Username;
                       $_SESSION["email"] = $user->Email;
                       $_SESSION["joindate"] = $user->Joindate; 
                        $_SESSION["avatar"] = $user->Avatar;
                       $_SESSION["description"]="";
                    
                    
                      
                      
                       echo ("<p>Your username is ".$_SESSION["username"]."<br/> 
                       Your email is ".$_SESSION["email"]."<br/>
                       You joined on ".$_SESSION["joindate"]."</p>"); //TESTITULOSTUS  
                
                        echo ("<p>Your registration is now complete.<br> The button below takes you to your profile.</p>");
                        echo ("<a href='profile.php?Id=".$_SESSION['id']."'><button type='button'>continue</button></a>");
                    }catch(PDOException $e){
                        echo ("Error fetching information");
                    }
                }
            }catch(PDOException $e){
            echo ("Error inserting information");
            }
        }else {
            echo("Faulty username.");  
        }
       }else {
            echo("Faulty email address.");
        };  ?>
            
        </div>
    </main>

    </body>
</html>