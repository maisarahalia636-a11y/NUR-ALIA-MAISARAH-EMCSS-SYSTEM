<?php
session_start();
include("config/db.php");

// Sekatan akses keselamatan admin
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Tukar status jadi Rejected
    $update = mysqli_query($conn, "UPDATE mc_submissions SET status='Rejected' WHERE id='$id'");
    
    if($update){
        echo "<script>
            alert('MC status successfully Rejected!');
            window.location.href='admin_dashboard.php';
        </script>";
        exit();
    } else {
        echo "<script>
            alert('Error updating status');
            window.location.href='admin_dashboard.php';
        </script>";
        exit();
    }
} else {
    header("Location: admin_dashboard.php");
    exit();
}
?>