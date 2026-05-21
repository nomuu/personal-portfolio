<div class="container mt-4">
    <h2 class="mb-4">Manage Stocks</h2>

    <!-- Status Messages -->
    <?php if (isset($_GET['status'])): ?>
        <div class="alert alert-<?php echo ($_GET['status'] == 'success') ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
            <?php echo ($_GET['status'] == 'success') ? 'Stock added successfully!' : 'There was an error adding the stock. Please try again.'; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Stock Form -->
    <form action="Content/Stock_process.php" method="post">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="producttype">Product Type:</label>
                <select class="form-control" id="producttype" name="producttype" required>
                    <option value="">Select a product type</option>
                    <?php
                    // Include database configuration
                    require_once 'Config/db_config.php';

                    // Fetch product types from Productlist
                    $sql = "SELECT id, Productname FROM Productlist";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row["id"]) . "'>" . htmlspecialchars($row["Productname"]) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="productname">Product Name:</label>
                <input type="text" class="form-control" id="productname" name="productname" required>
            </div>
            <div class="form-group col-md-4">
                <label for="netweight">Net Weight:</label>
                <select class="form-control" id="netweight" name="netweight" required>
                    <option value="">Select net weight</option>
                    <option value="100">100 grams</option>
                    <option value="250">250 grams</option>
                    <option value="500">500 grams</option>
                    <option value="1000">1000 grams</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="quantity">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" min="0" required>
            </div>
            <div class="form-group col-md-4">
                <label for="store">Store:</label>
                <select class="form-control" id="store" name="store" required>
                    <option value="">Select a store</option>
                    <?php
                    // Include database configuration
                    require_once 'Config/db_config.php';
                    
                    // Fetch store names from Storelist
                    $sql = "SELECT id, Storename FROM Storelist";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row["id"]) . "'>" . htmlspecialchars($row["Storename"]) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Add Stock</button>
    </form>

    <hr class="my-4">

    <!-- Stock Table -->
    <h3 class="mb-4">Stock List</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Type</th>
                <th>Product Name</th>
                <th>Store</th>
                <th>Net Weight</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include database configuration
            require_once 'Config/db_config.php';

            // Fetch stocks from Stocklist with product names from Productlist and store names from Storelist
            $sql = "SELECT s.id, s.Productname, s.Netweight, s.Quantity, s.Dateadded, s.addedby, st.Storename, p.Productname as Pname 
                    FROM Stocklist s 
                    JOIN Productlist p ON s.Productid = p.id
                    JOIN Storelist st ON s.Store = st.id"; // Adjust according to your database schema
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Pname"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Productname"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Storename"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Netweight"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Quantity"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>No stocks found</td></tr>";
            }

            // Close connection
            $conn->close();
            ?>
        </tbody>
    </table>
</div>
