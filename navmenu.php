<?php 

//display the navigation bar
echo(' 
 <header id="navbar">');
       echo('<a id="navbarH" href="main.php">create.it</a> <div id="navbutton">&#9776;</div> ');
echo('</header>

<nav id="rightMenu">');

//if logged in, display user-menu
 if($_SESSION['loggedin']){
    echo("<div id='navmenu'><a href='profile.php?Id=".$_SESSION['id']."'><img class='navP' src='images/uploads/".$_SESSION['avatar']."'></a>");
        
    echo("<h2><p id='pname'>".$_SESSION['username']."</p></h2>");
    echo("<ul class='controls1'>
    
    <a href='upload.php'><li>
    NEW POST</li></a>
    
    <a href='main.php'><li>
    home</li></a>
    
    <li id='search'>
    search</li>
    <li id='searchbar'>
    <form action='search.php' method='POST'>
    <input type='text' name='search'>
    <button type='submit' name='submit'>Search</button>
    </form>
    </li>
    <a href='discover.php'>
    <li>discover</li></a>
    <a href='settings.php'>
    <li>settings</li></a>
    
    <a href='logout.php'>
    <li>log out</li></a></div>");
    
}

//If user isn't logged in, show menu with login and register    
else { 
    echo("<div id='navmenu'><ul class='controls1'>");
    echo("<li id='search'>Log in</li>
    <li id='searchbar'>
    <form method='POST' action='login.php'>
    <input type='text' name='email' id='email' placeholder='Email' required><br/>
    <input type='password' name='pwd' id='pwd' placeholder='Password' required><br/>
    <input type='submit' name='login' value='Log in'>
    </form>
    </li>
    <a href='register.php'><li>Register</li></a>
    </ul></div>");

} 
echo('</nav>');

?>

    