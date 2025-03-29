<?php
session_start();

// Redirect to login if no user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intellitect System</title>

    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="css.css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        .main--content {
            position: absolute;
            top: 60px;
            right: 0;
            height: 100%;
            width: calc(100% - 300px);
            padding: 20px;
            overflow-y: auto;
            background-color: #f7f7f7;
            transition: .3s;
        }

        .main--content.active {
            width: calc(100% - 103px);
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .dashboard-header h2 {
            font-size: 22px;
            font-weight: bold;
            font-style: italic;
        }

        .metrics-container {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .metric-box {
            flex: 1;
            background-color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .metric-box h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .metric-box p {
            font-size: 22px;
            font-weight: bold;
            margin: 5px 0 0;
        }

        .chart-container {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            height: 45%;
        }

        .chart {
            width: 100px;
            flex: 1;
            background-color: #fff;
            padding: 60px 30px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .section-container {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .section {
            flex: 1;
            background-color: #fff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .payroll-input {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .payroll-input input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .submit-btn {
            background-color: #f57c00;
            color: white;
            border: none;
            padding: 10px 15px;
            margin-top: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #e65100;
        }
    </style>
    </style>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <?php include "includes/sidebar.php"; ?>


    <div class="main--content">
        <div class="dashboard-header">
            <h2>ORDER FORM - Overview</h2>
            <div class="date-picker">
                <i class="fas fa-calendar"></i>
                <span>Start date → End date</span>
            </div>
        </div>

        <!-- Metrics -->
        <div class="metrics-container">
            <div class="metric-box">
                <h3>Customer Total</h3>
                <p>0</p>
            </div>
            <div class="metric-box">
                <h3>New Customer</h3>
                <p>0</p>
            </div>
            <div class="metric-box">
                <h3>Total Complete Service</h3>
                <p>0</p>
            </div>
            <div class="metric-box">
                <h3>Total Income</h3>
                <p>0</p>
            </div>
        </div>

        <!-- Charts -->
        <div class="chart-container">
            <div class="chart">
                <h3>Revenue Income</h3>
                <p>Amount</p>
                <canvas id="revenueChart"></canvas>
            </div>
            <div class="chart">
                <h3>Service Sales Distribution</h3>
                <p>Sales</p>
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="section-container">
            <div class="section">
                <h3>Attendance Statistics</h3>
                <p>Total Employees: 38</p>
            </div>
            <div class="section">
                <h3>Inventory Overview</h3>
                <p>Flap Disc - Quantity: 100</p>
            </div>
        </div>

        <div class="section">
            <h3>Input Payroll Data</h3>
            <p>Enter details accurately</p>
            <div class="payroll-input">
                <input type="text" placeholder="Hours Worked">
                <input type="text" placeholder="Overtime Hours (if applicable)">
            </div>
            <button class="submit-btn">Submit</button>
        </div>
    </div>
    </div>


    <?php include "includes/script.php"; ?>
</body>

</html>