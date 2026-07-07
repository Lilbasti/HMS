<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: user_page.php");
    exit();
}

include "conn.php";

// Fetch booking data for table
$result = mysqli_query($conn, "SELECT * FROM booking");

// Fetch data for chart (room type count)
$statusResult = mysqli_query($conn, "SELECT Room_Type, COUNT(*) as count FROM booking GROUP BY Room_Type");
$statusLabels = [];
$statusData = [];
while($row = mysqli_fetch_assoc($statusResult)){
    $statusLabels[] = $row['Room_Type'];
    $statusData[] = $row['count'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hotel Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap');
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f4f6f9;
        }
        .dashboard { display: flex; }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background: #2c3e50;
            color: white;
            height: 100vh;
            padding: 20px;
        }
        .sidebar h2 { text-align: center; margin-bottom: 30px; }
        .sidebar ul { list-style: none; padding: 0; }
        .sidebar ul li { margin-bottom: 15px; }
        .sidebar ul li a { color: white; text-decoration: none; }
        .sidebar ul li a:hover { text-decoration: underline; }

        /* Main content */
        .main { flex: 1; padding: 20px; }
        .topbar { margin-bottom: 20px; }
        .topbar h1 { margin: 0; }
        
        /* Centered Search Bar Styles */
        .search-container {
            margin-bottom: 20px;
            display: flex;
            justify-content: center; /* Centers the search input horizontally */
        }
        .search-input {
            padding: 10px 15px;
            width: 400px; /* Made slightly wider for better visibility in the center */
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            outline: none;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
        }
        .search-input:focus {
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }

        table { width: 100%; border-collapse: collapse; margin-bottom: 40px; background: white; }
        table th, table td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        table th { background: #3498db; color: white; }
        .card {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        canvas { width: 100% !important; max-width: 600px; height: 300px !important; }
    </style>
</head>
<body>

<div class="dashboard">
    <div class="sidebar">
        <h2>Hotel Admin</h2>
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="Users.php">Users</a></li>
            <li><a href="index.php">Logout</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="topbar">
            <h1>Admin Dashboard</h1>
        </div>

        <div class="card">
            <h2>Booking Table</h2>
            
            <div class="search-container">
                <input type="text" id="tableSearch" onkeyup="filterTable()" placeholder="Search guest names..." class="search-input">
            </div>

            <table id="bookingTable">
                <tr>
                    <th>Id</th>
                    <th>Guest Name</th>
                    <th>Room Type</th>
                    <th>No. of Guest</th>
                    <th>Contact</th>
                    <th>Booking Date</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['Guest_Name'] ?></td>
                    <td><?= $row['Room_Type'] ?></td>
                    <td><?= $row['No_of_Guest'] ?></td>
                    <td><?= $row['Contact'] ?></td>
                    <td><?= $row['Booking_Date'] ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>

        <div class="card">
            <h2>Room Type Distribution</h2>
            <canvas id="roomChart"></canvas>
        </div>

    </div>
</div>

<script>
// Real-Time Table Filter Function
function filterTable() {
    let input = document.getElementById("tableSearch");
    let filter = input.value.toLowerCase();
    let table = document.getElementById("bookingTable");
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        let tdName = tr[i].getElementsByTagName("td")[1]; // Column 2 (Guest Name)
        
        if (tdName) {
            let txtValue = tdName.textContent || tdName.innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

// ChartJS Configuration
const ctx = document.getElementById('roomChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($statusLabels) ?>,
        datasets: [{
            label: 'Number of Bookings',
            data: <?= json_encode($statusData) ?>,
            backgroundColor: 'rgba(52, 152, 219, 0.6)',
            borderColor: 'rgba(52, 152, 219, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                stepSize: 1
            }
        }
    }
});
</script>

</body>
</html>