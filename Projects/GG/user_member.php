<?php
require 'config/db.php';

$currentUserId = $_SESSION['user']['email'];

$sql = "SELECT userID, usernickname, userProfile 
        FROM GG_users 
        ORDER BY (userID = ?) DESC, usernickname ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $currentUserId);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($userID, $nickname, $profile);

if ($stmt->num_rows > 0): ?>
    <div class="row">
        <?php while ($stmt->fetch()): 
            $displayName = ($userID === $currentUserId) ? $nickname . " (you)" : $nickname;
        ?>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card text-center h-100">
                    <div style="height: 200px; overflow: hidden;">
                        <img src="<?= htmlspecialchars($profile) ?>" alt="Profile Image"
                             class="img-fluid w-100" style="height: 100%; object-fit: cover;">
                    </div>
                    <div class="card-body d-flex align-items-end justify-content-center">
                        <small class="card-title fw-bold"><?= htmlspecialchars($displayName) ?></small>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p>No members found.</p>
<?php endif;

$stmt->close();
$conn->close();
?>
