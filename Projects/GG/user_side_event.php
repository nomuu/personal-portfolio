<?php
require 'config/db.php';

$sql = "SELECT eventID, eventname, eventdate FROM GG_event WHERE status = 0 ORDER BY eventdate ASC LIMIT 3";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
        $eventId = $row['eventID'];

        // Get join count
        $stmt = $conn->prepare("SELECT COUNT(*) FROM GG_event_register WHERE eventID = ?");
        $stmt->bind_param("s", $eventId);
        $stmt->execute();
        $stmt->bind_result($joinCount);
        $stmt->fetch();
        $stmt->close();
?>
        <div class="mb-2">
            <strong><?= htmlspecialchars($row['eventname']) ?></strong><br>
            <small><?= date("F j, Y", strtotime($row['eventdate'])) ?></small><br>
            <span class="text-muted"><?= $joinCount ?> joined</span>
        </div>
<?php
    endwhile;
else:
    echo "<p>No upcoming events.</p>";
endif;

$conn->close();
?>
