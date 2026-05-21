<?php
// Start session to access error message
session_start();

// Check if there is an error message to display
$errorMessage = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']); // Clear the error message after displaying it

require 'sso_login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
      <link rel="icon" href="images/icon.png" type="image/png">
    <title>Weevu - Website Vulnerability Scanner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="content/css/home.css" rel="stylesheet" />
    <link href="content/css/scan.css" rel="stylesheet" />
    <link href="content/css/home-services.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
<?php 
include 'nav.php'; 
include 'home-scan.php'; 
require 'about.php'; 
require 'services.php'; 
require 'documentation.php'; 
require 'contact.php'; 
require 'faq.php'; 
require 'home-services.php'; 
require 'footer.php'; 
?>
<!-- Bootstrap 5.3 JS, Popper.js -->
<!-- Popper.js (required by Bootstrap for tooltips, popovers, dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-z6eE8UAK4XeypZExmraJpXGn1n9zPgMyoRo9by9zUUqzByMeNP0WcI0wZWFqC3f1" crossorigin="anonymous"></script>
<script>
    // Show error modal if PHP error
    <?php if ($errorMessage): ?>
        var myModal = new bootstrap.Modal(document.getElementById('errorModal'));
        myModal.show();
    <?php endif; ?>
    
    function showSection(idToShow) {
  // Get all content sections
  var sections = document.querySelectorAll('.content-section');

  // Hide all sections
  sections.forEach(function(section) {
    section.style.display = 'none';
  });

  // Show the selected section
  var sectionToShow = document.getElementById(idToShow);
  if (sectionToShow) {
    sectionToShow.style.display = 'block';
  }
}
</script>

</body>
</html>
