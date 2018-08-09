<?php
require_once "inc/db_connect.php";

// URL Shortening Process
// Check if form is submitted
if (isset($_POST['submit']) && isset($_POST['link'])) {

    // Check if URL input field is not empty
    if (!empty($_POST['link'])) {

        // Random String Generation function
        function randomStringGen($length = 5) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';

            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        // Create appropriate shortened variables
        $title = randomStringGen();
        $og_url = $_POST['link'];
        $redirect_url = "http://" . $_SERVER['HTTP_HOST'] . "/" . $title;


        // Create entry in the database
        $query = "INSERT INTO sites VALUES ('{$title}', '{$og_url}', '{$redirect_url}')";
        if (mysqli_query($conn, $query)) {
            echo "Your shortened URL: {$redirect_url}";
        } else {
            echo "An error occured during shortening. Please try again later";
            echo mysqli_error($conn);
        }

    } else {
        $error = "Please type a link to shorten.";
    }
}


// URL Redirection Process
if (isset($_GET['url']) && $_GET['url'] != 'index') {
    $query = "SELECT * FROM sites WHERE title = '{$_GET['url']}'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result)) {
        header('Location: ' . mysqli_fetch_assoc($result)['og_url']);
    } else {
        echo "No such URL exists";
    }
}
?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Shortie | URL Shortener</title>
</head>
<body>

<section id="main">
    <div class="intro">
        <h1>Welcome to Shortie!</h1>
        <h3>Here you can shorten your URLs</h3>
    </div>

    <div class="shorten">
        <form action="index.php" method="post">
            <input type="url" name="link" placeholder="Type a link to shorten">
            <input type="submit" name="submit">
        </form>

        <?php if (isset($error)) { echo $error; } ?>
    </div>
</section>


</body>
</html>