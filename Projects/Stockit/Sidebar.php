<!-- Sidebar.php -->
<?php
    session_start();
?>
<div class="sidebar">
    <h6 class="text-center">Hi, <?php echo htmlspecialchars($_SESSION["Usernickname"]); ?>!</h6>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="Dashboard.php?page=Content">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Dashboard.php?page=Product">Products</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Dashboard.php?page=Stock">Stock Management</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Dashboard.php?page=reports">Sales Tracking</a>
        </li>
        <li class="nav-item mt-auto">
            <a class="nav-link text-danger" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</div>
<!-- modal for logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to logout?
            </div>
            <div class="modal-footer">
                <form action="Logout.php" method="post">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

