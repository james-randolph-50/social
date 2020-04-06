<?php
class Post {
    private $user_obj;
    private $con;

    public function __construct($con, $user){
        $this->con = $con;
        $this->user_obj = new User($con, $user);
    }

    public function submitPost($body, $number, $user_to) {
        $body = strip_tags($body); // removes html tags
        // $number = string_tags($number);
        $body = mysqli_real_escape_string($this->con, $body);

        $body = str_replace('\r\n', '\n', $body);
        $body = nl2br($body);

        $check_empty = preg_replace('/\s+/', '', $body); // deletes all spaces

        if($check_empty != "") {

            // Current date and time
            $date_added = date("Y-m-d H:i:s");
            // Get username
            $added_by = $this->user_obj->getUsername();

            // If user is on own profiile, user_to is 'none'
            if($user_to == $added_by) {
                $user_to = "none";
            }

            // Insert post into database
            $query = mysqli_query($this->con, "INSERT INTO posts VALUES(NULL, '$body',  '$number', '$added_by', '$user_to', '$date_added', 'no', 'no', '0')");
            $returned_id = mysqli_insert_id($this->con);

            // insert notification

            // Update post count for user
            $num_posts = $this->user_obj->getNumPosts();
            $num_posts++;
            $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by");
        }

        
    }

    public function loadPostsFriends() {
        $str = "";
        $data = mysqli_query($this->con, "SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC");

        while($row = mysqli_fetch_array($data)) {
            $id = $row['id'];
            $number = $row['number'];
            $body = $row['body'];
            $added_by = $row['added_by'];
            $date_time = $row['date_added'];

            // Prepare user_to string so it can be included even if not posted to a user
            if($row['user_to'] == "none") {
                $user_to = "";
            }
            else {
                $user_to_obj = new  User($con, $row['user_to']);
                $user_to_name = $user_to_obj->getFirstAndLastName();
                $user_to = "<a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>"
            }

            // Check if poster has their account closed
             $added_to_obj = new  User($con, $added_by);
             if($added_by_obj->isClosed()){
                 continue;
             }

             $user_details_query = mysqli_query($this->con, "SELECT firstname, last_name,  profile_pic FROM users WHERE username='$added_by'");
             $user_row = mysqli_fetch_array($user_details_query);

             //Timeframe
             $date_time_now = date("Y-m-d H:i:s");
             $start_date = new DateTime($date_time);
             $end_date = new DateTime($date_time_now);
             $interval = $start_date->diff($end_date);
             if($interval->y >= 1) {
                if($inteval == 1)
                    $time_message = $interval->y . " year ago";
                else
                    $time_message = $interval->y . " years ago";
             }
             else if ($interval-> m >= 1) {
                 if($interval->d == 0) {
                     $days = " ago";
                 }
                 else if($interval->d == 1) {
                    $days = $interval->d . " day ago"
                 }
                 else {
                    $days = $interval->d . " days ago"
                 }

                 if($interval->m == 1) {
                     $time_message = $interval->m . " month" . $days;
                 } else {
                    $time_message = $interval->m . " months" . $days;
                 }
             }
             else if($interval->d >= 1) {
                if($interval->d == 1) {
                    $time_message = "Yesterday";
                 }
                 else {
                    $time_message = $interval->d . " days ago"
                 }
             }
             else if($interval->h >= 1) {
                if($interval->h == 1) {
                    $time_message = $interval->h . " hour ago"
                 }
                 else {
                    $time_message = $interval->h . " hours ago"
                 }
             }
             else if($interval->i >= 1) {
                if($interval->i == 1) {
                    $time_message = $interval->i . " minute ago"
                 }
                 else {
                    $time_message = $interval->i . " minutes ago"
                 }
             }
             else ($interval->s < 30) {
                if($interval->s == 1) {
                    $time_message = "Just now";
                 }
                 else {
                    $time_message = $interval->s . " seconds ago"
                 }
             }
        }
    }
}

?>