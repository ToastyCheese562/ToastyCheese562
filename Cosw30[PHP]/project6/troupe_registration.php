<!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Troupe: Account Registration Form</title>
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
          <p><a href="troupe_directory.php">Account Directory</a></p>
        </div>
      </header>

      <main>
        <?php 
          // Check for form submission:
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            require('db.php'); 

            // Initialize an error array.
            $errors = [];

            // Check for image upload
            if (!empty($_FILES["upload"]["name"])) {

              // Get img file info 
              $fileName = basename($_FILES["upload"]["name"]);
              $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
              // Validate whether upload is JPEG or PNG.
              $allowed = array('pjpeg', 'jpeg', 'JPG', 'X-PNG', 'PNG', 'png', 'x-png');

              // Check extension 
              if (in_array($fileType, $allowed)) {
                $upload = $_FILES["upload"]["tmp_name"];
                $profile_img = addslashes(file_get_contents($upload));
              } else {
                $errors[] = 'Error invalid image file type.';
              }
            } else {
              $profile_img = null;
            }

            /*
            // Alternative approach to file upload 
            // Reference: https://makitweb.com/upload-and-store-an-image-in-the-database-with-php/

            // Check for image upload
            if(isset($_POST['submit'])) {
              $profile_img = $_FILES['upload']['profile_img'];
              $target_dir = "uploads/";
              $target_file = $target_dir . basename($_FILES["upload"]["profile_img"]);
            
              // Select file type
              $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
              // Valid file extensions
              $allowed = array("pjpeg", "jpeg", "JPG", "X-PNG", "PNG", "png", "x-png");
            
              // Check extension
              if(in_array($imageFileType,$allowed)) {
                // Upload file
                if(move_uploaded_file($_FILES['upload']['tmp_name'],$target_dir.$profile_img)){
                    // Insert record
                    $q = "INSERT INTO Troupe (profile_img) VALUES('".$profile_img."')";
                    mysqli_query($connection,$q);
                }
            
              }
            }
            */

            // Check for a username 
            if (empty($_POST['username'])) {
              $errors[] = 'You forgot to enter a username.';
            } else {
              $un = mysqli_real_escape_string($connection, trim($_POST['username']));
            }
            
            // Check for an email and authenticate whether it already exists in db:
            if (!empty($_POST['email'])) {
              $check_email = mysqli_query($connection, "SELECT * FROM Troupe WHERE email_address = '".$_POST['email']."'");
              if(mysqli_num_rows($check_email)) {
                $errors[] = 'That email already exists in file. Please enter an email one that has not been taken.';
              } else {
                $ea = mysqli_real_escape_string($connection, trim($_POST['email']));
              }
            } else {
              $errors[] = 'You forgot to enter an email address.';
            }

            // Check for a password and match against the confirmed password:
            if (!empty($_POST['password'])) {
              if ($_POST['password'] != $_POST['confirmPassword']) {
                $errors[] = 'Your two passwords do not match each other. Please re-enter matching passwords.';
              } else {
                $pwd = mysqli_real_escape_string($connection, trim($_POST['password']));
              }
            } else {
              $errors[] = 'You forgot to enter your password.';
            }

            // Check for an age
            if (empty($_POST['age'])) {
              $errors[] = 'You forgot to enter an age.';
            } else {
              $age = trim($_POST['age']);
              //$age = mysqli_real_escape_string($connection, trim($_POST['age']));
            }

            // Check for a gender selection
            if (empty($_POST['gender'])) {
              $errors[] = 'You forgot to make a gender selection.';
            } else {
              $gdr = trim($_POST['gender']);
              //$gdr = mysqli_real_escape_string($connection, trim($_POST['gender']));
            }

            // Check for a city selection
            if (empty($_POST['city'])) {
              $errors[] = 'You forgot to enter a city.';
            } else {
              $city = mysqli_real_escape_string($connection, trim($_POST['city']));
            }

            // Check for a state selection
            if (empty($_POST['state'])) {
              $errors[] = 'You forgot to enter a state.';
            } else {
              $ste = mysqli_real_escape_string($connection, trim($_POST['state']));
            }

            // If everything is okay and no errors 
            if (empty($errors)) {

              // Insert new artist's data

              // Make the query
              $q = "INSERT INTO Troupe (profile_img, username, email_address, password, age, gender, city, state) VALUES ('$profile_img', '$un', '$ea', SHA2('$pwd', 512), '$age', '$gdr', '$city', '$ste')";

              // Run the query.
              $mysqli_result = mysqli_query($connection, $q);

              // If it ran OK
              if ($mysqli_result) {
                
                // BUILD A CONFIRMATION EMAIL

                // Assign the new email to the $to variable
                $to = "{$_POST['email']}";

                // Create a $subject variable
                $subject = "Your New Troupe Account";

                // Create the body:
                $body = "Thank you {$_POST['username']}! Your account was successfully registered with <strong>Troupe</strong. Please verify your email address through the link sent to you.";

                // Limit line count to 70 characters long:
                $body = wordwrap($body, 70);

                // Send the email:
                mail($to, $subject, $body);

                // Print a message:
                echo '<div id="confirmationMsg"><h2>Welcome '.$un.'</h2><p>Thank you for registering with Troupe. An email confirmation letter will be sent to '.$ea.' very shortly. Once received, please verify your email address.</p><p><br></p></div>';

                // Clear $_POST (so that the form's not sticky):
                $_POST = [];

              } else { // If it did not run OK

                // Public Message: 
                echo '<h2>System Error</h2><p class="error">We were unable to process your registration form at the moment. Please try another time.</p>';

                // Debugging message: 
                echo '<p>' . mysqli_error($connection) . '<br><br>Query: ' . $q . '</p>';

              } // End of if ($mysqli_result) conditional

              // Clear $_POST (so that the form's not sticky):
                $_POST = [];

              // Close the db connection
              mysqli_close($connection);

              // Quit the script:
              exit();

            } else { // Report the errors.
              echo '<h2>Error!</h2><p class=”error”>The following error(s) occurred:<br>';
              foreach ($errors as $msg) { // Print each error
                echo " - $msg<br>\n";
              }
              echo '</p><p class=”error”>Please try again.</p><p><br></p>';
            } // End of if (empty($errors)) 

            // Close the db connection
            mysqli_close($connection);
          } // End of the form submission conditional
        ?>

        <section>
          <form enctype="multipart/form-data" name="newArtist" method="POST" action="troupe_registration.php">
            <fieldset>
              <legend>Please fill out all form fields:</legend>

              <p>Select a JPEG or PNG image of 1MB or smaller for profile picture:</p>
              <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
              <p><strong>File:</strong><input type="file" id="upload" name="upload" value="<?php
              if (isset($_POST['upload']))
                echo $_POST['upload']; ?>"></p>

              <label><strong>Username:</strong></label>
              <input type="text" id="username" name="username" value="<?php 
              if (isset($_POST['username'])) 
                echo $_POST['username']; ?>" maxlength="60" required><br>
      
              <label><strong>Email Address:</strong></label>
              <input type="email" id="email" name="email" value="<?php 
              if (isset($_POST['email'])) 
                echo $_POST['email']; ?>" maxlength="60" required><br>

              <label><strong>Password:</strong></label>
              <input type="password" id="password" name="password" value="<?php 
              if (isset($_POST['password'])) 
                echo $_POST['password']; ?>" maxlength="60" required><br>

              <label><strong>Confirm Password:</strong></label>
              <input type="password" id="confirmPassword" name="confirmPassword" value="<?php 
              if (isset($_POST['confirmPassword'])) 
                echo $_POST['confirmPassword']; ?>" maxlength="60" required><br>

              <label><strong>Age:</strong></label>
              <input type="number" id="age" name="age" value="<?php 
              if (isset($_POST['age'])) 
                echo $_POST['age']; ?>" minlength="18" maxlength="110" required><br>

              <label><strong>Gender:</strong></label>
              <select id="gender" name="gender" value="<?php if (isset($_POST['gender'])) 
                echo $_POST['gender']; ?>" required>
                <option>Male</option>
                <option>Female</option>
                <option>Undisclosed</option> 
              </select><br>

              <label><strong>City:</strong></label>
              <input type="text" id="city" name="city" value="<?php 
              if (isset($_POST['city'])) 
                echo $_POST['city']; ?>" minlength="2" maxlength="100" required><br>

              <label><strong>State:</strong></label>
              <input type="text" id="state" name="state" value="<?php 
              if (isset($_POST['state'])) 
                echo $_POST['state']; ?>" minlength="2" maxlength="2" required><br>
            </fieldset>

            <div id="addArtist">
              <input type="Submit" name="submit" value="Add Artist">
            </div>
          </form>
        </section>
      </main>

      <footer>
        <p>Created by <strong>Adrian Mauri</strong><br>COSW 30<br>Spring 2022</p>
      </footer>
    </div>
  </body>
</html>
