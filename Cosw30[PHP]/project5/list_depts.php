<!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wu-Tang Clan: Loud Records' Directory</title>
    <link rel="stylesheet" href="styles.css">
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
            <a href="add_dept.php">Add New Department</a>
          </li>

          <li>
          <a href="list_users.php">Wu-Tang Roster</a>
          </li>
        </ul>
      </nav>
    </header>

    <main>
      <?php
        // Use require to force this to exist before running any queries
        require('db.php');

        echo "<h2>Loud Records' Department Directory</h2>";

        if(isset($_GET['msg'])) {
          // if msg exists, then create feedback
          echo "<h4>Your Record Updated Successfully</h4>";
        }

        // create a query & store to $dept_query variable
        $dept_query = "SELECT * FROM DEPARTMENT ORDER BY department_id ASC";

        // Open a db connection and run the query
        $dept_result = mysqli_query($connection, $dept_query);

        echo "<table id='dept_table'><thead><td class'center'>Department ID</td><td>Department Name</td><td>Number of Employees</td><td>Building Number</td><td>Status</td><td>Actions</td></thead>"; // open table and include table headings 

        while ($row = mysqli_fetch_assoc($dept_result)) {
          echo "<tr><td class='center'>" . $row['department_id'] . "</td><td>" . $row['department_name'] . "</td><td>" . $row['num_of_employees'] . "</td><td>" . $row['building_number'] . "</td><td>" . $row['status'] . "</td><td><a class='edit_link' href='edit_dept.php?id=" .$row['department_id'] . "'>Edit</a></td></tr>";
        }
        echo "</table>"; // close table
      ?>
    </main>

    <footer>
      <p>Created by <strong>Adrian Mauri</strong><br>COSW 30<br>Spring 2022</p>
    </footer>
  </body>
</html>
