<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
$user = $_SESSION['user'];
require 'config/db.php';
$userID = $user['email'];

// Fetch all gallery entries ordered by Gallerygroup
$sql = "SELECT Gallerygroup, Gallerypath, Gallerydescription FROM GG_gallery ORDER BY Gallerygroup, Gallerydescription";
$result = $conn->query($sql);

if (!$result) {
    echo "Database query failed.";
    exit;
}

$currentGroup = null;
?>

<?php if ($result->num_rows > 0): ?>
    <div class="container">
        <?php while ($row = $result->fetch_assoc()):
            if ($currentGroup !== $row['Gallerygroup']):
                if ($currentGroup !== null): ?>
                    </div> <!-- close previous row -->
                <?php endif; ?>
                <h3 class="mt-4"><?= htmlspecialchars($row['Gallerygroup']) ?></h3>
                <div class="row">
                <?php 
                $currentGroup = $row['Gallerygroup'];
            endif;
            ?>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100 d-flex flex-column">
                    <div style="height: 200px; overflow: hidden;">
                        <img src="<?= htmlspecialchars($row['Gallerypath']) ?>" class="card-img-top img-fluid" alt="<?= htmlspecialchars($row['Gallerydescription']) ?>" style="object-fit: cover; width: 100%; height: 100%;">
                    </div>
                    <div class="card-body d-flex flex-column justify-content-end">
<p class="card-text text-center fw-bold"><?= htmlspecialchars($row['Gallerydescription']) ?></p>

                        <a href="<?= htmlspecialchars($row['Gallerypath']) ?>" download class="btn btn-primary btn-sm mt-auto">Download</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        </div> <!-- close last row -->
    </div>
<?php else: ?>
    <p>No images found.</p>
<?php endif;

$conn->close();
?>
