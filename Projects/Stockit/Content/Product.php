<div class="container mt-4">
    <h2 class="mb-4">Add New Product</h2>

    <!-- Status Messages -->
    <?php if (isset($_GET['status'])): ?>
        <div class="alert alert-<?php echo ($_GET['status'] == 'success') ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
            <?php echo ($_GET['status'] == 'success') ? 'Product added successfully!' : 'There was an error adding the product. Please try again.'; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Product Form -->
    <form action="Content/Product_process.php" method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="producttype">Product Type:</label>
                <input type="text" class="form-control" id="producttype" name="producttype" required>
            </div>
            <div class="form-group col-md-6">
                <label for="productname">Product Name:</label>
                <input type="text" class="form-control" id="productname" name="productname" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>

    <hr class="my-4">

    <!-- Product Table -->
    <h3 class="mb-4">Product List</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Type</th>
                <th>Product Name</th>
                <th>Date Added</th>
                <th>Added By</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include database configuration
            require_once 'Config/db_config.php';

            // Fetch products
            $sql = "SELECT * FROM Productlist";
            $result = $conn->query($sql);

            if (!$result) {
                die("Query failed: " . $conn->error);
            }

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Producttype"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Productname"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["dateadded"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["addedby"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No products found</td></tr>";
            }

            // Close connection
            $conn->close();
            ?>
        </tbody>
    </table>
</div>
