<?php
session_start();
require 'config/db.php';

// Fetch existing users
$sql = "SELECT * FROM GG_users";
$result = $conn->query($sql);
?>
<h3>User Management</h3>

<?php
// Check if a notification message exists
if (isset($_SESSION['notification'])):
    $notification = $_SESSION['notification'];
    unset($_SESSION['notification']);
?>
    <div class="alert alert-<?= $notification['type'] ?> alert-dismissible fade show" role="alert">
        <?= $notification['message'] ?>
    </div>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-header bg-primary text-white">Add User</div>
    <div class="card-body">
<form action="add_user.php" method="POST">
    <div class="row">
        <div class="col-md-5 mb-3">
            <label for="userID" class="form-label">User ID</label>
            <input type="text" class="form-control" id="userID" name="userID" required>
        </div>

        <div class="col-md-5 mb-3">
            <label for="usernickname" class="form-label">Nickname</label>
            <input type="text" class="form-control" id="usernickname" name="usernickname" required>
        </div>

        <div class="col-md-2 mb-3">
            <label for="userrole" class="form-label">User Role</label>
            <select class="form-control" id="userrole" name="userrole" required>
                <option value="1">User</option>
                <option value="0">Admin</option>
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-success">Add User</button>
</form>

    </div>
</div>

<div class="card">
    <div class="card-header bg-secondary text-white">Existing Users</div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Nickname</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['userID']) ?></td>
                        <td><?= htmlspecialchars($row['Usernickname']) ?></td>
                        <td><?= $row['Userrole'] == 0 ? 'Admin' : 'User' ?></td>
                        <td>
                            <a href="edit_user.php?id=<?= $row['userID'] ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="delete_user.php?id=<?= $row['userID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
