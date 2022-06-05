<!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wu-Tang Clan: New Member Form</title>
    <link rel="stylesheet" href="styles1.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  </head>

  <body>
    <header>
      <div class="wutang_gif">
        <img src="img/wutang.gif" alt="Gif of Wu-Tang Clan Members"/>
      </div>
      <h1>Wu-Tang Clan</h1>
      <nav>
        <ul>
          <li id="first_link">
            <a href="list_users1.php">Roster</a>
          </li>

          <li>
            <a href="list_departments.php">Loud Records' Directory</a>
          </li>
        </ul>
      </nav>
    </header>

    <main>
      <section>
        <h2>New Member Form</h2>
        <form name="newMember" method="POST" action="process_user.php">
          <fieldset>
            <p>Please fill out the new member's information.</p>
    
            <label>First Name</label>
            <input type="text" id="first_name" name="first_name" min="2" max="30" placeholder="First Name" value="<?php
            if (isset($_POST['first_name'])) 
            echo $_POST['first_name']; ?>" required><br>
    
            <label>Last Name</label>
            <input type="text" id="last_name" name="last_name" min="2" max="30" placeholder="Last Name" value="<?php 
            if (isset($_POST['last_name'])) 
            echo $_POST['last_name']; ?>" required><br>
    
            <label>Email Address</label>
            <input type="email" id="email" name="email" placeholder="Email Address" value="<?php 
            if (isset($_POST['email'])) 
            echo $_POST['email']; ?>" required><br>
    
            <div id="addMember">
              <input type="Submit" value="Add Member">
            </div>
          </fieldset>
        </form>
      </section>
      
      <!-- Set up php up -->

      <?php
        /*require('db1.php'); */

        // Establish a connection to MySQL and select a database and set encoding
        mysqli_set_charset($connection, "utf8");

        // This script will perform an INSERT query to add a record to the users table.

        //Check for form submisstion
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $errors = []; // Initialize an error array.

          //Check for the first name inputted
          if (empty($_POST['first_name'])) {
            $errors[] = 'You forgot to enter your first name.';
          } else {
              $first_name = trim($_POST['first_name']);
          }

          //Check for the last name inputted
          if (empty($_POST['last_name'])) {
            $errors[] = 'You forgot to enter your last name.';
          } else {
              $last_name = trim($_POST['last_name']);
          }

          // Check for an email address 
          if (empty($_POST['email'])) {
            $errors[] = 'You forgot to enter your email address.';
          } else {
              $email = trim($_POST['email']);
          }

          // If everything is okay and no errors 
          if (empty($errors)) {
            // Register the user in the database
            //Connect to the db
            require('db1.php'); 

            // Make the query
            $q = "INSERT INTO USER2 (first_name, last_name, email_address) 
            VALUES ('$first_name', '$last_name', '$email')";

            // Run the query.
            $rq = mysqli_query($connection, $q);

            // If it ran OK
            if ($rq) {
              //Print a message:
              echo '<h2>Thank you!</h2><p>You have now registered the new member!</p><p><br></p>';
            } else {

                // If it did not run OK.

                // Public Message: 
                echo '<h1>System Error</h1><p class="error">We were unable to process your new member registration form. Please try another time.</p>';

                // Debugging message: 
                echo '<p>' . mysqli_error($connection) . '<br><br>Query: ' . $q . '</p>';
            } // End of if ($rq) IF
            
            // Close the db connection
            mysqli_close($connection);

            // Quit the script:
            exit();

          } else { // Report the errors.

              echo '<h2>Error!</h2><p class=”error”>The following error(s) occurred:<br>';
              foreach ($errors as $msg) { // Print each error.
                echo " - $msg<br>\n";
              }
              echo '</p><p>Please try again.</p><p><br></p>';

          } // End of if (empty($errors)) IF.  
        } // End of the main Submit conditional.
      ?>
    </main>

    <footer>
      <p>Created by <strong>Adrian Mauri</strong><br>COSW 30<br>Spring 2022</p>
    </footer>
  </body>
</html>