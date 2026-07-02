<?php
session_start();
include("config/db.php");

// Pastikan student dah login, kalau tak tendang pergi login page
if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard - eMCSS</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        /* CONTAINER UTAMA: Dinaikkan ke 1200px supaya kotak jadi lebih lebar dan besar */
        .dashboard-container {
            max-width: 1200px !important; 
            width: 95% !important;
            margin: 3% auto !important;
        }

        /* Styling Logo KPM yang dah dibesarkan */
        .logo-wrapper {
            text-align: center;
            margin-bottom: 30px; /* Jarak bawah logo dibesarkan sikit */
        }
        
        .logo-wrapper img {
            max-height: 130px; /* DAH DIBESARKAN (Asal 80px) */
            width: auto;
        }

        /* Container welcome yang dibesarkan ruang dalamnya */
        .welcome-box {
            background: white;
            padding: 35px 50px; /* Tingkatkan padding supaya kotak nampak lebih besar & tebal */
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.03);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
        }

        .welcome-box h1 {
            color: #4a74b4;
            font-size: 28px; /* Besarkan font tulisan Welcome */
            margin: 0;
        }

        .logout-btn {
            color: #7db4ff;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px; /* Besarkan tulisan logout */
            transition: color 0.2s;
        }

        .logout-btn:hover {
            color: #5d9cff;
        }

        /* Susunan kad bawah yang menggunakan jarak (gap) */
        .cards-wrapper {
            display: flex;
            gap: 35px; /* Jarak antara dua kad dibesarkan sikit */
            width: 100%;
        }

        /* Reka bentuk dua kad menu bawah yang dibesarkan */
        .menu-card {
            flex: 1;
            background: white;
            padding: 40px; /* Tingkatkan padding dalam kad supaya nampak luas */
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.03);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card-upload {
            background: #e3efff; 
        }

        .menu-card h3 {
            color: #4a74b4;
            font-size: 24px; /* Besarkan tajuk kad */
            margin-top: 0;
            margin-bottom: 15px;
        }

        .menu-card p {
            color: #555;
            font-size: 16px; /* Besarkan teks penerangan */
            margin-bottom: 30px;
            line-height: 1.5;
        }

        .menu-card a.open-link {
            color: #7db4ff;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px; /* Besarkan pautan Open */
            display: inline-block;
        }

        .menu-card a.open-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="dashboard-container">

    <div class="logo-wrapper">
        <img src="assets/logo-kpm.png" alt="Logo KPM">
    </div>

    <div class="welcome-box">
        <h1>Welcome, <?php echo $_SESSION['fullname']; ?> 📃</h1>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="cards-wrapper">
        
        <div class="menu-card card-upload">
            <h3>Upload MC</h3>
            <p>Submit your MC online easily.</p>
            <a href="upload_mc.php" class="open-link">Open</a>
        </div>

        <div class="menu-card">
            <h3>Check Status</h3>
            <p>View MC approval status.</p>
            <a href="view_status.php" class="open-link">Open</a>
        </div>

    </div>

</div>

</body>
</html>