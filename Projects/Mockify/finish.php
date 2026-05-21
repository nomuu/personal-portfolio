<?php
session_start();
session_destroy(); // optional: clear session if needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="images/icon.png" type="image/png">
  <title>Mockify - Finished</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      background: linear-gradient(135deg, #000428, #004e92);
      color: #ffffff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      align-items: flex-start;
      justify-content: center;
      text-align: left;
      padding: 4rem 2rem;
    }

    .container-custom {
      max-width: 800px;
      width: 100%;
    }

    h1 {
      font-size: 3rem;
      font-weight: 700;
      margin-bottom: 1rem;
    }

    .typewriter {
      font-size: 1.2rem;
      font-weight: 300;
      white-space: nowrap;
      overflow: hidden;
      border-right: 2px solid #fff;
      width: 0;
      animation: typing 3s steps(40, end) forwards, blink 1s step-end infinite;
      margin-bottom: 2rem;
    }

    @keyframes typing {
      from { width: 0 }
      to { width: 320px }
    }

    @keyframes blink {
      from, to { border-color: transparent }
      50% { border-color: white }
    }

    .message {
      font-size: 1.1rem;
      color: #ddd;
      line-height: 1.8;
    }

    a {
      color: #00c6ff;
      text-decoration: underline;
    }

    a:hover {
      color: #00a9e0;
    }

    .btn-home {
      margin-top: 2rem;
      background: #00c6ff;
      background: linear-gradient(to right, #0072ff, #00c6ff);
      border: none;
      padding: 12px 24px;
      font-size: 1rem;
      font-weight: 600;
      color: #fff;
      text-transform: uppercase;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .btn-home:hover {
      background: linear-gradient(to right, #0056d6, #00a9e0);
    }
  </style>
</head>
<body>

  <div class="container-custom">
    <h1>Thank You for Using Mockify</h1>
    <div class="typewriter">We hope you found it helpful.</div>

    <div class="message">
      <p>You've successfully completed your mock interview. You can use Mockify any time to sharpen your skills, practice responses, and build your confidence.</p>
      <p>If you have feedback, questions, or just want to share your thoughts about this tool, feel free to contact the developer at <a href="https://imronaldmendoza.com" target="_blank">imronaldmendoza.com</a>.</p>
      <p>We hope Mockify plays a meaningful role in helping you prepare for real interviews and that it contributes positively to your growth.</p>
      <p>Good luck — go ace that interview!</p>

      <form action="index.php" method="get">
        <button type="submit" class="btn-home">Back to Home</button>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
