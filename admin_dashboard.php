<?php
session_start();
include("config/db.php");

// Pastikan hanya admin boleh masuk
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .dashboard-box {
            max-width: 1000px !important;
            width: 95% !important;
            margin: 5% auto !important;
        }
        .status-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .status-table th, .status-table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }
        .status-table th {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .badge-pending { color: #b7791f; font-weight: bold; }
        .badge-approved { color: #38a169; font-weight: bold; }
        .badge-rejected { color: #e53e3e; font-weight: bold; }
        
        /* Style untuk teks status di ruangan action */
        .action-text {
            font-weight: bold;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container-box dashboard-box">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Admin Dashboard 📃</h2>
        <a href="logout.php" style="color: #7db4ff; text-decoration: none; font-weight: bold;">Logout</a>
    </div>

    <table class="status-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Programme</th>
                <th>Date & Time</th>
                <th>MC</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // INNER JOIN untuk paparkan Nama, Program & Tarikh Masa
            $query = mysqli_query($conn, "
                SELECT 
                    m.id,
                    m.student_id, 
                    s.student_name, 
                    s.programme, 
                    m.submission_date, 
                    m.mc_file, 
                    m.status 
                FROM mc_submissions m
                INNER JOIN students s ON m.student_id = s.student_id
                ORDER BY m.id DESC
            ");

            if(mysqli_num_rows($query) > 0) {
                while($row = mysqli_fetch_assoc($query)) {
                    $formatted_date = date('d/m/Y h:i A', strtotime($row['submission_date']));
                    
                    // Set class warna berdasarkan status untuk ruangan "Status"
                    $status_class = "badge-pending";
                    if($row['status'] == 'Approved') $status_class = "badge-approved";
                    if($row['status'] == 'Rejected') $status_class = "badge-rejected";
            ?>
            <tr>
                <td><?php echo $row['student_id']; ?></td>
                <td><?php echo $row['student_name']; ?></td>
                <td><?php echo $row['programme']; ?></td>
                <td><?php echo $formatted_date; ?></td>
                <td>
                    <a target="_blank" href="uploads/<?php echo $row['mc_file']; ?>" style="color:#7db4ff; text-decoration:underline;">View</a>
                </td>
                <td class="<?php echo $status_class; ?>"><?php echo $row['status'] ?: 'Pending'; ?></td>
                <td>
                    <?php 
                    // Logik Semakan Status untuk Ruangan Action
                    if($row['status'] == 'Approved') {
                        // Kalau dah Approved, keluar teks hijau
                        echo "<span class='action-text' style='color: #38a169;'>Approved</span>";
                    } 
                    elseif($row['status'] == 'Rejected') {
                        // Kalau dah Rejected, keluar teks merah
                        echo "<span class='action-text' style='color: #e53e3e;'>Rejected</span>";
                    } 
                    else { 
                        // Kalau status masih kosong atau 'Pending', kekalkan butang asal
                    ?>
                        <a href="approve.php?id=<?php echo $row['id']; ?>" style="color: #38a169; text-decoration:none; font-weight:bold;">Approve</a> | 
                        <a href="reject.php?id=<?php echo $row['id']; ?>" style="color: #e53e3e; text-decoration:none; font-weight:bold;">Reject</a>
                    <?php 
                    } 
                    ?>
                </td>
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='7'>No MC submissions found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>