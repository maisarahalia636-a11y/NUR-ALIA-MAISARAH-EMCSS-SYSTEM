<?php
session_start();


if(isset($_SESSION['admin'])){
    header("Location: admin_dashboard.php");
    exit();
}
if(isset($_SESSION['id'])){
    header("Location: student_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>eMCSS - Welcome</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .container-box {
            max-width: 550px !important; 
            width: 90% !important;
            padding: 40px 50px !important; 
            margin: 10% auto !important; 
        }

      
        .logo-container {
            text-align: center;
            margin-bottom: 15px; 
        }
        
        .logo-container img {
            max-width: 120px; 
            height: auto;
        }

        
        .btn-group {
            display: flex;
            gap: 20px;
            margin-top: 35px;
        }
        
        .btn-group a {
            flex: 1;
            text-align: center;
            padding: 15px;
            background: #7db4ff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            transition: background 0.3s, transform 0.1s;
        }
        
        .btn-group a:hover {
            background: #5d9cff;
        }

        .btn-group a:active {
            transform: scale(0.98);
        }
        
        .btn-secondary {
            background: #fff !important;
            color: #7db4ff !important;
            border: 2px solid #7db4ff;
        }
        
        .btn-secondary:hover {
            background: #f0f5ff !important;
        }

        h2 {
            text-align: center !important; 
            font-size: 26px !important;
            margin-bottom: 15px !important;
        }
    </style>
</head>
<body>

<div class="container-box">

    <div class="logo-container">
        <img src="assets/logo-kpm.png" alt="Logo KPM">
    </div>

    <h2>e-MC Submission System 📃</h2>
    <p style="text-align:center; color:#666; font-size: 15px; margin-bottom: 20px;">
        Welcome! Choose your role to continue:
    </p>

    <div class="btn-group">
        <a href="login.php?role=student">Student</a>
        <a href="login.php?role=admin" class="btn-secondary">Admin</a>
    </div>

</div>

</body>
</html>