<?php
include("includes/header.php");
?>


<div class="user_details column">
    <a href="#"> <img src="<?php echo $user['profile_pic']; ?>"/></a>

    <div class="user_details_left_right">
        <a href="#"><?php echo $user['first_name']; ?></a><br>
        <a href="#"><?php 
            echo "Posts: " . $user['num_posts'] . "<br>";
            echo "Likes: " . $user['num_posts'];
        ?></a>
    </div>
</div>

<div class="main_column column">
    <form class="post_form" action="index.php" method="POST">
        <input type="number" name="post_number" id="post_number" min="0" max="200"><br>
        <textarea name="post_text" id="post_text" placeholder="Describe it to us..."></textarea>
        <input type="submit" name="post" id="post_button" value="Post">
        <hr>
    </form>
</div>


</div> <!-- closes wrapper from header.php -->
</body>
</html>