<?php 

//Login function and other user-related functions

function login($email, $pwd, $DBH){
    
//include password-lib since password_hash isn't supported yet in our PHP version
include('password/lib/password.php');
    
    try {
        $sql = $DBH->prepare("SELECT * FROM a_Users WHERE Email = ?");
        $sql->execute([$email]);
        $num = $sql->rowCount();        
        if($num > 0){
             while($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                $hash = $row['UPassword'];
                if(password_verify($pwd,$hash)){
                    echo("<br> You are now logged in.");
                    $_SESSION['loggedin']=TRUE;
                    $_SESSION['id']=$row['Id'];
                    $_SESSION['username']=$row['Username'];
                    $_SESSION['email']=$row['Email'];
                    $_SESSION['avatar']=$row['Avatar'];
                    $_SESSION['description']=$row['Description'];
                    $_SESSION['isadmin']=$row['IsAdmin'];
                    
                    //if user was found, set session variables and return true
                    return true;
                } else {
                    
                    //in case of wrong password, give notice and possibility to try again
                    echo("Wrong password!");
                    echo("<form method='POST' action='login.php'>
                    <input type='text' name='email' id='email' placeholder='Email' value=".$email." required><br/>
                    <input type='password' name='pwd' id='pwd' placeholder='Password' required><br/>
                    <input type='submit' name='login' value='Log in'>
                    </form>");
                    
                }
             }
        }else {
            
            //if user wasn't found, echo login-form and also give link to registering page
            echo("User doesn't exist, try another email or register below.");
            echo("<form method='POST' action='login.php'>
            <input type='text' name='email' id='email' placeholder='Email' value=".$email." required><br/>
            <input type='password' name='pwd' id='pwd' placeholder='Password' required><br/>
            <input type='submit' name='login' value='Log in'>
            </form>");
            echo("<a href='register.php'><button>Register</button></a>");
        }
        
    }catch(PDOEXception $e){
        // echo("Login error");
    }
}

//function for logging out, destroys session and redirects user to index.php
function logout(){
    session_unset();
    session_destroy();
   redirect('index.php');

}



?>