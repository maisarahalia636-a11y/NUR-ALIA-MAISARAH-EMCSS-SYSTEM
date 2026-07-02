<?php
session_start();
include("config/db.php");

// Sekatan keselamatan: Kalau student belum login, sekat dari masuk page ni
if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['upload'])){

    $student_id = $_SESSION['id'];

    // 1. Ambil maklumat nama, programme, & email student daripada table 'students'
    $student_info = mysqli_query($conn, "SELECT * FROM students WHERE student_id='$student_id'");
    $student_data = mysqli_fetch_assoc($student_info);
    
    $student_name = mysqli_real_escape_string($conn, $student_data['student_name']);
    $programme = mysqli_real_escape_string($conn, $student_data['programme']);
    $email = mysqli_real_escape_string($conn, $student_data['email']);

    // 2. Ambil data fail
    $fileName = $_FILES['mc_file']['name'];
    $tempName = $_FILES['mc_file']['tmp_name'];
    $fileSize = $_FILES['mc_file']['size']; // Ambil saiz fail

    // 3. SEKATAN SAIZ: Hadkan maksimum 2MB (2 * 1024 * 1024 Bytes)
    $max_size = 2 * 1024 * 1024; 
    if($fileSize > $max_size) {
        echo "<script>
            alert('Error: File size too large! Maximum limit is 2MB.');
            window.history.back();
        </script>";
        exit();
    }

    $folder = "uploads/".$fileName;

    // Proses pindah fail ke folder uploads
    if(move_uploaded_file($tempName, $folder)){
        
        // 4. QUERY BARU: Masukkan sekali data name, programme, email, dan default status 'Pending'
        mysqli_query($conn, "
            INSERT INTO mc_submissions (student_id, student_name, programme, email, mc_file, status)
            VALUES ('$student_id', '$student_name', '$programme', '$email', '$fileName', 'Pending')
        ");

        echo "<script>
            alert('MC Uploaded Successfully! 📃');
            window.location.href='student_dashboard.php';
        </script>";
        exit();
    } else {
        echo "<script>alert('Failed to upload file to server folder.')</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload MC</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container-box">

    <h2>Upload MC 📃</h2>

    <form method="POST" enctype="multipart/form-data">

        <input type="file" name="mc_file" required>

        <button type="submit" name="upload">Upload MC</button>

    </form>

    <p style="text-align:center; margin-top:20px;">
        <a href="student_dashboard.php">Back</a>
    </p>

</div>

</body>
</html>