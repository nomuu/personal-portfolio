<?php
session_save_path('/tmp');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_name'])) {
    $_SESSION['user_name'] = trim($_POST['user_name']);
}

if (!isset($_SESSION['user_name'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Device Setup</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: #0f2027;  /* fallback for old browsers */
      background: linear-gradient(135deg, #000428, #004e92);
      color: white;
      font-family: 'Segoe UI', sans-serif;
      padding-top: 40px;
    }
    video {
      width: 100%;
      max-width: 480px;
      height: 320px;
      border: 4px solid #00bcd4;
      border-radius: 12px;
      margin-bottom: 20px;
      background-color: black;
    }
    .form-select {
      max-width: 400px;
      margin-bottom: 20px;
    }
    .btn-main {
      background: linear-gradient(to right, #0072ff, #00c6ff);
      color: white;
      border: none;
      padding: 10px 20px;
      font-weight: bold;
    }
    .btn-main:disabled {
      background: #999;
    }
  </style>
</head>
<body>
<div class="container text-center">
  <h2>Hi <?php echo htmlspecialchars($_SESSION['user_name']); ?>,</h2>
  <p>Please grant access and test your camera and microphone before proceeding.</p>

  <video id="videoPreview" autoplay muted playsinline></video>

  <div class="d-flex flex-column align-items-center">
    <label for="cameraSelect">Select Camera</label>
    <select id="cameraSelect" class="form-select"></select>

    <label for="micSelect" class="mt-3">Select Microphone</label>
    <select id="micSelect" class="form-select"></select>
  </div>

  <button id="proceedBtn" class="btn-main mt-4" disabled>Start Mock Interview</button>
</div>

<script>
  const videoElement = document.getElementById('videoPreview');
  const cameraSelect = document.getElementById('cameraSelect');
  const micSelect = document.getElementById('micSelect');
  const proceedBtn = document.getElementById('proceedBtn');

  let currentStream;

  async function getDevices() {
    const devices = await navigator.mediaDevices.enumerateDevices();
    cameraSelect.innerHTML = '';
    micSelect.innerHTML = '';

    devices.forEach(device => {
      const option = document.createElement('option');
      option.value = device.deviceId;
      option.text = device.label || `${device.kind}`;
      if (device.kind === 'videoinput') {
        cameraSelect.appendChild(option);
      } else if (device.kind === 'audioinput') {
        micSelect.appendChild(option);
      }
    });

    if (cameraSelect.length && micSelect.length) {
      proceedBtn.disabled = false;
    }
  }

  async function startPreview() {
    if (currentStream) {
      currentStream.getTracks().forEach(track => track.stop());
    }

    const constraints = {
      video: { deviceId: cameraSelect.value ? { exact: cameraSelect.value } : undefined },
      audio: { deviceId: micSelect.value ? { exact: micSelect.value } : undefined }
    };

    try {
      const stream = await navigator.mediaDevices.getUserMedia(constraints);
      currentStream = stream;
      videoElement.srcObject = stream;
      proceedBtn.disabled = false;
    } catch (err) {
      alert("Could not access camera or microphone.");
      proceedBtn.disabled = true;
    }
  }

  cameraSelect.onchange = startPreview;
  micSelect.onchange = startPreview;

  proceedBtn.onclick = () => {
        const selectedVideoDeviceId = cameraSelect.value;
  const selectedAudioDeviceId = micSelect.value;

  // ✅ Save to localStorage
  localStorage.setItem('videoDeviceId', selectedVideoDeviceId);
  localStorage.setItem('audioDeviceId', selectedAudioDeviceId);
    if (currentStream) {
      currentStream.getTracks().forEach(track => track.stop());
    }
    window.location.href = 'interview.php';
  };

  // Initialize
  navigator.mediaDevices.getUserMedia({ video: true, audio: true })
    .then(stream => {
      stream.getTracks().forEach(track => track.stop()); // stop temp stream
      return getDevices();
    })
    .then(startPreview)
    .catch(err => {
      alert("Access denied. Please allow access to camera and microphone.");
    });
</script>
</body>
</html>
