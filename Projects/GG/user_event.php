<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
$user = $_SESSION['user'];
require 'config/db.php';
$userID = $user['email'];

?>

<h2>Available Events</h2>

<?php if (isset($_SESSION['message'])): ?>
<div class="alert alert-info">
    <?= $_SESSION['message'] ?>
</div>
<?php unset($_SESSION['message']); ?>
<?php endif; ?>

<div class="row">
<?php
$sql = "SELECT * FROM GG_event WHERE status = 0 ORDER BY eventdate ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
        $eventId = $row['eventID']; // Correct column name

        // ✅ MOVE join check INSIDE the loop
        $stmt2 = $conn->prepare("SELECT 1 FROM GG_event_register WHERE eventID = ? AND userID = ?");
        $stmt2->bind_param("ss", $eventId, $userID);
        $stmt2->execute();
        $stmt2->store_result();
        $alreadyJoined = $stmt2->num_rows > 0;
        $stmt2->close();
        
        
// Get number of users who joined the event
$stmt3 = $conn->prepare("SELECT COUNT(*) FROM GG_event_register WHERE eventID = ?");
$stmt3->bind_param("s", $eventId);
$stmt3->execute();
$stmt3->bind_result($joinCount);
$stmt3->fetch();
$stmt3->close();
?>

    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($row['eventname']) ?></h5>
                <p class="card-text">
    Date: <?= date("F j, Y", strtotime($row['eventdate'])) ?><br>
    Location: <?= htmlspecialchars($row['eventlocation']) ?><br>
    <strong><?= $joinCount ?></strong> user(s) joined this event
</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal<?= $eventId ?>">
                    View Details
                </button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="eventModal<?= $eventId ?>" tabindex="-1" aria-labelledby="eventModalLabel<?= $eventId ?>" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="user_join_event.php">
                <input type="hidden" name="event_id" value="<?= $eventId ?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= htmlspecialchars($row['eventname']) ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Date:</strong> <?= date("F j, Y", strtotime($row['eventdate'])) ?></p>
                        <p><strong>Location:</strong> <?= htmlspecialchars($row['eventlocation']) ?></p>
                        <p><strong>Description:</strong></p>
                        <p><?= nl2br(htmlspecialchars($row['eventdescription'])) ?></p>
                    </div>
                    <div class="modal-footer">
                        <?php if ($alreadyJoined): ?>
                            <button type="button" class="btn btn-secondary" disabled>Already Joined</button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-success">Join Event</button>
                        <?php endif; ?>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php
    endwhile;
else:
    echo "<p>No events available.</p>";
endif;

$conn->close();
?>
</div>
