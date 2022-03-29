<?php
// Initialize the session
session_start();

$link = mysqli_connect('localhost', 'root', '');
 
// Check connection
if($link === false){
    //die("ERROR: Could not connect. " . mysqli_connect_error());
}

//make sure our recently created database is the active one
mysqli_select_db($link,'concerts');  

// Define variables and initialize with empty values
$username = $password ="";
$username_err = $password_err = $login_err = "";


// Processing form data when form is submitted
if(isset($_POST['logIn'])){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Unesite username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Unesite password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    //$hashed_password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, pass FROM users WHERE username = ? and pass=?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username,$param_pass);
            
            // Set parameters
            $param_username = $username;
            $param_pass= $password;
            
           // Execute the prepared statement
           if(mysqli_stmt_execute($stmt)){
            // Store result
            mysqli_stmt_store_result($stmt);
            
            
            if(mysqli_stmt_num_rows($stmt) == 1){                    
                
                header("location: main.php");
                   
            } else{
                
                $login_err = "Pogrešni kredencijali.";
            }
        } else{
            echo "Greška na serveru.";
        }
        // Close statement
        mysqli_stmt_close($stmt);
        }
    }
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koncerti</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h1 align="center">KONCERTI</h1>
<form method="post" action="">
	<h2 align="center">Log In</h2>
    <div class="input-group">
        <label>Username</label>
        <input type="text" name="username"style="font-size:20px ;">
        <span  style="color: red;"><?php echo $username_err; ?></span>
	</div>
    <div class="input-group">
        <label>Password</label>
        <input type="password" name="password" style="font-size: 20px;">
        <span  style="color: red;"><?php echo $password_err; ?></span>
    </div>
    <?php 
        if(!empty($login_err)){
            echo '<p  style="color: red;">' . $login_err . '</p>';
        }        
    ?>
    <button class="btn" type="submit" name="logIn" align="center" style="margin-bottom: 10px;">Log In</button>
    <br>
    <a href="sign_up.php" class="btn-signUP">Sign up</a>
	
</form>
</body>

</html>