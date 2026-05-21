<?php
$code = http_response_code(); // Get current HTTP status code
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Error - Ronald Fernandez Mendoza</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
    }
    .error-box {
      max-width: 500px;
      margin: 100px auto;
      padding: 30px;
      border-radius: 15px;
      background: white;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .error-code {
      font-size: 72px;
      font-weight: bold;
      color: #dc3545;
    }
  </style>
</head>
<body>

  <div class="container text-center">
    <div class="error-box">
      <div class="error-code"><?= $code ?></div>
      <h4 class="mb-3">Oops! Something went wrong.</h4>
      <p class="text-muted mb-4">The page you're looking for may have been moved or doesn't exist.</p>
      <a href="/" class="btn btn-outline-primary">Go to my profile</a>
    </div>
  </div>

</body>
</html>
