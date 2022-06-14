<!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Troupe Account Directory</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
  </head>

  <body>
    <header>
      <div id="stage_img">
        <img src="img/stage_shot.jpg" alt="Picture of a concert crowd from the stage's standpoint"/>
      </div>
      <h1>Troupe Account Directory</h1>
      <nav>
        <ul>
          <li>
            <a href="troupe_registration.php">Register Account01</a>
          </li>
        </ul>
      </nav>
    </header>

    <main>
      <?php

      // Use require to force this to exist before running any queries
      require('db.php'); // Connect to the db.

      // Make the query:
      //$q = "SELECT CONCAT(last_name, ', ', first_name) AS name, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr FROM users ORDER BY registration_date ASC";
      $q = "SELECT * FROM Troupe ORDER BY user_id ASC";


      $rq = mysqli_query($connection, $q); // Run the query.

      // Count the number of returned rows:
      $num = mysqli_num_rows($rq);

      if ($num > 0) { // If it ran OK, display the records.

        // Table header.
        echo '<table width="60%">
        <thead>
        <tr>
          <th align="left">User ID</th>
          <th align="left">Profile Image</th>
          <th align="left">Username</th>
          <th align="left">Email Address</th>
          <th align="left">Age</th>
          <th align="left">Gender</th>
          <th align="left">City</th>
          <th align="left">State</th>
        </tr>
        </thead>
        <tbody>
      ';

        // Fetch and print all the records:
        while ($row = mysqli_fetch_array($rq)) {
          echo '<tr><td align="left">' . $row['user_id'] . '</td><td align="left">' . '<img src="data:upload/jpeg;charset=utf-8;base64.'.base64_encode($row['profile_img']).'"/>' . '</td><td align="left">' . $row['username'] . '</td><td align="left">' . $row['email_address'] . '</td><td align="left">' . $row['age'] . '</td><td align="left">' . $row['gender'] . '</td><td align="left">' . $row['city'] . '</td><td align="left">' . $row['state'] . '</td></tr>';
        }

        /*
        while ($row = mysqli_fetch_array($rq, MYSQLI_ASSOC)) {
          while ($row = mysqli_fetch_array($rq)) {
            echo '<tr><td align="left">' . $row['user_id'] . '</td><td align="left"><img src="uploads/' . $row['profile_img'] . '"></td><td align="left">' . $row['username'] .'</td><td align="left">' . $row['email_address'] . '</td><td align="left">' . $row['age'] . '</td><td align="left">' . $row['gender'] . '</td><td align="left">' . $row['city'] . '</td><td align="left">' . $row['state'] . '</td></tr>';
          }
        */

        echo '</tbody></table>'; // Close the table.

        mysqli_free_result ($rq); // Free up the resources.

      } else { // If no records were returned.

        echo '<p class="error">There are currently no registered users.</p>';

      }

      mysqli_close($connection); // Close the database connection.

      /*
        // Use require to force this to exist before running any queries
        require('db.php');

        /* Establish a connection to MySQL and select a database and set encoding
        mysqli_set_charset($connection, "utf8");

        // DEFINE QUERY

        // create a query & store to $roster_query variable
        $q = "SELECT * FROM TROUPE ORDER BY user_id ASC VALUES $profile_img, $ea, $un, SHA2('$pwd', 512), $age, $gdr, $city, $ste";

        // Open a db connection and run the query
        $rq = mysqli_query($connection, $q);

        while ($row = mysqli_fetch_assoc($rq)) {
          echo '<div class="card_container">';
          echo '<div class="img_container"><img src="data:image/jpeg;charset=utf-8;base64,'.base64_encode($row['profile_img']).'"/></div>';
          echo '<p class="email_address">' . '<strong>Email:</strong>' . $row['email'] . '</p>';
          echo '<p class="username">' . "@" . $row['username'] . '</p>';
          echo '<p class="age">' . $row['age'] . '</p>'; 
          echo '<p class="gender">' . $row['gender'] . '</p>';
          echo '<p class="city">' . $row['city'] . '</p>';
          echo '<p class="state">' . $row['state'] . '</p></div>';
        }
        mysqli_free_result($rq);
        mysqli_close($connection);

      */
      ?>
    </main>

    <footer>
      <p>Created by <strong>Adrian Mauri</strong><br>COSW 30<br>Spring 2022</p>
    </footer>
  </body>
</html>
