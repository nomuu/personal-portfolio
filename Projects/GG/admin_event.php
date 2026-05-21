<?php
session_start();
require 'config/db.php';

// Fetch existing users
$sql = "SELECT * FROM GG_event";
$result = $conn->query($sql);
?>
<style>
  /* Fix dropdown z-index */
  .pac-container {
    z-index: 1050 !important;
  }
</style>
<h3>EVENTS</h3>

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
    <div class="card-header bg-primary text-white">Add New Event</div>
    <div class="card-body">
        <form action="admin_new_event.php" method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="eventName" class="form-label">Event Name</label>
                    <input type="text" class="form-control" id="eventName" name="eventName" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="eventLocation" class="form-label">Event Location</label>
                    <input type="text" class="form-control" id="eventLocation" name="eventLocation" placeholder="Type location..." autocomplete="off" required>

                </div>
            </div>
            <div class="mb-3">
                <label for="eventDescription" class="form-label">Event Description</label>
                <textarea class="form-control" id="eventDescription" name="eventDescription" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="eventDate" class="form-label">Event Date</label>
                <input type="date" class="form-control" id="eventDate" name="eventDate" required>
            </div>
            <button type="submit" class="btn btn-success">Add Event</button>
        </form>
    </div>
</div>


<div class="card">
    <div class="card-header bg-secondary text-white">Existing Events</div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Event ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['eventID']) ?></td>
                        <td><?= htmlspecialchars($row['eventname']) ?></td>
                        <td><?= htmlspecialchars($row['eventdescription']) ?></td>
                        <td><?= htmlspecialchars($row['eventlocation']) ?></td>
                        <td><?= htmlspecialchars($row['eventdate']) ?></td>
                        <td><?= $row['status'] == 0 ? 'Active' : 'Inactive' ?></td>
                        <td>
                            <a href="edit_user.php?id=<?= $row['eventID'] ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="delete_user.php?id=<?= $row['eventID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<script
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDPd1eNJlPiLDSqqa-OLMpHWdEcYjvL3Ig&libraries=places&callback=initAutocomplete"
  async
  defer
></script>
<script>
function initAutocomplete() {
  const input = document.getElementById('eventLocation');
  const options = {
    componentRestrictions: { country: 'ph' } // Restrict to Philippines
  };
  new google.maps.places.Autocomplete(input, options);
}
</script>