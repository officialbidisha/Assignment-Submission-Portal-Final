<?php
session_start();
include("../includes/db.php");
if (isset($_SESSION['username']))
  $username = $_SESSION['username']; //has to be logged in
else
  header("refresh:2; url=login_teacher.php");
$semester = !empty($_GET['sem']) ? $_GET['sem'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="navigation.js"></script>
  <link href="navigation.css" rel="stylesheet" id="naviagtion-css">
  <link rel="stylesheet" href="cardstyles.css">
  <style>
    body {
      background-color: #ededed;
      background-repeat: no-repeat;
      background-position: center;
      background-size: contain;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand navbar-dark bg-primary fixed-top"> <a href="#menu-toggle" id="menu-toggle" class="navbar-brand"><span class="navbar-toggler-icon"></span></a> <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
    <div class="collapse navbar-collapse" id="navbarsExample02">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active"> <a class="nav-link" href="firstteacher.php">Dashboard</a> </li>
      </ul>
      <form class="form-inline my-2 my-md-0"> </form>
    </div>
  </nav>
  <div id="wrapper" class="toggled">
    <div id="sidebar-wrapper">
      <ul class="sidebar-nav">
        <li class="sidebar-brand"> <a href="#"> <?php echo $_SESSION['username'] ?> </a> </li>
        <li> <a href="firstteacher.php">Dashboard</a> </li>
        <li> <a href="assignmentinside.php">Assignments</a> </li>
        <li> <a href="noticeview.php">Notices</a> </li>
        <li> <a href="studyupload.php">Study Material</a> </li>
        <li> <a href="#">Contact</a> </li>
      </ul>
    </div> <!-- /#sidebar-wrapper -->
    <div class="container">
      <div class="p-4"></div>
      <h3 style="text-align:center"> ADD NOTICE</h3>
      <form class="form-inline">
        <div class="form-group">
          <label for="sem">Semester</label>
          <div class="mr-1"></div>
          <input type="number" class="form-control" id="num" value="<?php echo $semester; ?>" name="sem" aria-describedby="semester" placeholder="Enter Semester">
        </div>
        <div class="mr-3"></div>
        <button type="submit" class="btn btn-primary">Search</button>
      </form>
      <?php
      if (isset($_GET["sem"])) {

      ?>
        <form action="" method="post">
          <input name="semester" value="<?php echo $_GET["sem"]; ?>" type="hidden">
          <div class="form-group">
            <label for="exampleFormControlSelect1">Select</label>
            <select class="form-control" name="subject">
              <!---the subject is the variable where the selected item is stored-->


              <?php

              $sem_sub = $_GET["sem"];
              $get_subject = "select * from sem_subject where sem=$sem_sub AND teacher='$username'";

              $run_subject = mysqli_query($con, $get_subject);

              while ($row_subject = mysqli_fetch_array($run_subject)) {

                $subject = $row_subject['subject'];
                echo "<option>$subject</option>";
              }

              ?>
            </select>

          </div>

        <?php
      } else {
        //echo 'Search a semester first';
      }
        ?>
        <div class="form-group">
          <label for="exampleFormControlTextarea1">Write Notice</label>
          <textarea class="form-control rounded-0" name="file" id="exampleFormControlTextarea1" rows="8"></textarea>
        </div>

        <button type="submit" name="post" class="btn btn-primary">Post Notice</button>
        </form>
        <?php

        $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
        $file = isset($_POST['file']) ? $_POST['file'] : '';

        if (isset($_POST['post'])) {
          $sem_sub = $_POST["semester"];
          date_default_timezone_set('Indian/Antananarivo');
          $date = date("Y/m/d");
          if ($sem_sub != "" &&  $file != "" && $subject != "") {
            $query = "INSERT INTO notice(sem,file,subject,date) VALUES('$sem_sub','$file','$subject','$date')";
            $data = mysqli_query($con, $query);

            if ($data) {
              echo "Notice Posted";
            }
          } else {
            echo "All fields required $sem_sub,$file,$subject";
          }
        }
        ?>
    </div>
  </div><!---Wrapper toggled--->
</body>

</html>