<script>
let preview = document.getElementById('preview');
let timerDisplay = document.getElementById('timer');
let nextBtn = document.getElementById('nextBtn');
let questionInput = document.getElementById('questionInput');
let hiddenQuestionInput = document.getElementById('hiddenQuestionInput');
let questionText = document.getElementById('questionText');

let mediaRecorder;
let recordedChunks = [];
let countdown;
let timeLeft = 60;

function updateTimer() {
  let min = Math.floor(timeLeft / 60).toString().padStart(2, '0');
  let sec = (timeLeft % 60).toString().padStart(2, '0');
  timerDisplay.textContent = `${min}:${sec}`;
  if (timeLeft <= 0) {
    clearInterval(countdown);
    stopRecordingAndEnableNext();
  } else {
    timeLeft--;
  }
}

function startTimer() {
  updateTimer();
  countdown = setInterval(updateTimer, 1000);
}

function stopRecordingAndEnableNext() {
  if (mediaRecorder && mediaRecorder.state === "recording") {
    mediaRecorder.stop();
  }
  nextBtn.disabled = false;
}

let videoWidth = 640;
let videoHeight = 480;
let canvas = document.createElement('canvas');
let ctx = canvas.getContext('2d');
canvas.width = videoWidth;
canvas.height = videoHeight;

let animationFrameId;

function wrapText(context, text, x, y, maxWidth, lineHeight) {
  const words = text.split(' ');
  let line = '';
  for (let n = 0; n < words.length; n++) {
    const testLine = line + words[n] + ' ';
    const metrics = context.measureText(testLine);
    const testWidth = metrics.width;
    if (testWidth > maxWidth && n > 0) {
      context.fillText(line.trim(), x, y);
      line = words[n] + ' ';
      y += lineHeight;
    } else {
      line = testLine;
    }
  }
  context.fillText(line.trim(), x, y);
}

async function initCameraAndRecord() {
  try {
    const videoDeviceId = localStorage.getItem('videoDeviceId');
    const audioDeviceId = localStorage.getItem('audioDeviceId');
    const question = questionText.textContent || '';

    const constraints = {
      video: { width: videoWidth, height: videoHeight },
      audio: true
    };

    if (videoDeviceId) constraints.video.deviceId = { exact: videoDeviceId };
    if (audioDeviceId) constraints.audio.deviceId = { exact: audioDeviceId };

    const stream = await navigator.mediaDevices.getUserMedia(constraints);
    preview.srcObject = stream;

    function drawFrame() {
      ctx.drawImage(preview, 0, 0, videoWidth, videoHeight);
      const subtitleHeight = 80;
      ctx.fillStyle = 'rgba(0, 0, 0, 0.5)';
      ctx.fillRect(0, videoHeight - subtitleHeight, videoWidth, subtitleHeight);
      ctx.font = '24px sans-serif';
      ctx.fillStyle = 'white';
      ctx.textAlign = 'center';
      ctx.textBaseline = 'top';

      const maxWidth = videoWidth - 40;
      const lineHeight = 30;
      const x = videoWidth / 2;
      const y = videoHeight - subtitleHeight + 2;

      wrapText(ctx, question, x, y, maxWidth, lineHeight);
      animationFrameId = requestAnimationFrame(drawFrame);
    }

    drawFrame();
    const canvasStream = canvas.captureStream(30);

    // Prepare audio
    const encodedText = encodeURIComponent(question);
    const voiceRssUrl = `https://api.voicerss.org/?key=01ae73253ff6464894204d9058c9841b&hl=en-us&src=${encodedText}&c=mp3`;

    const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    const micSource = audioCtx.createMediaStreamSource(stream);
    const micGain = audioCtx.createGain();
    micGain.gain.value = 1.0;

    const response = await fetch(voiceRssUrl);
    const audioData = await response.arrayBuffer();
    const audioBuffer = await audioCtx.decodeAudioData(audioData);

    const speechSource = audioCtx.createBufferSource();
    speechSource.buffer = audioBuffer;

    const speechGain = audioCtx.createGain();
    speechGain.gain.value = 1.0;

    const mixedDest = audioCtx.createMediaStreamDestination();

    micSource.connect(micGain).connect(mixedDest);
    speechSource.connect(speechGain);
    speechGain.connect(mixedDest);
    speechGain.connect(audioCtx.destination); // for live AI voice playback

    const finalStream = new MediaStream([
      ...canvasStream.getVideoTracks(),
      ...mixedDest.stream.getAudioTracks()
    ]);

    // ✅ Start recording and timer when AI voice starts
    speechSource.onended = () => {
      // You can optionally log or act after AI stops talking
    };

    speechSource.start(0); // starts speaking right away
    startRecording(finalStream); // starts recording at same moment
    startTimer(); // start countdown at the same time

  } catch (err) {
    alert("Error accessing camera/mic or voice API: " + err.message);
  }
}

function startRecording(stream) {
  recordedChunks = [];
  mediaRecorder = new MediaRecorder(stream);
  mediaRecorder.ondataavailable = function (e) {
    if (e.data.size > 0) {
      recordedChunks.push(e.data);
    }
  };

  mediaRecorder.onstop = function () {
    cancelAnimationFrame(animationFrameId);
    const blob = new Blob(recordedChunks, { type: "video/webm" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.style.display = 'none';
    a.href = url;
    a.download = '<?php echo $_SESSION["user_name"]; ?>_Mockified_Q<?php echo $currentIndex + 1; ?>_' + Date.now() + '.webm';
    document.body.appendChild(a);
    a.click();
    setTimeout(() => {
      document.body.removeChild(a);
      URL.revokeObjectURL(url);
    }, 100);
  };

  mediaRecorder.start();
}

// Show modal on page load if not done
<?php if (!$done): ?>
window.onload = function () {
  const modal = new bootstrap.Modal(document.getElementById('questionModal'), {
    backdrop: 'static',
    keyboard: false
  });
  modal.show();

  document.getElementById('startBtn').addEventListener('click', function () {
    const question = questionInput.value.trim();
    if (question === '') {
      alert('Please enter a question.');
      return;
    }

    if (question.length < 10) {
      alert('Question is too short. Please enter at least 10 characters.');
      return;
    }

    if (question.length > 150) {
      alert('Question is too long. Please limit it to 150 characters.');
      return;
    }

    questionText.textContent = question;
    hiddenQuestionInput.value = question;
    modal.hide();
    initCameraAndRecord();
  });
};
<?php endif; ?>
</script>
