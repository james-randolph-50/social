<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "social");
if(mysqli_connect_errno()) {
    echo "Failed to connect: " . mysqli_connect_errno();
}

// Declaring vars to prevent errors
$fname = "";
$lname = "";
$em = "";
$em2 = "";
$password = "";
$password2 = "";
$date = "";
$error_array = array();

if(isset($_POST['register_button'])) {

    // Registration for values
    $fname = strip_tags($_POST['reg_fname']); // Remove html tags
    $fname = str_replace(' ', '', $fname); // Remove spaces
    $fname = ucfirst(strtolower($fname)); // Uppercase first letter
    $_SESSION['reg_fname'] = $fname; // Stores first name into session var

    $lname = strip_tags($_POST['reg_lname']); // Remove html tags
    $lname = str_replace(' ', '', $lname); // Remove spaces
    $lname = ucfirst(strtolower($lname)); // Uppercase first letter
    $_SESSION['reg_lname'] = $lname; // Stores last name into session var

   
    $em = strip_tags($_POST['reg_email']); // Remove html tags
    $em = str_replace(' ', '', $em); // Remove spaces
    $em = ucfirst(strtolower($em)); // Uppercase first letter
    $_SESSION['reg_email'] = $em; // Stores email into session var

  
    $em2 = strip_tags($_POST['reg_email2']); // Remove html tags
    $em2 = str_replace(' ', '', $em2); // Remove spaces
    $em2 = ucfirst(strtolower($em2)); // Uppercase first letter
    $_SESSION['reg_email2'] = $em2; // Stores email2 into session var

   
    $password = strip_tags($_POST['reg_password']); // Remove html tags
    $password2 = strip_tags($_POST['reg_password2']); // Remove html tags

    $date = date("Y-m-d"); // Current Date

    if($em == $em2) {
        // Check for valid email

        if(filter_var($em, FILTER_VALIDATE_EMAIL)) {

            $em = filter_var($em, FILTER_VALIDATE_EMAIL);

            // Check if email already exists
            $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");

            // Count the number of rows returned
            $num_rows = mysqli_num_rows($e_check);

            if($num_rows > 0) {
                array_push($error_array, "Email already in use.<br>");
            }

        } else {
            array_push($error_array, "Invalid format<br>");
        }

    } else {
        array_push($error_array, "Emails don't match<br>");
    }

    if(strlen($fname) > 25 || strlen($fname) < 2) {
        array_push($error_array, "Your first name must be between 2 and 25 characters<br>"); 
    }

    if(strlen($lname) > 25 || strlen($lname) < 2) {
        array_push($error_array, "Your last name must be between 2 and 25 characters<br>");
    }

    if($password != $password2) {
        array_push($error_array, "Passwords don't match<br>"); 
    }
    else {
        if(preg_match('/[^A-Za-z0-9]/', $password)) {
            array_push($error_array, "Your password can only contain english alphanumeric numbers<br>"); 
            
        }
    }

    if(strlen($password > 30 || strlen($password) < 5)) {
        array_push($error_array, "Your password must be between 5 and 30 characters<br>");
    }

    if(empty($error_array)) {
        $password = md5($password); // Encrypt pw before sending to database

        // Generate username by concatenating first and last names
        $username = strtolower($fname . "_" . $lname);
        $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");

        $i = 0;
        // If username exists, add number to username
        while(mysqli_num_rows($check_username_query) != 0) {
            $i++;
            $username = $username . "_" . $i;
            $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
        }

        // Assign a default profile picture
        $rand = rand(1, 2);
        if($rand == 1)
            $profile_pic = "assets/images/profile_pics/defaults/head_deep_blue.png";
        else if($rand == 2)
            $profile_pic = "assets/images/profile_pics/defaults/head_emerald.png";


            // send values to database
        $query = mysqli_query($con, "INSERT INTO users VALUES (NULL, '$fname', '$lname', '$username', '$em', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");

        array_push($error_array, "<span style='color:#14C800;'>You're all set! Go ahead and login.</span><br>");

    }
}
?>

<html>
<head>
<title>Register</title>
</head>
<body>
<h1>Register</h1>
<form action="register.php" method="POST">
    <input type="text" name="reg_fname" placeholder="First Name" value="<?php 
        if(isset($_SESSION['reg_fname'])) {
            echo $_SESSION['reg_fname'];
        }
    ?>" required>
    <br>
    <?php if(in_array("Your first name must be between 2 and 25 characters<br>", $error_array)) echo "Your first name must be between 2 and 25 characters<br>"; ?>

    
    <input type="text" name="reg_lname" placeholder="Last Name" value="<?php 
        if(isset($_SESSION['reg_lname'])) {
            echo $_SESSION['reg_lname'];
        }
    ?>" required>
    <br>
    <?php if(in_array("Your last name must be between 2 and 25 characters<br>", $error_array)) echo "Your last name must be between 2 and 25 characters<br>"; ?>


    <input type="email" name="reg_email" placeholder="Email" value="<?php 
        if(isset($_SESSION['reg_email'])) {
            echo $_SESSION['reg_email'];
        }
    ?>" required>
    <br>

    <input type="email" name="reg_email2" placeholder="Confirm Email" value="<?php 
        if(isset($_SESSION['reg_email2'])) {
            echo $_SESSION['reg_email2'];
        }
    ?>"  required>
    <br>
    <?php if(in_array("Email already in use.<br>", $error_array)) echo "Email already in use.<br>"; 
        else if(in_array("Invalid format<br>", $error_array)) echo "Invalid format<br>";
        else if(in_array("Emails don't match<br>", $error_array)) echo "Emails don't match<br>"; ?>

    <input type="password" name="reg_password" placeholder="Password" required>
    <br>
    <input type="password" name="reg_password2" placeholder="Confirm Password" required>
    <br>
    <?php if(in_array("Passwords don't match<br>", $error_array)) echo "Passwords don't match<br>"; 
        else if(in_array("Your password can only contain english alphanumeric numbers<br>", $error_array)) echo "Your password can only contain english alphanumeric numbers<br>";
        else if(in_array("Your password must be between 5 and 30 characters<br>", $error_array)) echo "Your password must be between 5 and 30 characters<br>"; ?>

    <input type="submit" name="register_button" value="Register">
    <br>
        <?php if(in_array("<span style='color:#14C800;'>You're all set! Go ahead and login.</span><br>", $error_array)) echo "<span style='color:#14C800;'>You're all set! Go ahead and login.</span><br>"; ?>


</form>
</body>

</html>