<?php
include("config/db.php");

if(isset($_POST['register'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $student_name = mysqli_real_escape_string($conn, $_POST['student_name']);
    $programme = mysqli_real_escape_string($conn, $_POST['programme']);
    $password = md5($_POST['password']);

    // BARIS 13: Dah ditukar ke table 'students'
    $check = mysqli_query($conn, "SELECT * FROM students WHERE email='$email' OR student_id='$student_id'");

    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('Email or Student ID already exists')</script>";
    }
    else{
        // Dah ditukar ke table 'students' juga
        mysqli_query($conn, 
            "INSERT INTO students (student_id, student_name, programme, email, password) 
             VALUES ('$student_id', '$student_name', '$programme', '$email', '$password')"
        );

        echo "<script>
            alert('Registration successful! Click OK to login.');
            window.location.href='login.php?role=student';
        </script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register 📃</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container-box">

    <h2>Register 📃</h2>

    <form method="POST" autocomplete="off">
        
        <input 
            type="text" 
            name="student_name" 
            placeholder="Full Name" 
            autocomplete="off" 
            required>

        <input 
            type="email" 
            name="email" 
            placeholder="Email Address" 
            autocomplete="off" 
            required>

        <input 
            type="text" 
            name="student_id" 
            placeholder="Student ID" 
            autocomplete="off" 
            required>

        <input 
            type="text" 
            name="programme" 
            placeholder="Programme" 
            autocomplete="off" 
            required>

        <input 
            type="password" 
            name="password" 
            placeholder="Password" 
            autocomplete="new-password" 
            required>

        <button type="submit" name="register">Register</button>
    </form>

    <p style="text-align:center; margin-top:20px; font-size:14px;">
        Already have an account? <a href="login.php?role=student">Login here</a>
    </p>

</div>

</body>
</html>