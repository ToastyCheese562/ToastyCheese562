<!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wu-Tang Clan: Roster</title>
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
          <li>
            <a href="add_user.php">Add New Member</a>
          </li>

          <li>
            <a href="list_depts.php">Loud Records' Directory</a>
          </li>
        </ul>
      </nav>
    </header>

    <main>
      <?php
        // Use require to force this to exist before running any queries
        require('db.php');

        echo "<h2>Roster</h2>";

        if(isset($_GET['msg'])) {
          // if msg exists, then create feedback
          echo "<h4>Your Record Updated Successfully</h4>";
        }

        // PAGINATING & DISPLAYING RECORDS 

        // Use variable to display the number of records
        $display = 5;
        
        // Determine how many pgs are there
        if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
          $pages = $_GET['p'];
        } else { // Need to determine.

          // Count the number of records
          $roster_query = "SELECT COUNT(user_id) FROM USER2";
          $roster_result = mysqli_query($connection, $roster_query);
          $row = mysqli_fetch_array($roster_result, MYSQLI_NUM);
          $records = $row[0];
          
          // Calculate the number of pgs required
          if ($records > $display) { // More than 1 pg
            $pages = ceil ($records/$display);
          } else {
            $pages = 1;
          }

        } // End of p IF

        // Determine the starting point in the db
        if (isset($_GET['s']) && is_numeric($_GET['s'])) {
          $start = $_GET['s'];
        } else {
          $start = 0;
        }

        // Determine the sort..
        // Default is by user id.
        $sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'user_id';

        // Determine the sorting order:
        switch ($sort) {
          case 'ln':
            $order_by = 'last_name ASC';
            break;
          case 'ea':
            $order_by = 'email_address ASC';
            break;
          default:
            $order_by = 'user_id ASC';
            $sort = 'ui';
            break;
        }

        // DEFINE QUERY

        // create a query & store to $roster_query variable
        $roster_query = "SELECT * FROM USER2 ORDER BY $order_by LIMIT $start, $display";

        // Open a db connection and run the query
        $roster_result = mysqli_query($connection, $roster_query);

        
        echo "<table id='roster_table'><thead><td class'center'>User ID</td><td>First Name</td><td><strong><a href='list_users.php?sort=ln'>Last Name</a></strong></td><td><strong><a href='list_users.php?sort=ea'>Email Address</a></strong></td><td>Status</td><td>Actions</td></thead>"; // open table and include table headings

        
        while ($row = mysqli_fetch_assoc($roster_result)) {
          echo "<tr><td class='center'>" . $row['user_id'] . "</td><td>" . $row['first_name'] . "</td><td>" . $row['last_name'] . "</td><td>" . $row['email_address'] . "</td><td>" . $row['status'] . "</td><td><a class='edit_link' href='edit_users.php?id=" .$row['user_id'] . "'>Edit</a></td></tr>";
        } 
        echo "</table>"; // close table
        mysqli_free_result($roster_result);
        mysqli_close($connection);
        


        /*
        echo "<table id='roster_table'><thead><td class'center'>User ID</td><td>First Name</td><td><strong><a href='list_users.php?sort=ln'>Last Name</a></strong></td><td id='email_box'><strong><a href='list_users.php?sort=ea'>Email Address</a></strong></td><td>Status</td><td>Actions</td></thead>"; // open table and include table headings 

        
        // My attempt to offset table bg colors

        $bg = '#eeeeee'; // Set the initial bg color.
        while ($row = mysqli_fetch_array($roster_result, MYSQLI_ASSOC)) {
          $bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // Switch the bg color.
          echo '<tr bgcolor="' . $bg . '"><td class="center">' . $row['user_id'] . '</td><td>' . $row['first_name'] . '</td><td>' . $row['last_name'] . '</td><td>' . $row['email_address'] . '</td><td>' . $row['status'] . '</td><td><a class="edit_link" href="edit_users.php?id=' . $row['user_id'] . '">Edit</a></td></tr>';
        } 
        echo '</table>'; // close table
        mysqli_free_result($roster_result);
        mysqli_close($connection);
        */


        // Make the links to other pages, if necessary.
        if ($pages > 1) {  
          // Add some spacing and start a paragraph:
          echo '<br><p>';
        
          // Determine what page the script is on:
          $current_page = ($start/$display) + 1;

          // If it's not the first page, make a Previous link:
          if ($current_page != 1) {
            echo '<a href="list_users.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
          }
        
          // Make all the numbered pages:
          for ($i = 1; $i <= $pages; $i++) {
            if ($i != $current_page) {
              echo '<a href="list_users.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
            } else {
              echo $i . ' ';
            }
          } // End of FOR loop.
                
          // If it's not the last page, make a Next button:
          if ($current_page != $pages) {
              echo '<a href="list_users.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next<a>';
          }
          echo '</p>'; // Close the paragraph.
        } // End of links section.
      ?>
    </main>

    <footer>
      <p>Created by <strong>Adrian Mauri</strong><br>COSW 30<br>Spring 2022</p>
    </footer>
  </body>
</html>
