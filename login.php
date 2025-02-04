<?php
    session_start();

    include("db.php");

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        if(isset($_POST['register'])) {
            // Registration process
            $firstname = mysqli_real_escape_string($con, $_POST['fname']);
            $lastname = mysqli_real_escape_string($con, $_POST['lname']);
            $gmail = mysqli_real_escape_string($con, $_POST['mail']);
            $password = mysqli_real_escape_string($con, $_POST['pass']);

            if(!empty($firstname) && !empty($lastname) && !empty($gmail) && !empty($password)) {
                // Proceed with registration
                $query = "INSERT INTO form (fname, lname, mail, pass) VALUES ('$firstname', '$lastname', '$gmail', '$password')";
                if(mysqli_query($con, $query)) {
                    echo "<script type='text/javascript'> alert('Successfully Registered!')</script>";
                } else {
                    echo "<script type='text/javascript'> alert('Registration Failed!')</script>";
                }
            } else {
                echo "<script type='text/javascript'> alert('Please enter valid information!')</script>";
            }
        } elseif(isset($_POST['login'])) {
            // Login process
            $gmail = mysqli_real_escape_string($con, $_POST['mail']);
            $password = mysqli_real_escape_string($con, $_POST['pass']);

            if(!empty($gmail) && !empty($password)) {
                // Proceed with login
                $query = "SELECT * FROM form WHERE mail = '$gmail' LIMIT 1";
                $result = mysqli_query($con, $query);

                if($result && mysqli_num_rows($result) > 0) {
                    $user_data = mysqli_fetch_assoc($result);

                    if(password_verify($password, $user_data['pass'])) {
                        $_SESSION['user_id'] = $user_data['id'];
                        header("Location: index.php");
                        exit();
                    } else {
                        echo "<script type='text/javascript'> alert('Wrong Password')</script>";
                    }
                } else {
                    echo "<script type='text/javascript'> alert('User not found')</script>";
                }
            } else {
                echo "<script type='text/javascript'> alert('Please enter valid information!')</script>";
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" href="login.html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Ludiflex | Login & Registration</title>
</head>
<body>
 <div class="wrapper">
    <nav class="nav">
        <div class="nav-logo">
        <!--logo-->
        </div>
        <div class="nav-menu" id="navMenu">
            <ul>
                <li><a href="#" class="link active">Home</a></li>
                <li><a href="why.php" class="link">Why minute burger?</a></li>
                <li><a href="#" class="link">About Us</a></li>
                <li><a href="#" class="link">Gallery</a></li>
            </ul>
        </div>
        <div class="nav-button">
            <button class="btn white-btn" id="loginBtn" onclick="login()">Sign In</button>
            <button class="btn" id="registerBtn" onclick="register()">Sign Up</button>
        </div>
        <div class="nav-menu-btn">
            <i class="bx bx-menu" onclick="myMenuFunction()"></i>
        </div>
    </nav>
<!----------------------------- Form box ----------------------------------->    
    <form class="form-box" method="POST">
        
        <!------------------- login form -------------------------->
        <div class="login-container" id="login">
            <header>Login</header>
    <div class="input-box">
        <input type="text" class="input-field" placeholder="Username" name="mail">
        <i class="bx bx-user"></i>
    </div>
    <div class="input-box">
        <input type="password" class="input-field" placeholder="Password" name="pass">
        <i class="bx bx-lock-alt"></i>
    </div>
    <div class="input-box">
        <input type="submit" class="submit" value="Sign In" name="login">
    </div>  
            <div class="two-col">
                <div class="one">
                    <input type="checkbox" id="login-check">
                    <label for="login-check"> Remember Me</label>
                </div>
                <div class="two">
                    <label><a href="#">Forgot password?</a></label>
                </div>
            </div>
            <div class="top">
                <span>Don't have an account? <a href="#" onclick="register()">Sign Up</a></span>
            
            </div>
        </div>
        <!------------------- registration form -------------------------->
        <div class="register-container" id="register">
            <header>Sign Up</header>
            <div class="two-forms">
                <div class="input-box">
                    <input type="text" class="input-field" placeholder="Firstname" name="fname">
                    <i class="bx bx-user"></i>
                </div>
                <div class="input-box">
                    <input type="text" class="input-field" placeholder="Lastname" name="lname">
                    <i class="bx bx-user"></i>
                </div>
            </div>
            <div class="input-box">
                <input type="text" class="input-field" placeholder="Email" name="mail">
                <i class="bx bx-envelope"></i>
            </div>
            
            <div class="input-box">
                <input type="password" class="input-field" placeholder="Password" name="pass">
                <i class="bx bx-lock-alt"></i>
            </div>
            <div class="input-box">
                <input type="submit" class="submit" value="Register">
            </div>
            <div class="two-col">
                <div class="one">
                    <input type="checkbox" id="register-check">
                    <label for="register-check"> Remember Me</label>
                </div>
                <div class="two">
                    <label><a href="#">Terms & conditions</a></label>
                </div>
            </div>
            <div class="top">
                <span>Have an account? <a href="#" onclick="login()">Login</a></span>
            </div>
        </div>
    </div>
</form>   
<script>
   
   function myMenuFunction() {
    var i = document.getElementById("navMenu");
    if(i.className === "nav-menu") {
        i.className += " responsive";
    } else {
        i.className = "nav-menu";
    }
   }
 
</script>
<script>
    var a = document.getElementById("loginBtn");
    var b = document.getElementById("registerBtn");
    var x = document.getElementById("login");
    var y = document.getElementById("register");
    function login() {
        x.style.left = "4px";
        y.style.right = "-520px";
        a.className += " white-btn";
        b.className = "btn";
        x.style.opacity = 1;
        y.style.opacity = 0;
    }
    function register() {
        x.style.left = "-510px";
        y.style.right = "5px";
        a.className = "btn";
        b.className += " white-btn";
        x.style.opacity = 0;
        y.style.opacity = 1;
    }
</script>
</body>
</html>