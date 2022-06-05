<!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <title>The Wu-Tang Clan</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  </head>

  <?php

    //Connect to the database - use these values if you are using my webserver, just change your db name to your own
    $host = "ftp.imminentmachinations.blog"; // My website hosting for those using my cpanel, if you are using your own, just use 127.0.0.1 to indicate your local host
    $user = "imminent_admin"; //Your database username Does not change
    $pass = "E30mthree$$"; // Your database user password
    $db = "imminent_cosw30db"; // Your database name you want to connect to - add your number to the end of this
    $port = 3306; //The port #. It is always 3306

    // Try to make a database connection
    $connection = mysqli_connect($host, $user, $pass, $db, $port); // Catch any connection errors
    if(mysqli_connect_errno()) {
      die("Database connection failed: " . mysqli_connect_error() . " (" .mysqli_connect_errno() . ")");
    }

    // If no errors, you can proceed with your sql queries
  ?>
