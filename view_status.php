<?php
session_start();
include("config/db.php");


if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}


$current_student_id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>My MC Status</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .status-box {
            max-width: 700px !important; 
            width: 90% !important;
            padding: 40px 45px !important;
            margin: 6% auto !important;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        /* Rekabentuk table status yang kemas */
        .status-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            margin-bottom: 15px;
            font-size: 15px;
        }

        .status-table th, .status-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .status-table th {
            background-color: #f7fafc;
            color: #4a6fa5;
            font-weight: bold;
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 30px;
            font-weight: bold;
            font-size: 13px;
            text-align: center;
        }

        .approved { background: #d4edda; color: #155724; }
        .rejected { background: #f8d7da; color: #721c24; }
        .pending { background: #fff3cd; color: #856404; }

        .empty-message {
            text-align: center;
            padding: 30px 20px;
            color: #718096;
            font-size: 15px;
            line-height: 1.6;
        }

        .btn-upload-now {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #7db4ff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background 0.2s;
        }

        .btn-upload-now:hover {
            background-color: #5d9cff;
        }

        .btn-back {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #888;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-back:hover {
            color: #5d9cff;
        }

        h2 {
            font-size: 26px !important;
            text-align: center !important;
            margin-bottom: 5px !important;
        }
    </style>
</head>
<body>

<div class="container-box status-box">

    <h2>My MC History 📃</h2>
    <p style="text-align:center; color:#666; font-size: 14px;">
        Logged in as: <strong><?php echo $_SESSION['fullname']; ?></strong> (<?php echo $current_student_id; ?>)
    </p>

    <?php
    
    $query = mysqli_query(
        $conn,
        "SELECT * FROM mc_submissions WHERE student_id='$current_student_id' ORDER BY id DESC"
    );

    if(mysqli_num_rows($query) > 0){
    ?>
        <table class="status-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Document</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while($row = mysqli_fetch_assoc($query)){ 
                    $badge_class = "pending";
                    if($row['status'] == "Approved") { $badge_class = "approved"; }
                    if($row['status'] == "Rejected") { $badge_class = "rejected"; }
                ?>
                <tr>
                    <td><?php echo date('d M Y', strtotime($row['submission_date'])); ?></td>
                    <td>
                        <a target="_blank" href="uploads/<?php echo $row['mc_file']; ?>" style="color:#5d9cff; font-weight:bold; text-decoration:underline;">
                            View File
                        </a>
                    </td>
                    <td>
                        <span class="badge <?php echo $badge_class; ?>">
                            <?php echo $row['status'] ?: 'Pending'; ?>
                        </span>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

    <?php
    } else {
    ?>
        <div class="empty-message">
            <p>❌ You have not uploaded any MC to check the status.</p>
            <a href="student_dashboard.php" class="btn-upload-now">Upload MC Now</a>
        </div>
    <?php
    }
    ?>

    <a href="student_dashboard.php" class="btn-back">← Back to Dashboard</a>

</div>

</body>
</html>