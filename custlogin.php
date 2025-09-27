<?php
error_reporting(E_ALL & ~E_NOTICE  &  ~E_STRICT  &  ~E_WARNING);
$con = mysqli_connect("localhost", "root", "", "eventplanner");
echo mysqli_connect_error();
?>
<?php
include("header.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Login with Instant Image Preview</title>
  <style>
.login_box{
  padding-left: 39%;
  padding-top: 5%;

}
    .login-container {
      width: 350px;
      background: #3d3d3d; 
      padding: 30px 40px;
      border-radius: 10px;
      box-shadow:  10px 10px 5px lightgray;
    }
    .login-container:hover {
      background:  #3d3d3d;
      cursor: pointer;
      box-shadow:  10px 10px 5px #faf7f3;

    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 15px;
      color: #d4a856;
    }

    #preview {
      text-align: center;
      margin-bottom: 15px;
    }

    .profile-img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      display: none;
      margin: 0 auto;
      border: 2px solid #eed6b3;
    }

    .login-container label {
      font-weight: bold;
      color: #eed6b3;
      margin-bottom: 5px;
      display: block;
    }

    .login-container input[type="text"],
    .login-container input[type="password"] {
      width: 100%;
      padding: 10px 12px;
      margin-bottom: 20px;
      border: 1px solid #eed6b3;
      border-radius: 5px;
      box-sizing: border-box;
      transition: border-color 0.3s ease;
      box-shadow: 05px 05px 0px #5b5a5aff;
    }

    .login-container input[type="text"]:focus,
    .login-container input[type="password"]:focus {
      border-color: #d4a856;
      outline: none;
      box-shadow: 05px 05px 0px #5b5a5aff;
    }

    .login-container input[type="submit"] {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 5px;
      background: linear-gradient(135deg, #d4a373, #eed6b3);
      color: black;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
      box-shadow: 05px 05px 0px #5b5a5aff;
    }

    .login-container input[type="submit"]:hover {
      background-color: #d4a373;
      box-shadow: 0px 0px 0px #5b5a5aff;
   
    }
  </style>
</head>
<body>
  <div class="login_box">
  <div class="login-container">
    <h2>Login</h2>

    <!-- 👇 Image preview now just below h2 -->
    <div id="preview">
      <img id="userImage" class="profile-img" src="">
    </div>

    <form method="post" action="login_action.php" autocomplete="off">
      <label for="email_id">Email ID:</label>
      <input type="text" name="email_id" id="email_id" required autocomplete="off">

      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required autocomplete="new-password">

      <input type="submit" name="submit" value="Login">
    </form>
  </div></div>

  <script>
    document.getElementById("email_id").addEventListener("input", function () {
      var email = this.value;

      if (email.length >= 5) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "fetch_image.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
          if (this.status === 200) {
            var response = this.responseText.trim();
            if (response !== "NOT_FOUND") {
              document.getElementById("userImage").src = "uploads/" + response;
              document.getElementById("userImage").style.display = "block";
            } else {
              document.getElementById("userImage").style.display = "none";
            }
          }
        };
        xhr.send("email_id=" + encodeURIComponent(email));
      } else {
        document.getElementById("userImage").style.display = "none";
      }
    });
  </script>
  
</body>
</html>
<br/>
<br/>
<br/>
<br/> 
<?php
include("footer.php")
?>