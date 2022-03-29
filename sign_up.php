<?php
// Initialize the session
//session_start();

$link = mysqli_connect('localhost', 'root', '', 'concerts');
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Define variables and initialize with empty values
$username = $password =$confirm_password="";
$username_err = $password_err=$confirm_password_err = $signup_err = "";

// Processing form data when form is submitted
if(isset($_POST['singUp'])){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Unesite username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Unesite password.";
    }else if(empty(trim($_POST["confirm-password"]))){
        $password_err = "Unesite password i potvrdu password-a.";
    } 
    else{
        $password = trim($_POST["password"]);
        $confirm_password = trim($_POST["confirm-password"]);
        //$hashed_password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);
    }
    
    // Validate credentials
    if(empty(trim($_POST["username"]))){
        $username_err = "Unesite username.";
    } else
    {

        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Username se već koristi.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Greška na serveru.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
        
    }
    //validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Unesite password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password mora da ima najmanje 6 karaktera.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm-password"]))){
        $confirm_password_err = "Unesite potvrdu password-a.";     
    } else{
        $confirm_password = trim($_POST["confirm-password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password-i se ne podudaraju.";
        }
    }
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, pass) VALUES (?, ?)";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = $password;
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: index.php");
            } else{
                echo "Došlo je do grške prilikom insertovanja u bazu podataka.";
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
	<h2 align="center">Sign UP</h2>
    <div class="input-group">
        <label>Username</label>
        <input type="text" name="username" style="font-size:20px ;">
        <span  style="color: red;"><?php echo $username_err; ?></span>
	</div>
    <div class="input-group">
        <label>Password</label>
        <input type="password" name="password" style="font-size: 20px;">
        <span  style="color: red;"><?php echo $password_err; ?></span>
    </div>
    <div class="input-group">
        <label>Potvrdi password</label>
        <input type="password" name="confirm-password" style="font-size: 20px;">
        <span  style="color: red;"><?php echo $confirm_password_err; ?></span>
    </div>
    
    <?php 
        if(!empty($signup_err)){
            echo '<p  style="color: red;">' . $signup_err . '</p>';
        }        
    ?>
    <button class="btn" type="submit" name="singUp" align="center" >Sign Up</button>
	
</form>
</body>

</html>