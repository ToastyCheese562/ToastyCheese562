<!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wu-Tang Clan: Edit Department</title>
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
            <a href="list_depts.php">Loud Records' Directory</a>
          </li>

          <li>
            <a href="add_dept.php">Add New Department</a>
          </li>

          <li>
            <a href="list_users.php">Group Roster</a>
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

          $department_id = $_POST['department_id'];
          $department_name = $_POST['department_name'];
          $num_of_employees = $_POST['num_of_employees'];
          $building_number = $_POST['building_number'];
          $status = $_POST['status'];

          $update_dept_query =
            "UPDATE DEPARTMENT
            SET department_name = '$department_name',
            num_of_employees = $num_of_employees,
            building_number = $building_number,
            status = '$status'
            WHERE department_id = $department_id";
  
          // echo $update_dept_query;

          $update_dept_result = mysqli_query($connection, $update_dept_query);
          if ($update_dept_result) {
            // Success 
            //redirect_to("list_depts.php?msg=ok");
            header("Location: list_depts.php?msg=ok");
            //echo "Record has been successfully updated.";
            exit;
          } else {
            // Faliure
            echo "Update has failed.";
          }
          //exit("Testing");
        } else {
          $department_id = $_GET['id'];
          //original variable: $query
          $dept_query = "SELECT * FROM DEPARTMENT WHERE department_id = $department_id";

          // USER TESTING
          //echo $department_id;
          //echo $dept_query;

          $dept_result = mysqli_query($connection, $dept_query);
          $row = mysqli_fetch_array($dept_result);
        }
      ?>

      <h2>Update Department</h2>
      <form name="updateDept" action="edit_dept.php" method="POST">
        <fieldset>
          <p>Please make your appropriate alterations.</p>

          <input type="hidden" id="department_id" name="department_id" value="<?php echo $row['department_id']; ?>"><br>

          <label>Department Name: <input type="text" id="department_name" name="department_name" value="<?php echo $row['department_name']; ?>" required><br></label>
          
          <label>Number of Employees: <input type="number" id="num_of_employees" name="num_of_employees" min="1" max="300" value="<?php echo $row['num_of_employees']; ?>" required><br></label>
          
          <label>Building Number: <input type="number" id="building_number" name="building_number" min="1" max="100" value="<?php echo $row['building_number']; ?>"><br></label>

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
