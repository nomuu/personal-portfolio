<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
$user = $_SESSION['user'];
require 'config/db.php';
$userID = $user['email'];
$useremail = $user['email'];
$usernickname = $user['nickname'];
$userprofile = $user['profile'];
?>

<div class="col-md-8">
    <!-- User Info Card -->
    <div class="card mb-4">
        <div class="card-header bg-info d-flex justify-content-between align-items-center">
            User Information
            <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                Edit My Profile
            </button>
        </div>
        <div class="card-body d-flex align-items-center">
            <div class="me-3">
                <img src="<?= htmlspecialchars($userprofile) ?>" alt="Profile Image" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
            </div>
            <div>
                <h5 class="card-title mb-1">Yow, <?= htmlspecialchars($usernickname) ?>!</h5>
                <p class="mb-0">Email: <?= htmlspecialchars($useremail) ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="user_update_profile.php" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileLabel">Edit My Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nickname" class="form-label">Nickname</label>
                    <input type="text" class="form-control" name="nickname" id="nickname" 
                           value="<?= htmlspecialchars($usernickname) ?>" maxlength="15" required>
                    <small class="text-muted">Max 15 characters</small>
                </div>
                <div class="mb-3">
                    <label for="profile" class="form-label">Profile Image (.jpg or .png only)</label>
                    <input type="file" class="form-control" name="profile" id="profile" 
                           accept=".jpg,.jpeg,.png" required>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="email" value="<?= htmlspecialchars($useremail) ?>">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

