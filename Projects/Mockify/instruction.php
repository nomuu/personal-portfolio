<?php
session_save_path('/tmp');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_name'])) {
    $_SESSION['user_name'] = trim($_POST['user_name']);
    $_SESSION['mock_index'] = 0;
    $_SESSION['mock_questions'] = [];
} elseif (!isset($_SESSION['user_name'])) {
    header('Location: index.php');
    exit;
}

$user_name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="images/icon.png" type="image/png">
  <title>Mockify - Instructions</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(135deg, #000428, #004e92);
      color: #ffffff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding-top: 40px;
      min-height: 100vh;
    }
    .container-box {
      background: rgba(255, 255, 255, 0.05);
      border-radius: 8px;
      padding: 2rem;
      height: 100%;
    }
    h1 {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 20px;
    }
    .intro {
      font-size: 1.1rem;
      margin-bottom: 30px;
      font-weight: 300;
    }
    .instructions ol {
      padding-left: 1.2rem;
    }
    .privacy {
      color: #b5d9ff;
      font-style: italic;
      font-size: 0.95rem;
      margin-top: 1rem;
    }
    .start-btn {
      background: linear-gradient(to right, #0072ff, #00c6ff);
      border: none;
      padding: 12px 24px;
      font-size: 1.1rem;
      font-weight: 600;
      color: #fff;
      text-transform: uppercase;
      cursor: pointer;
      text-decoration: none;
      transition: background 0.3s ease;
    }
    .start-btn:hover {
      background: linear-gradient(to right, #0056d6, #00a9e0);
    }
    .disclaimer {
      font-size: 1rem;
      line-height: 1.6;
      color: #e0e0e0;
    }
    .btn-secondary {
      margin-top: 15px;
    }
    @media (max-width: 768px) {
      .row > div {
        margin-bottom: 30px;
      }
    }
  </style>
</head>
<body>
<div class="container">
  <h1 class="text-center">Hey <?php echo $user_name; ?>, Ready to Mock?</h1>
  <p class="intro text-center">Here’s how Mockify works — short, simple, and powerful.</p>

  <div class="row">
    <!-- Left Column: Disclaimer -->
    <div class="col-md-6">
      <div class="container-box">
        <h4>Before You Proceed</h4>
        <p class="disclaimer">
        <hr>
          Please allow access to your <strong>microphone and camera</strong> when prompted.<br><br>
          We value your privacy and do <strong>not collect, store, or analyze</strong> any video or audio data. This tool is free and runs entirely on your browser.<br><br>
          Due to hosting limitations, it cannot handle large file storage or intensive data processing.<br><br>
          If you're not comfortable using this tool, you may safely return to the homepage.
        </p>
        <hr><br>
        <a href="index.php" class="start-btn">Go Back to Home</a>
      </div>
    </div>

    <!-- Right Column: Instructions -->
    <div class="col-md-6">
      <div class="container-box instructions">
        <h4>Instructions</h4>
        <hr>
        <ol>
          <li>You will go through <strong>3 rounds</strong> of mock interviews.<br></li><br>
          <li>Before each round, you’ll enter a <strong>question</strong> you want to be asked.</li><br>
          <li>Each mock interview will last exactly <strong>1 minute</strong>.<br></li><br>
          <li>After the 1-minute session, your recorded video will be <strong>automatically downloaded</strong> to your device.<br></li>
        </ol>
        <div class="privacy">
          We do <strong>not store</strong> any videos on our servers. Everything stays local — your data, your privacy.
        </div>
<hr>
        <form method="POST" action="setup.php" class="mt-4">
          <input type="hidden" name="user_name" value="<?php echo $user_name; ?>" />
          <button type="submit" class="start-btn">Setup Camera and Microphone</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
