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
    <div class="container">
      <header>
        <div id="header_img">
          <img src="img/stage_shot.jpg" alt="Picture of a concert crowd from the stage's standpoint"/>
        </div>
        <div id="header_content">
          <h1>Troupe: Account Registration Form</h1>
          <p><a href="troupe_registration.php">Register Account</a></p>
        </div>
      </header>

      <main>
        <?php
          // Use require to force this to exist before running any queries
          require('db.php'); // Connect to the db.

          // Make the query:
          $q = "SELECT * FROM Troupe ORDER BY user_id ASC";

          // Open a db connection and run the query
          $mysqli_result = mysqli_query($connection, $q);

          // Count the number of returned rows:
          $num = mysqli_num_rows($mysqli_result);

          if ($num > 0) { // If it ran OK, display the records.

            // Table header.
            echo '<table>
            <thead>
            <tr>
              <th align="left">Profile Image</th>
              <th align="left">User ID</th>
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

          // Fetch and print all the records
          while ($row = mysqli_fetch_array($mysqli_result, MYSQLI_ASSOC)) {
            echo '<tr><td align="left">' . $row['profile_img'] . '</td><td align="left">' . $row['user_id'] . '</td><td align="left">' . $row['username'] . '</td><td align="left">' . $row['email_address'] . '</td><td align="left">' . $row['age'] . '</td><td align="left">' . $row['gender'] . '</td><td align="left">' . $row['city'] . '</td><td align="left">' . $row['state'] . '</td></tr>';
          }
          /* Fetch and print all the records v.2
          while ($row = mysqli_fetch_array($mysqli_result, MYSQLI_ASSOC)) {
            echo '<tr><td align="left">' . '<img src="data:upload/jpeg;charset=utf-8;base64.'.base64_encode($row['profile_img']).'"/>' . '</td><td align="left">' . $row['user_id'] . '</td><td align="left">' . $row['username'] . '</td><td align="left">' . $row['email_address'] . '</td><td align="left">' . $row['age'] . '</td><td align="left">' . $row['gender'] . '</td><td align="left">' . $row['city'] . '</td><td align="left">' . $row['state'] . '</td></tr>';
          }*/
            echo '</tbody></table>'; // Close the table.
            mysqli_free_result ($mysqli_result); // Free up the resources.
          } else { // If no records were returned.
            echo '<p class="error">There are currently no registered users.</p>';
          }
          mysqli_close($connection); // Close the database connection.

          /*
          // ALTERNATIVE APPROACH

          // Reguire db file
          require('db.php');

          // Make the query:
          $q = "SELECT (profile_img) FROM Troupe WHERE id=1;
          SELECT (username, email_address, password, age, gender, city, state) FROM Troupe ORDER BY user_id ASC";

          $rq = multi_query($connection, $q); // Run the query.
          $image = $row['profile_img']; // Assign profile img result to a variable
          $image_src = "uploads/".$image; // Concatenate $image to aimed path and assign it to a variable

          $num = mysqli_num_rows($rq); // Count the number of returned rows

          if ($num > 0) { // If it ran OK, display the records.

            // Table header.
            echo '<table>
            <thead>
            <tr>
              <th align="left">Profile Img</th>
              <th align="left">User ID</th>
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

            while ($row = mysqli_fetch_array($rq, MYSQLI_ASSOC)) {
              echo '<tr><td align="left">' . '<img src="uploads/' . $image_src . '"></td><td align="left">' . $row['user_id'] . '</td><td align="left">' . $row['username'] .'</td><td align="left">' . $row['email_address'] . '</td><td align="left">' . $row['age'] . '</td><td align="left">' . $row['gender'] . '</td><td align="left">' . $row['city'] . '</td><td align="left">' . $row['state'] . '</td></tr>';
            }
            echo '</tbody></table>'; // Close the table.
            mysqli_free_result ($rq); // Free up the resources.
          } else { // If no records were returned.
            echo '<p class="error">There are currently no registered users.</p>';
          }
          mysqli_close($connection); // Close the database connection.

          */
        ?>
      </main>

      <footer>
        <p>Created by <strong>Adrian Mauri</strong><br>COSW 30<br>Spring 2022</p>
      </footer>
    </div>
  </body>
</html>
