<?php
//import the config,php file to establish database connectivity
require('config.php');
//turn on buffer output
ob_start();

//retrive name & email from cookies
// If cookies is empty them redirect to login page
if($_COOKIE['email']==""){
  header("Location: index.php");
}
//If cookies is present then page will load
else{?>
<!DOCTYPE HTML>
<html lang="en" >
<head>
  <title>Approve Request</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">

  <!-- binding CSS with HTML -->
  <link rel="stylesheet" type="text/css" href="style.css">

<!-- restrict user to go back to previous page -->
  <script type = "text/javascript">
      history.pushState(null, null, location.href);
      history.back(); history.forward();
      window.onpopstate = function () { history.go(1); };
  </script>
</head>

<body class="body">
  <!-- logout button division -->
<div class="lable">
    <div class="cssmarquee">
     <h1 style="color:white; font-family:Serif; font-size:160%; font-weight: bold;">Welcome, <?php echo $safename = htmlspecialchars($name);?></h1>
  </div>
</div>
<!-- after logout button lable divide page into 30:70 ratio using section -->
<!-- right align naigation pannel menu-->
 <!-- right align naigation pannel End -->
 <!-- view booking division tag -->
<div id="outPopUp">
    <form action="" method="post" role="form">   
      <!-- initalizing table to display fetch result in tabular form -->
      <table class="table table-bordered" id="myTable">
        <caption style="color:white; font-family:Serif; font-size:160%; font-weight: bold;">Uploaded Files to S3</caption>
        <!-- initalizing table head to display fetch result headings -->
        <thead class="alert-info">
          <tr>
            <th id="student_name">File Name</th>
            <th id="student_email">Date Uploaded</th>
            <th id="student_lecture">Time Uploaded</th>
            <th id="student_lecture">Action</th>
          </tr>
        </thead>
        <!-- initalizing table body containing rows -->
        <tbody>
        <!-- MySQL query to fetch the appointment of professor lecture data from database -->
          <?php

          // If form submitted, insert values into the database.
    $resp = "SELECT * FROM Upload_Files WHERE email=:email";
    $query_params = array(
        ':email' => $_COOKIE['email']
    );
    try {
        $stmt = $db->prepare($resp);
        $result = $stmt->execute($query_params);
}

    catch (PDOException $ex) {
        $response["error"] = true;
        $response["message"] = "Database Error1. Please Try Again!";
        die(json_encode($response));
    }
        if($resp){
            while($fetch = $stmt->fetch())
                {?>
                  <tr style="color:white;">
                    <td><?php echo $fetch['filename']?></td>
                    <td><?php echo $fetch['date']?></td>
                    <td><?php echo $fetch['upload_time']?></td>
                    <!-- execute update operation using Update.php -->
                    <td><a class="button1" href="https://photo-editor.s3.amazonaws.com/<?php echo $fetch['filename']; ?>" data-toggle="tooltip" data-placement=bottom title="Approve">Download</a></td>
                   </tr>
                   <?php }
        }?>
        </tbody>
      </table> 
    </form>
</div>
<!-- Script to flush the stored cookies -->
<script>
  function resetCookie(){
    document.cookie = "lecture" + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/"
    document.cookie = "name" + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/"
    document.cookie = "email" + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/"
  }
</script>
</body>
</html>
<?php }?>
