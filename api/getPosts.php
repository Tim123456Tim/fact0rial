<?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        header('Content-type: application/json');

        $connect = mysqli_connect('localhost', 'admin', '0jm2Ne1fWNEY', 'app');

        $limit = 4;

        if (isset($_GET['date'])) {
            $date = $_GET['date'];
            $posts = mysqli_query($connect, "SELECT * FROM posts WHERE date < '" . $date  . "' ORDER BY date DESC LIMIT " . $limit);
        } else {
            $posts = mysqli_query($connect, "SELECT * FROM posts ORDER BY date DESC LIMIT " . $limit);
        }

        if ($posts) {
            $posts_array = array();
            $post = $posts->fetch_assoc();
            while ($post != null) {
                array_push($posts_array, $post);
                $post = $posts->fetch_assoc();
            }
            die(json_encode($posts_array));
        } else {
            die(json_encode(['err' => 1]));
        }

    } else {
         die("Only GET method is allowed.");
    }