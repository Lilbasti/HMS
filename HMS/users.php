<?php
include "conn.php";

// Fetch user data for table
$result = mysqli_query($conn, "SELECT * FROM users");

// Fetch data for chart: count by role
$roleResult = mysqli_query($conn, "SELECT role, COUNT(*) as count FROM users GROUP BY role");
$roleLabels = [];
$roleData = [];
while($row = mysqli_fetch_assoc($roleResult)){
    $roleLabels[] = $row['role'];
    $roleData[] = $row['count'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hotel Admin Users</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap');
        body { font-family: 'Poppins', sans-serif; margin: 0; background: #f4f6f9; }
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

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Hotel Admin</h2>
        <ul>
            <li><a href="admin_page.php">Dashboard</a></li>
            <li><a href="Users.php">Users</a></li>
            <li><a href="index.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="main">
        <div class="topbar">
            <h1>Admin Dashboard</h1>
        </div>

        <!-- Table -->
        <div class="card">
            <h2>Users Table</h2>
            <table>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['role'] ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>

        <!-- Graph -->
        <div class="card">
            <h2>User Role Distribution</h2>
            <canvas id="roleChart"></canvas>
        </div>

    </div>

</div>

<script>
const ctx = document.getElementById('roleChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($roleLabels) ?>,
        datasets: [{
            label: 'Number of Users',
            data: <?= json_encode($roleData) ?>,
            backgroundColor: [
                'rgba(52, 152, 219, 0.6)',
                'rgba(231, 76, 60, 0.6)'
            ],
            borderColor: [
                'rgba(52, 152, 219, 1)',
                'rgba(231, 76, 60, 1)'
            ],
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