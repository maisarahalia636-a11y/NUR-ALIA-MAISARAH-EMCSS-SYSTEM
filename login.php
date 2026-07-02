<?php
session_start();
include("config/db.php");

$role = isset($_GET['role']) ? $_GET['role'] : 'student';

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);

    // 1. Semak table admins
    $admin_query = mysqli_query(
        $conn,
        "SELECT * FROM admins WHERE email='$email' AND password='$password'"
    );

    if(mysqli_num_rows($admin_query) > 0){
        $_SESSION['admin'] = true;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // 2. Semak table 'students' (Dah ditukar daripada 'users')
        $user_query = mysqli_query(
            $conn,
            "SELECT * FROM students WHERE email='$email' AND password='$password'"
        );

        if(mysqli_num_rows($user_query) > 0){
            $user_data = mysqli_fetch_assoc($user_query);
            $_SESSION['id'] = $user_data['student_id']; 
            $_SESSION['fullname'] = $user_data['student_name']; 
            
            header("Location: student_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid Email or Password');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - eMCSS</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container-box">

    <h2>Welcome Back! 📃</h2>

    <form method="POST" autocomplete="off">

        <input 
            type="email" 
            name="email" 
            placeholder="Email Address" 
            autocomplete="off" 
            required>

        <input 
            type="password" 
            name="password" 
            placeholder="Password" 
            autocomplete="new-password" 
            required>

        <button type="submit" name="login">Login</button>
        
    </form>

    <div style="text-align:center; margin-top:20px; font-size:14px;">
        <?php if($role == 'student') { ?>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        <?php } ?>
        <p style="margin-top:10px;"><a href="index.php" style="color:#888;">← Back to Home</a></p>
    </div>

</div>

</body>
</html>