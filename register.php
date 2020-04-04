<?php
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
$error_array = "";

if(isset($_POST['register_button'])) {

    // Registration for values
    $fname = strip_tags($_POST['reg_fname']); // Remove html tags
    $fname = str_replace(' ', '', $fname); // Remove spaces
    $fname = ucfirst(strtolower($fname)); // Uppercase first letter

    $lname = strip_tags($_POST['reg_lname']); // Remove html tags
    $lname = str_replace(' ', '', $lname); // Remove spaces
    $lname = ucfirst(strtolower($lname)); // Uppercase first letter
   
    $em = strip_tags($_POST['reg_email']); // Remove html tags
    $em = str_replace(' ', '', $em); // Remove spaces
    $em = ucfirst(strtolower($em)); // Uppercase first letter
  
    $em2 = strip_tags($_POST['reg_email2']); // Remove html tags
    $em2 = str_replace(' ', '', $em2); // Remove spaces
    $em2 = ucfirst(strtolower($em2)); // Uppercase first letter
   
    $password = strip_tags($_POST['reg_password']); // Remove html tags
    $password2 = strip_tags($_POST['reg_password2']); // Remove html tags

    $date = date("Y-m-d"); // Current Date

    if($em == $em2) {
        // Check for valid email

        if(filter_var($em, FILTER_VALIDATE_EMAIL)) {
            $em = filter_var($em, FILTER_VALIDATE_EMAIL);

            
        } else {
            echo "Invalid format";
        }

    } else {
        echo "Emails don't match";
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
    <input type="text" name="reg_fname" placeholder="First Name" required>
    <br>
    <input type="text" name="reg_lname" placeholder="Last Name" required>
    <br>
    <input type="email" name="reg_email" placeholder="Email" required>
    <br>
    <input type="email" name="reg_email2" placeholder="Confirm Email" required>
    <br>
    <input type="password" name="reg_password" placeholder="Password" required>
    <br>
    <input type="password" name="reg_password2" placeholder="Confirm Password" required>
    <br>
    <input type="submit" name="register_button" value="Register">
</form>
</body>

</html>