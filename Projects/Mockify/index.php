<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="images/icon.png" type="image/png">
  <title>Mockify - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
body {
  margin: 0;
  padding: 0;
  height: 100vh;
  background: linear-gradient(-45deg, #000428, #004e92, #0072ff, #00c6ff);
  background-size: 400% 400%;
  animation: gradientBG 15s ease infinite;
  color: #ffffff;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
}

@keyframes gradientBG {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}


    h1 {
      font-size: 3rem;
      font-weight: 700;
      margin-bottom: 1rem;
    }

    /* Removed typing animation styles */
    .typewriter {
      font-size: 1.2rem;
      font-weight: 300;
      white-space: nowrap;
      overflow: visible;
      border: none;
      width: auto;
    }

    form {
      margin-top: 2rem;
      width: 100%;
      max-width: 400px;
    }

    input[type="text"] {
      background: transparent;
      border: none;
      border-bottom: 2px solid #fff;
      color: #fff;
      font-size: 1.1rem;
      width: 100%;
      padding: 10px;
      outline: none;
    }

    input::placeholder {
      color: #ccc;
    }

    button {
      margin-top: 1rem;
      width: 100%;
      background: #00c6ff;
      background: linear-gradient(to right, #0072ff, #00c6ff);
      border: none;
      padding: 12px;
      font-size: 1rem;
      font-weight: 600;
      color: #fff;
      text-transform: uppercase;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background: linear-gradient(to right, #0056d6, #00a9e0);
    }

    .about {
      margin-top: 4rem;
      max-width: 800px;
      font-size: 1rem;
      color: #ddd;
    }

    .about h2 {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>

  <h1>Welcome to MOCKIFY</h1>
  <div class="typewriter">Ace your next interview with confidence.</div>

  <form method="POST" action="instruction.php">
    <input type="text" name="user_name" placeholder="Enter your name..." required autofocus />
    <button type="submit">Start Interview</button>
  </form>

  <div class="about">
    <h2>About Mockify</h2>
    <p>Mockify helps you prepare for real-world interviews by letting you input your own questions and practice answering them on your terms.</p>
    <p>Built for people who don’t want fluff — just effective preparation that works.</p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
