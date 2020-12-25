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
  <title>Sign Up</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <!-- binding CSS with HTML -->
  <link rel="stylesheet" type="text/css" href="login_signup_style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>

</head>

<body class="body">
  <!-- login page layout division-->
<div>
  <div class="form">
    <form action= "editor.html" role="form">
      <!-- Redirect to editor -->
      <button type="submit" value="editor">Open Image Editor</button>
    </form>

    <form action= "upload.php" role="form">
      <!-- Redirect to upload -->
      <button type="submit" value="upload">Upload Edited Image</button>
    </form>

    <form action= "Download.php" role="form">
      <!-- Redirect to download -->
      <button type="submit" value="download">Download Edited Image</button>
    </form>

    <form action= "index.php" onclick="resetCookie()">
      <!-- Redirect to index after logout -->
      <button type="submit" value="logout" style="background-color:red;">Logout</button>
    </form>
  </div>
</div>
<script>
  function resetCookie(){
    document.cookie = "email" + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/"
  }
</script>
</body>
</html>
<?php }?>
