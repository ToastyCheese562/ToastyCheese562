<!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wu-Tang Clan: Edit Member</title>
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
            <a href="list_users.php">Roster</a>
          </li>

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
        require("db.php"); 
      ?>

      <?php 
        // if this form has been submitted, do the update proc_get_status
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

          // print_r($_POST);

          $user_id = $_POST['user_id'];
          $first_name = $_POST['first_name'];
          $last_name = $_POST['last_name'];
          $email_address = $_POST['email_address'];
          $status = $_POST['status'];

          // original variable: $update_query =
          $update_member_query =
            "UPDATE USER2
            SET email_address = '$email_address', 
            first_name = '$first_name',
            last_name = '$last_name',
            status = '$status'
            WHERE user_id = $user_id";
  
          // echo $update_member_query;

          // original variable: $update_result = mysqli_query($connection, $update_query)
          $update_member_result = mysqli_query($connection, $update_member_query);
          if ($update_member_result) {
            // Success 
            //redirect_to("list_users.php?msg=ok");
            header("Location: list_users.php?msg=ok");
            //echo "Record has been successfully updated.";
            exit;
          } else {
            // Faliure
            echo "Update has failed.";
          }
          //exit("Testing");
        } else {
          $user_id = $_GET['id'];
          // original variable: $query
          $roster_query = "SELECT * FROM USER2 WHERE user_id = $user_id";

          // USER TESTING
          //echo $user_id;
          //echo $roster_query;

          // original variable: $result
          $roster_result = mysqli_query($connection, $roster_query);
          $row = mysqli_fetch_array($roster_result);
        }
      ?>

      <h2>Update Existing Member</h2>
      <form name="updateMember" action="edit_users.php" method="POST">
        <fieldset>
          <p>Please make your appropriate alterations.</p>

          <input type="hidden" id="user_id" name="user_id" value="<?php echo $row['user_id']; ?>"><br>

          <label>First Name: <input type="text" id="first_name" name="first_name" value="<?php echo $row['first_name']; ?>" required><br></label>
    
          <label>Last Name: <input type="text" id="last_name" name="last_name" value="<?php echo $row['last_name']; ?>" required><br></label>
    
          <label>Email Address: <input type="email" id="email_address" name="email_address" value="<?php echo $row['email_address']; ?>" required><br></label>

          <label>Status:</label>
          <select id="status" name="status" value="<?php echo $row['status']; ?>" required>
            <option>A</option>
            <option>I</option> 
          </select>
    
          <div id="Update">
            <input type="Submit" value="Update">
          </div>
        </fieldset>
      </form>
    </main>

    <footer>
      <p>Created by <strong>Adrian Mauri</strong><br>COSW 30<br>Spring 2022</p>
    </footer>
  </body>
</html>
