<?php
require 'config/config.php';



if(isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);
} else {
    header("Location: register.php");
}
?>


<html>
<head>
<title>Social network</title>

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">


</head>
<body>


<div class="top_bar">
    <div class="logo">
        <a href="index.php">Social App</a>
    </div>

    <nav>
        <a href="<?php echo $userLoggedIn ?>"><?php echo $user['first_name']; ?></a>
        <a href="index.php"><i class="fa fa-home"></i></a>
        <a href="#"><i class="fa fa-envelope"></i></a>
        <a href="#"><i class="fa fa-users"></i></a>
        <a href="#"><i class="fa fa-cog"></i></a>
    </nav>
</div>

<div class="wrapper"> <!-- this is closed on index.php -->

