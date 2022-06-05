<!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wu-Tang Clan: Loud Records' Directory</title>
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
            <a href="process_dept.php">Add New Department</a>
          </li>

          <li>
          <a href="list_users1.php">Wu-Tang Roster</a>
          </li>
        </ul>
      </nav>
    </header>

    <main>
      <?php
        require('db1.php');

        echo "<h2>Loud Records' Department Directory</h2>";
        // And now the magic begins!
        // create a query & store to $query variable
        $query = "SELECT * FROM DEPARTMENT ORDER BY department_name ASC";

        // Open a db connection and run the query
        $result = mysqli_query($connection, $query);

        echo "<table><thead><td class'center'>Department ID</td><td>Department Name</td><td>Number of Employees</td><td>Building Number</td><td></thead>"; // open table and include table headings 

        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr><td class='center'>" . $row['department_id'] . "</td><td>" . $row['department_name'] . "</td><td>" . $row['num_of_employees'] . "</td><td>" . $row['building_number'] . "</td><td>" . "</td></tr>";
          // echo '<p id="db_results">' . $row['department_id'] ." " . $row['department_name'] ." " .  $row['num_of_employees'] ." " . $row['building_number'] . "</p>";
        }
        echo "</table>"; // close table
      ?>
    </main>

    <footer>
      <p>Created by <strong>Adrian Mauri</strong><br>COSW 30<br>Spring 2022</p>
    </footer>
  </body>
</html>
