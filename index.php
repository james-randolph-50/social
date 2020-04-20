<?php
include("includes/header.php");
include("includes/classes/User.php");
include("includes/classes/Post.php");

if(isset($_POST['post'])){
    $post = new Post($con, $userLoggedIn);
    $post->submitPost($_POST['post_text'],$_POST['post_number'], NULL);
    header("Location: index.php");
}
?>

<div class="user_details column">
    <a href="<?php echo $userLoggedIn ?>"> <img src="<?php echo $user['profile_pic']; ?>"/></a>

    <div class="user_details_left_right">
        <a href="<?php echo $userLoggedIn ?>"><?php echo $user['first_name']; ?></a><br>
        <a href="#"><?php 
            echo "Posts: " . $user['num_posts'] . "<br>";
            echo "Likes: " . $user['num_posts'];
        ?></a>
    </div>
</div>

<div class="main_column column">
    <form class="post_form" action="index.php" method="POST">
        <input type="number" name="post_number" id="post_number" min="0" max="200" required><br>
        <textarea name="post_text" id="post_text" placeholder="Describe it to us..."></textarea>
        <input type="submit" name="post" id="post_button" value="Post">
        <hr>
    </form>

<?php  

    $post = new Post($con, $userLoggedIn);
    $post->loadPostsFriends();
?>

<img id="#loading" src="assets/images/icons/ylb.png">

</div>

<script>
var userLoggedIn = '?php echo $userLoggedIn; ?>';

$(document).ready(function() {
    $('#loading').show();

    // Original ajax request for loading first posts
    $.ajax({
        url: "includes/handlers/ajax_load_posts.php",
        type: "POST",
        data: "page=1&userLoggedIn=" + userLoggedIn,
        cache: false,

        success: function(data) {
            $('#loading'.hide();
            $('.posts_area').html(data);
        }
    });


});


</script>


</div> <!-- closes wrapper from header.php -->
</body>
</html>