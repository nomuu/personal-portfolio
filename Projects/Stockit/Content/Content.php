<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Chartjs DataLabels Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <style>
        .chart-container {
            position: relative;
            height: 400px; /* Adjust height as needed */
            width: 100%; /* Full width of the column */
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Dashboard</h4>
            </div>
            <div class="card-body">
                <p>Welcome, <?php echo htmlspecialchars($_SESSION["userID"]); ?>!</p>
                <p>You are logged in as a user with role: <?php echo htmlspecialchars($_SESSION["userrole"]); ?>.</p>

                <!-- Product Report -->
                <hr class="my-4">
                <h5 class="mb-4">Product Report</h5>
                
                <?php
                // Include database configuration
                require_once 'Config/db_config.php';

                // Get product count
                $sql = "SELECT COUNT(*) as total FROM Productlist";
                $result = $conn->query($sql);

                if (!$result) {
                    die("Query failed: " . $conn->error);
                }

                $row = $result->fetch_assoc();
                $totalProducts = $row['total'];

                // Get stock data grouped by store
                $sqlStocks = "SELECT Store, SUM(Quantity) as totalQuantity FROM Stocklist GROUP BY Store";
                $resultStocks = $conn->query($sqlStocks);

                if (!$resultStocks) {
                    die("Query failed: " . $conn->error);
                }

                $stockLabels = [];
                $stockData = [];
                $totalStocks = 0; // Initialize totalStocks

                while ($rowStocks = $resultStocks->fetch_assoc()) {
                    $storeID = $rowStocks['Store'];
                    $storeName = ''; // Default value, update if necessary
                    // Retrieve store name from Storelist table
                    $sqlStoreName = "SELECT Storename FROM Storelist WHERE id = $storeID";
                    $resultStoreName = $conn->query($sqlStoreName);
                    if ($resultStoreName && $rowStoreName = $resultStoreName->fetch_assoc()) {
                        $storeName = $rowStoreName['Storename'];
                    }
                    $stockLabels[] = $storeName;
                    $stockData[] = $rowStocks['totalQuantity'];
                    $totalStocks += $rowStocks['totalQuantity']; // Accumulate total quantity
                }

                // Close connection
                $conn->close();
                ?>
                
                <!-- Product and Stock Report -->
                <div class="row">
                    <!-- Product Chart -->
                    <div class="col-md-6 mb-4">
                        <p>Total Number of Products: <strong><?php echo htmlspecialchars($totalProducts); ?></strong></p>
                        <div class="chart-container">
                            <canvas id="productChart"></canvas>
                        </div>
                    </div>
                    
                    <!-- Stock Chart -->
                    <div class="col-md-6 mb-4">
                        <p>Total Number of Stocks: <strong><?php echo htmlspecialchars($totalStocks); ?></strong></p>
                        <div class="chart-container">
                            <canvas id="stockChart"></canvas>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script>
        // Product Chart
        var ctxProduct = document.getElementById('productChart').getContext('2d');
        var productChart = new Chart(ctxProduct, {
            type: 'doughnut',
            data: {
                labels: ['Products'],
                datasets: [{
                    label: 'Total Products',
                    data: [<?php echo $totalProducts; ?>],
                    backgroundColor: ['#007bff'],
                    borderColor: ['#fff'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    datalabels: {
                        color: '#fff',
                        display: true,
                        formatter: function(value) {
                            return value;
                        },
                        font: {
                            weight: 'bold',
                            size: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return 'Total Products: ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        // Stock Chart
        var ctxStock = document.getElementById('stockChart').getContext('2d');
        var stockChart = new Chart(ctxStock, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($stockLabels); ?>,
                datasets: [{
                    label: 'Total Stocks',
                    data: <?php echo json_encode($stockData); ?>,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'], // Customize colors as needed
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    datalabels: {
                        color: '#fff',
                        display: true,
                        formatter: function(value) {
                            return value;
                        },
                        font: {
                            weight: 'bold',
                            size: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return 'Stock: ' + tooltipItem.label + ' - ' + tooltipItem.raw + ' units';
                            }
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>
</body>
</html>
