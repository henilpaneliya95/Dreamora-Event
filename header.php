<?php 
if(!isset($_SESSION)) { session_start(); }
error_reporting(E_ALL & ~E_NOTICE  &  ~E_STRICT  &  ~E_WARNING);
include("dbconnection.php");

$dt = date("Y-m-d");

// Fetch photo of logged-in customer
$customer_image = '';
if (isset($_SESSION['customer_id'])) {
    $customer_id = $_SESSION['customer_id'];
    $qry = mysqli_query($con, "SELECT photo FROM customer WHERE customer_id='$customer_id'");
    $row = mysqli_fetch_array($qry);
    $customer_image = $row['photo'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Event Planner</title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/icofont@1.0.1/icofont.min.css">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.singlePageNav.min.js"></script>
    <script src="js/typed.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap4.min.js"></script>

    <style>
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            color: #fff;
        }

        select[name="status"],
        select[name="status"] option {
            color: black;
        }

        .profile-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid white;
            margin-left: 10px;
            object-fit: cover;
            margin-left: 100%;
        }

        .logo_header {
            padding-left: 5px;
        }

        .profile-container {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .profile-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #ccc;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border-radius: 6px;
            min-width: 180px;
            z-index: 999;
            list-style: none;
            padding: 8px 0;
            margin: 5px 0 0 0;
            margin-left: 700%;
        }

        .dropdown-menu li {
            padding: 10px;
        }

        .dropdown-menu li a {
            text-decoration: none;
            color: #333;
            display: block;
            font-size: 14px;
        }

        .dropdown-menu li a:hover {
            background-color: #fff;
        }

        /* Chatbot Modal */
        /* Floating button */
#chatbot-float {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #3d3d3d;
    color:  #d4a856;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
  box-shadow: 10px 5px 10px  #686363ff;
    font-size: 28px;
    z-index: 1000;
}

/* Popup box */
#chatbot-popup {
    position: fixed;
    bottom: 80px;
    right: 20px;
    width: 350px;
    height: 500px;
    background: white;
    border:2px solid #9a7a3dff;
    border-radius: 10px;
    display: none;
    z-index: 1001;
    box-shadow: 10px 5px 10px rgba(0,0,0,0.3);
    overflow: hidden;
    transition: all 0.3s ease;
}


/* Popup header */
.chatbot-header {
    background: #3d3d3d;
    color: white;
    padding: 8px 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.chatbot-controls button {
    background: none;
    border: none;
    color: white;
    font-size: 18px;
    cursor: pointer;
    margin-left: 8px;
}

/* Iframe */
#chatbot-popup iframe {
    width: 100%;
    height: calc(100% - 35px);
    border: none;
}
        

    </style>
</head>

<body id="top">

    <?php include("menu.php"); ?>

    <!-- start preloader -->
    <div class="preloader">
        <div class="sk-spinner sk-spinner-wave">
            <div class="sk-rect1"></div>
            <div class="sk-rect2"></div>
            <div class="sk-rect3"></div>
            <div class="sk-rect4"></div>
            <div class="sk-rect5"></div>
        </div>
    </div>
    <!-- end preloader -->

    <!-- start header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <p><i class="fa fa-phone"></i><span>Phone</span><a href="tel:+91 6353482102" style='color: black;'>+91 1023456789</a></p>
                </div>
                <div>
                    <p><i class="fa fa-envelope-o"></i><span>Email</span><a href="https://mail.google.com/mail/?view=cm&to=dreamoraevents4@gmail.com" style='color: black;'>dreamoraevents4@gmail.com</a></p> 
                </div>
                <div>
                    <ul class="social-icon">
                        <?php if (isset($_SESSION['customer_id'])) { ?>
                        <li><span class="logo_header"><a href="customer_profile_account.php">My Account</a></span></li>
                        <li><span class="logo_header"><a href="logout.php">Logout</a></span></li>
                        <?php if (!empty($customer_image)) { ?>
                        <li class="profile-container">
                            <img src="uploads/<?php echo $customer_image; ?>" alt="Profile" class="profile-image"
                                title="My Profile">
                            <ul class="dropdown-menu">
                                <li><a href="customeraccount.php">My Account</a></li><br />
                                <li><a href="customer_profile_account.php">Change profile</a></li><br />
                                <li><a href="updatecustpassword.php">Change password</a></li><br />
                                <li><a href="logout.php">Logout</a></li><br />
                            </ul>
                        </li>
                        <script>
                            const profileImg = document.querySelector('.profile-container .profile-image');
                            const dropdownMenu = document.querySelector('.profile-container .dropdown-menu');
                            profileImg.addEventListener('click', function (e) {
                                dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
                                e.stopPropagation();
                            });
                            document.addEventListener('click', function () {
                                dropdownMenu.style.display = 'none';
                            });
                        </script>
                        <?php } ?>
                        <?php } else if (!isset($_SESSION['employee_id'])) { ?>
                        <li><span><a href="custlogin.php">Login</a></span></li>
                        <li><span><a href="register.php">Register</a></span></li>
                        <?php } ?>

                        
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <!-- end header -->

    <!-- Floating Chatbot Icon -->
<div id="chatbot-float" onclick="openChatbot()">
    💬
</div>

<!-- Chatbot Popup -->
<div id="chatbot-popup">
    <div class="chatbot-header">
        <span>Chatbot</span>
        <div class="chatbot-controls">
            <button onclick="toggleFullscreen()">⛶</button>
            <button onclick="closeChatbot()">×</button>
        </div>
    </div>
    <iframe id="chatbot-frame" src="chatbot/index.html"></iframe>
</div>

<style>

</style>


    <!-- start navigation -->
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon icon-bar"></span>
                    <span class="icon icon-bar"></span>
                    <span class="icon icon-bar"></span>
                </button>
                <a href="index.php" class="navbar-brand">Event Planner</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="about.php">ABOUT</a></li>
                    <li><a href="displaylocation.php?selected=Event">EVENT</a></li>
                    <li><a href="displaylocation.php?selected=Photographer">PHOTOGRAPHER</a></li>
                    <li><a href="displaylocation.php?selected=Editography">EDITOGRAPHY</a></li>
                    <li><a href="contact.php">CONTACT</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- end navigation -->

    
<script>
function openChatbot() {
    document.getElementById("chatbot-popup").style.display = "block";
}

function closeChatbot() {
    document.getElementById("chatbot-popup").style.display = "none";
}

// Fullscreen toggle
function toggleFullscreen() {
    let popup = document.getElementById("chatbot-popup");
    if (popup.classList.contains("fullscreen")) {
        popup.classList.remove("fullscreen");
        popup.style.width = "350px";
        popup.style.height = "500px";
        popup.style.bottom = "80px";
        popup.style.right = "20px";
    } else {
        popup.classList.add("fullscreen");
        popup.style.width = "100%";
        popup.style.height = "100%";
        popup.style.bottom = "0";
        popup.style.right = "0";
        popup.style.borderRadius = "0";
    }
}
</script>

</body>
</html>
