<!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wu-Tang Clan: New Department Form</title>
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
            <a href="list_departments.php">Loud Records' Directory</a>
          </li>

          <li>
            <a href="list_users1.php">Wu-Tang Roster</a>
          </li>
        </ul>
      </nav>
    </header>

    <main>
      <section>
        <h2>New Department Form</h2>
        <form name="newDept" method="POST" action="process_dept.php">
          <fieldset>
            <p>Please fill out the new department's information.</p>
    
            <label>Department Name</label>
            <input type="text" id="dept_name" name="dept_name" min="5" max="30" placeholder="Department Name" value="<?php
            if (isset($_POST['dept_name'])) 
              echo $_POST['dept_name']; ?>" required><br>
    
            <label>Number of Employees</label>
            <input type="number" id="num_of_employees" name="num_of_employees" min="1" max="30" placeholder="Number of Employees" value="<?php 
            if (isset($_POST['num_of_employees'])) 
              echo $_POST['num_of_employees']; ?>" required><br>
    
            <label>Building Number</label>
            <input type="number" id="building_number" name="building_number" min="1" max="100" placeholder="Building Number" value="<?php 
            if (isset($_POST['building_number'])) 
            echo $_POST['building_number']; ?>" required><br>
    
            <div id="addDept">
              <input type="Submit" value="Add Dept.">
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
          if (empty($_POST['dept_name'])) {
            $errors[] = "You forgot to enter the new department's name.";
          } else {
              $dept_name = trim($_POST['dept_name']);
          }

          //Check for the last name inputted
          if (empty($_POST['num_of_employees'])) {
            $errors[] = 'You forgot to enter the number of employees.';
          } else {
              $num_of_employees = trim($_POST['num_of_employees']);
          }

          // Check for an email address 
          if (empty($_POST['building_number'])) {
            $errors[] = "You forgot to enter the department's building number.";
          } else {
              $building_number = trim($_POST['building_number']);
          }

          // If everything is okay and no errors 
          if (empty($errors)) {
            // Register the user in the database
            //Connect to the db
            require('db1.php'); 

            // Make the query
            $q = "INSERT INTO DEPARTMENT (department_name, num_of_employees, building_number) 
            VALUES ('$dept_name', '$num_of_employees', '$building_number')";

            // Run the query.
            $rq = mysqli_query($connection, $q);

            // If it ran OK
            if ($rq) {
              //Print a message:
              echo '<h2>Thank you!</h2><p>You have now registered the new department!</p><p><br></p>';
            } else {

                // If it did not run OK.

                // Public Message: 
                echo '<h1>System Error</h1><p class="error">We were unable to register your new department. Please try another time.</p>';

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
  