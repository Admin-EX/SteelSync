<?php
session_start();

// Redirect to login if no user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: /steelsync/admin/login.php");
    exit();
}
// Verify the user has the correct role
if ($_SESSION["role"] !== 'super_admin') {
    // Redirect to appropriate page or show error

    header("Location: /steelsync/admin/login.php");
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

        /* Orders Management Styles */
        .orders-container {
            padding: 15px;
            background-color: #f7f7f7;
        }

        /* Order Statistics Cards */
        .order-stats {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .stat-card {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            min-width: 200px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            flex: 1;
        }

        .stat-card h3 {
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: #333;
        }

        /* Order Controls */
        .order-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .filter-controls {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            flex: 1;
        }

        .filter-dropdown {
            padding: 10px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            background-color: #fff;
            min-width: 150px;
            font-size: 14px;
        }

        .search-box {
            position: relative;
            flex: 1;
            max-width: 300px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 15px;
            padding-right: 40px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
        }

        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .new-order-btn {
            background-color: #f57c00;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background-color 0.3s;
        }

        .new-order-btn:hover {
            background-color: #e65100;
        }

        /* Orders Table */
        .orders-table-container {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-table th {
            background-color: #f9f9f9;
            padding: 15px;
            text-align: left;
            font-weight: 500;
            color: #333;
            border-bottom: 1px solid #eee;
        }

        .orders-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            color: #555;
        }

        .orders-table tbody tr:hover {
            background-color: #f9f9f9;
        }

        /* Status Badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
            text-align: center;
            min-width: 100px;
        }

        .paid {
            background-color: #e0edff;
            color: #4a7eff;
        }

        .unpaid {
            background-color: #ffe0e0;
            color: #ff4a4a;
        }

        .ongoing {
            background-color: #e0f7ff;
            color: #4ac4ff;
        }

        .complete {
            background-color: #e0ffe0;
            color: #4aff4a;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 4px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .view-btn {
            background-color: #f0f0f0;
            color: #3498db;
        }

        .check-btn {
            background-color: #f0f0f0;
            color: #27ae60;
        }

        .delete-btn {
            background-color: #f0f0f0;
            color: #e74c3c;
        }

        .action-btn:hover {
            background-color: #e0e0e0;
        }

        /* Pagination */
        .pagination {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
        }

        .pagination-btn {
            padding: 8px 15px;
            border: 1px solid #e0e0e0;
            background-color: #fff;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
        }

        .pagination-btn.active {
            background-color: #f57c00;
            color: white;
            border-color: #f57c00;
        }

        .pagination-btn:hover:not(.active) {
            background-color: #f0f0f0;
        }

        .pagination-info {
            margin-left: 15px;
            color: #666;
            font-size: 14px;
        }

        /* Responsive Adjustments */
        @media (max-width: 1024px) {
            .orders-table {
                min-width: 800px;
            }

            .orders-table-container {
                overflow-x: auto;
            }
        }

        @media (max-width: 768px) {
            .order-stats {
                flex-direction: column;
            }

            .stat-card {
                width: 100%;
            }

            .order-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-controls {
                width: 100%;
            }

            .search-box {
                max-width: 100%;
            }

            .new-order-btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Adjustments for sidebar states */
        .main--content.active .orders-container {
            padding: 10px;
        }

        .main--content.active .order-stats {
            gap: 15px;
        }

        .main--content.active .stat-card {
            padding: 15px;
        }

        /**dito mo lagay yung css ng point of sale content yung css sa taas default yan format ng main--content wag mo aalisin*/
    </style>
    </style>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <?php include "includes/sidebar.php"; ?>


    <div class="main--content">
        <!-- dito mo ilagay yung point of sale ng appointment-->

        <!-- Orders Management UI -->
        <div class="orders-container">
            <!-- Order Statistics Cards -->
            <div class="order-stats">
                <div class="stat-card">
                    <h3>Total Orders</h3>
                    <p class="stat-number">8</p>
                </div>
                <div class="stat-card">
                    <h3>Active Orders</h3>
                    <p class="stat-number">4</p>
                </div>
                <div class="stat-card">
                    <h3>Complete Orders</h3>
                    <p class="stat-number">4</p>
                </div>
            </div>

            <!-- Order Controls -->
            <div class="order-controls">
                <div class="filter-controls">
                    <select class="filter-dropdown">
                        <option>All</option>
                        <option>Ongoing</option>
                        <option>Complete</option>
                        <option>Paid</option>
                        <option>Unpaid</option>
                    </select>

                    <div class="search-box">
                        <input type="text" placeholder="Search">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>

                <button class="new-order-btn">
                    <i class="ri-add-line"></i> NEW ORDER
                </button>
            </div>

            <!-- Orders Table -->
            <div class="orders-table-container">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Client Name</th>
                            <th>Service Availed</th>
                            <th>Payment Status</th>
                            <th>Order Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Jennylyn Vinuya</td>
                            <td>Gate Automation</td>
                            <td><span class="status-badge unpaid">UNPAID</span></td>
                            <td><span class="status-badge ongoing">ONGOING</span></td>
                            <td class="action-buttons">
                                <button class="action-btn view-btn"><i class="ri-file-list-line"></i></button>
                                <button class="action-btn check-btn"><i class="ri-check-line"></i></button>
                                <button class="action-btn delete-btn"><i class="ri-delete-bin-line"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Mike Dela Cruz</td>
                            <td>Sectional Garage Door</td>
                            <td><span class="status-badge paid">PAID</span></td>
                            <td><span class="status-badge complete">COMPLETE</span></td>
                            <td class="action-buttons">
                                <button class="action-btn view-btn"><i class="ri-file-list-line"></i></button>
                                <button class="action-btn check-btn"><i class="ri-check-line"></i></button>
                                <button class="action-btn delete-btn"><i class="ri-delete-bin-line"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Ozzy Hernandez</td>
                            <td>Roll Up Door</td>
                            <td><span class="status-badge unpaid">UNPAID</span></td>
                            <td><span class="status-badge complete">COMPLETE</span></td>
                            <td class="action-buttons">
                                <button class="action-btn view-btn"><i class="ri-file-list-line"></i></button>
                                <button class="action-btn check-btn"><i class="ri-check-line"></i></button>
                                <button class="action-btn delete-btn"><i class="ri-delete-bin-line"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Angelo Aqcuitan</td>
                            <td>Smart Electric Fence Out</td>
                            <td><span class="status-badge paid">PAID</span></td>
                            <td><span class="status-badge ongoing">ONGOING</span></td>
                            <td class="action-buttons">
                                <button class="action-btn view-btn"><i class="ri-file-list-line"></i></button>
                                <button class="action-btn check-btn"><i class="ri-check-line"></i></button>
                                <button class="action-btn delete-btn"><i class="ri-delete-bin-line"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Alexis Paira</td>
                            <td>Gate Fabrication</td>
                            <td><span class="status-badge paid">PAID</span></td>
                            <td><span class="status-badge complete">COMPLETE</span></td>
                            <td class="action-buttons">
                                <button class="action-btn view-btn"><i class="ri-file-list-line"></i></button>
                                <button class="action-btn check-btn"><i class="ri-check-line"></i></button>
                                <button class="action-btn delete-btn"><i class="ri-delete-bin-line"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Rossel Tiqua</td>
                            <td>Smart Curtain</td>
                            <td><span class="status-badge unpaid">UNPAID</span></td>
                            <td><span class="status-badge ongoing">ONGOING</span></td>
                            <td class="action-buttons">
                                <button class="action-btn view-btn"><i class="ri-file-list-line"></i></button>
                                <button class="action-btn check-btn"><i class="ri-check-line"></i></button>
                                <button class="action-btn delete-btn"><i class="ri-delete-bin-line"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Alfred Io</td>
                            <td>Smart Electric Fence Out</td>
                            <td><span class="status-badge paid">PAID</span></td>
                            <td><span class="status-badge ongoing">ONGOING</span></td>
                            <td class="action-buttons">
                                <button class="action-btn view-btn"><i class="ri-file-list-line"></i></button>
                                <button class="action-btn check-btn"><i class="ri-check-line"></i></button>
                                <button class="action-btn delete-btn"><i class="ri-delete-bin-line"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Rossel Tiqua</td>
                            <td>Smart Curtain</td>
                            <td><span class="status-badge unpaid">UNPAID</span></td>
                            <td><span class="status-badge complete">COMPLETE</span></td>
                            <td class="action-buttons">
                                <button class="action-btn view-btn"><i class="ri-file-list-line"></i></button>
                                <button class="action-btn check-btn"><i class="ri-check-line"></i></button>
                                <button class="action-btn delete-btn"><i class="ri-delete-bin-line"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <button class="pagination-btn"><i class="ri-arrow-left-s-line"></i></button>
                <button class="pagination-btn">Prev</button>
                <button class="pagination-btn active">1</button>
                <button class="pagination-btn">Next</button>
                <div class="pagination-info">
                    <span>Page: 1</span>
                    <span>of 1</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        /**dito mo lagay yung js ng point of sale content */
        // JavaScript for Orders Management functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Filter functionality
            const filterDropdown = document.querySelector('.filter-dropdown');
            if (filterDropdown) {
                filterDropdown.addEventListener('change', function() {
                    // Filter logic would go here
                    console.log('Filter changed to:', this.value);
                });
            }

            // Search functionality
            const searchInput = document.querySelector('.search-box input');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    // Search logic would go here
                    console.log('Searching for:', this.value);
                });
            }

            // New Order button
            const newOrderBtn = document.querySelector('.new-order-btn');
            if (newOrderBtn) {
                newOrderBtn.addEventListener('click', function() {
                    // Open new order form/modal
                    console.log('New Order button clicked');
                });
            }

            // Action buttons
            const actionButtons = document.querySelectorAll('.action-btn');
            actionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const action = this.classList.contains('view-btn') ? 'view' :
                        this.classList.contains('check-btn') ? 'check' : 'delete';
                    const row = this.closest('tr');
                    const clientName = row.cells[0].textContent;

                    console.log(`${action} action for ${clientName}`);

                    // Action-specific logic would go here
                });
            });

            // Pagination
            const paginationButtons = document.querySelectorAll('.pagination-btn');
            paginationButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Pagination logic would go here
                    console.log('Pagination button clicked:', this.textContent);
                });
            });

            // Update counts (this would normally be done server-side)
            updateOrderCounts();
        });

        // Function to update order counts
        function updateOrderCounts() {
            const totalOrders = document.querySelectorAll('.orders-table tbody tr').length;
            const ongoingOrders = document.querySelectorAll('.status-badge.ongoing').length;
            const completeOrders = document.querySelectorAll('.status-badge.complete').length;

            // Update stat cards
            const statNumbers = document.querySelectorAll('.stat-number');
            if (statNumbers.length >= 3) {
                statNumbers[0].textContent = totalOrders;
                statNumbers[1].textContent = ongoingOrders;
                statNumbers[2].textContent = completeOrders;
            }
        }
    </script>
    </script>
    <?php include "includes/script.php"; ?>
</body>

</html>