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

 <script src="https://sdk.amazonaws.com/js/aws-sdk-2.119.0.min.js"></script>
</head>

<body class="body">
  <!-- login page layout division-->
<div>
  <div class="form">
      <!-- input filled for name -->
      <input type="file" id="file-chooser" accept="image/*" />
      <button id="upload-button">Upload to S3</button>
    <div id="results"></div>
  </div>
</div>

<script type="text/javascript">
    AWS.config.region = 'us-east-1'; // 1. Enter your region

    AWS.config.credentials = new AWS.CognitoIdentityCredentials({
        IdentityPoolId: 'us-east-1:16d30013-21c8-43db-a456-e022345aacad' // 2. Enter your identity pool
    });

    AWS.config.credentials.get(function(err) {
        if (err) alert(err);
        console.log(AWS.config.credentials);
    });

    var bucketName = 'photo-editor'; // Enter your bucket name
        var bucket = new AWS.S3({
            params: {
                Bucket: bucketName
            }
        });

        var fileChooser = document.getElementById('file-chooser');
        var button = document.getElementById('upload-button');
        var results = document.getElementById('results');
        button.addEventListener('click', function() {

            var file = fileChooser.files[0];

            if (file) {

                results.innerHTML = '';
                var objKey = file.name;
                var params = {
                    Key: objKey,
                    ContentType: file.type,
                    Body: file,
                    ACL: 'public-read'
                };

                bucket.putObject(params, function(err, data) {
                    if (err) {
                        results.innerHTML = 'ERROR: ' + err;
                    } else {
                        listObjs(); // this function will list all the files which has been uploaded
                        //here you can also add your code to update your database(MySQL, firebase whatever you are using)

                    }
                });
            } else {
                alert("Nothing to upload");
            }
        }, false);
        function listObjs() {
            var prefix = 'testing';
            bucket.listObjects({
                Prefix: prefix
            }, function(err, data) {
                if (err) {
                    results.innerHTML = 'ERROR: ' + err;
                } else {
                    var objKeys = "";
                    data.Contents.forEach(function(obj) {
                        objKeys += obj.Key + "<br>";
                    });
                    results.innerHTML = objKeys;
                    alert("File uploaded sucessfully");
                    document.location.href="welcome.php";
                }
            });
        }
        </script>
</body>
</html>
<?php }?>